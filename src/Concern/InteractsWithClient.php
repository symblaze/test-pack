<?php

declare(strict_types=1);

namespace Symblaze\TestPack\Concern;

trait InteractsWithClient
{
    protected function setUpClient(array $options = [], array $server = []): void
    {
        self::ensureKernelShutdown();

        self::createClient($options, $server);
    }
}
