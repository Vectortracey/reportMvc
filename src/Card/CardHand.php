<?php

/**
 * class game
 */

namespace App\Card;

use App\Card\Card;

/**
 * class for 21
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
     * takes a card-object as a parameter and add the card to the $cardHand-array.
     *
     * @param Card $card    A card-object
     */
    public function addCard(Card $card): void
    {
        array_push($this->cardHand, $card);
    }

    /**
     * returns the cardhand as an array.
     */
    public function getCardHand(): array
    {
        return $this->cardHand;
    }
}
