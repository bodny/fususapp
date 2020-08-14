<?php

namespace App\Fuzzy\Quantifiers;

use App\Fuzzy\Memberships\MembershipFunction;

/**
 * Class MostOfQuantifier
 * @package App\Fuzzy\Quantifiers
 * @copyright (c) 2020
 * @author Tomas Bodnar <bodnarto@gmail.com>
 */
class MostOfQuantifier implements Quantifier
{
    /** @var MembershipFunction */
    private $membershipFunction;

    /**
     * MostOfQuantifier constructor.
     * @param MembershipFunction $membershipFunction
     */
    public function __construct(MembershipFunction $membershipFunction)
    {
        $this->membershipFunction = $membershipFunction;
    }

    /**
     * @param array $data
     * @return float
     */
    public function calc(array $data): float
    {
        $result = [];

        foreach ($data as $key => $value) {
            $result[$key] = $this->membershipFunction->calc($value);
        }

        return $this->evaluate($this->calcProportion($result));
    }

    /**
     * @param float $y
     * @return float
     */
    private function evaluate(float $y): float
    {
        if ($y >= 0.85) {
            return 1;
        }

        if (0.5 < $y && $y < 0.85) {
            return ($y - 0.5) / 0.35;
        }

        // y <= 0.5
        return 0;
    }

    /**
     * @param array $data array of calculated function values
     * @return float
     */
    private function calcProportion(array $data): float
    {
        $count = count($data);
        $sum = array_sum($data);

        if ($count === 0) {
            return 0;
        }

        return (1 / $count) * $sum;
    }
}
