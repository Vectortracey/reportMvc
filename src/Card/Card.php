<?php

/**
 * class Card
 */

namespace App\Card;

/**
 *  class Card
 */
class Card
{
    /**
     * @var string The cards value
     */
    private string $value;

    /**
     * @var string The cards color
     */
    private string $color;

    /**
     * @param string $cardValue     The value of the card
     * @param string $cardColor     The color of the card
     */
    public function __construct(string $cardValue, string $cardColor)
    {
        $this->value = $cardValue;
        $this->color = $cardColor;
    }

    /**
     * returns the color of the card as a string
     */
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * returns the value of the card as a string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
