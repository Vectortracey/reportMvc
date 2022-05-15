<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Player.
 */
class PlayerTest extends TestCase
{

    public function testGetEmptyHand()
    {
        $player = new Player(1);
        $this->assertInstanceOf("\App\Card\Player", $player);

        $res = $player->getHand();
        $this->assertNotInstanceOf("\App\Card\CardHand", $res);
        $this->assertEquals($res, null);
    }

    public function testCreatePlayer()
    {
        $player = new Player(1);
        $this->assertInstanceOf("\App\Card\Player", $player);

        $res = $player->getPlayerId();
        $this->assertEquals($res, 1);
    }

    public function testGetSumEmptyCardHand()
    {
        $player = new Player(1);
        $res = $player->getSum();
        $this->assertEquals($res, 0);
    }


    public function testGetSumCardHandTwoCards()
    {
        $player = new Player(1);
        $card = new Card("2", "♥");
        $card2 = new Card("3", "♥");

        $player->addToHand($card);
        $player->addToHand($card2);
        $res = $player->getHand();

        $cardArray = $res->getCardHand();
        $this->assertCount(2, $cardArray);

        $res = $player->getSum();
        $this->assertEquals($res, 5);
    }


    public function testAddCardNoCardHand()
    {
        $player = new Player(1);
        $card = new Card("2", "♥");

        $player->addToHand($card);
        $res = $player->getHand();
        $this->assertInstanceOf("\App\Card\CardHand", $res);

        $cardArray = $res->getCardHand();
        $this->assertCount(1, $cardArray);
    }


    public function testAddCardExistingCardHand()
    {
        $player = new Player(1);
        $card = new Card("2", "♥");
        $card2 = new Card("3", "♥");

        $player->addToHand($card);
        $player->addToHand($card2);
        $res = $player->getHand();

        $cardArray = $res->getCardHand();
        $this->assertCount(2, $cardArray);
    }



}
