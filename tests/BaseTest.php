<?php

namespace Railken\Amethyst\Tests;

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

        $this->artisan('passport:install');
        config(['amethyst.user.entity' => config('amethyst.authentication.entity')]);
    }

    protected function getPackageProviders($app)
    {
        return [
            \Railken\Amethyst\Providers\OwnerServiceProvider::class,
            \Railken\Amethyst\Providers\AuthenticationServiceProvider::class,
            \Railken\Amethyst\Providers\FooServiceProvider::class,
        ];
    }
}
