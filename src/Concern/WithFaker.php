<?php

declare(strict_types=1);

namespace Symblaze\TestPack\Concern;

use Faker\Factory;
use Faker\Generator as Faker;
use Faker\ORM\Doctrine\Populator;

trait WithFaker
{
    protected ?Faker $faker = null;
    protected ?Populator $populator = null;

    protected function setUpFaker(): void
    {
        $this->faker = Factory::create();
        $this->populator = new Populator($this->faker);
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

    protected function populator(): Populator
    {
        if ($this->populator === null) {
            $this->setUpFaker();
        }

        return $this->populator;
    }
}
