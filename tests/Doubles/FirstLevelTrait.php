<?php

declare(strict_types=1);

namespace Symblaze\TestPack\Tests\Doubles;

trait FirstLevelTrait
{
    public bool $invokedL1Setup = false;

    protected function setUpFirstLeveLTrait(): void
    {
        $this->invokedL1Setup = ! $this->invokedL1Setup;
    }
}
