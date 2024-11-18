<?php

declare(strict_types=1);

use Yard\Hook\Config;
use Yard\Hook\PluginConfig;

describe('configuration', function () {
    it('can create configData from empty config', function () {
        $configData = Config::from([]);

        expect($configData)->toBeInstanceOf(Config::class);
    });

    it('can create configData', function () {
        $hooksConfig = [
            'classNames' => [
                \Yard\Hook\Tests\Stubs\ClassContainsHooks::class,
            ],
            'plugins' => [
                'acf/acf.php' => [\Yard\Hook\Tests\Stubs\ChildClassContainsHooks::class],
            ],
        ];

        $configData = Config::from($hooksConfig);

        expect($configData)->toBeInstanceOf(Config::class);
    });

    it('gets classNames from configData', function () {
        $hooksConfig = [
            'classNames' => [
                \Yard\Hook\Tests\Stubs\ClassContainsHooks::class,
            ],
        ];

        $configData = Config::from($hooksConfig);

        expect($configData->classNames())->toBeArray()
            ->toContain(\Yard\Hook\Tests\Stubs\ClassContainsHooks::class);
    });

    it('returns plugin hooks if plugin active', function () {
        $classNames = [
            \Yard\Hook\Tests\Stubs\ClassContainsHooks::class,
        ];

        $plugin = new PluginConfig(
            'acf/acf.php',
            [
                \Yard\Hook\Tests\Stubs\ChildClassContainsHooks::class,
            ],
        );

        $config = new Config($classNames, [$plugin]);

        WP_Mock::userFunction('is_plugin_active', [
            'times' => 1,
            'args' => ['acf/acf.php'],
            'return' => true,
        ]);

        expect($config->classNames())->toBeArray()
            ->toContain(\Yard\Hook\Tests\Stubs\ClassContainsHooks::class)
            ->toContain(\Yard\Hook\Tests\Stubs\ChildClassContainsHooks::class);
    });
    it('does not return plugin hooks if plugin inactive', function () {
        $classNames = [
            \Yard\Hook\Tests\Stubs\ClassContainsHooks::class,
        ];

        $plugin = new PluginConfig(
            'acf/acf.php',
            [
                \Yard\Hook\Tests\Stubs\ChildClassContainsHooks::class,
            ],
        );

        $config = new Config($classNames, [$plugin]);

        WP_Mock::userFunction('is_plugin_active', [
            'times' => 1,
            'args' => ['acf/acf.php'],
            'return' => false,
        ]);

        expect($config->classNames())->toBeArray()
            ->toContain(\Yard\Hook\Tests\Stubs\ClassContainsHooks::class)
            ->not()->toContain(\Yard\Hook\Tests\Stubs\ChildClassContainsHooks::class);
    });
});
