<?php

namespace Tests\Unit\Fuzzy\Aggregations;

use App\Fuzzy\Aggregations\GeometricMean;
use PHPUnit\Framework\TestCase;

class GeometricMeanTest extends TestCase
{
    /**
     * @return void
     */
    public function testCalcReturnNullIfEmptyData()
    {
        $data = [];

        $aggregation = new GeometricMean();

        $result = $aggregation->calc($data);

        $this->assertNull($result);
    }

    /**
     * @return void
     */
    public function testCalcWithOnlyZero()
    {
        $data = [0];

        $aggregation = new GeometricMean();

        $result = $aggregation->calc($data);

        $this->assertEquals(0, $result);
    }

    /**
     * @return void
     */
    public function testCalcWithNumbers()
    {
        $data = [1.5, 3.3, 6.8, 9.2, 4.7];

        $aggregation = new GeometricMean();

        $result = $aggregation->calc($data);

        $this->assertEquals(4.291409511, $result);
    }

    /**
     * @return void
     */
    public function testCalcWithNumbersAndZero()
    {
        $data = [1.5, 3.3, 6.8, 9.2, 4.7, 0];

        $aggregation = new GeometricMean();

        $result = $aggregation->calc($data);

        $this->assertEquals(0, $result);
    }
}
