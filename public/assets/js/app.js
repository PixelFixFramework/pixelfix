// =====================================================
// ZEBRA DIALOG UTILITIES
// =====================================================

function isZebraDialogAvailable() {
	return Boolean(
		window.jQuery
		&&
		typeof window.jQuery.Zebra_Dialog === 'function'
	);
}

function escapeZebraDialogContent(value) {
	return String(value ?? '')
		.replace(/&/g, '&amp;')
		.replace(/</g, '&lt;')
		.replace(/>/g, '&gt;')
		.replace(/"/g, '&quot;')
		.replace(/'/g, '&#039;');
}

function showZebraDialog(message, options = {}) {
	if (!isZebraDialogAvailable()) {
		return null;
	}

	const {
		htmlContent = false,
		...dialogOptions
	} = options;

	if (typeof dialogOptions.title === 'string') {
		dialogOptions.title = escapeZebraDialogContent(
			dialogOptions.title
		);
	}

	const content = htmlContent
		? String(message ?? '')
		: escapeZebraDialogContent(message);

	return new window.jQuery.Zebra_Dialog(
		content,
		dialogOptions
	);
}

// =====================================================
// PREVENT UNINTENDED DIALOG CLOSING
// =====================================================
//
// Zebra Dialog 3.1.0 calls onBeforeClose with an empty
// string when closing is requested through the backdrop,
// Escape, or the close button.
//
// Returning false cancels the closing operation.
// A non-empty button caption permits the dialog to close.
//
// =====================================================

function preventZebraDialogDismissal(caption) {
	return typeof caption === 'string'
		&& caption.length > 0;
}

// =====================================================
// AJAX SUCCESS DIALOG
// =====================================================

function handleSuccess(response = {}) {
	const result =
		response && typeof response === 'object'
			? response
			: {};

	const redirectUrl =
		result.redirect || window.location.href;

	const message =
		result.message || 'Operation successful.';

	if (!isZebraDialogAvailable()) {
		window.alert(message);
		window.location.href = redirectUrl;
		return;
	}

	showZebraDialog(
		message,
		{
			type: 'confirmation',
			title: '',
			backdrop_close: false,
			keyboard: false,
			show_close_button: false,
			buttons: [
				{
					caption: 'OK',
					custom_class: 'btn btn-secondary',
				},
			],
			onBeforeClose: preventZebraDialogDismissal,
			onClose: function (caption) {
				if (caption === 'OK') {
					window.location.href = redirectUrl;
				}
			},
		}
	);
}

// =====================================================
// AJAX FAILURE DIALOG
// =====================================================

function handleFailure(response = {}) {
	const result =
		response && typeof response === 'object'
			? response
			: {};

	const message =
		result.message || 'Operation failed.';

	if (!isZebraDialogAvailable()) {
		window.alert(message);
		return;
	}

	showZebraDialog(
		message,
		{
			type: 'information',
			title: '',
			backdrop_close: false,
			keyboard: false,
			show_close_button: false,
			buttons: [
				{
					caption: 'OK',
					custom_class: 'btn btn-secondary',
				},
			],
			onBeforeClose: preventZebraDialogDismissal,
		}
	);
}

// =====================================================
// DESTRUCTIVE ACTION CONFIRMATION
// =====================================================

function showConfirmation(text, callback) {
	const title = String(text ?? 'Are you sure?');
	const message =
	`<div class="text-start">
		<p>
			Are you sure you want to proceed with
			deleting the record?
		</p>
		<span class='text-muted'>This action maybe irreversible.</span>
	</div>`;

	if (!isZebraDialogAvailable()) {
		if (
			window.confirm(title + '\n\n' + message)
			&&
			typeof callback === 'function'
		) {
			callback();
		}

		return;
	}

	showZebraDialog(
		message,
		{
			htmlContent: true,
			type: 'warning',
			title: '',
			backdrop_close: false,
			keyboard: false,
			show_close_button: false,
			buttons: [
				{
					caption: 'Yes, Proceed',
					custom_class: 'btn btn-danger',
				},
				{
					caption: 'No, Cancel',
					custom_class: 'btn btn-secondary',
				},
			],
			onBeforeClose: preventZebraDialogDismissal,
			onClose: function (caption) {
				if (
					caption === 'Yes, Proceed'
					&& typeof callback === 'function'
				) {
					callback();
				}
			},
		}
	);
}

// =====================================================
// NOTIFICATION
// =====================================================

function showMessage(
	type,
	message,
	driver = 'toastr'
) {

	// =========================
	// TOASTR
	// =========================

	if (driver === 'toastr') {

		switch (type) {

			case 'error':
				toastr.error(message);
				break;

			case 'warning':
				toastr.warning(message);
				break;

			case 'info':
				toastr.info(message);
				break;

			default:
				toastr.success(message);
		}

		return;
	}

	// =========================
	// ZEBRA
	// =========================

	if (driver === 'zebra') {

		const zebraTypes = {
			error: 'error',
			warning: 'warning',
			info: 'information',
			success: 'confirmation',
		};

		if (!isZebraDialogAvailable()) {
			window.alert(message);
			return;
		}

		showZebraDialog(
			message,
			{
				type: zebraTypes[type] || 'information',
				backdrop_close: false,
				keyboard: false,
				show_close_button: false,
				onBeforeClose: preventZebraDialogDismissal,
			}
		);

		return;
	}

	// =========================
	// FALLBACK
	// =========================

	window.alert(message);
}

// =====================================================
// FLASH MESSAGES
// =====================================================

function handleFlashMessages(
	driver
) {

	if (
		!window.flashMessages
		||
		window.flashMessages.length === 0
	) {

		return;
	}

	window.flashMessages.forEach(msg => {

		showMessage(
			msg.type,
			msg.message,
			driver
		);
	});
}

// =====================================================
// BOOTSTRAP VALIDATION
// =====================================================

function initializeBootstrapValidation(
	driver = 'toastr'
) {

	const forms =
		document.querySelectorAll('form');

	Array.from(forms).forEach(form => {

		// =================================================
		// CHECK FOR REQUIRED FIELDS
		// =================================================

		const hasRequiredFields =
			form.querySelector(
				'[required]'
			) !== null;

		// =================================================
		// NO REQUIRED FIELDS
		// =================================================

		if (!hasRequiredFields) {

			return;
		}

		// =================================================
		// ENABLE BOOTSTRAP VALIDATION
		// =================================================

		form.classList.add(
			'needs-validation'
		);

		form.setAttribute(
			'novalidate',
			''
		);

		// =================================================
		// SUBMIT
		// =================================================

		form.addEventListener(

			'submit',

			event => {

				if (
					!form.checkValidity()
				) {

					event.preventDefault();

					event.stopPropagation();

					showMessage(
						'error',
						'Please fix the form errors.',
						driver
					);
				}

				form.classList.add(
					'was-validated'
				);
			},

			false
		);
	});
}

// =====================================================
// BROWSER HISTORY SYNCHRONIZATION
// =====================================================

function synchronizeBrowserHistory(
	event
) {

	if (
		!event.persisted
	) {

		return;
	}

	window.location.reload();
}

// =====================================================
// PAGE RESTORE
// =====================================================

window.addEventListener(
	'pageshow',
	synchronizeBrowserHistory
);

// =====================================================
// APPLICATION BOOT
// =====================================================

document.addEventListener(

	'DOMContentLoaded',

	() => {

		const driver =
			window.uiDriver
			|| 'toastr';

		handleFlashMessages(
			driver
		);

		initializeBootstrapValidation(
			driver
		);
	}
);