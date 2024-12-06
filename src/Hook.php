<?php

declare(strict_types=1);

namespace Yard\Hook;

interface Hook
{
	public function __construct(
		string $hookName,
		int $priority = 10,
	);

	public function register(callable $callable, int $acceptedArgs = 1): void;
}
