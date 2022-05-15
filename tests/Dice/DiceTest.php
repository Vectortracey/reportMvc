<?php

namespace App\Dice;

use PHPUnit\Framework\TestCase;

class DiceTest extends TestCase
{

    public function testCreateDice()
    {
        $die = new Dice();
        $this->assertInstanceOf("\App\Dice\Dice", $die);

        $res = $die->getAsString();
        $this->assertNotEmpty($res);
    }
}