<?php

namespace Exolnet\StaticModel;

use Illuminate\Database\Eloquent\Concerns\HasAttributes;
use Illuminate\Database\Eloquent\Concerns\HidesAttributes;
use Illuminate\Support\Traits\ForwardsCalls;

class StaticModel
{
    use HasAttributes,
        // HasRelationships,
        HidesAttributes,
        ForwardsCalls;

    /**
     * @var array
     */
    protected static $items = [];

    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * Create a new StaticModel instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    /**
     * Set a given attribute on the model.
     *
     * @param  string  $key
     * @param  mixed  $value
     */
    public function setAttribute($key, $value)
    {
        //
    }

    /**
     * Set a given JSON attribute on the model.
     *
     * @param  string  $key
     * @param  mixed  $value
     */
    public function fillJsonAttribute($key, $value)
    {
        //
    }

    /**
     * Create a new instance of the given model.
     *
     * @param  array  $attributes
     * @return static
     */
    public function newInstance(array $attributes = [])
    {
        return new static((array) $attributes);
    }

    /**
     * @return \Exolnet\StaticModel\Collection
     */
    public function newCollection(): Collection
    {
        $collection = new Collection;

        foreach ($this->getRawItems() as $key => $value) {
            $collection->add(
                $this->newFromRawItem($value, $key)
            );
        }

        return $collection;
    }

    /**
     * Create a new model instance that is existing.
     *
     * @param mixed $item
     * @param mixed $key
     * @return static
     */
    protected function newFromRawItem($item, $key)
    {
        $attributes = $this->buildRawItemAttributes($item, $key);

        return $this->newInstance($attributes);
    }

    /**
     * @param mixed $item
     * @param mixed $key
     * @return array
     */
    protected function buildRawItemAttributes($item, $key): array
    {
        $attributes = ['id' => $key];

        if (is_array($item)) {
            $attributes += $item;
        } else {
            $attributes['value'] = $item;
        }

        return $attributes;
    }

    /**
     * @return array
     */
    protected static function getRawItems(): array
    {
        return static::$items;
    }
}
