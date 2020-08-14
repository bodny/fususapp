<?php

namespace App\Fuzzy\Quantifiers;

use App\Fuzzy\Memberships\LowOpinionMembershipFunction;

/**
 * Class MostOfHaveLowOpinion
 * @package App\Fuzzy\Quantifiers
 * @copyright (c) 2020
 * @author Tomas Bodnar <bodnarto@gmail.com>
 */
class MostOfHaveLowOpinion extends MostOfQuantifier
{
    /**
     * MostOfHaveLowOpinion constructor.
     * @param float $min
     * @param float $max
     */
    public function __construct(float $min, float $max)
    {
        parent::__construct(new LowOpinionMembershipFunction($min, $max));
    }
}
