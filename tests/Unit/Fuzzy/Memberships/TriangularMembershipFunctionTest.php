<?php

namespace Tests\Unit\Fuzzy\Memberships;

use App\Fuzzy\Memberships\TriangularMembershipFunction;
use PHPUnit\Framework\TestCase;

class TriangularMembershipFunctionTest extends TestCase
{
    /**
     * @return void
     */
    public function testCalcReturnOne()
    {
        $mf = new TriangularMembershipFunction(2, 8, 5);

        $this->assertEquals(1, $mf->calc(5));
    }

    /**
     * @return void
     */
    public function testCalcReturnZeroIfOutsideRange()
    {
        $mf = new TriangularMembershipFunction(2, 8, 5);

        $this->assertEquals(0, $mf->calc(1));
        $this->assertEquals(0, $mf->calc(2));
        $this->assertEquals(0, $mf->calc(8));
        $this->assertEquals(0, $mf->calc(9));
    }

    /**
     * @return void
     */
    public function testCalcIncreasingPart()
    {
        $mf = new TriangularMembershipFunction(2, 8, 5);

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
        $mf = new TriangularMembershipFunction(2, 8, 5);

        $this->assertEquals(0.9966666666666667, $mf->calc(5.01));
        $this->assertEquals(0.6666666666666667, $mf->calc(6));
        $this->assertEquals(0.1666666666666667, $mf->calc(7.5));
        $this->assertEquals(0.0033333333333333, $mf->calc(7.99));
    }
}
