<?php

return [

    'csrf' => filter_var(
        env(
            'CSRF_ENABLED',
            true
        ),
        FILTER_VALIDATE_BOOL
    ),

];
