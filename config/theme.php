<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default theme colors (hex). Used when not set in admin.
    |--------------------------------------------------------------------------
    */
    'defaults' => [
        'theme_primary'       => '#059669',
        'theme_secondary'     => '#047857',
        'theme_accent'        => '#10B981',
        'theme_text_dark'      => '#1a1a1a',
        'theme_text_light'     => '#666666',
        'theme_background'     => '#ffffff',
        'theme_success'        => '#10B981',
        'theme_warning'        => '#F59E0B',
        'theme_error'          => '#EF4444',
    ],

    /** CSS variable names (without --) that map to setting keys */
    'css_map' => [
        'primary'        => 'theme_primary',
        'secondary'      => 'theme_secondary',
        'accent'         => 'theme_accent',
        'text-dark'       => 'theme_text_dark',
        'text-light'      => 'theme_text_light',
        'background'      => 'theme_background',
        'success'         => 'theme_success',
        'warning'         => 'theme_warning',
        'error'           => 'theme_error',
    ],
];
