<?php

/**
 * This file contains the class Game and is written by me, Agnes Rodhe.
 */

namespace App\Card;

use App\Card\CardHand;


class Player
{

    private int $playerId;


    private $cards;

    private $sum;

    public function __construct(int $idPlayer, int $sum = 0)
    {
        $this->playerId = $idPlayer;
        $this->sum = $sum;
    }

    public function getPlayerId(): int
    {
        return $this->playerId;
    }


    public function getHand()
    {
        return $this->cards;
    }


    public function addToHand(Card $card)
    {
        if ($this->cards == null) {
            $this->cards = new CardHand();
        };
        $this->cards->addCard($card);
    }


    public function getSum(): int
    {
        $arrayCardValues = ["A", "2", "3", "4", "5", "6", "7", "8", "9", "10", "J", "Q", "K"];
        $sum = 0;
        if ($this->cards == null) {
            return $this->sum;
        };

        foreach ($this->cards->getCardHand() as $card) {
            $index = array_search($card->getValue(), $arrayCardValues);
            $sum += $index + 1;
        };
        $this->sum = $sum;
        return $this->sum;
    }
}
