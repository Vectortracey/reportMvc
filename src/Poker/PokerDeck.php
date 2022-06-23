<?php

namespace App\Poker;

/**
 * PokerDeck Class.
 *
 * @access private
 */
class PokerDeck
{
    private array $deck;
    private array $values = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];
    private array $suits = ["♠", "♥", "♣", "♦"];

    /**
     * Buiding the deck from the variables insert into the deck
     * Calling PokerCards class to build the cards.
     *
     * @return void
     */
    public function __construct()
    {
        $this->deck = [];
        foreach ($this->suits as $suit) {
            foreach ($this->values as $value) {
                $count = $value;
                if ($value === "J") {
                    $count = 11;
                } elseif ($value === "Q") {
                    $count = 12;
                } elseif ($value === "K") {
                    $count = 13;
                } elseif ($value === "A") {
                    $count = 14;
                }
                $this->deck[] = new PokerCards($value, $suit, $count);
            }
        }
    }

    /**
     * Show the whole deck (pack of cards).
     *
     * @return array $deck ( All cards that are in the deck )
     */
    public function showDeck(): array
    {
        return $this->deck;
    }

    /**
     * Shuffle the deck.
     *
     * @return array $deck Shuffled deck.
     */
    public function shuffleDeck(): array
    {
        shuffle($this->deck);
        return $this->deck;
    }

    /**
     * draw a card from the deck.
     *
     * @param int $numDraw Amount of cards to draw
     * @return array $cards ( Cards that have been drawn in the deck ).
     */
    public function draw(int $numDraw)
    {
        $cards = [];
        $randomCard = array_rand($this->deck, $numDraw);
        for ($i = 1; $i <= $numDraw; $i++) {
            if (is_array($randomCard)) {
                $cards[] = $this->deck[$randomCard[$i - 1]];
                unset($this->deck[$randomCard[$i - 1]]);
            } else {
                $cards[] = $this->deck[$randomCard];
                unset($this->deck[$randomCard]);
            }
        }

        return $cards;
    }
}
