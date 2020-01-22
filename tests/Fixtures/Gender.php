<?php

namespace Exolnet\StaticModel\Tests\Fixtures;

use Exolnet\StaticModel\StaticModel;

/**
 * @property-read string $key
 * @property-read string $value
 */
class Gender extends StaticModel
{
    const M = 'm';
    const F = 'f';

    // Note: The key is not stored in the database, the value is
    // The key is only there to that the UI may use it
    protected static $items = [
        self::M => 'Male',
        self::F => 'Female',
    ];

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->value;
    }
}
