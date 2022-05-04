<?php

namespace App\Card;

use App\Card\Card;

class CardHand
{
    private $cardHand = array();

    public function addCard(Card $card)
    {
        array_push($this->cardHand, $card);
    }

    public function getCardHand()
    {
        return $this->cardHand;
    }
}
