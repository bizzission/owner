<?php

return [
    'table'      => 'ownable',
    'comment'    => 'Ownable',
    'model'      => Amethyst\Models\Ownable::class,
    'baseModel'  => Amethyst\Models\Ownerable::class,
    'schema'     => Amethyst\Schemas\OwnableSchema::class,
    'repository' => Amethyst\Repositories\OwnableRepository::class,
    'serializer' => Amethyst\Serializers\OwnableSerializer::class,
    'validator'  => Amethyst\Validators\OwnableValidator::class,
    'authorizer' => Amethyst\Authorizers\OwnableAuthorizer::class,
    'faker'      => Amethyst\Fakers\OwnableFaker::class,
    'manager'    => Amethyst\Managers\OwnableManager::class,
];
