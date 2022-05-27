<?php

/**
 * This file contains the class Game and is written by me, Agnes Rodhe.
 */

namespace App\Card;

use App\Card\Player;
use App\Card\Deck;

class Game
{
    private $deck;

    private $player1;

    private $bank;

    private $winner = "Ingen har vunnit!";

    public function __construct(int $sumPlayer = 0, int $sumBank = 0)
    {
        $this->deck = new Deck();
        $this->player1 = new Player(1, $sumPlayer);
        $this->bank = new Player(2, $sumBank);
    }

    public function getDeck(): Deck
    {
        return $this->deck;
    }

    public function drawCardPlayer()
    {
        $card = $this->deck->draw();
        $this->player1->addToHand($card[0]);
    }

    public function getHandPlayer(): array
    {
        $hand = $this->player1->getHand();
        return $hand->getCardHand();;
    }

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

    public function setWinner()
    {
        $bankSum = $this->bank->getSum();
        $playerSum = $this->player1->getSum();
        if ($bankSum > $playerSum && $bankSum <= 21) {
            $this->winner = "Banken vann!";
        } elseif ($playerSum <= 21) {
            $this->winner = "Du vann!";
        } elseif ($playerSum > 21 && $bankSum > 21) {
            $this->winner = "Ingen har vunnit!";
        };
    }

    public function getSum(): array
    {
        $sumAll = array();
        $sumPlayer1 = $this->player1->getSum();
        if ($sumPlayer1 > 21) {
            $this->winner = "Banken vann!";
        };
        array_push($sumAll, $sumPlayer1);
        if ($this->bank->getHand() != null) {
            $sumBank = $this->bank->getSum();
            array_push($sumAll, $sumBank);
        };
        return $sumAll;
    }

    public function getWinner(): string
    {
        return $this->winner;
    }
}
