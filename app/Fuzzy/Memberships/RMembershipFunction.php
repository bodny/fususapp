<?php

namespace App\Fuzzy\Memberships;

/**
 * Class RMembershipFunction (extends TrapezoidalMembershipFunction)
 * @package App\Fuzzy\Memberships
 * @copyright (c) 2020
 * @author Tomas Bodnar <bodnarto@gmail.com>
 */
class RMembershipFunction extends TrapezoidalMembershipFunction implements MembershipFunction
{
    /**
     * RMembershipFunction constructor.
     * @param float $a
     * @param float $b
     */
    public function __construct(float $a, float $b)
    {
        parent::__construct($a, $b, INF, INF);
    }
}
