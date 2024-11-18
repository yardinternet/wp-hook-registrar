<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Hook Classes
    |--------------------------------------------------------------------------
    | Add your custom hook classes to the 'classNames' array below. All hooks
    | defined within these classes will be automatically registered with WordPress.
    |
    */

    'classNames' => [
        // \App\Hooks\Theme::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugin-Specific Hooks
    |--------------------------------------------------------------------------
    | Define plugin-specific hooks that should only be registered when the
    | respective plugin is active. Use the relative plugin path as the key,
    | which matches the format expected by the WordPress `is_plugin_active()`
    | function.
    |
    */

    'plugins' => [
        // 'acf/acf.php' => [
        //     'classNames' => [],
        //     'files' => [],
        //     'directories' => [],
        //     'namespaces' => [],
        // ],
    ],
];
