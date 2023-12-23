<?php

declare(strict_types=1);

namespace Symblaze\TestPack\Concern;

use Symfony\Component\BrowserKit\AbstractBrowser;

trait InteractsWithClient
{
    protected function setUpClient(array $options = [], array $server = []): void
    {
        self::ensureKernelShutdown();

        self::createClient($options, $server);
    }

    protected function client(): AbstractBrowser
    {
        return self::getClient();
    }
}
