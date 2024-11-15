<?php

declare(strict_types=1);

namespace Yard\Hooks\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD|Attribute::IS_REPEATABLE|Attribute::TARGET_FUNCTION)]
class Action extends Hook
{

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
