<?php

declare(strict_types=1);

namespace Symblaze\TestPack\Tests\Doubles;

trait SecondLevelTrait
{
    use FirstLevelTrait;

    public bool $invokedL2Setup = false;

    public bool $invokedL2TearDown = false;

    protected function setUpL2(): void
    {
        $this->invokedL2Setup = ! $this->invokedL2Setup;
    }

    protected function tearDownL2(): void
    {
        $this->invokedL2TearDown = ! $this->invokedL2TearDown;
    }
}
