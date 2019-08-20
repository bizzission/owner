<?php

namespace Amethyst\Tests;

abstract class BaseTest extends \Orchestra\Testbench\TestCase
{
    /**
     * Setup the test environment.
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:fresh');

        app('amethyst')->pushMorphRelation('ownable', 'owner', 'foo');
        app('amethyst')->pushMorphRelation('ownable', 'ownable', 'foo');
        app('amethyst')->pushMorphRelation('ownable', 'owner', 'user');

        $this->artisan('passport:install');
        config(['amethyst.user.entity' => config('amethyst.authentication.entity')]);
    }

    protected function getPackageProviders($app)
    {
        return [
            \Amethyst\Providers\OwnerServiceProvider::class,
            \Amethyst\Providers\AuthenticationServiceProvider::class,
            \Amethyst\Providers\FooServiceProvider::class,
        ];
    }
}
