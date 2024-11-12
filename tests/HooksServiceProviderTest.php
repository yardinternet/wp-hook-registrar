<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Config;
use Yard\Hooks\HookRegistrar;
use Yard\Hooks\Tests\Stubs\ClassContainsHooks;

it('registers hooks in classNames from config', function () {
    // Arrange //
    Config::shouldReceive('get')
        ->with('hooks.classNames', null)
        ->andReturn([
            ClassContainsHooks::class,
        ]);

    app()->singleton(HookRegistrar::class, fn () => new HookRegistrar(config('hooks.classNames')));

    $registrar = app(HookRegistrar::class);
    $classContainsHooks = new ClassContainsHooks();

    invokeProtectedMethod($registrar, 'setInstance', [
        ClassContainsHooks::class,
        $classContainsHooks,
    ]);

    // Expect //
    WP_Mock::expectActionAdded('save_post', [$classContainsHooks, 'doSomething'], 10, 2);

    // Act //
    $registrar->registerHooks();
});
