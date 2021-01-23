<?php

namespace Amethyst\Models;

use Amethyst\Core\ConfigurableModel;
use Railken\Lem\Contracts\EntityContract;

class Ownable extends Ownerable implements EntityContract
{
    use ConfigurableModel;

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
}
