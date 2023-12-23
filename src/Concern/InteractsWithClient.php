<?php

declare(strict_types=1);

namespace Symblaze\TestPack\Concern;

use Symfony\Component\BrowserKit\AbstractBrowser;
use Symfony\Component\HttpFoundation\File\UploadedFile as SymfonyUploadedFile;

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

    protected function extractFilesFromDataArray(array &$data): array
    {
        $files = [];

        foreach ($data as $key => $value) {
            if ($value instanceof SymfonyUploadedFile) {
                $files[$key] = $value;

                unset($data[$key]);
            }

            if (is_array($value)) {
                $files[$key] = $this->extractFilesFromDataArray($value);

                $data[$key] = $value;
            }
        }

        return $files;
    }
}
