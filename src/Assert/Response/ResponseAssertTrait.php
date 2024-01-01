<?php

declare(strict_types=1);

namespace Symblaze\TestPack\Assert\Response;

use Opis\JsonSchema\Errors\ErrorFormatter;
use Opis\JsonSchema\Validator;
use Symfony\Component\HttpFoundation\Response;

trait ResponseAssertTrait
{
    protected function assertResponseMatchesSchema(array $rawSchema): void
    {
        $response = $this->response();
        $content = json_decode($response->getContent(), false, 512, JSON_THROW_ON_ERROR);
        $rawSchema = json_decode(json_encode($rawSchema), false);

        $validator = new Validator();
        $result = $validator->validate($content, $rawSchema);
        $isValid = $result->isValid();
        $message = '';

        if (! $isValid) {
            $formatter = new ErrorFormatter();
            $errors = $formatter->format($result->error());
            foreach ($errors as $path => $messageList) {
                $message .= sprintf("Path [%s]: %s\n", $path, implode(', ', $messageList));
            }
        }

        self::assertTrue($isValid, $message);
    }

    protected function assertResponseIsOk(string $message = ''): void
    {
        self::assertResponseStatusCodeSame(Response::HTTP_OK, $message);
    }

    protected function assertResponseIsCreated(string $message = ''): void
    {
        self::assertResponseStatusCodeSame(Response::HTTP_CREATED, $message);
    }

    protected function assertResponseIsUnAuthorized(string $message = ''): void
    {
        self::assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED, $message);
    }

    protected function assertResponseIsBadRequest(string $message = ''): void
    {
        self::assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST, $message);
    }
}
