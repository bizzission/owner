<?php

namespace Railken\Amethyst\Tests;

abstract class BaseTest extends \Orchestra\Testbench\TestCase
{
    /**
     * Setup the test environment.
     */
    public function setUp()
    {
        $dotenv = new \Dotenv\Dotenv(__DIR__.'/..', '.env');
        $dotenv->load();

        parent::setUp();

        $this->artisan('migrate:fresh');


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
