<?php

namespace App\Card;

use App\Card\Card;

class Deck
{
    protected $deck = array();

    public function __construct($deck = array())
    {
        $card = null;
        if ($deck == null) {
            foreach (array("♥", "♣", "♦", "♠") as $color) {
                for ($x = 1; $x <= 13; $x++) {
                    if ($x == 1) {
                        $card = new Card("A", $color);
                    } elseif ($x == 11) {
                        $card = new Card("J", $color);
                    } elseif ($x == 12) {
                        $card = new Card("Q", $color);
                    } elseif ($x == 13) {
                        $card = new Card("K", $color);
                    } elseif ($x < 11) {
                        $card = new Card(strval($x), $color);
                    }
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
