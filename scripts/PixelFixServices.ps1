[CmdletBinding()]
param(
    [Parameter(Position = 0)]
    [ValidateSet('setup', 'install', 'start', 'stop', 'status', 'remove', 'verify', 'worker-daemon', 'scheduler-daemon')]
    [string]$Action = 'status',

    [string]$Queues = ''
)

$ErrorActionPreference = 'Stop'
$ProjectRoot = (Resolve-Path (Join-Path $PSScriptRoot '..')).Path
$Launcher = Join-Path $ProjectRoot 'pixelfix'
$EnvPath = Join-Path $ProjectRoot '.env'
$PhpCommand = Get-Command php -ErrorAction SilentlyContinue
$PowerShellCommand = if ($PSVersionTable.PSEdition -eq 'Core') { Get-Command pwsh -ErrorAction SilentlyContinue } else { Get-Command powershell.exe -ErrorAction SilentlyContinue }
$PowerShellExe = if ($PowerShellCommand) { $PowerShellCommand.Source } else { Join-Path $PSHOME 'powershell.exe' }
$CurrentWindowsUser = if ($env:USERDOMAIN) { "$env:USERDOMAIN\$env:USERNAME" } else { $env:USERNAME }
$LogDirectory = Join-Path $ProjectRoot 'storage\logs'
$WorkerLog = Join-Path $LogDirectory 'pixelfix-queue-worker.log'
$SchedulerLog = Join-Path $LogDirectory 'pixelfix-scheduler.log'

function Get-EnvValue([string]$Name, [string]$Default = '') {
    if (-not (Test-Path $EnvPath)) { return $Default }
    $line = Get-Content $EnvPath | Where-Object { $_ -match "^\s*$([regex]::Escape($Name))\s*=" } | Select-Object -Last 1
    if (-not $line) { return $Default }
    $value = ($line -replace '^\s*[^=]+\s*=\s*', '').Trim()
    if ($value.Length -ge 2) {
        if (($value.StartsWith("'") -and $value.EndsWith("'")) -or ($value.StartsWith('"') -and $value.EndsWith('"'))) {
            $value = $value.Substring(1, $value.Length - 2)
        }
    }
    return $value
}

$AppName = Get-EnvValue 'APP_NAME' 'PixelFix App'
$AppSlug = ($AppName -replace '[^A-Za-z0-9]+', '-') -replace '^-|-$', ''
if ([string]::IsNullOrWhiteSpace($AppSlug)) { $AppSlug = 'App' }
$PathBytes = [System.Text.Encoding]::UTF8.GetBytes($ProjectRoot.ToLowerInvariant())
$Sha256 = [System.Security.Cryptography.SHA256]::Create()
try { $PathHash = $Sha256.ComputeHash($PathBytes) } finally { $Sha256.Dispose() }
$ProjectSuffix = ([System.BitConverter]::ToString($PathHash).Replace('-', '').Substring(0, 8)).ToLowerInvariant()
$TaskPrefix = "PixelFix-$AppSlug-$ProjectSuffix"
$WorkerTaskName = "$TaskPrefix-Queue-Worker"
$SchedulerTaskName = "$TaskPrefix-Scheduler"
$QueueDriver = (Get-EnvValue 'QUEUE_CONNECTION' 'sync').ToLowerInvariant()
if ([string]::IsNullOrWhiteSpace($Queues)) {
    $Queues = Get-EnvValue 'PIXELFIX_WORKER_QUEUES' 'default'
}
$Queues = (($Queues -split ',') | ForEach-Object { $_.Trim() } | Where-Object { $_ }) -join ','
if ([string]::IsNullOrWhiteSpace($Queues)) { $Queues = 'default' }
if ($Queues -notmatch '^[A-Za-z0-9_,\-]+$') { throw 'Queue names may contain only letters, digits, underscores, hyphens, and commas.' }

function Write-Section([string]$Text) {
    Write-Host "`n== $Text ==" -ForegroundColor Cyan
}

function Assert-Project {
    if (-not (Test-Path $Launcher)) { throw "PixelFix launcher not found: $Launcher. Run this script from the application root." }
    if (-not $PhpCommand) { throw 'PHP was not found on PATH. Add the PHP CLI used by this app to PATH and reopen PowerShell.' }
    if (-not (Test-Path $EnvPath)) { throw "Application .env not found: $EnvPath" }
    if (-not (Test-Path $LogDirectory)) { New-Item -ItemType Directory -Path $LogDirectory -Force | Out-Null }
}

function Get-TaskSafe([string]$Name) {
    try { Get-ScheduledTask -TaskName $Name -ErrorAction Stop } catch { $null }
}

