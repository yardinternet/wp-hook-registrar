<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Hook Classes
    |--------------------------------------------------------------------------
    | Add your custom hook classes to the classNames array below. All hooks
    | defined in these classes will be automatically registered with WordPress.
    |
    */

    'classNames' => [
        // \App\Hooks\Theme::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugin-Specific Hooks
    |--------------------------------------------------------------------------
    | Define hooks that are specific to a plugin and should only be registered
    | when the plugin is active. Use the plugin’s relative path as the key,
    | matching the format required by the WordPress `is_plugin_active()` function.
    |
    */

    'plugins' => [
        // 'acf/acf.php' => [
        //     'classNames' => [],
        // ],
    ],
];
