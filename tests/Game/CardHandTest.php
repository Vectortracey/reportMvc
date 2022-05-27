<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

class CardHandTest extends TestCase
{

    public function testCreateCardHand()
    {
        $cardHand = new CardHand();
        $this->assertInstanceOf("\App\Card\CardHand", $cardHand);
    }

    public function testGetCardHandEmptyHand()
    {
        $cardHand = new CardHand();
        $this->assertInstanceOf("\App\Card\CardHand", $cardHand);

        $res = $cardHand->getCardHand();
        $this->assertEquals($res, []);
    }

    public function testGetCardHandWithCards()
    {
        $cardHand = new CardHand();
        $this->assertInstanceOf("\App\Card\CardHand", $cardHand);

        $card = new Card("2", "♥");
        $card2 = new Card("3", "♥");

        $cardHand->addCard($card);
        $cardHand->addCard($card2);

        $res = $cardHand->getCardHand();
        $this->assertCount(2, $res);
    }
}
