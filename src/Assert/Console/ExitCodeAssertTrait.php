<?php

declare(strict_types=1);

namespace Symblaze\TestPack\Assert\Console;

use Symblaze\TestPack\Concern\WithCommandTester;
use Symfony\Component\Console\Command\Command;

/**
 * @mixin WithCommandTester
 */
trait ExitCodeAssertTrait
{
    protected function assertCommandSucceeded(): void
    {
        $this->commandTester->assertCommandIsSuccessful();
    }

    protected function assertCommandDidNotSucceed(): void
    {
        $exitCode = $this->commandTester->getStatusCode();
        $this->assertNotEquals(Command::SUCCESS, $exitCode);
    }

    protected function assertCommandFailed(): void
    {
        $this->assertEquals(Command::FAILURE, $this->commandTester->getStatusCode());
    }

    protected function assertCommandInvalid(): void
    {
        $this->assertEquals(Command::INVALID, $this->commandTester->getStatusCode());
    }
}
