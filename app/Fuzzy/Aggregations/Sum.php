<?php

namespace App\Fuzzy\Aggregations;

/**
 * Class ArithmeticMean
 * @package App\Fuzzy\Aggregations
 * @copyright (c) 2020
 * @author Tomas Bodnar <bodnarto@gmail.com>
 */
class Sum implements AggregationFunction
{
    /**
     * @param array $data
     * @return float
     */
    public function calc(array $data): float
    {
        return (float)array_sum($data);
    }
}
