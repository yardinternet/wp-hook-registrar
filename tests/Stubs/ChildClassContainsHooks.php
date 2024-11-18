<?php

declare(strict_types=1);

namespace Yard\Hooks\Tests\Stubs;

use Yard\Hooks\Action;

class ChildClassContainsHooks extends ClassContainsHooks
{
    #[Action('save_post', 10)]
    public function doSomething($one, $two): string
    {
        return 'child';
    }

    public function shouldNotGetRegistered()
    {
        throw new \Exception('This method should not be registered');
    }
}
