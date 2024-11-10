<?php

declare(strict_types=1);

use Yard\Hooks\Tests\TestCase;

uses(TestCase::class)->in(__DIR__);

/**
 * @param array<int, mixed> $parameters
 *
 * @throws ReflectionException
 */
function invokeProtectedMethod(object $object, string $methodName, array $parameters = []): mixed
{
    $reflection = new ReflectionClass($object);
    $method = $reflection->getMethod($methodName);
    $method->setAccessible(true);

    return $method->invokeArgs($object, $parameters);
}
