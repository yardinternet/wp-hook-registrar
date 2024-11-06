<?php

namespace Yard\Hooks;

use ReflectionAttribute;
use ReflectionClass;
use ReflectionException;
use Yard\Hooks\Attributes\Hook;

class HooksRegistrar
{
	private array $instances = [];

	public function __construct(private array $classNames = [])
	{
	}

	public function addClass(string $className): self
	{
		$this->classNames[] = $className;

		return $this;
	}

	public function addClassInstance(string $className, object $instance): self
	{
		$this->instances[$className] = $instance;

		return $this;
	}

	/**
	 * @throws ReflectionException
	 */
	public function registerHooks(): void
	{
		foreach ($this->classNames as $className) {
			$reflectionClass = new ReflectionClass($className);

			foreach ($reflectionClass->getMethods() as $method) {
				$attributes = $method->getAttributes(Hook::class, ReflectionAttribute::IS_INSTANCEOF);

				foreach ($attributes as $attribute) {
					if (! array_key_exists($className, $this->instances)) {
						$this->instances[$className] = new $className();
					}

					$filterClass = $attribute->newInstance();
					$filterClass->register(
						[
							$this->instances[$className],
							$method->getName()
						]
					);
				}
			}
		}
	}
}