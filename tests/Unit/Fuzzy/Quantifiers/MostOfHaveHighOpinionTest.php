<?php

namespace Tests\Unit\Fuzzy\Quantifiers;

use App\Fuzzy\Quantifiers\MostOfHaveHighOpinion;
use PHPUnit\Framework\TestCase;

class MostOfHaveHighOpinionTest extends TestCase
{
    /**
     * @return void
     */
    public function testCalcReturnZeroIfEmptyDataArray()
    {
        $quantifier = new MostOfHaveHighOpinion(1, 5);

        $this->assertEquals(0, $quantifier->calc([]));
    }

    /**
     * @return void
     */
    public function testCalcReturnZero()
    {
        $quantifier = new MostOfHaveHighOpinion(1, 5);

        $this->assertEquals(0, $quantifier->calc([0, 1, 2]));
        $this->assertEquals(0, $quantifier->calc([0, 1, 2, 3, 5, 5]));
    }

    /**
     * @return void
     */
    public function testCalcReturnOne()
    {
        $quantifier = new MostOfHaveHighOpinion(1, 5);

        $this->assertEquals(1, $quantifier->calc([5]));
        $this->assertEquals(1, $quantifier->calc([5, 5, 5]));
    }
}
