<?php

namespace Tests\Unit\Fuzzy\Memberships;

use App\Fuzzy\Memberships\SingletonMembershipFunction;
use PHPUnit\Framework\TestCase;

class SingletonMembershipFunctionTest extends TestCase
{
    /**
     * @return void
     */
    public function testCalcReturnZeroIfNotMatch()
    {
        $mf = new SingletonMembershipFunction(5);

        $this->assertEquals(0, $mf->calc(3));
        $this->assertEquals(0, $mf->calc(4.99));
        $this->assertEquals(0, $mf->calc(5.01));
        $this->assertEquals(0, $mf->calc(7));
    }

    /**
     * @return void
     */
    public function testCalcReturnOneIfMatch()
    {
        $mf = new SingletonMembershipFunction(5.0);

        $this->assertEquals(1, $mf->calc(5.0));
    }
}
