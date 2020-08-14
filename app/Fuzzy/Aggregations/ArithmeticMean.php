<?php

namespace App\Fuzzy\Aggregations;

/**
 * Class ArithmeticMean
 * @package App\Fuzzy\Aggregations
 * @copyright (c) 2020
 * @author Tomas Bodnar <bodnarto@gmail.com>
 */
class ArithmeticMean implements AggregationFunction
{
    /**
     * @param array $data
     * @return float
     */
    public function calc(array $data): ?float
    {
        if (empty($data)) {
            return null;
        }

        $sum = (float)array_sum($data);
        $count = (float)count($data);

        return $sum / $count;
    }
}
