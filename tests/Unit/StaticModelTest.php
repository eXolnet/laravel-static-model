<?php

namespace Exolnet\StaticModel\Tests\Unit;

use Exolnet\StaticModel\StaticModel;

class StaticModelTest extends UnitTest
{
    /**
     * @return void
     */
    public function testInitializationWithoutAttributes(): void
    {
        $model = new StaticModel();

        $this->assertInstanceOf(StaticModel::class, $model);

        $this->assertCount(0, $model->getAttributes());
    }

    /**
     * @return void
     */
    public function testInitializationWithAttributes(): void
    {
        $expectedAttributes = [
            'a' => 1,
            'b' => 2,
        ];

        $model = new StaticModel($expectedAttributes);

        $this->assertInstanceOf(StaticModel::class, $model);

        $this->assertEquals($expectedAttributes, $model->getAttributes());
    }

    /**
     * @return void
     */
    public function testGetAttributeValue(): void
    {
        $model = new StaticModel(['foo' => 'bar']);

        $this->assertEquals('bar', $model->getAttribute('foo'));
    }

    /**
     * @return void
     */
    public function testGetAttributeValueForMissingKey(): void
    {
        $model = new StaticModel();

        $this->assertNull($model->getAttribute('unknown'));
    }
}
