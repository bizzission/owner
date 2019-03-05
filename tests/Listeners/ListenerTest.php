<?php

namespace Railken\Amethyst\Tests\Listeners;

use Railken\Amethyst\Concerns\Auth\User;
use Railken\Amethyst\Fakers\UserFaker;
use Illuminate\Support\Facades\Auth;
use Railken\Amethyst\Models\Foo;
use Railken\Amethyst\Models\Ownable;
use Railken\Amethyst\Fakers\FooFaker;
use Railken\Amethyst\Tests\BaseTest;

class ListenerTest extends BaseTest
{
    public function testListener()
    {   
        $user = User::create(UserFaker::make()->parameters()->set('token', 'a')->toArray());
        Auth::login($user);
        $foo = Foo::create(FooFaker::make()->parameters()->toArray());
        $this->assertEquals($foo->id, Ownable::where([
            'owner_type' => get_class($user),
            'owner_id' => $user->id,
            'relation' => 'author',
            'ownable_type' => get_class($foo),
            'ownable_id' => $foo->id
        ])->first()->ownable->id);
    }
}
