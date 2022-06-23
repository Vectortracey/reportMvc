<?php

namespace App\Poker;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Blackjack.
 */
class PokerRulesTest extends TestCase
{

    private array $player;
    private array $board = [];
    private array $dealer;

    private array $boardHighCard;
    private array $playerHighCard;

    /**
     * Test pushToValueCards method.
     * Check if both dealer and player returns a array with arrays.
     */
    public function testPushtoValueCards()
    {
        $die = new PokerRules();

        $this->player[] = new PokerCards("2", "♣", 2);
        $this->player[] = new PokerCards("4", "♦", 4);

        $this->dealer[] = new PokerCards("7", "♣", 7);
        $this->dealer[] = new PokerCards("4", "♣", 4);

        $this->board[] = new PokerCards("8", "♦", 8);
        $this->board[] = new PokerCards("J", "♥", 11);
        $this->board[] = new PokerCards("K", "♦", 13);
        $this->board[] = new PokerCards("A", "♠", 14);
        $this->board[] = new PokerCards("9", "♥", 9);

        $player = $die->pushToValueCards($this->player, $this->board);
        $dealer = $die->pushToValueCards($this->dealer, $this->board);
        $this->assertIsArray($player);
        $this->assertIsArray($dealer);
    }

    /**
     * Test checkAllRules method.
     *
     * Test if checkAllRules method returns a array and first element returns a string that says Four Of A Kind.
     * Test if checkAllRules method returns a array with first element says nogthing if put in 2 empty arrays in the method.
     * Test if checkAllRules method returns a array with first element says High Card when put in cards that have nothing on the rules.
     */
    public function testCheckAllRules()
    {

        // When have Four Of A Kind
        $this->player[] = new PokerCards("2", "♣", 2);
        $this->player[] = new PokerCards("4", "♦", 4);

        $this->board[] = new PokerCards("4", "♠", 4);
        $this->board[] = new PokerCards("4", "♥", 4);
        $this->board[] = new PokerCards("4", "♣", 4);
        $this->board[] = new PokerCards("A", "♠", 14);
        $this->board[] = new PokerCards("9", "♥", 9);

        $die = new PokerRules();
        $rulePlayer = $die->checkAllRules($this->player, $this->board);
        $this->assertStringContainsString('Four Of A Kind', $rulePlayer[0]);

        // When array is empty
        $ruleEmpty = $die->checkAllRules([], []);
        $this->assertStringContainsString('Nothing', $ruleEmpty[0]);

        // When have no rule
        $this->playerHighCard[] = new PokerCards("2", "♣", 2);
        $this->playerHighCard[] = new PokerCards("4", "♦", 4);

        $this->boardHighCard[] = new PokerCards("8", "♦", 8);
        $this->boardHighCard[] = new PokerCards("J", "♥", 11);
        $this->boardHighCard[] = new PokerCards("K", "♦", 13);
        $this->boardHighCard[] = new PokerCards("A", "♠", 14);
        $this->boardHighCard[] = new PokerCards("9", "♥", 9);

        $ruleEmpty = $die->checkAllRules($this->playerHighCard, $this->boardHighCard);
        $this->assertStringContainsString('High Card', $ruleEmpty[0]);
    }

    /**
     * Test Pair method.
     * Both check when player have pair and not having pair.
     *
     * Test if Pair method returns a array and first element returns a boolean that is true when player have pair.
     * Test if Pair method returns a array and first element returns a boolean that is false when player have no pair.
     */
    public function testPairRule()
    {
        // Test when have Pair.
        $this->player[] = new PokerCards("A", "♣", 14);
        $this->player[] = new PokerCards("J", "♣", 11);

        $this->board[] = new PokerCards("A", "♦", 14);
        $this->board[] = new PokerCards("3", "♠", 3);
        $this->board[] = new PokerCards("K", "♠", 13);

        $die = new PokerRules();
        $allCards = $die->pushToValueCards($this->player, $this->board);
        $result = $die->pair($allCards);
        $this->assertTrue($result[0]);

        // Test when not have Pair.
        $this->playerHighCard[] = new PokerCards("2", "♣", 2);
        $this->playerHighCard[] = new PokerCards("4", "♦", 4);

        $this->boardHighCard[] = new PokerCards("8", "♦", 8);
        $this->boardHighCard[] = new PokerCards("J", "♥", 11);
        $this->boardHighCard[] = new PokerCards("K", "♦", 13);
        $this->boardHighCard[] = new PokerCards("A", "♠", 14);
        $this->boardHighCard[] = new PokerCards("9", "♥", 9);

        $allCardsNoPair = $die->pushToValueCards($this->playerHighCard, $this->boardHighCard);
        $result = $die->pair($allCardsNoPair);
        $this->assertFalse($result[0]);
    }

