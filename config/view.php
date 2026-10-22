<?php

return [

    'debug' => filter_var(
        env(
            'TWIG_DEBUG',
            false
        ),
        FILTER_VALIDATE_BOOL
    ),

];
