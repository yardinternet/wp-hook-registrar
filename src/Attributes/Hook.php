<?php

namespace Yard\Hooks\Attributes;


abstract class Hook
{
	public function __construct(
		public string $hookName,
		public int $priority = 10,
		public int $acceptedArgs = 1
	)
	{}

	abstract public function register(callable|array $method): void;
}