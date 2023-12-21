<?php

declare(strict_types=1);

namespace Symblaze\TestPack\Assert\Database;

use Doctrine\ODM\MongoDB\DocumentManager;

trait OdmAssertTrait
{
    protected function dm(): DocumentManager
    {
        return self::getContainer()->get(DocumentManager::class);
    }

    protected function assertDocumentExists(string $documentClass, array $criteria, ?string $message = null): void
    {
        $document = $this->dm()->getRepository($documentClass)->findOneBy($criteria);
        $this->assertNotNull($document, $message ?: "Failed asserting that document exists.");
    }

    protected function assertDocumentNotExists(string $documentClass, array $criteria, ?string $message = null): void
    {
        $document = $this->dm()->getRepository($documentClass)->findOneBy($criteria);
        $this->assertNull($document, $message ?: "Failed asserting that document not exists.");
    }
}
