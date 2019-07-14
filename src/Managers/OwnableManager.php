<?php

namespace Amethyst\Managers;

use Amethyst\Common\ConfigurableManager;
use Railken\Lem\Manager;

/**
 * @method \Amethyst\Models\Ownable                 newEntity()
 * @method \Amethyst\Schemas\OwnableSchema          getSchema()
 * @method \Amethyst\Repositories\OwnableRepository getRepository()
 * @method \Amethyst\Serializers\OwnableSerializer  getSerializer()
 * @method \Amethyst\Validators\OwnableValidator    getValidator()
 * @method \Amethyst\Authorizers\OwnableAuthorizer  getAuthorizer()
 */
class OwnableManager extends Manager
{
    use ConfigurableManager;

    /**
     * @var string
     */
    protected $config = 'amethyst.owner.data.ownable';
}
