<?php

declare(strict_types=1);

use Facades\Yard\Hook\HookRegistrar;
use Illuminate\Support\Facades\Config;
use Yard\Hook\Tests\Stubs\ClassContainsHooks;

describe('class hooks', function () {
    beforeEach(function () {
        Config::shouldReceive('get')
            ->with('hooks', null)
            ->andReturn([
                'classNames' => [ClassContainsHooks::class],
            ]);
    });

    it('should register hooks once the package is booted', function () {
        // Expect //
        HookRegistrar::shouldReceive('registerHooks')
            ->once();

        // Act //
        $provider = new \Yard\Hook\HookServiceProvider(app());
        $provider->packageBooted();
    });

    it('passes classNames from config into the HookRegistrar', function () {
        // Act //
        $registrar = app(\Yard\Hook\HookRegistrar::class);

        // Expect //
        expect(getPrivateProperty($registrar, 'classNames'))->toBeArray()
            ->toContain(ClassContainsHooks::class);
    });

});
