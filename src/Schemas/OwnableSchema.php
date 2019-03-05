<?php

namespace Railken\Amethyst\Schemas;

use Illuminate\Support\Facades\Config;
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
        $ownableConfig = Config::get('amethyst.owner.data.ownable.attributes.ownable.options');
        $ownerConfig = Config::get('amethyst.owner.data.ownable.attributes.owner.options');

        return [
            Attributes\IdAttribute::make(),
            Attributes\TextAttribute::make('relation')
                ->setDefault(function (EntityContract $entity) {
                    return 'default';
                }),
            Attributes\EnumAttribute::make('owner_type', array_keys($ownerConfig))
                ->setRequired(true),
            Attributes\MorphToAttribute::make('owner_id')
                ->setRelationKey('owner_type')
                ->setRelationName('owner')
                ->setRelations($ownerConfig)
                ->setRequired(true),
            Attributes\EnumAttribute::make('ownable_type', array_keys($ownableConfig))
                ->setRequired(true),
            Attributes\MorphToAttribute::make('ownable_id')
                ->setRelationKey('ownable_type')
                ->setRelationName('ownable')
                ->setRelations($ownableConfig)
                ->setRequired(true),
            Attributes\CreatedAtAttribute::make(),
            Attributes\UpdatedAtAttribute::make(),
            Attributes\DeletedAtAttribute::make(),
        ];
    }
}