function New-ManagedAction([string]$DaemonAction) {
    $ArgumentLine = "-NoProfile -NonInteractive -ExecutionPolicy Bypass -File `"$PSCommandPath`" $DaemonAction -Queues $Queues"
    return New-ScheduledTaskAction -Execute $PowerShellExe -Argument $ArgumentLine -WorkingDirectory $ProjectRoot
}

function Register-ManagedTasks {
    Assert-Project
    Write-Section 'Install generic PixelFix background services'
    $settings = New-ScheduledTaskSettingsSet `
        -StartWhenAvailable `
        -AllowStartIfOnBatteries `
        -DontStopIfGoingOnBatteries `
        -MultipleInstances IgnoreNew `
        -RestartCount 999 `
        -RestartInterval (New-TimeSpan -Minutes 1) `
        -ExecutionTimeLimit ([TimeSpan]::Zero)
    $principal = New-ScheduledTaskPrincipal -UserId $CurrentWindowsUser -LogonType Interactive -RunLevel Limited
    $trigger = New-ScheduledTaskTrigger -AtLogOn -User $CurrentWindowsUser

    if ($QueueDriver -in @('database', 'redis')) {
        $workerAction = New-ManagedAction 'worker-daemon'
        Register-ScheduledTask -TaskName $WorkerTaskName -Action $workerAction -Trigger $trigger -Settings $settings -Principal $principal -Description "PixelFix queue worker for $AppName" -Force | Out-Null
        Write-Host "Registered: $WorkerTaskName (queues: $Queues)" -ForegroundColor Green
    } else {
        Write-Host "Queue driver is '$QueueDriver'; no persistent background worker was registered. Use a persistent database/Redis queue to process web-request jobs in a separate process." -ForegroundColor Yellow
        if (Get-TaskSafe $WorkerTaskName) { Unregister-ScheduledTask -TaskName $WorkerTaskName -Confirm:$false }
    }

    $schedulerAction = New-ManagedAction 'scheduler-daemon'
    Register-ScheduledTask -TaskName $SchedulerTaskName -Action $schedulerAction -Trigger $trigger -Settings $settings -Principal $principal -Description "PixelFix scheduler for $AppName" -Force | Out-Null
    Write-Host "Registered: $SchedulerTaskName" -ForegroundColor Green
    Start-ManagedTasks
    Write-Host "Logs: $LogDirectory" -ForegroundColor Green
    Write-Host 'These processes run as background scheduled tasks while this Windows user is logged on; no terminal window needs to stay open.' -ForegroundColor Green
}

function Start-ManagedTasks {
    foreach ($name in @($WorkerTaskName, $SchedulerTaskName)) {
        $task = Get-TaskSafe $name
        if (-not $task) {
            if ($name -eq $WorkerTaskName -and $QueueDriver -notin @('database', 'redis')) { continue }
            throw "Scheduled task '$name' is not installed. Run .\scripts\PixelFixServices.ps1 setup first."
        }
        if ($task.State -eq 'Running') {
            Write-Host "Already running: $name" -ForegroundColor DarkGreen
            continue
        }
        Start-ScheduledTask -TaskName $name -ErrorAction Stop
        Write-Host "Started: $name" -ForegroundColor Green
    }
}

function Stop-ManagedTasks {
    foreach ($name in @($WorkerTaskName, $SchedulerTaskName)) {
        if (Get-TaskSafe $name) {
            try { Stop-ScheduledTask -TaskName $name -ErrorAction Stop } catch { Write-Warning "Could not stop $name : $($_.Exception.Message)" }
            Write-Host "Stopped: $name" -ForegroundColor Yellow
        } else {
            Write-Host "Not installed: $name"
        }
    }
}

function Show-Status {
    Write-Section "PixelFix services for $AppName"
    Write-Host "Queue driver: $QueueDriver"
    Write-Host "Worker queues: $Queues"
    foreach ($name in @($WorkerTaskName, $SchedulerTaskName)) {
        $task = Get-TaskSafe $name
        if (-not $task) { Write-Host "NOT INSTALLED  $name" -ForegroundColor Yellow; continue }
        $details = Get-ScheduledTaskInfo -TaskName $name
        [pscustomobject]@{
            Task = $name
            State = $task.State
            LastRun = $details.LastRunTime
            LastResult = ('0x{0:X8}' -f [long]$details.LastTaskResult)
            NextRun = $details.NextRunTime
        } | Format-List
    }
    foreach ($path in @($WorkerLog, $SchedulerLog)) {
        if (Test-Path $path) {
            Write-Host "`nRecent log: $path" -ForegroundColor Cyan
            Get-Content $path -Tail 12
        }
    }
}

function Invoke-WorkerDaemon {
    Assert-Project
    if ($QueueDriver -notin @('database', 'redis')) {
        "[$(Get-Date -Format s)] Queue driver '$QueueDriver' is not persistent; background worker exiting." | Add-Content $WorkerLog
        exit 0
    }
    while ($true) {
        "[$(Get-Date -Format s)] Starting queue worker for [$Queues]." | Add-Content -Path $WorkerLog
        & $PhpCommand.Source $Launcher 'queue:work' $Queues '--max-runtime=3600' 2>&1 | Tee-Object -FilePath $WorkerLog -Append
        $code = $LASTEXITCODE
        "[$(Get-Date -Format s)] Worker exited with code $code; restarting in 5 seconds." | Add-Content -Path $WorkerLog
        Start-Sleep -Seconds 5
    }
}

function Invoke-SchedulerDaemon {
    Assert-Project
    while ($true) {
        "[$(Get-Date -Format s)] schedule:run" | Add-Content -Path $SchedulerLog
        & $PhpCommand.Source $Launcher 'schedule:run' 2>&1 | Tee-Object -FilePath $SchedulerLog -Append
        $seconds = [Math]::Max(1, 60 - (Get-Date).Second)
        Start-Sleep -Seconds $seconds
    }
}

switch ($Action) {
    { $_ -in 'setup', 'install' } { Register-ManagedTasks; break }
    'start' { Assert-Project; Start-ManagedTasks; break }
    'stop' { Stop-ManagedTasks; break }
    'status' { Show-Status; break }
    'remove' {
        Stop-ManagedTasks
        foreach ($name in @($WorkerTaskName, $SchedulerTaskName)) {
            if (Get-TaskSafe $name) { Unregister-ScheduledTask -TaskName $name -Confirm:$false }
        }
        Write-Host 'PixelFix scheduled tasks removed. Application data and logs were preserved.' -ForegroundColor Green
        break
    }
    'verify' {
        Assert-Project
        & $PhpCommand.Source $Launcher 'subsystems:verify'
        exit $LASTEXITCODE
    }
    'worker-daemon' { Invoke-WorkerDaemon; break }
    'scheduler-daemon' { Invoke-SchedulerDaemon; break }
}
