<?php

declare(strict_types=1);

namespace Yard\Hook;

use Exception;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

class Registrar
{
	/**
	 * @var array<class-string, object>
	 */
	private array $instances = [];

	/**
	 * @param array<class-string> $classNames
	 */
	public function __construct(private array $classNames = [])
	{
	}

	/**
	 * @param class-string $className
	 */
	public function addClass(string $className): self
	{
		$this->classNames[] = $className;

		return $this;
	}

	/**
	 * @param class-string $className
	 */
	protected function getInstance(string $className): object
	{
		return $this->instances[$className];
	}

	/**
	 * @param class-string $className
	 */
	private function setInstance(string $className, object $instance): void
	{
		$this->instances[$className] = $instance;
	}

	private function hasInstance(string $className): bool
	{
		return array_key_exists($className, $this->instances);
	}

	/**
	 * @throws ReflectionException
	 * @throws Exception
	 */
	public function registerHooks(): void
	{
		foreach ($this->classNames as $className) {
			$reflectionClass = new ReflectionClass($className);

			foreach ($reflectionClass->getMethods() as $method) {
				$attributes = $method->getAttributes(Hook::class, ReflectionAttribute::IS_INSTANCEOF);

				foreach ($attributes as $attribute) {
					if (! $this->hasInstance($className)) {
						$this->setInstance($className, (object)new $className());
					}

					$hookClass = $attribute->newInstance();
					$hookClass->register(
						callable: $this->makeCallable($className, $method),
						acceptedArgs: $this->methodArgs($method)
					);
				}
			}
		}
	}

	/**
	 * @param class-string $className
	 *
	 * @throws Exception
	 */
	private function makeCallable(string $className, ReflectionMethod $method): callable
	{
		$callable = [
			$this->getInstance($className),
			$method->getName(),
		];

		if (! is_callable($callable)) {
			throw new Exception('Method is not callable');
		}

		return $callable;
	}

	private function methodArgs(ReflectionMethod $method): int
	{
		$methodArgs = $method->getNumberOfParameters();

		return 0 !== $methodArgs ? $methodArgs : 1;
	}
}
