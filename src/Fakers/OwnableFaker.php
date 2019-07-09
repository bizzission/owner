<?php

namespace Amethyst\Fakers;

use Faker\Factory;
use Railken\Bag;
use Railken\Lem\Faker;

class OwnableFaker extends Faker
{
    /**
     * @return \Railken\Bag
     */
    public function parameters()
    {
        $faker = Factory::create();

        $bag = new Bag();
        $bag->set('relation', 'faker');
        $bag->set('owner_type', \Amethyst\Models\Foo::class);
        $bag->set('owner', FooFaker::make()->parameters()->toArray());
        $bag->set('ownable_type', \Amethyst\Models\Foo::class);
        $bag->set('ownable', FooFaker::make()->parameters()->toArray());

        return $bag;
    }
}
