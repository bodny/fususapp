<?php

namespace App\Fuzzy\Quantifiers;

use App\Fuzzy\Memberships\HighOpinionMembershipFunction;

/**
 * Class MostOfHaveHighOpinion
 * @package App\Fuzzy\Quantifiers
 * @copyright (c) 2020
 * @author Tomas Bodnar <bodnarto@gmail.com>
 */
class MostOfHaveHighOpinion extends MostOfQuantifier
{
    /**
     * MostOfHaveHighOpinion constructor.
     * @param float $min
     * @param float $max
     */
    public function __construct(float $min, float $max)
    {
        parent::__construct(new HighOpinionMembershipFunction($min, $max));
    }
}
