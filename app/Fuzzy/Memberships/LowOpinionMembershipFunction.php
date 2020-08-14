<?php

namespace App\Fuzzy\Memberships;

/**
 * Class LowOpinionMembershipFunction
 * @package App\Fuzzy\Memberships
 * @copyright (c) 2020
 * @author Tomas Bodnar <bodnarto@gmail.com>
 */
class LowOpinionMembershipFunction extends LMembershipFunction
{
    /**
     * LowOpinionMembershipFunction constructor.
     * @param float $min
     * @param float $max
     */
    public function __construct(float $min, float $max)
    {
        $mid = ($max - $min) / 2 + $min;
        $a = $mid - ($mid * 0.1);
        $b = $mid + ($mid * 0.1);

        parent::__construct($a, $b);
    }
}
