<?php

use Illuminate\Support\Facades\Config;
use Yard\Hooks\HooksRegistrar;

it('registers hooks in classNames from config', function () {
	// Arrange //
	Config::shouldReceive('get')
		->with('hooks.classNames', null)
		->andReturn([
			\Yard\Hooks\Tests\Stubs\ClassContainsHooks::class
		]);

	app()->singleton(HooksRegistrar::class, fn() => new HooksRegistrar(config('hooks.classNames')));

	$registrar = app(HooksRegistrar::class);
	$classContainsHooks = new \Yard\Hooks\Tests\Stubs\ClassContainsHooks();
	$registrar->addClassInstance(\Yard\Hooks\Tests\Stubs\ClassContainsHooks::class, $classContainsHooks);

	// Expect //
	WP_Mock::expectActionAdded('save_post', [$classContainsHooks, 'doSomething'], 10, 2);

	// Act //
	$registrar->registerHooks();
});
