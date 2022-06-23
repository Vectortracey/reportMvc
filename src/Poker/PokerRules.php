<?php

namespace App\Poker;

/**
 * PokerRules Class.
 *
 * @SuppressWarnings
 */
class PokerRules
{
    public array $arrayrules = [
        [10, 11, 12, 13, 14],
        [9, 10, 11, 12, 13],
        [8, 9, 10, 11, 12],
        [7, 8, 9, 10, 11],
        [6, 7, 8, 9, 10],
        [5, 6, 7, 8, 9],
        [4, 5, 6, 7, 8],
        [3, 4, 5, 6, 7],
        [2, 3, 4, 5, 6],
        [14, 2, 3, 4, 5],
    ];

    /**
     * pushToValueCards method.
     * @param array $hand ( The Player or Dealer card hand ).
     * @param array $board ( The boards cards ).
     *
     * Push board and hand cards with suites, poker values and cards into arrays.
     * Using for the rule methods.
     *
     * $array[0] = Counts all the values of poker values
     * $array[1] = Counts all the values of suites
     * $array[2] = poker values
     * $array[3] = board + hand cards
     *
     * @return array $array ( Returns in a array with all the arrays ).
     */
    public function pushToValueCards($hand, $board)
    {
        $suites = [];
        $pokerValues = [];
        $allCards = [];
        // Get all the values from the board and push it into arrays
        foreach ($board as $card) {
            $suite = $card->getSuite();
            $pokerValue = $card->getPokerValue();
            array_push($suites, $suite);
            array_push($pokerValues, $pokerValue);
            array_push($allCards, $card);
        }

        // Get all the values from the hand and push it into arrays
        foreach ($hand as $card) {
            $suite = $card->getSuite();
            $pokerValue = $card->getPokerValue();
            array_push($suites, $suite);
            array_push($pokerValues, $pokerValue);
            array_push($allCards, $card);
        }

        sort($pokerValues);

        $array = [array_count_values($pokerValues), array_count_values($suites), $pokerValues, $allCards];

        return $array;
    }

    /**
     * checkAllRules method.
     * @param array $hand ( The Player or Dealer card hand ).
     * @param array $board ( The boards cards ).
     *
     * Check if player / dealer have a rule.
     * Starts from the highest rule ranking to the button.
     * return a array with the rule the player / dealer have and card values for the rule used.
     */
    public function checkAllRules($hand, $board)
    {
        $cards = $this->pushToValueCards($hand, $board);

        if ($hand === []) {
            return ["Nothing", null];
        }

        if ($this->royalFlush($cards)[0]) {
            return ["Royal Flush", $this->royalFlush($cards)[1]];
        } elseif ($this->straightFlush($cards)[0]) {
            return ["Straigth Flush", $this->straightFlush($cards)[1]];
        } elseif ($this->fourOfAKind($cards)[0]) {
            return ["Four Of A Kind", $this->fourOfAKind($cards)[1]];
        } elseif ($this->fullHouse($cards)[0]) {
            return ["Full House", $this->fullHouse($cards)[1]];
        } elseif ($this->flush($cards)) {
            return ["Flush", "same"];
        } elseif ($this->straight($cards)[0]) {
            return ["Straight", $this->straight($cards)[1]];
        } elseif ($this->threeOfAKind($cards)[0]) {
            return ["Thee Of A Kind", $this->threeOfAKind($cards)[1]];
        } elseif ($this->twoPair($cards)[0]) {
            return ["Two Pair", $this->twoPair($cards)[1]];
        } elseif ($this->pair($cards)[0]) {
            return ["Pair", $this->pair($cards)[1]];
        }
        return ["High Card", null];
    }

    /**
     * Pair method.
     * @param array $boardHandCards (Array from pushToValueCards methods return).
     * Checks if $hand + $board contains 2 cards with same value.
     * If pair: Returns true and the biggest pair value on the board / hand in a array.
     * Else: return false and null in a array.
     *
     * @return array (boolean, what cards used)
     */
    public function pair($boardHandCards)
    {
        $cardValues = [];
        $hasPair = false;
        foreach ($boardHandCards[0] as $key => $value) {
            if ($value >= 2) {
                $hasPair = true;
                array_push($cardValues, $key);
            }
        }

        if ($hasPair) {
            sort($cardValues);
            $arrlength = count($cardValues);
            return [true, $cardValues[$arrlength - 1]];
        }
        return [false, null];
    }

    /**
     * Two Pair method
     * @param array $boardHandCards (Array from pushToValueCards methods return).
     *
     * Checks if $hand + $board contains 2 pairs of cards with same value.
     * If have 2 pairs: return the true and the pairs card values used in the rule.
     * Else: returns false and null in a array.
     *
     * @return array (boolean, what cards used for the both pairs)
     */
    public function twoPair($boardHandCards)
    {
        $cardValues = [];
        $count = 0;
        foreach ($boardHandCards[0] as $key => $value) {
            if ($value >= 2) {
                $count += 1;
                array_push($cardValues, $key);
            }
        }

        if ($count >= 2) {
            if ($count >= 3) {
                sort($cardValues);
                $arrlength = count($cardValues);
                return [true, [$cardValues[$arrlength - 1], $cardValues[$arrlength - 2]], $cardValues];
            }
            return [true, $cardValues];
        }
        return [false, null];
    }

