<?php

namespace Tests\Unit\Fuzzy\Memberships;

use App\Fuzzy\Memberships\RMembershipFunction;
use PHPUnit\Framework\TestCase;

class RMembershipFunctionTest extends TestCase
{
    /**
     * @return void
     */
    public function testCalcReturnOne()
    {
        $mf = new RMembershipFunction(2, 5);

        $this->assertEquals(1, $mf->calc(5));
        $this->assertEquals(1, $mf->calc(6));
        $this->assertEquals(1, $mf->calc(6.5));
        $this->assertEquals(1, $mf->calc(1000));
    }

    /**
     * @return void
     */
    public function testCalcReturnZeroIfOutsideRange()
    {
        $mf = new RMembershipFunction(2, 5);

        $this->assertEquals(0, $mf->calc(0));
        $this->assertEquals(0, $mf->calc(1));
        $this->assertEquals(0, $mf->calc(1.99));
    }

    /**
     * @return void
     */
    public function testCalcIncreasingPart()
    {
        $mf = new RMembershipFunction(2, 5);

        $this->assertEquals(0.0033333333333333, $mf->calc(2.01));
        $this->assertEquals(0.3333333333333333, $mf->calc(3));
        $this->assertEquals(0.8333333333333333, $mf->calc(4.5));
        $this->assertEquals(0.9966666666666667, $mf->calc(4.99));
    }
}
