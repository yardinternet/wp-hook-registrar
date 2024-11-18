<?php

declare(strict_types=1);

namespace Yard\Hook;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD|Attribute::IS_REPEATABLE)]
class Action implements Hook
{
    public function __construct(
        public string $hookName,
        public int $priority = 10,
    ) {
    }

    public function register(callable $callable, int $acceptedArgs = 1): void
    {
        add_action(
            $this->hookName,
            $callable,
            $this->priority,
            $acceptedArgs
        );
    }
}