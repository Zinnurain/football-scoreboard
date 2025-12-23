<?php

namespace App\Tests\ScoreBoardDomain;

use PHPUnit\Framework\TestCase;
use RuntimeException;

use App\ScoreBoardDomain\ScoreBoard;

/**
 * ScoreBoardTest class
 */
final class ScoreBoardTest extends TestCase
{
    /**
     * Test game summary
     *
     * @return void
     */
    public function testGameSummary(): void
    {
        $board = new ScoreBoard();

        $board->startGame('Mexico', 'Canada');
        $board->startGame('Spain', 'Brazil');
        $board->startGame('Germany', 'France');
        $board->startGame('Uruguay', 'Italy');
        $board->startGame('Argentina', 'Australia');

        $board->updateScore('Mexico', 'Canada', 0, 5);
        $board->updateScore('Spain', 'Brazil', 10, 2);
        $board->updateScore('Germany', 'France', 2, 2);
        $board->updateScore('Uruguay', 'Italy', 6, 6);
        $board->updateScore('Argentina', 'Australia', 3, 1);

        $summary = $board->getSummary();

        $this->assertSame('Uruguay 6 - Italy 6', (string) $summary[0]);
        $this->assertSame('Spain 10 - Brazil 2', (string) $summary[1]);
    }

    /**
     * Test finish game
     *
     * @return void
     */
    public function testFinishGameRemovesMatch(): void
    {
        $scoreBoard = new ScoreBoard();

        $scoreBoard->startGame('Mexico', 'Canada');
        $scoreBoard->finishGame('Mexico', 'Canada');

        $this->assertCount(0, $scoreBoard->getSummary());
    }

    /**
     * Test exception when start game but game already exists exception
     *
     * @return void
     */
    public function testStartGameThrowsExceptionWhenGameAlreadyExists(): void
    {
        $scoreBoard = new ScoreBoard();

        $scoreBoard->startGame('Mexico', 'Canada');

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Game already exists.');

        $scoreBoard->startGame('Mexico', 'Canada');
    }

    /**
     * Test exception when update score but game does not exit
     *
     * @return void
     */
    public function testUpdateScoreThrowsExceptionWhenGameDoesNotExist(): void
    {
        $scoreBoard = new ScoreBoard();

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Game not found');

        $scoreBoard->updateScore('Spain', 'Brazil', 1, 1);
    }

    /**
     * Test exception when finish game but game does not exist
     *
     * @return void
     */
    public function testFinishGameThrowsExceptionWhenGameDoesNotExist(): void
    {
        $scoreBoard = new ScoreBoard();

        $this->expectException(RuntimeException::class);

        $scoreBoard->finishGame('Germany', 'France');
    }
}
