<?php

namespace Amethyst\Tests\Managers;

use Amethyst\Fakers\OwnableFaker;
use Amethyst\Managers\OwnableManager;
use Amethyst\Tests\BaseTest;
use Railken\Lem\Support\Testing\TestableBaseTrait;

class OwnableTest extends BaseTest
{
    use TestableBaseTrait;

    /**
     * Manager class.
     *
     * @var string
     */
    protected $manager = OwnableManager::class;

    /**
     * Faker class.
     *
     * @var string
     */
    protected $faker = OwnableFaker::class;
}
