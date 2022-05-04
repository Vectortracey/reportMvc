<?php

namespace App\Card;

use App\Card\Player;
use App\Card\Deck;

class Game
{
    private $deck;
    private $player;
    private $bank;
    private $winner;

    public function __construct()
    {
        $this->deck = new Deck();
        $this->player = new Player(1);
        $this->bank = new Player(2);
    }

    public function getPlayers(): string
    {
        return "[{$this->player->getPlayerId()}]";
    }

    public function getDeck()
    {
        return $this->deck;
    }

    public function drawCardPlayer()
    {
        $card = $this->deck->draw();
        $this->player->addToHand($card[0]);
    }

    public function getHandPlayer(): array
    {
        $hand = $this->player->getHand();
        return $hand->getCardHand();
        ;
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
        return $hand->getCardHand();
        ;
    }

    public function setWinner()
    {
        $bankSum = $this->bank->getSum();
        $playerSum = $this->player->getSum();
        if ($bankSum > $playerSum && $bankSum <= 21) {
            $this->winner = $this->bank;
        } elseif ($playerSum <= 21) {
            $this->winner = $this->player;
        } elseif ($playerSum > 21 && $bankSum > 21) {
            $this->winner = null;
        };
    }

    public function getSum(): array
    {
        $sumAll = array();
        $sumPlayer = $this->player->getSum();
        if ($sumPlayer > 21) {
            $this->winner = $this->bank;
        };
        array_push($sumAll, $sumPlayer);
        if ($this->bank->getHand() != null) {
            $sumBank = $this->bank->getSum();
            array_push($sumAll, $sumBank);
        };
        return $sumAll;
    }

    public function getWinner(): string
    {
        $winnerMessage = "Spelaren";
        if ($this->winner == null) {
            $winnerMessage = "oavgjort";
        } elseif ($this->winner == $this->bank) {
            $winnerMessage = "Banken";
        };
        return $winnerMessage;
    }
}
