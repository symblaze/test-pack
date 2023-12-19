<?php

declare(strict_types=1);

namespace Symblaze\TestPack\Concern;

use Faker\Factory;
use Faker\Generator as Faker;

trait WithFaker
{
    protected ?Faker $faker = null;

    protected function setUpFaker(): void
    {
        $this->faker = Factory::create();
    }

    protected function tearDownFaker(): void
    {
        $this->faker = null;
    }

    protected function faker(): Faker
    {
        if ($this->faker === null) {
            $this->setUpFaker();
        }

        return $this->faker;
    }
}
