<?php

namespace Amethyst\Models;

use Illuminate\Database\Eloquent\Relations\MorphPivot;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Amethyst\Common\ConfigurableModel;
use Railken\Lem\Contracts\EntityContract;

class Ownable extends MorphPivot implements EntityContract
{
    use ConfigurableModel;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->ini('amethyst.owner.data.ownable');
        parent::__construct($attributes);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function owner(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function ownable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Delete the pivot model record from the database.
     *
     * @return int
     */
    public function delete()
    {
        $query = $this->getDeleteQuery();

        if ($this->morphClass) {
            $query->where($this->morphType, $this->morphClass);
        }

        return $query->delete();
    }

    /**
     * Get the query builder for a delete operation on the pivot.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function getDeleteQuery()
    {
        return $this->id ? $this->newQuery()->where('id', $this->id) : parent::getDeleteQuery();
    }
}
