<?php

declare(strict_types=1);

use Yard\Hooks\HookRegistrar;
use Yard\Hooks\Tests\Stubs\ChildClassContainsHooks;
use Yard\Hooks\Tests\Stubs\ClassContainsHooks;

beforeEach(function () {
    // Arrange //
    $this->classContainsHooks = new ClassContainsHooks();
    $this->childClassContainsHooks = new ChildClassContainsHooks();
    $this->registrar = new HookRegistrar();

    invokeProtectedMethod($this->registrar, 'setInstance', [
        ClassContainsHooks::class,
        $this->classContainsHooks,
    ]);

    $this->registrar->addClass(ClassContainsHooks::class);
});

describe('class hooks', function () {
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

        // Act //
        $this->registrar->registerHooks();
    });

});
