<?php

declare(strict_types=1);

namespace Symblaze\TestPack\Assert\Console;

use Symblaze\TestPack\Concern\WithCommandTester;

/**
 * @mixin WithCommandTester
 */
trait OutputAssertTrait
{
    protected function assertCommandOutputs(string $expected, string $message = ''): void
    {
        $display = $this->commandTester->getDisplay();
        $this->assertStringContainsString($expected, $display, $message);
    }

    protected function assertCommandNotOutputs(string $expected, string $message = ''): void
    {
        $display = $this->commandTester->getDisplay();
        $this->assertStringNotContainsString($expected, $display, $message);
    }
}
