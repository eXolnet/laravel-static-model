<?php

namespace Exolnet\StaticModel\Tests\Integration;

use Exolnet\StaticModel\Tests\Fixtures\Gender;

class GenderTest extends TestCase
{
    /**
     * @return void
     */
    public function testBuildGenderModels(): void
    {
        $genders = Gender::all();

        $this->assertCount(2, $genders);

        /** @var \Exolnet\StaticModel\Tests\Fixtures\Gender $genderMale */
        $genderMale = $genders[0];

        $this->assertInstanceOf(Gender::class, $genderMale);

        $this->assertEquals(Gender::M, $genderMale->getKey());
        $this->assertEquals('Male', $genderMale->getLabel());

        /** @var \Exolnet\StaticModel\Tests\Fixtures\Gender $genderFemale */
        $genderFemale = $genders[1];

        $this->assertInstanceOf(Gender::class, $genderFemale);

        $this->assertEquals(Gender::F, $genderFemale->getKey());
        $this->assertEquals('Female', $genderFemale->getLabel());
    }
}
