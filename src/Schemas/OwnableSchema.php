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
            Attributes\EnumAttribute::make('owner_type', app('amethyst')->getMorphListable('ownable', 'owner'))
                ->setRequired(true),
            Attributes\MorphToAttribute::make('owner_id')
                ->setRelationKey('owner_type')
                ->setRelationName('owner')
                ->setRelations(app('amethyst')->getMorphRelationable('ownable', 'owner'))
                ->setRequired(true),
            Attributes\EnumAttribute::make('ownable_type', app('amethyst')->getMorphListable('ownable', 'ownable'))
                ->setRequired(true),
            Attributes\MorphToAttribute::make('ownable_id')
                ->setRelationKey('ownable_type')
                ->setRelationName('ownable')
                ->setRelations(app('amethyst')->getMorphRelationable('ownable', 'ownable'))
                ->setRequired(true),
            Attributes\CreatedAtAttribute::make(),
            Attributes\UpdatedAtAttribute::make(),
            Attributes\DeletedAtAttribute::make(),
        ];
    }
}
