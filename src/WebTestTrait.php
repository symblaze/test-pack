<?php

declare(strict_types=1);

namespace Symblaze\TestPack;

use LogicException;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestAssertionsTrait;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

/**
 * All test cases that need the client should use this trait.
 *
 * @mixin KernelTestCase
 */
trait WebTestTrait
{
    use WebTestAssertionsTrait;

    /**
     * This is only changed method from original WebTestCase.
     * It is renamed to work with the TestCase class that invoke all template methods.
     */
    protected function tearDownWebTest(): void
    {
        parent::tearDown();
        self::getClient(null);
    }

    /**
     * Creates a KernelBrowser.
     *
     * @param array $options An array of options to pass to the createKernel method
     * @param array $server  An array of server parameters
     */
    protected static function createClient(array $options = [], array $server = []): KernelBrowser
    {
        if (static::$booted) {
            throw new LogicException(
                sprintf(
                    'Booting the kernel before calling "%s()" is not supported, the kernel should only be booted once.',
                    __METHOD__
                )
            );
        }

        $kernel = static::bootKernel($options);

        try {
            $client = $kernel->getContainer()->get('test.client');
        } catch (ServiceNotFoundException) {
            if (class_exists(KernelBrowser::class)) {
                throw new LogicException(
                    'You cannot create the client used in functional tests if the "framework.test" config is not set to true.'
                );
            }
            throw new LogicException(
                'You cannot create the client used in functional tests if the BrowserKit component is not available. Try running "composer require symfony/browser-kit".'
            );
        }

        $client->setServerParameters($server);

        return self::getClient($client);
    }
}
