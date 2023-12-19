<?php

declare(strict_types=1);

namespace Symblaze\TestPack\Tests;

use Symblaze\TestPack\TestCase;
use Symblaze\TestPack\Tests\Doubles\FirstLevelTrait;
use Symblaze\TestPack\Tests\Doubles\SecondLevelTrait;

final class TestCaseTest extends TestCase
{
    use FirstLeveLTrait;
    use SecondLeveLTrait;

    /** @test */
    public function it_should_invoke_setup_template_methods_only_once(): void
    {
        $this->assertTrue($this->invokedL1Setup);
        $this->assertTrue($this->invokedL2Setup);
    }
}
