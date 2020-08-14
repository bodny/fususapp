<?php

namespace Tests\Unit\Fuzzy\Memberships;

use App\Fuzzy\Memberships\TrapezoidalMembershipFunction;
use PHPUnit\Framework\TestCase;

class TrapezoidalMembershipFunctionTest extends TestCase
{
    /**
     * @return void
     */
    public function testCalcReturnOne()
    {
        $mf = new TrapezoidalMembershipFunction(2, 5, 8, 11);

        $this->assertEquals(1, $mf->calc(5));
        $this->assertEquals(1, $mf->calc(5.5));
        $this->assertEquals(1, $mf->calc(6));
        $this->assertEquals(1, $mf->calc(8));
    }

    /**
     * @return void
     */
    public function testCalcReturnZeroIfOutsideRange()
    {
        $mf = new TrapezoidalMembershipFunction(2, 5, 8, 11);

        $this->assertEquals(0, $mf->calc(1));
        $this->assertEquals(0, $mf->calc(2));
        $this->assertEquals(0, $mf->calc(11));
        $this->assertEquals(0, $mf->calc(11.5));
    }

    /**
     * @return void
     */
    public function testCalcIncreasingPart()
    {
        $mf = new TrapezoidalMembershipFunction(2, 5, 8, 11);

        $this->assertEquals(0.0033333333333333, $mf->calc(2.01));
        $this->assertEquals(0.3333333333333333, $mf->calc(3));
        $this->assertEquals(0.8333333333333333, $mf->calc(4.5));
        $this->assertEquals(0.9966666666666667, $mf->calc(4.99));
    }

    /**
     * @return void
     */
    public function testCalcDecreasingPart()
    {
        $mf = new TrapezoidalMembershipFunction(2, 5, 8, 11);

        $this->assertEquals(0.9966666666666667, $mf->calc(8.01));
        $this->assertEquals(0.6666666666666667, $mf->calc(9));
        $this->assertEquals(0.1666666666666667, $mf->calc(10.5));
        $this->assertEquals(0.0033333333333333, $mf->calc(10.99));
    }
}
