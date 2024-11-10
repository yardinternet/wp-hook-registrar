<?php

declare(strict_types=1);

namespace Yard\Hooks\Tests\Stubs;

use Yard\Hooks\Attributes\Action;
use Yard\Hooks\Attributes\Filter;

class ClassContainsHooks
{
    #[Action('save_post', 10, 2)]
    public function doSomething()
    {
        //
    }

    #[Action('save_post', 5, 3)]
    public function doSomethingElse()
    {
        //
    }

    #[Action('save_post')]
    public function doSomethingWithDefaultArgs()
    {
        //
    }

    #[Filter('the_content', 10, 2)]
    public function filterSomething()
    {
        //
    }

    #[Filter('the_content', 5, 1)]
    public function filterSomethingElse()
    {
        //
    }

    #[Filter('the_content')]
    public function filterSomethingElseWithDefaultArgs()
    {
        //
    }
}
