<?php

namespace App\Poker;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class PokerCards.
 */
class PokerCardsTest extends TestCase
{
    /**
     * Test to construct a card work.
     * Input value 2, suite ♥ and pokerValue 2 into Cards
     *
     * Look up if $die is an instance of \App\Poker\PokerCards.
     * Look up if $resValue $resSuite is a string and $resPokerValue is a int
     * from getValue, getSuite and getPokerValue method.
     */
    public function testCreatePokerCard()
    {
        $die = new PokerCards("2", "♥", 2);
        $this->assertInstanceOf("\App\Poker\PokerCards", $die);

        $resValue = $die->getValue();
        $this->assertIsString($resValue);

        $resSuite = $die->getSuite();
        $this->assertIsString($resSuite);

        $resPokerValue = $die->getPokerValue();
        $this->assertIsString($resSuite);
    }
}