    /**
     * Test Two Pair method.
     * Both check when player have and have not 2 pairs.
     *
     * Test if twoPair method returns a array and first element returns a boolean that is true when player have two pair.
     * Test if when it's 3 pairs on the board, the method returns the 2 highest pairs value.
     * Test if twoPair method returns a array and first element returns a boolean that is false when player have no two pair.
     */
    public function testTwoPairRule()
    {
        $die = new PokerRules();

        // Test when not have Two Pair.
        $this->player[] = new PokerCards("A", "♣", 14);
        $this->player[] = new PokerCards("J", "♣", 11);

        $this->board[] = new PokerCards("A", "♦", 14);
        $this->board[] = new PokerCards("J", "♠", 3);
        $this->board[] = new PokerCards("K", "♠", 13);
        $this->board[] = new PokerCards("K", "♣", 13);
        $this->board[] = new PokerCards("3", "♥", 3);

        $allCards = $die->pushToValueCards($this->player, $this->board);
        $result = $die->twoPair($allCards);
        $this->assertTrue($result[0]);

        // Test when it's 3 pairs on the board, the method returns the 2 highest pairs value.
        $this->assertEquals("14", $result[1][0]);
        $this->assertEquals("13", $result[1][1]);

        // Test when not have Two Pair.
        $this->playerHighCard[] = new PokerCards("2", "♣", 2);
        $this->playerHighCard[] = new PokerCards("4", "♦", 4);

        $this->boardHighCard[] = new PokerCards("8", "♦", 8);
        $this->boardHighCard[] = new PokerCards("J", "♥", 11);
        $this->boardHighCard[] = new PokerCards("K", "♦", 13);
        $this->boardHighCard[] = new PokerCards("A", "♠", 14);
        $this->boardHighCard[] = new PokerCards("9", "♥", 9);

        $allCardsNoPair = $die->pushToValueCards($this->playerHighCard, $this->boardHighCard);
        $result = $die->twoPair($allCardsNoPair);
        $this->assertFalse($result[0]);
    }

    /**
     * Test Three of a kind method.
     * Both check when player have and have not Three of a kind.
     *
     * Test if threeOfAKind method returns a array and first element returns a boolean that is true when player have Three of a kind.
     * Test if when it's 2 Three of a kind on board, see if it returns the highest card.
     * Test if threeOfAKind method returns a array and first element returns a boolean that is false when player have Three of a kind.
     */

    public function testThreeOfAKindRule()
    {
        $die = new PokerRules();

        // Test when have Three of a kind.
        $this->player[] = new PokerCards("A", "♣", 14);
        $this->player[] = new PokerCards("A", "♠", 14);

        $this->board[] = new PokerCards("A", "♦", 14);
        $this->board[] = new PokerCards("J", "♠", 3);
        $this->board[] = new PokerCards("6", "♠", 6);
        $this->board[] = new PokerCards("6", "♣", 6);
        $this->board[] = new PokerCards("6", "♥", 6);

        $allCards = $die->pushToValueCards($this->player, $this->board);
        $result = $die->threeOfAKind($allCards);
        $this->assertTrue($result[0]);
        // Test when it's 2 Three of a kind on board, see if it returns the highest card.
        $this->assertEquals("14", $result[1]);

        // Test when not have Three of a kind.
        $this->playerHighCard[] = new PokerCards("2", "♣", 2);
        $this->playerHighCard[] = new PokerCards("4", "♦", 4);

        $this->boardHighCard[] = new PokerCards("8", "♦", 8);
        $this->boardHighCard[] = new PokerCards("J", "♥", 11);
        $this->boardHighCard[] = new PokerCards("K", "♦", 13);
        $this->boardHighCard[] = new PokerCards("A", "♠", 14);
        $this->boardHighCard[] = new PokerCards("9", "♥", 9);

        $allCardsNoPair = $die->pushToValueCards($this->playerHighCard, $this->boardHighCard);
        $result = $die->threeOfAKind($allCardsNoPair);
        $this->assertFalse($result[0]);
    }

