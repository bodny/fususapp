<?php

namespace Tests\Unit\Fuzzy\Aggregations;

use App\Fuzzy\Aggregations\YagerRybalovUniformProductAggregation;
use PHPUnit\Framework\TestCase;

class YagerRybalovUniformAggregationTest extends TestCase
{
    /**
     * @return void
     */
    public function testReturnNullIfEmptyData()
    {
        $data = [];

        $aggregation = new YagerRybalovUniformProductAggregation();

        $result = $aggregation->calc($data);

        $this->assertNull($result);
    }

    /**
     * @return void
     */
    public function testCalcWithOnlyZero()
    {
        $data = [0];

        $aggregation = new YagerRybalovUniformProductAggregation();

        $result = $aggregation->calc($data);

        $this->assertEquals(0, $result);
    }

    /**
     * @return void
     */
    public function testCalcWithNumbers()
    {
        $data = [1.5, 3.3, 6.8, 9.2, 4.7];

        $aggregation = new YagerRybalovUniformProductAggregation();

        $result = $aggregation->calc($data);

        $this->assertEquals(1.161494946973507, $result);
    }

    /**
     * @return void
     */
    public function testCalcWithNumbersAndZero()
    {
        $data = [1.5, 3.3, 6.8, 9.2, 4.7, 0];

        $aggregation = new YagerRybalovUniformProductAggregation();

        $result = $aggregation->calc($data);

        $this->assertEquals(0, $result);
    }
}
