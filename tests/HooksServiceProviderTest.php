<?php

declare(strict_types=1);

use Facades\Yard\Hooks\HookRegistrar;
use Illuminate\Support\Facades\Config;
use Yard\Hooks\Tests\Stubs\ClassContainsHooks;

beforeEach(function () {
    Config::shouldReceive('get')
        ->with('hooks.classNames', null)
        ->andReturn([
            ClassContainsHooks::class,
        ]);
});

it('should register hooks once the package is booted', function () {
    // Expect //
    HookRegistrar::shouldReceive('registerHooks')
        ->once();

    // Act //
    $provider = new \Yard\Hooks\HooksServiceProvider(app());
    $provider->packageBooted();
});

it('passes classNames from config into the HookRegistrar', function () {
    // Act //
    $registrar = app(\Yard\Hooks\HookRegistrar::class);

    // Expect //
    expect(getPrivateProperty($registrar, 'classNames'))->toBeArray()
        ->toContain(ClassContainsHooks::class);
});
