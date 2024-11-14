<?php

declare(strict_types=1);

use Yard\Hooks\ConfigData;

describe('configuration', function () {

    it('can create configData from empty config', function () {
        $configData = ConfigData::from([]);

        expect($configData)->toBeInstanceOf(ConfigData::class);

    });

    it('can create configData', function () {
        $hooksConfig = [
            'classNames' => [
                \Yard\Hooks\Tests\Stubs\ClassContainsHooks::class,
            ],
            'plugins' => [
                'acf/acf.php' => [\Yard\Hooks\Tests\Stubs\ChildClassContainsHooks::class],
            ],
        ];

        $configData = ConfigData::from($hooksConfig);

        expect($configData)->toBeInstanceOf(ConfigData::class);
    });

    it('gets classNames from configData', function () {
        $hooksConfig = [
            'classNames' => [
                \Yard\Hooks\Tests\Stubs\ClassContainsHooks::class,
            ],
        ];

        $configData = ConfigData::from($hooksConfig);

        expect($configData->classNames())->toBeArray()
            ->toContain(\Yard\Hooks\Tests\Stubs\ClassContainsHooks::class);
    });

    it('returns plugin hooks if plugin active', function () {
        $hooksConfig = [
            'classNames' => [
                \Yard\Hooks\Tests\Stubs\ClassContainsHooks::class,
            ],
            'plugins' => [
                'acf/acf.php' => [\Yard\Hooks\Tests\Stubs\ChildClassContainsHooks::class],
            ],
        ];

        $configData = ConfigData::from($hooksConfig);

        WP_Mock::userFunction('is_plugin_active', [
            'times' => 1,
            'args' => ['acf/acf.php'],
            'return' => true,
        ]);

        expect($configData->classNames())->toBeArray()
            ->toContain(\Yard\Hooks\Tests\Stubs\ClassContainsHooks::class)
            ->toContain(\Yard\Hooks\Tests\Stubs\ChildClassContainsHooks::class);
    });
    it('does not return plugin hooks if plugin inactive', function () {
        $hooksConfig = [
            'classNames' => [
                \Yard\Hooks\Tests\Stubs\ClassContainsHooks::class,
            ],
            'plugins' => [
                'acf/acf.php' => [\Yard\Hooks\Tests\Stubs\ChildClassContainsHooks::class],
            ],
        ];

        $configData = ConfigData::from($hooksConfig);

        WP_Mock::userFunction('is_plugin_active', [
            'times' => 1,
            'args' => ['acf/acf.php'],
            'return' => false,
        ]);

        expect($configData->classNames())->toBeArray()
            ->toContain(\Yard\Hooks\Tests\Stubs\ClassContainsHooks::class)
            ->not()->toContain(\Yard\Hooks\Tests\Stubs\ChildClassContainsHooks::class);
    });
});
