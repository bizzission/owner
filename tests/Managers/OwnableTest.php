<?php

namespace Railken\Amethyst\Tests\Managers;

use Railken\Amethyst\Fakers\OwnableFaker;
use Railken\Amethyst\Managers\OwnableManager;
use Railken\Amethyst\Tests\BaseTest;
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
