<?php

namespace Amethyst\Tests\Listeners;

use Amethyst\Concerns\Auth\User;
use Amethyst\Fakers\FooFaker;
use Amethyst\Fakers\UserFaker;
use Amethyst\Models\Foo;
use Amethyst\Models\Ownable;
use Amethyst\Tests\BaseTest;
use Illuminate\Support\Facades\Auth;

class ListenerTest extends BaseTest
{
    public function testListener()
    {
        $user = User::create(UserFaker::make()->parameters()->toArray());
        Auth::login($user);
        $foo = Foo::create(FooFaker::make()->parameters()->toArray());

        /** @var \Amethyst\Models\Ownable */
        $ownable = Ownable::where([
            'owner_type'   => app('amethyst')->tableize($user),
            'owner_id'     => $user->id,
            'relation'     => 'author',
            'ownable_type' => app('amethyst')->tableize($foo),
            'ownable_id'   => $foo->id,
        ])->first();

        $this->assertEquals($foo->id, $ownable->ownable->id);
    }
}