    /**
     * Test Straight method.
     * Both check when player have and have not Straight.
     *
     * Test if straight method returns a array and first element returns a boolean that is true when player have Straight.
     * Test if straight method returns a array and first element returns a boolean that is false when player have Straight.
     */
    public function testStraightRule()
    {
        $die = new PokerRules();

        // Test when have Straight.
        $this->player[] = new PokerCards("A", "♣", 14);
        $this->player[] = new PokerCards("2", "♠", 2);

        $this->board[] = new PokerCards("3", "♦", 3);
        $this->board[] = new PokerCards("4", "♠", 4);
        $this->board[] = new PokerCards("5", "♠", 5);

        $allCards = $die->pushToValueCards($this->player, $this->board);
        $result = $die->straight($allCards);
        $this->assertTrue($result[0]);

        // Test when not have Straight.
        $this->playerHighCard[] = new PokerCards("2", "♣", 2);
        $this->playerHighCard[] = new PokerCards("4", "♦", 4);

        $this->boardHighCard[] = new PokerCards("8", "♦", 8);
        $this->boardHighCard[] = new PokerCards("J", "♥", 11);
        $this->boardHighCard[] = new PokerCards("K", "♦", 13);
        $this->boardHighCard[] = new PokerCards("A", "♠", 14);
        $this->boardHighCard[] = new PokerCards("9", "♥", 9);

        $allCardsNoPair = $die->pushToValueCards($this->playerHighCard, $this->boardHighCard);
        $result = $die->straight($allCardsNoPair);
        $this->assertFalse($result[0]);
    }

    /**
     * Test Flush method.
     * Both check when player have and have not flush.
     *
     * Test if flush method returns a boolean that is true when player have Flush.
     * Test if flush method returns a boolean that is false when player have Flush.
     */
    public function testFlushRule()
    {
        $die = new PokerRules();

        // Test when have Flush.
        $this->player[] = new PokerCards("A", "♠", 14);
        $this->player[] = new PokerCards("J", "♠", 2);

        $this->board[] = new PokerCards("3", "♠", 3);
        $this->board[] = new PokerCards("K", "♠", 4);
        $this->board[] = new PokerCards("2", "♠", 5);

        $allCards = $die->pushToValueCards($this->player, $this->board);
        $result = $die->flush($allCards);
        $this->assertTrue($result);

        // Test when not have Flush.
        $this->playerHighCard[] = new PokerCards("2", "♣", 2);
        $this->playerHighCard[] = new PokerCards("4", "♦", 4);

        $this->boardHighCard[] = new PokerCards("8", "♦", 8);
        $this->boardHighCard[] = new PokerCards("J", "♥", 11);
        $this->boardHighCard[] = new PokerCards("K", "♦", 13);
        $this->boardHighCard[] = new PokerCards("A", "♠", 14);
        $this->boardHighCard[] = new PokerCards("9", "♥", 9);

        $allCardsNoPair = $die->pushToValueCards($this->playerHighCard, $this->boardHighCard);
        $result = $die->flush($allCardsNoPair);
        $this->assertFalse($result);
    }

    /**
     * Test Full House method.
     * Both check when player have and have not Full House.
     *
     * Test if fullHouse method returns a array and first element returns a boolean that is true when player have Full House.
     * Test if fullHouse method returns a array and first element returns a boolean that is false when player have Full House.
     */
    public function testFullHouseRule()
    {
        $die = new PokerRules();

        // Test when have Full House.
        $this->player[] = new PokerCards("A", "♦", 14);
        $this->player[] = new PokerCards("5", "♣", 5);

        $this->board[] = new PokerCards("A", "♣", 14);
        $this->board[] = new PokerCards("5", "♥", 5);
        $this->board[] = new PokerCards("5", "♦", 5);

        $allCards = $die->pushToValueCards($this->player, $this->board);
        $result = $die->fullHouse($allCards);
        $this->assertTrue($result[0]);

        // Test when not have Full House.
        $this->playerHighCard[] = new PokerCards("2", "♣", 2);
        $this->playerHighCard[] = new PokerCards("4", "♦", 4);

        $this->boardHighCard[] = new PokerCards("8", "♦", 8);
        $this->boardHighCard[] = new PokerCards("J", "♥", 11);
        $this->boardHighCard[] = new PokerCards("K", "♦", 13);
        $this->boardHighCard[] = new PokerCards("A", "♠", 14);
        $this->boardHighCard[] = new PokerCards("9", "♥", 9);

        $allCardsNoPair = $die->pushToValueCards($this->playerHighCard, $this->boardHighCard);
        $result = $die->fullHouse($allCardsNoPair);
        $this->assertFalse($result[0]);
    }

