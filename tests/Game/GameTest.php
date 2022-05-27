<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{

    public function testCreateGameObject()
    {
        $game = new Game();
        $this->assertInstanceOf("\App\Card\Game", $game);

        $res = $game->getDeck();
        $this->assertInstanceOf("\App\Card\Deck", $res);
    }

    public function testDrawCardAndGetCardFromPlayer()
    {
        $game = new Game();
        $game->drawCardPlayer();

        $res = $game->getHandPlayer();
        $this->assertCount(1, $res);
    }

    public function testDrawAndGetCardFromBank()
    {
        $game = new Game();
        $res = $game->getHandBank();

        $this->assertIsArray($res);
        $this->assertNotCount(0, $res);
    }

    public function testSetWinnerToPlayer1()
    {
        $game = new Game(21, 19);

        $game->setWinner();
        $res = $game->getWinner();
        $this->assertEquals("Du vann!", $res);
    }

    public function testSetWinnerToBank()
    {
        $game = new Game(20, 21);
        $this->assertInstanceOf("\App\Card\Game", $game);

        $game->setWinner();
        $res = $game->getWinner();
        $this->assertEquals("Banken vann!", $res);
    }

    public function testSetWinnerToNoOne()
    {
        $game = new Game(24, 26);
        $this->assertInstanceOf("\App\Card\Game", $game);

        $game->setWinner();
        $res = $game->getWinner();
        $this->assertEquals("Ingen har vunnit!", $res);
    }

    public function testGetSumPlayer1()
    {
        $game = new Game(22);
        $res = $game->getSum();
        $this->assertCount(1, $res);
    }

    public function testGetSumPlayer1AndBank()
    {
        $game = new Game(22);
        $game->getHandBank();
        $res = $game->getSum();
        $this->assertCount(2, $res);
    }
}
