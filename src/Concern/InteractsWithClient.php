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

    protected function actAs(object $user, string $firewallContext = 'main'): self
    {
        $this->client()->loginUser($user, $firewallContext);

        return $this;
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

    protected function get(string $uri, array $headers = []): void
    {
        $this->request('GET', $uri, [], $headers);
    }

    protected function post(string $uri, array $data = [], array $headers = []): void
    {
        $this->request('POST', $uri, $data, $headers);
    }

    protected function put(string $uri, array $data = [], array $headers = []): void
    {
        $this->request('PUT', $uri, $data, $headers);
    }

    protected function patch(string $uri, array $data = [], array $headers = []): void
    {
        $this->request('PATCH', $uri, $data, $headers);
    }

    protected function delete(string $uri, array $headers = []): void
    {
        $this->request('DELETE', $uri, [], $headers);
    }

    protected function options(string $uri, array $headers = []): void
    {
        $this->request('OPTIONS', $uri, [], $headers);
    }

    protected function head(string $uri, array $headers = []): void
    {
        $this->request('HEAD', $uri, [], $headers);
    }

    protected function getJson(string $uri, array $headers = []): void
    {
        $this->json('GET', $uri, [], $headers);
    }

    protected function postJson(
        string $uri,
        array $data = [],
        array $headers = [],
        int $options = JSON_THROW_ON_ERROR
    ): void {
        $this->json('POST', $uri, $data, $headers, $options);
    }

    protected function putJson(
        string $uri,
        array $data = [],
        array $headers = [],
        int $options = JSON_THROW_ON_ERROR
    ): void {
        $this->json('PUT', $uri, $data, $headers, $options);
    }

    protected function patchJson(
        string $uri,
        array $data = [],
        array $headers = [],
        int $options = JSON_THROW_ON_ERROR
    ): void {
        $this->json('PATCH', $uri, $data, $headers, $options);
    }

    protected function deleteJson(
        string $uri,
        array $data = [],
        array $headers = [],
        int $options = JSON_THROW_ON_ERROR
    ): void {
        $this->json('DELETE', $uri, $data, $headers, $options);
    }

    protected function optionsJson(
        string $uri,
        array $data = [],
        array $headers = [],
        int $options = JSON_THROW_ON_ERROR
    ): void {
        $this->json('OPTIONS', $uri, $data, $headers, $options);
    }
}
