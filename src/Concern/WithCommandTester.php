<?php

declare(strict_types=1);

namespace Symblaze\TestPack\Concern;

use Symblaze\TestPack\Assert\Console\ExitCodeAssertTrait;
use Symblaze\TestPack\Assert\Console\OutputAssertTrait;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @mixin KernelTestCase
 */
trait WithCommandTester
{
    use ExitCodeAssertTrait;
    use OutputAssertTrait;

    protected CommandTester $commandTester;

    protected function console(string $command, array $arguments = [], ?Application $application = null): CommandTester
    {
        $application = $application ?? $this->consoleApp();
        $this->commandTester = new CommandTester($application->find($command));
        $this->commandTester->execute($arguments);

        return $this->commandTester;
    }

    protected function consoleApp(array $options = []): Application
    {
        $kernel = self::bootKernel($options);

        return new Application($kernel);
    }
}
