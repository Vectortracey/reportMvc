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
     */
    public function testCreatePokerCard()
    {
        $die = new PokerCards("2", "♥", 2);
        $this->assertInstanceOf("\App\Poker\PokerCards", $die);

        $resValue = $die->getValue();
        $this->assertIsString($resValue);

        $resSuite = $die->getSuite();
        $this->assertIsString($resSuite);
    }
}
