<?php

namespace Tests\Unit\Fuzzy\Aggregations;

use App\Fuzzy\Aggregations\ArithmeticMean;
use PHPUnit\Framework\TestCase;

class ArithmeticMeanTest extends TestCase
{
    /**
     * @return void
     */
    public function testCalcReturnNullIfEmptyData()
    {
        $data = [];

        $aggregation = new ArithmeticMean();

        $result = $aggregation->calc($data);

        $this->assertNull($result);
    }

    /**
     * @return void
     */
    public function testCalcWithOnlyZero()
    {
        $data = [0];

        $aggregation = new ArithmeticMean();

        $result = $aggregation->calc($data);

        $this->assertEquals(0, $result);
    }

    /**
     * @return void
     */
    public function testCalcWithNumbers()
    {
        $data = [1.5, 3.3, 6.8, 9.2, 4.7];

        $aggregation = new ArithmeticMean();

        $result = $aggregation->calc($data);

        $this->assertEquals(5.1, $result);
    }

    /**
     * @return void
     */
    public function testCalcWithNumbersAndZero()
    {
        $data = [1.5, 3.3, 6.8, 9.2, 4.7, 0];

        $aggregation = new ArithmeticMean();

        $result = $aggregation->calc($data);

        $this->assertEquals(4.25, $result);
    }
}
