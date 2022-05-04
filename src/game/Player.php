<?php

namespace App\Card;

use App\Card\CardHand;

class Player
{
    private int $playerId;
    private $cards;
    private $sum;

    public function __construct(int $idPlayer)
    {
        $this->playerId = $idPlayer;
    }

    public function getPlayerId(): int
    {
        return $this->playerId;
    }

    public function addToHand(Card $card)
    {
        if ($this->cards == null) {
            $this->cards = new CardHand();
        };
        $this->cards->addCard($card);
    }

    public function getHand()
    {
        return $this->cards;
    }

    public function getSum(): int
    {
        $arrayCardValues = ["A", "2", "3", "4", "5", "6", "7", "8", "9", "10", "J", "Q", "K"];
        $sum = 0;
        foreach ($this->cards->getCardHand() as $card) {
            $index = array_search($card->getValue(), $arrayCardValues);
            $sum += $index + 1;
        };
        $this->sum = $sum;
        return $this->sum;
    }
}