    /**
     * Three Of A kind method.
     * @param array $boardHandCards (Array from pushToValueCards methods return).
     *
     * Checks if $hand + $board contains 3 cards with same value.
     * If have 3 of the same card: return true and what card used in a array.
     * Else: false and null in a array.
     *
     * @return array (boolean, what cards used)
     */
    public function threeOfAKind($boardHandCards)
    {
        $cardValues = [];
        $hasThree = false;
        $count = 0;
        foreach ($boardHandCards[0] as $key => $value) {
            if ($value >= 3) {
                array_push($cardValues, $key);
                $hasThree = true;
                $count += 1;
            }
        }

        if ($hasThree) {
            if ($count >= 2) {
                sort($cardValues);
                $arrlength = count($cardValues);
                return [true, $cardValues[$arrlength - 1]];
            }
            return [true, $cardValues[0]];
        }

        return [false, null];
    }

    /**
     * Straight method.
     * @param array $boardHandCards (Array from pushToValueCards methods return).
     *
     * Checks if $hand + $board contains 5 cards with consecutive value.
     * If 5 cards are consecutive value: Returns true and the sum of the array in a array.
     * Else: Returns false and null in a array.
     *
     * @return array (boolean, what cards used)
     */
    public function straight($boardHandCards)
    {
        foreach ($this->arrayrules as $array) {
            if (!array_diff($array, $boardHandCards[2])) {
                if ($array[0] === 13) {
                    return [true, (array_sum($array) - 12)];
                }
                return [true, array_sum($array)];
            }
        }

        return [false, null];
    }

    /**
     * Flush method.
     * @param array $boardHandCards (Array from pushToValueCards methods return).
     *
     * Checks if $hand + $board contains 5 cards with same suit.
     * If 5 cards contains same suit: Returns true,
     * Else: Returns false.
     *
     * @return boolean (boolean if player / dealer have the rule or not).
     */
    public function flush($boardHandCards)
    {
        foreach ($boardHandCards[1] as $key => $value) {
            if ($value >= 5) {
                return true;
            }
        }
        return false;
    }

    /**
     * Full House method.
     * @param array $boardHandCards (Array from pushToValueCards methods return).
     *
     * Checks if $hand + $board contains 3 cards of the same value, and 2 cards of a different,
     * matching value (1 three of a kind and 1 pair).
     *
     * If have 1 Three of a kind and 1 pair: Returns true and the card value of three of a kind
     * and pair used in a array.
     *
     * Else: Returns false and null in a array.
     *
     * @return array (boolean, what cards used for three of a kind, what cards used for pair).
     */
    public function fullHouse($boardHandCards)
    {
        $three = false;
        $two = false;
        $hand = $boardHandCards[0];
        $threeValue = "";
        $twoValue = "";
        foreach ($hand as $key => $value) {
            if ($value >= 3) {
                $three = true;
                $threeValue = $key;
                unset($hand[$key]);
            }
        }

        foreach ($hand as $key => $value) {
            if ($value >= 2) {
                $two = true;
                $twoValue = $key;
            }
        }

        if ($three and $two) {
            return [true, [$threeValue, $twoValue]];
        }
        return [false, null];
    }

    /**
     * Four Of A Kind method.
     * @param array $boardHandCards (Array from pushToValueCards methods return).
     *
     * Checks if $hand + $board contains 4 cards with same value.
     * If it contains 4 with same value: Returns true and what card value is used in a array.
     * Else: Returns false and null in a array.
     *
     * @return array (boolean, what cards used)
     */
    public function fourOfAKind($boardHandCards)
    {
        foreach ($boardHandCards[0] as $key => $value) {
            if ($value >= 4) {
                return [true, $key];
            }
        }

        return [false, null];
    }

    /**
     * Straight Flush method.
     * @param array $boardHandCards (Array from pushToValueCards methods return).
     *
     * Checks if $hand + $board contains five cards of sequential rank, all of the same suite.
     * If sequential rank and all of the same suite: Returns true and what straight array is used in a array.
     * Else: Returns false and null in a array.
     *
     * @return array (boolean, what cards used)
     */
    public function straightFlush($boardHandCards)
    {
        $ifStr = false;
        $strSuite = "";
        $count = 0;
        $strArr = [];

        foreach ($this->arrayrules as $array) {
            if (!array_diff($array, $boardHandCards[2])) {
                $strArr = $array;
                $ifStr = true;
            }
        }

        if ($ifStr) {
            foreach ($boardHandCards[3] as $card) {
                $value = $card->getPokerValue();
                $suite = $card->getSuite();
                $inStraight = in_array($value, $strArr);
                if ($inStraight and $suite === $strSuite or $inStraight and $strSuite === "") {
                    $strSuite = $suite;
                    $count += 1;
                    if ($count >= 5) {
                        return [true, $strArr];
                    }
                }
            }
        }

        return [false, null];
    }

    /**
     * Three Of A kind method.
     * @param array $boardHandCards (Array from pushToValueCards methods return).
     *
     * Checks if $hand + $board contains five cards of sequential rank of the highest straight, all of the same suit.
     * If sequential rank of the highest straight and all of the same suite: Returns true and what
     * straight array is used in a array.
     *
     * Else: Returns false and null in a array.
     *
     * @return array (boolean, what cards used)
     */
    public function royalFlush($boardHandCards)
    {
        $suiteControll = "";
        $count = 0;
        $royalStraightRule = [10, 11, 12, 13, 14];

        if (!array_diff($royalStraightRule, $boardHandCards[2])) {
            foreach ($boardHandCards[3] as $card) {
                $cardValue = $card->getPokerValue();
                $cardSuite = $card->getSuite();
                $inStraight = in_array($cardValue, $royalStraightRule);
                if ($inStraight and $cardSuite === $suiteControll or $inStraight and $suiteControll === "") {
                    $suiteControll = $cardSuite;
                    $count += 1;
                    if ($count >= 5) {
                        return [true, $royalStraightRule];
                    }
                }
            }
        }

        return [false, null];
    }
}
