<?php

namespace Exolnet\StaticModel\Relations;

use Exolnet\StaticModel\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

abstract class RelationStatic extends Relation
{
    /**
     * @var \Exolnet\StaticModel\Collection
     */
    protected $collection;

    /**
     * Create a new relation instance.
     *
     * @param string $relatedClass
     * @param \Illuminate\Database\Eloquent\Model $parent
     */
    public function __construct(string $relatedClass, Model $parent)
    {
        $this->related = $this->newRelatedInstance($relatedClass);
        $this->collection = $this->related->newCollection();
        $this->parent = $parent;

        $this->addConstraints();
    }

    /**
     * Create a new model instance for a related model.
     *
     * @param  string  $class
     * @return mixed
     */
    protected function newRelatedInstance($class)
    {
        return new $class;
    }
}
