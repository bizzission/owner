<?php

namespace Amethyst\Models;

use Illuminate\Database\Eloquent\Relations\MorphPivot;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Railken\Lem\Contracts\EntityContract;

class Ownerable extends MorphPivot implements EntityContract
{
    protected $table = 'ownable';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

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
     * @return bool|int
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
