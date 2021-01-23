<?php

namespace Amethyst\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

trait Owns
{
    private function ownerModel()
    {
        return config('amethyst.owner.data.ownable.baseModel');
    }

    private function getOwnsRelation(Model $model)
    {
        return $this->owner()
            ->where('ownable_id', $model->id)->where('ownable_type', get_class($model))
            ->first();
    }
    /**
     * Query which models the user owns.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function owns()
    {
        return $this->morphMany($this->ownerModel(), 'ownable', 'owner_type', 'owner_id');
    }

    public function getOwned()
    {
        return $this->owns()
            ->with('ownable')
            ->get()->pluck('ownable');
    }

    public function getOwnedByType($class)
    {
        return $this->owns()
            ->where('ownable_type', $class)
            ->with('ownable')
            ->get()->pluck('ownable');
    }

    public function getOwnedByRelation($relation = 'author')
    {
        return $this->owns()
            ->where('relation', $relation)
            ->with('ownable')
            ->get()->pluck('ownable');
    }

    /**
     * Check if model is owned by another model.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return boolean
     */
    public function isOwned(Model $model)
    {
        return (bool) $this->getOwnsRelation($model);
    }

    public function addOwned(Model $model, $relation = 'author')
    {
        // Check if relationship already exists
        if (!$this->isOwned($model)) {
            return $this->ownerModel()::create([
                'ownable_id'      => $model->id,
                'ownable_type'    => get_class($model),
                'relation'        => $relation,
                'owner_id'        => $this->id,
                'owner_type'      => get_class($this)
            ]);
        }

        return true;
    }

    /**
     * Remove an owner from a model
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return boolean
     */
    public function removeOwned(Model $model)
    {
        $this->getOwnsRelation($model)->delete();
        return true;
    }

    // TODO: remove all owned
}
