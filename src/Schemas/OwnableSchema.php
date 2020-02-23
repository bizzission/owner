<?php

namespace Amethyst\Schemas;

use Railken\Lem\Attributes;
use Railken\Lem\Contracts\EntityContract;
use Railken\Lem\Schema;

class OwnableSchema extends Schema
{
    /**
     * Get all the attributes.
     *
     * @var array
     */
    public function getAttributes()
    {
        return [
            Attributes\IdAttribute::make(),
            Attributes\TextAttribute::make('relation')
                ->setDefault(function (EntityContract $entity) {
                    return 'default';
                }),
            \Amethyst\Core\Attributes\DataNameAttribute::make('owner_type')
                ->setRequired(true),
            Attributes\MorphToAttribute::make('owner_id')
                ->setRelationKey('owner_type')
                ->setRelationName('owner')
                ->setRelations(app('amethyst')->getDataManagers())
                ->setRequired(true),
            \Amethyst\Core\Attributes\DataNameAttribute::make('ownable_type')
                ->setRequired(true),
            Attributes\MorphToAttribute::make('ownable_id')
                ->setRelationKey('ownable_type')
                ->setRelationName('ownable')
                ->setRelations(app('amethyst')->getDataManagers())
                ->setRequired(true),
            Attributes\CreatedAtAttribute::make(),
            Attributes\UpdatedAtAttribute::make(),
            Attributes\DeletedAtAttribute::make(),
        ];
    }
}
