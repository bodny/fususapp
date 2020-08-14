<?php

namespace Tests\Unit\Fuzzy\Memberships;

use App\Fuzzy\Memberships\LMembershipFunction;
use PHPUnit\Framework\TestCase;

class LMembershipFunctionTest extends TestCase
{
    /**
     * @return void
     */
    public function testCalcReturnOne()
    {
        $mf = new LMembershipFunction(2, 5);

        $this->assertEquals(1, $mf->calc(0));
        $this->assertEquals(1, $mf->calc(1));
        $this->assertEquals(1, $mf->calc(1.5));
        $this->assertEquals(1, $mf->calc(2));
    }

    /**
     * @return void
     */
    public function testCalcReturnZeroIfOutsideRange()
    {
        $mf = new LMembershipFunction(2, 5);

        $this->assertEquals(0, $mf->calc(5));
        $this->assertEquals(0, $mf->calc(6));
        $this->assertEquals(0, $mf->calc(6.5));
    }

    /**
     * @return void
     */
    public function testCalcDecreasingPart()
    {
        $mf = new LMembershipFunction(2, 5);

        $this->assertEquals(0.9966666666666667, $mf->calc(2.01));
        $this->assertEquals(0.6666666666666667, $mf->calc(3));
        $this->assertEquals(0.1666666666666667, $mf->calc(4.5));
        $this->assertEquals(0.0033333333333333, $mf->calc(4.99));
    }
}
