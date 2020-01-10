<?php


namespace Exolnet\StaticModel;


trait StaticModelTrait
{
    /**
     * Define a one-to-one relationship.
     *
     * @param  string  $related
     * @param  string  $foreignKey
     * @param  string  $localKey
     * @return \Exolnet\StaticModel\StaticModelHasOne
     */
    public function staticHasOne($related)
    {
        $instance = new $related;
        return new StaticModelHasOne($instance::newQuery(), $this);
    }
}
