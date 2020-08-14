<?php

namespace Tests\Unit\Fuzzy\Quantifiers;

use App\Fuzzy\Memberships\SingletonMembershipFunction;
use App\Fuzzy\Quantifiers\MostOfQuantifier;
use PHPUnit\Framework\TestCase;

class MostOfQuantifierTest extends TestCase
{
    /**
     * @return void
     */
    public function testCalcReturnZeroIfEmptyDataArray()
    {
        $quantifier = new MostOfQuantifier(new SingletonMembershipFunction(5));

        $this->assertEquals(0, $quantifier->calc([]));
    }

    /**
     * @return void
     */
    public function testCalcReturnZero()
    {
        $quantifier = new MostOfQuantifier(new SingletonMembershipFunction(5));

        $this->assertEquals(0, $quantifier->calc([0, 1, 2])); // 0
        $this->assertEquals(0, $quantifier->calc([0, 1, 2, 3, 5, 5])); // 0.33
        $this->assertEquals(0, $quantifier->calc([0, 3, 3, 5, 5])); // 0.4
        $this->assertEquals(0, $quantifier->calc([4, 5])); // 0.5
    }

    /**
     * @return void
     */
    public function testCalcReturnOne()
    {
        $quantifier = new MostOfQuantifier(new SingletonMembershipFunction(5));

        $this->assertEquals(1, $quantifier->calc([5]));
        $this->assertEquals(1, $quantifier->calc([5, 5, 5]));
    }

    /**
     * @return void
     */
    public function testCalc()
    {
        $quantifier = new MostOfQuantifier(new SingletonMembershipFunction(5));

        $this->assertEquals(0.4761904761904762, $quantifier->calc([3, 5, 5]));
        $this->assertEquals(0.7142857142857143, $quantifier->calc([3, 5, 5, 5]));
        $this->assertEquals(0.8571428571428571, $quantifier->calc([3, 5, 5, 5, 5]));
        $this->assertEquals(0.9523809523809524, $quantifier->calc([3, 5, 5, 5, 5, 5]));
    }
}
