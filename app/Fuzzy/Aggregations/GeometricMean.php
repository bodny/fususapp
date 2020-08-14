<?php

namespace App\Fuzzy\Aggregations;

/**
 * Class GeometricMean
 * @package App\Fuzzy\Aggregations
 * @copyright (c) 2020
 * @author Tomas Bodnar <bodnarto@gmail.com>
 */
class GeometricMean implements AggregationFunction
{
    /**
     * @inheritDoc
     */
    public function calc(array $data): ?float
    {
        if (empty($data)) {
            return null;
        }

        $product = array_product($data);
        $count = count($data);

        if ($count === 0) {
            return 0;
        }

        return pow($product, 1 / $count);
    }
}
