<?php

return [
    'table'      => 'amethyst_ownables',
    'comment'    => 'Ownable',
    'model'      => Railken\Amethyst\Models\Ownable::class,
    'schema'     => Railken\Amethyst\Schemas\OwnableSchema::class,
    'repository' => Railken\Amethyst\Repositories\OwnableRepository::class,
    'serializer' => Railken\Amethyst\Serializers\OwnableSerializer::class,
    'validator'  => Railken\Amethyst\Validators\OwnableValidator::class,
    'authorizer' => Railken\Amethyst\Authorizers\OwnableAuthorizer::class,
    'faker'      => Railken\Amethyst\Fakers\OwnableFaker::class,
    'manager'    => Railken\Amethyst\Managers\OwnableManager::class,
];
