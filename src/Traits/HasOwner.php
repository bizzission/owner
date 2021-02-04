<?php

namespace Amethyst\Traits;

use Illuminate\Database\Eloquent\Model;

trait HasOwner
{
    // you cannot use the Ownable model if the other models are not managed by a railken manager

    private function ownerBaseModel()
    {
        return config('amethyst.owner.data.ownable.baseModel');
    }

    private function getOwnerRelation(Model $model)
    {
        return $this->owner()
            ->where('owner_id', $model->id)->where('owner_type', get_class($model))
            ->first();
    }

    /**
     * Return a collection of all the model's owner.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function owner()
    {
        return $this->morphMany($this->ownerBaseModel(), 'owner', 'ownable_type', 'ownable_id');
    }

    public function getOwner()
    {
        return $this->owner()
            ->with('owner:id,name')
            ->get()->pluck('owner');
    }

    public function getOwnerByType($class)
    {
        return $this->owner()
            ->where('owner_type', $class)
            ->with('owner:id,name')
            ->get()->pluck('owner');
    }

    public function getOwnerByRelation($relation = 'author')
    {
        return $this->owner()
            ->where('relation', $relation)
            ->with('owner:id,name')
            ->get()->pluck('owner');
    }

    /**
     * Check if model is owned by another model.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return boolean
     */
    public function isOwnedBy(Model $model)
    {
        return (bool) $this->getOwnerRelation($model);
    }

    /**
     * Add an owner to a model
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return boolean
     */
    public function addOwner(Model $model, $relation = 'author')
    {
        // Check if relationship already exists
        if (!$this->isOwnedBy($model)) {
            return $this->ownerBaseModel()::create([
                'owner_id'      => $model->id,
                'owner_type'    => get_class($model),
                'relation'      => $relation,
                'ownable_id'    => $this->id,
                'ownable_type'  => get_class($this)
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
    public function removeOwner(Model $model)
    {
        $this->getOwnerRelation($model)->delete();
        return true;
    }

    // TODO: remove all owners
    // TODO: replace owner for all, replace owner for model
    // TODO: orphaned
}
