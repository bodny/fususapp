<?php

namespace App\Fuzzy\Quantifiers;

/**
 * Interface Quantifier
 * @package App\Fuzzy\Quantifiers
 * @copyright (c) 2020
 * @author Tomas Bodnar <bodnarto@gmail.com>
 */
interface Quantifier
{
    /**
     * @param array $data
     * @return float
     */
    public function calc(array $data): float;
}
