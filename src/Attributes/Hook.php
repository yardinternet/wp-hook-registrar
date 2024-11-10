<?php

declare(strict_types=1);

namespace Yard\Hooks\Attributes;

abstract class Hook
{
    public function __construct(
        public string $hookName,
        public int $priority = 10,
        public int $acceptedArgs = 1
    ) {
    }

    abstract public function register(callable $callable): void;
}
