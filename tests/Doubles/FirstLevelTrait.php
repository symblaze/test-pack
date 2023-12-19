<?php

declare(strict_types=1);

namespace Symblaze\TestPack\Tests\Doubles;

trait FirstLevelTrait
{
    public bool $invokedL1Setup = false;
    public bool $invokedL1TearDown = false;

    protected function setUpL1(): void
    {
        $this->invokedL1Setup = ! $this->invokedL1Setup;
    }

    protected function tearDownL1(): void
    {
        $this->invokedL1TearDown = ! $this->invokedL1TearDown;
    }
}
