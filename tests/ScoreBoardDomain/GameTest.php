<?php

namespace App\Tests\ScoreBoardDomain;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

use App\ScoreBoardDomain\Game;

class GameTest extends TestCase
{
    /**
     * Test game score update
     *
     * @return void
     */
    public function testGameScoreIsUpdatedCorrectly(): void
    {
        $game = new Game('Germany', 'France', new \DateTimeImmutable());

        $game->updateScore(2, 2);

        $this->assertSame(2, $game->getHomeScore());
        $this->assertSame(2, $game->getAwayScore());
    }

    /**
     * Test game store home and away teams
     *
     * @return void
     */
    public function testGameStoresHomeAndAwayTeams(): void
    {
        $game = new Game('Germany', 'France', new \DateTimeImmutable());

        $this->assertSame('Germany', $game->getHomeTeam());
        $this->assertSame('France', $game->getAwayTeam());
    }

    /**
     * Test exception when game teams ase same
     *
     * @return void
     */
    public function testGameThrowsExceptionWhenTeamsAreTheSame(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Home and away teams must be different.');

        new Game('Brazil', 'Brazil', new \DateTimeImmutable());
    }

    /**
     * Test exception when negative score update for home team
     *
     * @return void
     */
    public function testUpdateScoreThrowsExceptionForNegativeScore(): void
    {
        $game = new Game('Germany', 'France', new \DateTimeImmutable());

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Scores cannot be negative');

        $game->updateScore(-1, 2);
    }

    /**
     * Test exception when negative score update for away team
     *
     * @return void
     */
    public function testUpdateScoreThrowsExceptionForNegativeAwayScore(): void
    {
        $game = new Game('Germany', 'France', new \DateTimeImmutable());

        $this->expectException(InvalidArgumentException::class);

        $game->updateScore(1, -2);
    }
}
