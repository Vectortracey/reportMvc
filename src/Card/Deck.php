<?php

/**
 * This file contains the class Game and is written by me, Agnes Rodhe.
 */

namespace App\Card;

use App\Card\Card;

class Deck
{
    protected $deck = array();

    public function __construct($deck = array())
    {
        $values = ["A", "2", "3", "4", "5", "6", "7", "8", "9", "10", "J", "Q", "K"];
        $colors = ["♥", "♣", "♦", "♠"];
        $card = null;
        if ($deck == null) {
            foreach ($colors as $color) {
                foreach ($values as $value) {
                    $card = new Card($value, $color);
                    $deck[] = $card;
                };
            };
        }
        $this->deck = $deck;
    }

    public function getDeck(): array
    {
        return $this->deck;
    }

    public function shuffleDeck(): array
    {
        shuffle($this->deck);
        return $this->deck;
    }

    public function draw(int $number = 1): array
    {
        shuffle($this->deck);
        $cardDrawedArray = array();
        for ($x = 0; $x < $number; $x++) {
            $cardDrawed = array_pop($this->deck);
            array_push($cardDrawedArray, $cardDrawed);
        };

        return $cardDrawedArray;
    }
}
