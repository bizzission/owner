<?php

namespace Amethyst\Tests\Listeners;

use Illuminate\Support\Facades\Auth;
use Amethyst\Concerns\Auth\User;
use Amethyst\Fakers\FooFaker;
use Amethyst\Fakers\UserFaker;
use Amethyst\Models\Foo;
use Amethyst\Models\Ownable;
use Amethyst\Tests\BaseTest;

class ListenerTest extends BaseTest
{
    public function testListener()
    {
        $user = User::create(UserFaker::make()->parameters()->set('token', 'a')->toArray());
        Auth::login($user);
        $foo = Foo::create(FooFaker::make()->parameters()->toArray());
        $this->assertEquals($foo->id, Ownable::where([
            'owner_type'   => get_class($user),
            'owner_id'     => $user->id,
            'relation'     => 'author',
            'ownable_type' => get_class($foo),
            'ownable_id'   => $foo->id,
        ])->first()->ownable->id);
    }
}
