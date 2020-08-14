<?php

namespace App\Fuzzy\Aggregations;

/**
 * Interface AggregationFunction
 * @package App\Fuzzy\Aggregation
 * @copyright (c) 2020
 * @author Tomas Bodnar <bodnarto@gmail.com>
 */
interface AggregationFunction
{
    /**
     * @param array $data
     * @return float
     */
    public function calc(array $data): ?float;
}
