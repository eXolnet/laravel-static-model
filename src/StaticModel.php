<?php

namespace Exolnet\StaticModel;

use Illuminate\Database\Eloquent\JsonEncodingException;
use Illuminate\Support\Traits\ForwardsCalls;

class StaticModel
{
    use Concerns\HasAttributes,
        Concerns\HasRelationships,
        ForwardsCalls;

    /**
     * @var string
     */
    const RAW_VALUE = 'value';

    /**
     * @var array
     */
    protected static $items = [];

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [];

    /**
     * The relationship counts that should be eager loaded on every query.
     *
     * @var array
     */
    protected $withCount = [];

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
    public static function collection()
    {
        return (new static)->newCollection();
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
        $attributes = [$this->getKeyName() => $key];

        if (is_array($item)) {
            $attributes += $item;
        } else {
            $attributes[static::RAW_VALUE] = $item;
        }

        return $attributes;
    }

    /**
     * Convert the model instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return array_merge($this->attributesToArray(), $this->relationsToArray());
    }

    /**
     * Convert the model instance to JSON.
     *
     * @param  int  $options
     * @return string
     *
     * @throws \Illuminate\Database\Eloquent\JsonEncodingException
     */
    public function toJson($options = 0)
    {
        $json = json_encode($this->jsonSerialize(), $options);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw JsonEncodingException::forModel($this, json_last_error_msg());
        }

        return $json;
    }

    /**
     * Convert the object into something JSON serializable.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * Determine if two models have the same ID and belong to the same class.
     *
     * @param  \Exolnet\StaticModel\StaticModel|null  $model
     * @return bool
     */
    public function is($model): bool
    {
        return ! is_null($model) &&
               get_class($this) === get_class($model) &&
               $this->getKey() === $model->getKey();
    }

    /**
     * Determine if two models are not the same.
     *
     * @param  \Exolnet\StaticModel\StaticModel|null  $model
     * @return bool
     */
    public function isNot($model): bool
    {
        return ! $this->is($model);
    }

    /**
     * Get the primary key for the model.
     *
     * @return string
     */
    public function getKeyName(): string
    {
        return $this->primaryKey;
    }

    /**
     * Get the value of the model's primary key.
     *
     * @return mixed
     */
    public function getKey()
    {
        return $this->getAttribute($this->getKeyName());
    }

    /**
     * Dynamically retrieve attributes on the model.
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->getAttribute($key);
    }

    /**
     * Determine if the given attribute exists.
     *
     * @param  mixed  $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return ! is_null($this->getAttribute($offset));
    }

    /**
     * Get the value for a given offset.
     *
     * @param  mixed  $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->getAttribute($offset);
    }

    /**
     * Determine if an attribute or relation exists on the model.
     *
     * @param  string  $key
     * @return bool
     */
    public function __isset($key)
    {
        return $this->offsetExists($key);
    }

    /**
     * Handle dynamic method calls into the model.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->forwardCallTo($this->newCollection(), $method, $parameters);
    }

    /**
     * Handle dynamic static method calls into the method.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        return (new static)->$method(...$parameters);
    }

    /**
     * @return array
     */
    protected static function getRawItems(): array
    {
        return static::$items;
    }

    /**
     * Convert the model to its string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }
}
