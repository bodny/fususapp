<?php

namespace App\Fuzzy\Memberships;

/**
 * Interface MembershipFunction
 * @package App\Fuzzy\Membership
 * @copyright (c) 2020
 * @author Tomas Bodnar <bodnarto@gmail.com>
 */
interface MembershipFunction
{
    /**
     * @param float $x
     * @return float
     */
    public function calc(float $x): float;
}
