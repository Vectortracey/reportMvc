<?php

namespace App\Card;

class Card
{
    private $value;
    private $color;

    public function __construct(string $cardValue, string $cardColor)
    {
        $this->value = $cardValue;
        $this->color = $cardColor;
        
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
