<?php

namespace Yard\Hooks\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD|Attribute::IS_REPEATABLE)]
class Action Extends Hook
{
	public function register(callable|array $method): void
	{
		add_action(
			$this->hookName,
			$method,
			$this->priority,
			$this->acceptedArgs
		);
	}
}