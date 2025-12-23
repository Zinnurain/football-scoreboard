<?php

namespace App\ScoreBoardDomain;

/**
 * Game class
 */
final class Game
{
    private string $homeTeam;
    private string $awayTeam;
    private int $homeScore = 0;
    private int $awayScore = 0;
    private \DateTimeImmutable $startedAt;

    /**
     * @param string $homeTeam
     * @param string $awayTeam
     * @param \DateTimeImmutable $startedAt
     */
    public function __construct(
        string $homeTeam,
        string $awayTeam,
        \DateTimeImmutable $startedAt
    ) {
        if ($homeTeam === $awayTeam) {
            throw new \InvalidArgumentException('Home and away teams must be different.');
        }

        $this->homeTeam = $homeTeam;
        $this->awayTeam = $awayTeam;
        $this->startedAt = $startedAt;
    }

    /**
     * Update score
     *
     * @param int $homeScore
     * @param int $awayScore
     * @return void
     */
    public function updateScore(int $homeScore, int $awayScore): void
    {
        if ($homeScore < 0 || $awayScore < 0) {
            throw new \InvalidArgumentException('Scores cannot be negative.');
        }

        $this->homeScore = $homeScore;
        $this->awayScore = $awayScore;
    }

    /**
     * @return string
     */
    public function getHomeTeam(): string
    {
        return $this->homeTeam;
    }

    /**
     * @return string
     */
    public function getAwayTeam(): string
    {
        return $this->awayTeam;
    }

    /**
     * @return int
     */
    public function getHomeScore(): int
    {
        return $this->homeScore;
    }

    /**
     * @return int
     */
    public function getAwayScore(): int
    {
        return $this->awayScore;
    }

    /**
     * @return int
     */
    public function getTotalScore(): int
    {
        return $this->homeScore + $this->awayScore;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getStartedAt(): \DateTimeImmutable
    {
        return $this->startedAt;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return sprintf(
            '%s %d - %s %d',
            $this->homeTeam,
            $this->homeScore,
            $this->awayTeam,
            $this->awayScore
        );
    }
}
