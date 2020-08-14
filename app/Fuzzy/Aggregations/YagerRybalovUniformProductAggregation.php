<?php

namespace App\Fuzzy\Aggregations;

/**
 * Class YagerRybalovUniformProductAggregation
 * @package App\Fuzzy\Aggregations
 * @copyright (c) 2020
 * @author Tomas Bodnar <bodnarto@gmail.com>
 */
class YagerRybalovUniformProductAggregation implements AggregationFunction
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

        $product = array_product($data);

        $data1 = array_map(function($x) {
            return 1 - (float) $x;
        }, $data);

        $product1 = array_product($data1);

        if (($product + $product1) === 0) {
            return 0;
        }

        return ($product / ($product + $product1));
    }
}
