<?php

namespace App\Poker;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Blackjack.
 */
class PokerTest extends TestCase
{
    public function testCreateDeckPoker()
    {
        $die = new Poker();
        $this->assertInstanceOf("\App\Poker\Poker", $die);

        $res = $die->showDeck();
        $this->assertIsArray($res);
    }

    /**
     * Test Ante method.
     * Check if ante method returns a array.
     * Check if the length of the array is 2 in first element ( Player draws 2 cards ) and
     * the length of the array is 3 in second element ( Board draws 3 cards ).
     */
    public function testAnte()
    {
        $die = new Poker();
        $cards = $die->ante();
        $arrayLengthPlayer = count($cards[0]);
        $arrayLengthBoard = count($cards[1]);

        $this->assertIsArray($cards);
        $this->assertEquals(2, $arrayLengthPlayer);
        $this->assertEquals(3, $arrayLengthBoard);
    }

    /**
     * Test Call method.
     * Check if call method work where it draws 2 more cars to board and 2 cards to dealer and
     * who the winner is returning from checkWinner method.
     *
     * Check if call method returns a array.
     * Check if second element in array is a string.
     */
    public function testCall()
    {
        $die = new Poker();
        $die->ante();
        $checkWinner = $die->call();
        $this->assertIsArray($checkWinner);
        $this->assertIsString($checkWinner[1]);
    }

    /**
     * Test getBoardCards and drawCardToBoard method.
     *
     * Check if array is empty when using getBoardCards method when no cards are drawn to the board.
     *
     * Using drawCardToBoard method and put in 3 to draw 3 cards then check if cards returning in a array
     * and arraylength is 3.
     */
    public function testGetBoardCards()
    {
        $die = new Poker();
        $boardCards = $die->getBoardCards();
        $arrayLengthNoDraw = count($boardCards);
        $this->assertEquals(0, $arrayLengthNoDraw);

        $die->drawCardToBoard(3);
        $boardCards = $die->getBoardCards();
        $arrayLengthDraw = count($boardCards);
        $this->assertIsArray($boardCards);
        $this->assertEquals(3, $arrayLengthDraw);
    }

    /**
     * Test getPlayerCards and drawCardToPlayer method.
     *
     * Check if array is empty when using getPlayerCards method when no cards are drawn to the player.
     *
     * Using drawCardToPlayer method and put in 2 to draw 2 cards then check if cards returning in a array
     * and arraylength is 2.
     */
    public function testGetPlayerCards()
    {
        $die = new Poker();
        $playerCards = $die->getPlayerCards();
        $arrayLengthNoDraw = count($playerCards);
        $this->assertEquals(0, $arrayLengthNoDraw);

        $die->drawCardToPlayer(2);
        $playerCards = $die->getPlayerCards();
        $arrayLengthDraw = count($playerCards);
        $this->assertIsArray($playerCards);
        $this->assertEquals(2, $arrayLengthDraw);
    }

    /**
     * Test getDealerCards and drawCardToDealer method.
     *
     * Check if array is empty when using getDealerCards method when no cards are drawn to the dealer.
     *
     * Using drawCardToDealer method and put in 2 to draw 2 cards then check if cards returning in a array
     * and arraylength is 2.
     */
    public function testGetDealerCards()
    {
        $die = new Poker();
        $dealerCards = $die->getDealerCards();
        $arrayLengthNoDraw = count($dealerCards);
        $this->assertEquals(0, $arrayLengthNoDraw);

        $die->drawCardToDealer(2);
        $dealerCards = $die->getDealerCards();
        $arrayLengthDraw = count($dealerCards);
        $this->assertIsArray($dealerCards);
        $this->assertEquals(2, $arrayLengthDraw);
    }

    /**
     * Test checkWinner method.
     * Using ante and call method to draw 2 cards to the Player, Dealer and 5 cards to the board.
     *
     * Test if checkwinner is returning a array and test if the first element in array is a boolean.
     * Test if second element in array is a string and if first element is true = Player winns test if
     * odds is in element 3 in array and have higher or equal to 50 when put in 50 to checkWinner method.
     */
    public function testCheckWinner()
    {
        $die = new Poker();
        $die->ante();
        $die->call();
        $checkWinner = $die->checkWinner(50);
        $this->assertIsArray($checkWinner);
        $this->assertIsBool($checkWinner[0]);
        $this->assertIsString($checkWinner[1]);
        if ($checkWinner[0]) {
            $this->assertIsInt($checkWinner[2]);
            $this->assertGreaterThanOrEqual(50, $checkWinner[2]);
        }
    }

    /**
     * Test payOdds method.
     *
     * Test payOdds method returns a integer with value of 500 when put int 50 in bet amount and rule Four Of A Kind.
     */
    public function testPayOdds()
    {
        $die = new Poker();
        $payOdds = $die->payOdds(50, "Four Of A Kind");
        $this->assertIsInt($payOdds);
        $this->assertEquals(500, $payOdds);
    }
}
