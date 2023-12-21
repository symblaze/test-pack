<?php

declare(strict_types=1);

namespace Symblaze\TestPack\Assert\Database;

use Doctrine\ORM\EntityManager;

trait OrmAssertTrait
{
    protected function em(): EntityManager
    {
        return self::getContainer()->get(EntityManager::class);
    }

    protected function assertEntityExists(string $entityClass, array $criteria, ?string $message = null): void
    {
        $entity = $this->em()->getRepository($entityClass)->findOneBy($criteria);
        $this->assertNotNull($entity, $message ?: "Failed asserting that entity exists.");
    }

    protected function assertEntityNotExists(string $entityClass, array $criteria, ?string $message = null): void
    {
        $entity = $this->em()->getRepository($entityClass)->findOneBy($criteria);
        $this->assertNull($entity, $message ?: "Failed asserting that entity not exists.");
    }
}