    /**
     * Test Four Of A Kind method.
     * Both check when player have and have not Four Of A Kind.
     *
     * Test if fourOfAKind method returns a array and first element returns a boolean that is true when player have Four Of A Kind.
     * Test if fourOfAKind method returns a array and first element returns a boolean that is false when player have Four Of A Kind.
     */
    public function testFourOfAKindRule()
    {
        $die = new PokerRules();

        // Test when have Four Of A Kind.
        $this->player[] = new PokerCards("8", "♦", 8);
        $this->player[] = new PokerCards("8", "♣", 8);

        $this->board[] = new PokerCards("A", "♣", 14);
        $this->board[] = new PokerCards("8", "♥", 8);
        $this->board[] = new PokerCards("8", "♦", 8);

        $allCards = $die->pushToValueCards($this->player, $this->board);
        $result = $die->fourOfAKind($allCards);
        $this->assertTrue($result[0]);

        // Test when not have Four Of A Kind.
        $this->playerHighCard[] = new PokerCards("2", "♣", 2);
        $this->playerHighCard[] = new PokerCards("4", "♦", 4);

        $this->boardHighCard[] = new PokerCards("8", "♦", 8);
        $this->boardHighCard[] = new PokerCards("J", "♥", 11);
        $this->boardHighCard[] = new PokerCards("K", "♦", 13);
        $this->boardHighCard[] = new PokerCards("A", "♠", 14);
        $this->boardHighCard[] = new PokerCards("9", "♥", 9);

        $allCardsNoPair = $die->pushToValueCards($this->playerHighCard, $this->boardHighCard);
        $result = $die->fourOfAKind($allCardsNoPair);
        $this->assertFalse($result[0]);
    }

    /**
     * Test Straight Flush method.
     * Both check when player have and have not Straight Flush.
     *
     * Test if straightFlush method returns a array and first element returns a boolean that is true when player have Straight Flush.
     * Test if straightFlush method returns a array and first element returns a boolean that is false when player have Straight Flush.
     */
    public function testStraightFlushRule()
    {
        $die = new PokerRules();

        // Test when have Straight Flush.
        $this->player[] = new PokerCards("4", "♣", 4);
        $this->player[] = new PokerCards("5", "♣", 5);

        $this->board[] = new PokerCards("6", "♣", 6);
        $this->board[] = new PokerCards("7", "♣", 7);
        $this->board[] = new PokerCards("8", "♣", 8);

        $allCards = $die->pushToValueCards($this->player, $this->board);
        $result = $die->straightFlush($allCards);
        $this->assertTrue($result[0]);

        // Test when not have Straight Flush.
        $this->playerHighCard[] = new PokerCards("2", "♣", 2);
        $this->playerHighCard[] = new PokerCards("4", "♦", 4);

        $this->boardHighCard[] = new PokerCards("8", "♦", 8);
        $this->boardHighCard[] = new PokerCards("J", "♥", 11);
        $this->boardHighCard[] = new PokerCards("K", "♦", 13);
        $this->boardHighCard[] = new PokerCards("A", "♠", 14);
        $this->boardHighCard[] = new PokerCards("9", "♥", 9);

        $allCardsNoPair = $die->pushToValueCards($this->playerHighCard, $this->boardHighCard);
        $result = $die->straightFlush($allCardsNoPair);
        $this->assertFalse($result[0]);
    }

    /**
     * Test Royal Flush method.
     * Both check when player have and have not Straight Flush.
     *
     * Test if royalFlush method returns a array and first element returns a boolean that is true when player have Royal Flush.
     * Test if royalFlush method returns a array and first element returns a boolean that is false when player have Royal Flush.
     */
    public function testRoyalFlushRule()
    {
        $die = new PokerRules();

        // Test when have Royal Flush.
        $this->player[] = new PokerCards("10", "♣", 10);
        $this->player[] = new PokerCards("J", "♣", 11);

        $this->board[] = new PokerCards("K", "♣", 12);
        $this->board[] = new PokerCards("Q", "♣", 13);
        $this->board[] = new PokerCards("A", "♣", 14);

        $allCards = $die->pushToValueCards($this->player, $this->board);
        $result = $die->royalFlush($allCards);
        $this->assertTrue($result[0]);

        // Test when not have Royal Flush.
        $this->playerHighCard[] = new PokerCards("2", "♣", 2);
        $this->playerHighCard[] = new PokerCards("4", "♦", 4);

        $this->boardHighCard[] = new PokerCards("8", "♦", 8);
        $this->boardHighCard[] = new PokerCards("J", "♥", 11);
        $this->boardHighCard[] = new PokerCards("K", "♦", 13);
        $this->boardHighCard[] = new PokerCards("A", "♠", 14);
        $this->boardHighCard[] = new PokerCards("9", "♥", 9);

        $allCardsNoPair = $die->pushToValueCards($this->playerHighCard, $this->boardHighCard);
        $result = $die->royalFlush($allCardsNoPair);
        $this->assertFalse($result[0]);
    }
}
