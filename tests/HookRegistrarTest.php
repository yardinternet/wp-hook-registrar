<?php

declare(strict_types=1);

use Yard\Hook\Registrar;
use Yard\Hook\Tests\Stubs\ChildClassContainsHooks;
use Yard\Hook\Tests\Stubs\ClassContainsHooks;

beforeEach(function () {
	// Arrange //
	$this->classContainsHooks = new ClassContainsHooks();
	$this->childClassContainsHooks = new ChildClassContainsHooks();
	$this->registrar = new Registrar();
});

describe('class hooks', function () {
	beforeEach(function () {
		// Arrange //
		invokeProtectedMethod($this->registrar, 'setInstance', [
			ClassContainsHooks::class,
			$this->classContainsHooks,
		]);
		$this->registrar->addClass(ClassContainsHooks::class);
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
		WP_Mock::expectFilterAdded('the_content', [$this->classContainsHooks, 'filterSomethingElse'], 5);
		WP_Mock::expectFilterAdded('the_content', [$this->classContainsHooks, 'filterSomethingElseWithDefaultArgs']);

		// Act //
		$this->registrar->registerHooks();
	});

	it('can register the same method on multiple hooks', function () {
		// Expect //
		WP_Mock::expectActionAdded('init', [$this->classContainsHooks, 'doSomethingOnInitAndAdminInit']);
		WP_Mock::expectActionAdded('admin_init', [$this->classContainsHooks, 'doSomethingOnInitAndAdminInit']);

		// Act //
		$this->registrar->registerHooks();
	});
});

describe('child class hooks', function () {
	beforeEach(function () {
		// Arrange //
		invokeProtectedMethod($this->registrar, 'setInstance', [
			ChildClassContainsHooks::class,
			$this->childClassContainsHooks,
		]);
		$this->registrar->addClass(ChildClassContainsHooks::class);
	});

	it('can register hooks for child classes', function () {
		// Expect //
		WP_Mock::expectActionAdded('save_post', [$this->childClassContainsHooks, 'doSomething'], 10, 2);
		WP_Mock::expectActionNotAdded('save_post', [$this->classContainsHooks, 'doSomething']);
		WP_Mock::expectActionAdded('save_post', [$this->childClassContainsHooks, 'doSomethingElse'], 5, 3);
		WP_Mock::expectFilterAdded('the_content', [$this->childClassContainsHooks, 'filterSomething'], 10, 2);

		// Act //
		$this->registrar->registerHooks();
	});

	it('can prevent hook registration in parent using method override', function () {
		// Expect //
		WP_Mock::expectActionNotAdded('fake_hook', [$this->classContainsHooks, 'shouldNotGetRegistered']);
		WP_Mock::expectActionNotAdded('fake_hook', [$this->childClassContainsHooks, 'shouldNotGetRegistered']);

		// Act //
		$this->registrar->registerHooks();
	});
});
