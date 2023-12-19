<?php

declare(strict_types=1);

namespace Symblaze\TestPack;

use ReflectionClass;

/**
 * All test cases should extend this class
 */
abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->invokeTemplateMethods('setUp');
    }

    protected function tearDown(): void
    {
        $this->invokeTemplateMethods('tearDown');

        parent::tearDown();
    }

    private function invokeTemplateMethods(string $prefix): void
    {
        $traits = $this->usedTraits(static::class);
        $called = [];

        foreach ($traits as $trait) {
            $reflection = new ReflectionClass($trait);
            $methods = $reflection->getMethods();

            foreach ($methods as $method) {
                if ($method->name !== $prefix &&
                    str_starts_with($method->name, $prefix) &&
                    ! in_array($method->name, $called, true)
                ) {
                    $this->{$method->name}();
                    $called[] = $method->name;
                }
            }
        }
    }

    private function usedTraits(string $class): array
    {
        $traits = class_uses($class);

        foreach ($traits as $trait) {
            $traits += $this->usedTraits($trait);
        }

        return array_unique($traits);
    }
}
