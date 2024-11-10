<?php

declare(strict_types=1);

namespace Yard\Hooks\Tests\Stubs;

use Yard\Hooks\Attributes\Action;
use Yard\Hooks\Attributes\Filter;

class ClassContainsHooks
{
    #[Action('save_post', 10)]
    public function doSomething($one, $two)
    {
        //
    }

    #[Action('save_post', 5)]
    public function doSomethingElse($one, $two, $three)
    {
        //
    }

    #[Action('save_post')]
    public function doSomethingWithDefaultArgs()
    {
        //
    }

    #[Filter('the_content', 10)]
    public function filterSomething($one, $two)
    {
        //
    }

    #[Filter('the_content', 5)]
    public function filterSomethingElse($one)
    {
        //
    }

    #[Filter('the_content')]
    public function filterSomethingElseWithDefaultArgs()
    {
        //
    }
}