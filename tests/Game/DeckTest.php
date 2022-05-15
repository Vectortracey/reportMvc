<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;


class DeckTest extends TestCase
{

    public function testCreateDeckNoArguments()
    {
        $deck = new Deck();
        $this->assertInstanceOf("\App\Card\Deck", $deck);

        $res = $deck->getDeck();
        $this->assertNotNull($res[0]);

        $res = $deck->getDeck();
        $this->assertEquals(count($res), 52);
    }

    public function testCreateDeckWithArguments()
    {
        $cards = ["1", "2", "3"];
        $deck = new Deck($cards);
        $this->assertInstanceOf("\App\Card\Deck", $deck);

        $res = $deck->getDeck();
        $this->assertNotNull($res[0]);
    }


    public function testIfShuffled()
    {
        $deck = new Deck();
        $shuffledDeck = new Deck();

        $res = $deck->getDeck();
        $res2 = $shuffledDeck->shuffleDeck();
        $this->assertNotEquals($res[0], $res2[0]);

        $res = $deck->getDeck();
        $res2 = $shuffledDeck->getDeck();
        $this->assertNotEquals($res[1], $res2[1]);

        $res = $deck->getDeck();
        $res2 = $shuffledDeck->getDeck();
        $this->assertNotEquals($res[2], $res2[2]);
    }

    public function testDrawCardWithArguments()
    {
        $deck = new Deck();

        $res = $deck->draw(3);
        $this->assertIsObject($res[0]);
        $this->assertIsObject($res[1]);
        $this->assertIsObject($res[2]);

        $res = $deck->getDeck();
        $this->assertEquals(count($res), 49);
    }
    
    public function testDrawCardNoArguments()
    {
        $deck = new Deck();

        $res = $deck->draw();
        $this->assertIsObject($res[0]);

        $res = $deck->getDeck();
        $this->assertEquals(count($res), 51);
    }



}
