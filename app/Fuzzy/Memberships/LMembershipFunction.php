<?php

namespace App\Fuzzy\Memberships;

/**
 * Class LMembershipFunction (extends TrapezoidalMembershipFunction)
 * @package App\Fuzzy\Memberships
 * @copyright (c) 2020
 * @author Tomas Bodnar <bodnarto@gmail.com>
 */
class LMembershipFunction extends TrapezoidalMembershipFunction implements MembershipFunction
{
    /**
     * LMembershipFunction constructor.
     * @param float $a
     * @param float $b
     */
    public function __construct(float $a, float $b)
    {
        parent::__construct(0, 0, $a, $b);
    }
}
