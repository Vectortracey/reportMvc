<?php

/**
 * This file contains the class Game and is written by me, Agnes Rodhe.
 */

namespace App\Card;

use App\Card\Card;

/**
 * The class Game represents a game of 21.
 */
class CardHand
{
    /**
     * Card hand parameter
     *
     * @var array $cardHand
     */
    private $cardHand = [];

    /**
     * This function takes a card-object as a parameter and add the card to the $cardHand-array.
     *
     * @param Card $card    A card-object
     */
    public function addCard(Card $card): void
    {
        array_push($this->cardHand, $card);
    }

    /**
     * This function returns the cardhand as an array.
     */
    public function getCardHand(): array
    {
        return $this->cardHand;
    }
}
