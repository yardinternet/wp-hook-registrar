<?php

namespace Yard\Hooks\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD|Attribute::IS_REPEATABLE)]
class Filter extends Hook
{
	public function register(callable|array $method): void
	{
		add_filter(
			$this->hookName,
			$method,
			$this->priority,
			$this->acceptedArgs
		);
	}
}