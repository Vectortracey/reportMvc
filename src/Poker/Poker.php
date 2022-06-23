<?php

namespace App\Poker;

/**
 * Poker Class.
 *
 */
class Poker extends PokerDeck
{
    private array $dealerHand = [];
    private array $playerHand = [];
    private array $board = [];
    private array $ruleRanking = [
        0 => 'High Card',
        1 => 'Pair',
        2 => 'Two Pair',
        3 => 'Thee Of A Kind',
        4 => 'Straight',
        5 => 'Flush',
        6 => 'Full House',
        7 => 'Four Of A Kind',
        8 => 'Straight Flush',
        9 => 'Royal FLush',
    ];

    /**
     * Construct method.
     * Creating pack of cards for Poker game.
     * Using PokerDeck class construction.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * If player bets / push Ante button.
     * Draw 2 cards to Player and 3 cards to the board.
     * @return array ( Player card hand and the board cards)
     */
    public function ante()
    {
        $this->drawCardToPlayer(2);
        $this->drawCardToBoard(3);

        // Return player and board cards for PokerTest class
        return [$this->playerHand, $this->board];
    }

    /**
     * If player push Calls after Ante.
     * Draw 2 cards to dealer and the last 2 cards to the board.
     * @return array ( Array with boolean, winning rule and if player winns payout odds to).
     */
    public function call()
    {
        $this->drawCardToDealer(2);
        $this->drawCardToBoard(2);
        $checkWinner = $this->checkWinner(50);

        return $checkWinner;
    }

    /**
     * Return all cards from the board (Middle section).
     * @return array ( boards card )
     */
    public function getBoardCards()
    {
        return $this->board;
    }

    /**
     * Return all cards from the Players hand (Down section).
     * @return array ( Players card hand )
     */
    public function getPlayerCards()
    {
        return $this->playerHand;
    }

    /**
     * Return all cards from the Dealers hand (Upper section).
     * @return array ( Dealers card hand )
     */
    public function getDealerCards()
    {
        return $this->dealerHand;
    }

    /**
     * Draws card to player.
     * Draw method is from PokerDeck class.
     *
     * @param int $amount Amount cards to draw.
     * @return array ( Players card hand )
     */
    public function drawCardToPlayer(int $amount)
    {
        // Draws card to player
        $card = parent::draw($amount);
        $arrayLength = count($card);
        for ($x = 0; $x < $arrayLength; $x++) {
            array_push($this->playerHand, $card[$x]);
        }
        return $this->playerHand;
    }

    /**
     * Draws card to dealer.
     * Draw method is from PokerDeck class.
     *
     * @param int $amount Amount cards to draw.
     * @return array ( Dealers card hand )
     */
    public function drawCardToDealer(int $amount)
    {
        // Draws card to dealer
        $card = parent::draw($amount);
        $arrayLength = count($card);
        for ($x = 0; $x < $arrayLength; $x++) {
            array_push($this->dealerHand, $card[$x]);
        }
        return $this->dealerHand;
    }

    /**
     * Draws card to the board.
     * Draw method is from PokerDeck class.
     *
     * @param int $amount Amount cards to draw.
     * @return array ( boards card )
     */
    public function drawCardToBoard(int $amount)
    {
        // Draws card to the board
        $card = parent::draw($amount);
        $arrayLength = count($card);
        for ($x = 0; $x < $arrayLength; $x++) {
            array_push($this->board, $card[$x]);
        }
        return $this->board;
    }

    /**
     * Check who is the winner ( dealer or player ).
     * @param int $betAmount (What the player bets in ante / call).
     *
     * If player wins, return true, player rule and how much the payout is.
     * If dealer wins, return false and dealers rule.
     * If drawn return same and dealers rule.
     */
    public function checkWinner($betAmount)
    {
        $ruleClass = new PokerRules();
        $dealerRule = $ruleClass->checkAllRules($this->dealerHand, $this->board);
        $playerRule = $ruleClass->checkAllRules($this->playerHand, $this->board);

        // If player and dealer have the same rule.
        if ($playerRule[0] === $dealerRule[0]) {
            // If player and dealer have the same card value of the same rule then it's a draw.
            // Elseif player have higher card value then dealer of the same rule, player winns.
            if ($playerRule[1] === $dealerRule[1]) {
                return ["same", $dealerRule[0]];
            } elseif ($playerRule[1] > $dealerRule[1]) {
                $odds = $this->payOdds($betAmount, $playerRule[0]);
                return [true, $playerRule[0], $odds];
            }
            return [false, $dealerRule[0]];
        }

        // Get what rule ranking the dealer and player have.
        $dealerRanking = array_search($dealerRule[0], $this->ruleRanking);
        $playerRanking = array_search($playerRule[0], $this->ruleRanking);

        // If player have higher rule ranking, player winns else loss.
        if ($playerRanking > $dealerRanking) {
            $odds = $this->payOdds($betAmount, $playerRule[0]);
            return [true, $playerRule[0], $odds];
        }
        return [false, $dealerRule[0]];
    }

    /**
     * payOdds method.
     * @param int $betAmount ( How much the player bet in ante / call ).
     * @param string $rule ( The rule that player win against the dealer ).
     *
     * A switch case method that checks what rule the player had and return the payout of the odds times bet amount.
     * Returns one of the payout the player should recive.
     */
    public function payOdds($betAmount, $rule)
    {
        $odds = 0;
        switch ($rule) {
            case "Royal Flush":
                $odds = 100;
                break;
            case "Straigth Flush":
                $odds = 20;
                break;
            case "Four Of A Kind":
                $odds = 10;
                break;
            case "Full House":
                $odds = 4;
                break;
            case "Flush":
                $odds = 3;
                break;
            case "Straight":
                $odds = 2;
                break;
            case "Three Of A Kind":
                $odds = 1;
                break;
            case "Two Pair":
                $odds = 1;
                break;
            case "Pair":
                $odds = 1;
                break;
            case "High Card":
                $odds = 1;
                break;
        }

        return ($betAmount * $odds);
    }
}
