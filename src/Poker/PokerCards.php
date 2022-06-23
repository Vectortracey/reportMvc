<?php

namespace App\Poker;

/**
 * PokerCards Class.
 *
 * @access public
 */
class PokerCards
{
    public string $value;
    public string $suite;
    public int $pokerValue;

    /**
     * Constructing card from value and suits and pokerValue
     *
     * @param string $value The card value.
     * @param string $suits The card suite.
     * @param int $pokerValue The value in poker.
     *
     * @return void
     */
    public function __construct(string $value, string $suits, $pokerValue)
    {
        $this->value = $value;
        $this->suite = $suits;
        $this->pokerValue = $pokerValue;
    }

    /**
     * Gets the card value
     *
     * @return string $value ( The vard value ).
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Gets the card suite
     *
     * @return string $suite ( The card suite ).
     */
    public function getSuite(): string
    {
        return $this->suite;
    }

    /**
     * Gets the card pokerValue
     *
     * @return int $pokerValue (The poker value of the card ).
     */
    public function getPokerValue(): int
    {
        return $this->pokerValue;
    }
}
