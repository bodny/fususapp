<?php

namespace Tests\Unit\Fuzzy\Aggregations;

use App\Fuzzy\Aggregations\Sum;
use PHPUnit\Framework\TestCase;

class SumTest extends TestCase
{
    /**
     * @return void
     */
    public function testReturnZeroIfEmptyData()
    {
        $data = [];

        $aggregation = new Sum();

        $result = $aggregation->calc($data);

        $this->assertEquals(0, $result);
    }

    /**
     * @return void
     */
    public function testCalcWithOnlyZero()
    {
        $data = [0];

        $aggregation = new Sum();

        $result = $aggregation->calc($data);

        $this->assertEquals(0, $result);
    }

    /**
     * @return void
     */
    public function testCalcWithNumbers()
    {
        $data = [1.5, 3.3, 6.8, 9.2, 4.7];

        $aggregation = new Sum();

        $result = $aggregation->calc($data);

        $this->assertEquals(25.5, $result);
    }

    /**
     * @return void
     */
    public function testCalcWithNumbersAndZero()
    {
        $data = [1.5, 3.3, 6.8, 9.2, 4.7, 0];

        $aggregation = new Sum();

        $result = $aggregation->calc($data);

        $this->assertEquals(25.5, $result);
    }
}
