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

    protected function request(string $method, string $uri, array $data = [], array $headers = []): void
    {
        $files = $this->extractFilesFromDataArray($data);
        $this->client()->request($method, $uri, $data, $files, $headers);
    }

    protected function json(
        $method,
        $uri,
        array $data = [],
        array $headers = [],
        int $options = JSON_THROW_ON_ERROR
    ): void {
        $files = $this->extractFilesFromDataArray($data);
        $content = json_encode($data, $options);
        $headers = array_merge([
            'CONTENT_LENGTH' => mb_strlen($content, '8bit'),
            'CONTENT_TYPE' => 'application/json',
            'Accept' => 'application/json',
        ], $headers);

        $this->client()->request($method, $uri, [], $files, $headers, $content);
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
