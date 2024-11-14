<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Hooks Configuration
    |--------------------------------------------------------------------------
    | This is the configuration for the hooks package. You can add your own
    | classes to the classNames array. All Hooks in these classes will be
    | automatically registered with WordPress.
    |
    */

    'classNames' => [
        //        		\App\Hooks\Theme::class,
    ],
    

    /*
    |--------------------------------------------------------------------------
    | Plugin Hooks
    |--------------------------------------------------------------------------
    | Plugin hooks are only registered if the plugin is active. Key should be the
    | path relative to the plugins directory, as is expected by the WordPress
    | function `\is_plugin_active()`. Value expects an array of classNames that
    | contain the hooks to be registered.
    |
    */

    'plugins' => [
        //        'acf/acf.php' => [\App\Hooks\Acf::class],
        //        'wp-seopress-pro/seopress-pro.php' => [\App\Hooks\SeoPress::class],
    ],
];
