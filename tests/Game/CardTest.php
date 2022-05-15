<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

class CardTest extends TestCase
{

    public function testCreateCard()
    {
        $card = new Card("9", "♥");
        $this->assertInstanceOf("\App\Card\Card", $card);

        $res = $card->getColor();
        $this->assertEquals($res, "♥");

        $res = $card->getValue();
        $this->assertEquals($res, "9");
    }
}
