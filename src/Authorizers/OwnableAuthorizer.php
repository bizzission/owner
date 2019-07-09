<?php

namespace Amethyst\Authorizers;

use Railken\Lem\Authorizer;
use Railken\Lem\Tokens;

class OwnableAuthorizer extends Authorizer
{
    /**
     * List of all permissions.
     *
     * @var array
     */
    protected $permissions = [
        Tokens::PERMISSION_CREATE => 'ownable.create',
        Tokens::PERMISSION_UPDATE => 'ownable.update',
        Tokens::PERMISSION_SHOW   => 'ownable.show',
        Tokens::PERMISSION_REMOVE => 'ownable.remove',
    ];
}
