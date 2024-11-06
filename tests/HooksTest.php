<?php

declare(strict_types=1);

use Yard\Hooks\HooksRegistrar;
use Yard\Hooks\Tests\Stubs\ClassContainsHooks;


beforeEach(function () {
	$this->classContainsHooks = new ClassContainsHooks();
	$this->registrar = new HooksRegistrar();
	$this->registrar->addClass(ClassContainsHooks::class);
	$this->registrar->addClassInstance(ClassContainsHooks::class, $this->classContainsHooks);
});

it('can register action hooks', function () {
	// Expect //
	WP_Mock::expectActionAdded('save_post', [$this->classContainsHooks, 'doSomething'], 10, 2);
	WP_Mock::expectActionAdded('save_post', [$this->classContainsHooks, 'doSomethingElse'], 5, 3);
	WP_Mock::expectActionAdded('save_post', [$this->classContainsHooks, 'doSomethingWithDefaultArgs']);

	// Act //
	$this->registrar->registerHooks();
});

it('can register filter hooks', function () {
	// Expect //
	WP_Mock::expectFilterAdded('the_content', [$this->classContainsHooks, 'filterSomething'], 10, 2);
	WP_Mock::expectFilterAdded('the_content', [$this->classContainsHooks, 'filterSomethingElse'], 5, 1);
	WP_Mock::expectFilterAdded('the_content', [$this->classContainsHooks, 'filterSomethingElseWithDefaultArgs']);

	// Act //
	$this->registrar->registerHooks();
});

