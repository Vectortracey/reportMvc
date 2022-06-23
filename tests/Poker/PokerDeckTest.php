<?php

namespace App\Poker;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class PokerDeck.
 */
class PokerDeckTest extends TestCase
{
    /**
     * Test to construct a poker deck.
     *
     * Look up if $die is an instance of \App\Poker\PokerDeck.
     * Look up $res is not empty after using show_deck method.
     */
    public function testCreateDeck()
    {
        $die = new PokerDeck();
        $this->assertInstanceOf("\App\Poker\PokerDeck", $die);

        $res = $die->showDeck();
        $this->assertNotEmpty($res);
    }

    /**
     * Test shuffleDeck work.
     * $shuffle using shuffleDeck method.
     * $noShuffle using showDeck method.
     *
     * Look up $shuffle is not equal to $noShuffle.
     */
    public function testShuffleDeck()
    {
        $die = new PokerDeck();

        $noShuffle = $die->showDeck();
        $shuffle = $die->shuffleDeck();
        $this->assertNotEquals($noShuffle, $shuffle);
    }

    /**
     * Test shuffle_deck work.
     * Input 1 into draw method (1 card).
     * Look up $res is not empty.
     */
    public function testDrawDeck()
    {
        $die = new PokerDeck();

        $res = $die->draw(1);
        $this->assertNotEmpty($res);
    }
}
