<?php

namespace App\Fuzzy\Memberships;

use InvalidArgumentException;

/**
 * Class TriangularMembershipFunction (trimf)
 * @package App\Fuzzy\Membership
 * @copyright (c) 2020
 * @author Tomas Bodnar <bodnarto@gmail.com>
 */
class TriangularMembershipFunction implements MembershipFunction
{
    /** @var float */
    private $a;

    /** @var float */
    private $b;

    /** @var float */
    private $m;

    /**
     * TriangularMembershipFunction constructor.
     * @param float $a
     * @param float $b
     * @param float $m
     */
    public function __construct(float $a, float $b, float $m)
    {
        if (!$this->areValid($a, $b, $m)) {
            throw new InvalidArgumentException('Invalid parameters a, b, m');
        }

        $this->a = $a;
        $this->b = $b;
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

        if ($x >= $this->a && $x < $this->m) {
            return ($x - $this->a) / ($this->m - $this->a);
        }

        if ($x > $this->m && $x <= $this->b) {
            return ($this->b - $x) / ($this->b - $this->m);
        }

        return 0;
    }

    /**
     * @param float $a
     * @param float $b
     * @param float $m
     * @return bool
     */
    private function areValid(float $a, float $b, float $m): bool
    {
        return (bool)($a <= $m && $b >= $m);
    }
}
