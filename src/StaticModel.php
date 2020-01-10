<?php

namespace Exolnet\StaticModel;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Collection;

class StaticModel
{
    /** @var array */
    protected $attributes = [];

    /**
     * Create a new StaticModel instance.
     */
    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    protected static function getData()
    {
        return static::$data;
    }

    public static function all()
    {
        $collection = new Collection(static::getData());

        return $collection
            ->map(function (array $attributes) {
                return new static($attributes);
            });
    }
}
