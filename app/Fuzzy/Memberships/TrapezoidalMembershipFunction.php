<?php

namespace App\Fuzzy\Memberships;

use InvalidArgumentException;

/**
 * Class TrapezoidalMembershipFunction (trapmf)
 * @package App\Fuzzy\Membership
 * @copyright (c) 2020
 * @author Tomas Bodnar <bodnarto@gmail.com>
 */
class TrapezoidalMembershipFunction implements MembershipFunction
{
    /** @var float */
    protected $a;

    /** @var float */
    protected $b;

    /** @var float */
    protected $c;

    /** @var float */
    protected $d;

    /**
     * TrapezoidalMembershipFunction constructor.
     * @param float $a
     * @param float $b
     * @param float $c
     * @param float $d
     */
    public function __construct(float $a, float $b, float $c, float $d)
    {
        if (!$this->areValid($a, $b, $c, $d)) {
            throw new InvalidArgumentException('Invalid parameters a, b, c, d');
        }

        $this->a = $a;
        $this->b = $b;
        $this->c = $c;
        $this->d = $d;
    }

    /**
     * @param float $x
     * @return float
     */
    public function calc(float $x): float
    {
        if ($x >= $this->b && $x <= $this->c) {
            return 1;
        }

        if ($x >= $this->a && $x < $this->b) {
            return ($x - $this->a) / ($this->b - $this->a);
        }

        if ($x > $this->c && $x <= $this->d) {
            return ($this->d - $x) / ($this->d - $this->c);
        }

        return 0;
    }

    /**
     * @param float $a
     * @param float $b
     * @param float $c
     * @param float $d
     * @return bool
     */
    private function areValid(float $a, float $b, float $c, float $d): bool
    {
        return (bool)($a <= $b && $b <= $c && $c <= $d);
    }
}
