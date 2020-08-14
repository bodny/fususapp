<?php

namespace App\Fuzzy\Memberships;

/**
 * Class SingletonMembershipFunction
 * @package App\Fuzzy\Membership
 * @copyright (c) 2020
 * @author Tomas Bodnar <bodnarto@gmail.com>
 */
class SingletonMembershipFunction implements MembershipFunction
{
    /** @var float */
    private $m;

    /**
     * SingletonMembershipFunction constructor.
     * @param float $m
     */
    public function __construct(float $m)
    {
        $this->m = $m;
    }

    /**
     * @param float $x
     * @return float
     */
    public function calc(float $x): float
    {
        if ($x === $this->m) {
            return 1;
        }

        return 0;
    }
}
