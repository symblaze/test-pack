<?php

declare(strict_types=1);

namespace Symblaze\TestPack\Concern;

use Doctrine\ODM\MongoDB\DocumentManager;
use Faker\ORM\Doctrine\Populator;
use Symblaze\TestPack\KernelTestTrait;

trait WithOdmPopulator
{
    use WithFaker;
    use KernelTestTrait;

    protected ?Populator $populator = null;

    protected function setUpPopulator(): void
    {
        $dm = $this->container()->get(DocumentManager::class);
        $this->populator = new Populator($this->faker(), $dm);
    }

    protected function tearDownPopulator(): void
    {
        $this->populator = null;
    }

    protected function populator(): Populator
    {
        if ($this->populator === null) {
            $this->setUpPopulator();
        }

        return $this->populator;
    }
}
