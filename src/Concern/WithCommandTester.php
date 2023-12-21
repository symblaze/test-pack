<?php

declare(strict_types=1);

namespace Symblaze\TestPack\Concern;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @mixin KernelTestCase
 */
trait WithCommandTester
{
    protected function console(string $command, array $arguments = [], ?Application $application = null): CommandTester
    {
        $application = $application ?? $this->consoleApp();
        $commandTester = new CommandTester($application->find($command));
        $commandTester->execute($arguments);

        return $commandTester;
    }

    protected function consoleApp(array $options = []): Application
    {
        $kernel = self::bootKernel($options);

        return new Application($kernel);
    }
}
