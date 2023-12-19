<?php

declare(strict_types=1);

namespace Symblaze\TestPack\Tests;

use Symblaze\TestPack\KernelTestTrait;
use Symblaze\TestPack\TestCase;
use Symblaze\TestPack\Tests\Doubles\FirstLevelTrait;
use Symblaze\TestPack\Tests\Doubles\Kernel;
use Symblaze\TestPack\Tests\Doubles\SecondLevelTrait;
use Symblaze\TestPack\WebTestTrait;

final class TestCaseTest extends TestCase
{
    use FirstLeveLTrait;
    use SecondLeveLTrait;
    use KernelTestTrait;
    use WebTestTrait;

    protected function setUp(): void
    {
        $_ENV['KERNEL_CLASS'] = Kernel::class;

        parent::setUp();
    }

    /** @test */
    public function it_should_invoke_setup_template_methods_only_once(): void
    {
        $this->assertTrue($this->invokedL1Setup);
        $this->assertTrue($this->invokedL2Setup);
    }

    /** @test */
    public function it_should_invoke_teardown_template_methods_only_once(): void
    {
        $this->tearDown();

        $this->assertTrue($this->invokedL1TearDown);
        $this->assertTrue($this->invokedL2TearDown);
    }

    /** @test */
    public function it_can_create_a_kernel(): void
    {
        $kernel = self::createKernel();

        $this->assertNotNull($kernel);
    }
}
