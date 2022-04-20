<?php

namespace App\Card;

use App\Card\CardHand;

class Player
{
    private $playerId;
    private $cards;

    public function __construct(int $id)
    {
        $this->playerId = $id;
    }

    public function getPlayerId()
    {
        return $this->playerId;
    }

    public function addToHand(Card $card)
    {
        if ($this->cards == null) {
            $this->cards = new CardHand();
            $this->cards->addCard($card);
        } else {
            $this->cards->addCard($card);
        }
    }

    public function getHand()
    {
        return $this->cards;
    }
}
