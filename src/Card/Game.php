<?php

/**
 * class Game
 */

namespace App\Card;

use App\Card\Player;
use App\Card\Deck;

/**
 *game of 21.
 */
class Game
{
    /**
     * Deck parameter
     *
     * @var Deck
     */
    private $deck;

    /**
     * Player1 parameter
     *
     * @var Player
     */
    private $player1;

    /**
     * Bank parameter
     *
     * @var Player
     */
    private $bank;

    /**
     * Winner parameter
     *
     * @var string
     */
    private $winner = "oavgjort";

    /**
     * Create new instances of the variables deck, player1 and bank.
     */
    public function __construct(int $sumPlayer = 0, int $sumBank = 0)
    {
        $this->deck = new Deck();
        $this->player1 = new Player(1, $sumPlayer);
        $this->bank = new Player(2, $sumBank);
    }

    /**
     * Return the deck as an object.
     */
    public function getDeck(): Deck
    {
        return $this->deck;
    }

    /**
     *  draws a card from the deck and add it to the player1 card hand.
     */
    public function drawCardPlayer()
    {
        $card = $this->deck->draw();
        $this->player1->addToHand($card[0]);
    }

    /**
     * returns the player1 card hand as an array.
     */
    public function getHandPlayer(): array
    {
        $hand = $this->player1->getHand();
        return $hand->getCardHand();;
    }

    /**
     * draws card by card and add to
     * the bankplayer card hand until the sum is 17 or more. Returns the card hand of the bankplayer.
     */
    public function getHandBank(): array
    {
        if (count($this->getSum()) < 2) {
            $card = $this->deck->draw();
            $this->bank->addToHand($card[0]);
        };
        while ($this->bank->getSum() < 17) {
            $card = $this->deck->draw();
            $this->bank->addToHand($card[0]);
        };
        $hand = $this->bank->getHand();
        return $hand->getCardHand();;
    }

    /**
     * compare the sum of the two players hands and set the winner.
     */
    public function setWinner()
    {
        $bankSum = $this->bank->getSum();
        $playerSum = $this->player1->getSum();
        if ($bankSum > $playerSum && $bankSum <= 21) {
            $this->winner = "Banken";
        } elseif ($playerSum <= 21) {
            $this->winner = "Spelaren";
        } elseif ($playerSum > 21 && $bankSum > 21) {
            $this->winner = "oavgjort";
        };
    }

    /**
     * returns the sum of the cards for both the player1 and the bankplayer as an array.
     */
    public function getSum(): array
    {
        $sumAll = array();
        $sumPlayer1 = $this->player1->getSum();
        if ($sumPlayer1 > 21) {
            $this->winner = "Banken";
        };
        array_push($sumAll, $sumPlayer1);
        if ($this->bank->getHand() != null) {
            $sumBank = $this->bank->getSum();
            array_push($sumAll, $sumBank);
        };
        return $sumAll;
    }

    /**
     * get winner
     */
    public function getWinner(): string
    {
        return $this->winner;
    }
}
