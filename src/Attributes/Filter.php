<?php

declare(strict_types=1);

namespace Yard\Hooks\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD|Attribute::IS_REPEATABLE)]
class Filter extends Hook
{
    public function register(callable $callable, int $acceptedArgs = 1): void
    {
        add_filter(
            $this->hookName,
            $callable,
            $this->priority,
            $acceptedArgs
        );
    }
}
