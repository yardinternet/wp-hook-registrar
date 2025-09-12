<?php

declare(strict_types=1);

/**
 * @param array<int, mixed> $parameters
 *
 * @throws ReflectionException
 */
function invokeProtectedMethod(object $object, string $methodName, array $parameters = []): mixed
{
	$reflection = new \ReflectionClass($object);
	$method = $reflection->getMethod($methodName);

	return $method->invokeArgs($object, $parameters);
}

/**
 * @throws ReflectionException
 */
function getPrivateProperty(object $object, string $propertyName): mixed
{
	$reflectionClass = new \ReflectionClass($object);
	$property = $reflectionClass->getProperty($propertyName);

	return $property->getValue($object);
}
