<?php

/**
 * This file contains the class Game and is written by me, Agnes Rodhe.
 */

namespace App\Card;

use App\Card\CardHand;

/**
 * The class Player represents a player in a game.
 */
class Player
{
    /**
     * PlayerId parameter
     *
     * @var int $playerId
     */
    private int $playerId;

    /**
     * Cards parameter
     *
     * @var CardHand $cards
     */
    private $cards;

    /**
     * Sum parameter
     *
     * @var int $sum
     */
    private $sum;

    /**
     * @param int $idPlayer     Set an id to a player
     */
    public function __construct(int $idPlayer, int $sum = 0)
    {
        $this->playerId = $idPlayer;
        $this->sum = $sum;
    }

    /**
     * This function returns the players id as an integer
     */
    public function getPlayerId(): int
    {
        return $this->playerId;
    }

    /**
     * This function returns the players cardhand as a CardHand-object.
     */
    public function getHand()
    {
        return $this->cards;
    }

    /**
     * This function takes a Card as an argument and if the the private $cards is empty
     * creates a cardHand-object. Then the card is added to the players CardHand.
     *
     * @param Card $card        A card-object to add to the hand
     */
    public function addToHand(Card $card)
    {
        if ($this->cards == null) {
            $this->cards = new CardHand();
        };
        $this->cards->addCard($card);
    }

    /**
     * This function sum all the values of the cards in the cardhand and return the sum as an integer.
     */
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
