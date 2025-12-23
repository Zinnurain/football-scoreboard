<?php

namespace App\ScoreBoardDomain;

/**
 * ScoreBoard class
 */
final class ScoreBoard
{
    /**
     * @var Game[]
     */
    private array $games = [];

    /**
     * Start game
     *
     * @param string $homeTeam
     * @param string $awayTeam
     * @return void
     */
    public function startGame(string $homeTeam, string $awayTeam): void
    {
        $key = $this->getKey($homeTeam, $awayTeam);

        if (isset($this->games[$key])) {
            throw new \RuntimeException('Game already exists.');
        }

        $this->games[$key] = new Game(
            $homeTeam,
            $awayTeam,
            new \DateTimeImmutable()
        );
    }

    /**
     * Finish game
     *
     * @param string $homeTeam
     * @param string $awayTeam
     * @return void
     */
    public function finishGame(string $homeTeam, string $awayTeam): void
    {
        $key = $this->getKey($homeTeam, $awayTeam);

        if (!isset($this->games[$key])) {
            throw new \RuntimeException('Game not found.');
        }

        unset($this->games[$key]);
    }

    /**
     * Update score
     *
     * @param string $homeTeam
     * @param string $awayTeam
     * @param int $homeScore
     * @param int $awayScore
     * @return void
     */
    public function updateScore(
        string $homeTeam,
        string $awayTeam,
        int $homeScore,
        int $awayScore
    ): void {
        $game = $this->getGame($homeTeam, $awayTeam);
        $game->updateScore($homeScore, $awayScore);
    }

    /**
     * Get Summary
     *
     * @return Game[]
     */
    public function getSummary(): array
    {
        $games = array_values($this->games);

        usort($games, function (Game $a, Game $b) {
            $totalScoreComparison = $b->getTotalScore() <=> $a->getTotalScore();

            if ($totalScoreComparison !== 0) {
                return $totalScoreComparison;
            }

            return $b->getStartedAt() <=> $a->getStartedAt();
        });

        return $games;
    }

    /**
     * Get game
     *
     * @param string $homeTeam
     * @param string $awayTeam
     * @return Game
     */
    private function getGame(string $homeTeam, string $awayTeam): Game
    {
        $key = $this->getKey($homeTeam, $awayTeam);

        if (!isset($this->games[$key])) {
            throw new \RuntimeException('Game not found.');
        }

        return $this->games[$key];
    }

    /**
     * Get Key
     *
     * @param string $homeTeam
     * @param string $awayTeam
     * @return string
     */
    private function getKey(string $homeTeam, string $awayTeam): string
    {
        return strtolower($homeTeam . '_' . $awayTeam);
    }
}
