<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use App\ScoreBoardDomain\ScoreBoard;

#[AsCommand(
    name: 'app:scoreboard',
    description: 'Start multiple games and show the Football World Cup scoreboard'
)]
class ScoreBoardCommand extends Command
{
    /**
     * Construct
     *
     * @var ScoreBoard
     */
    private ScoreBoard $scoreBoard;

    public function __construct(ScoreBoard $scoreBoard)
    {
        parent::__construct();
        $this->scoreBoard = $scoreBoard;
    }

    /**
     * Configure
     *
     * @return void
     */
    protected function configure(): void
    {
        $this
            ->addArgument(
                'games',
                InputArgument::REQUIRED,
                'JSON array of games with scores. Example: [{"Mexico":0,"Canada":6},{"Spain":10,"Brazil":2}]'
            );
    }

    /**
     * Execute
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $gamesJson = $input->getArgument('games');

        $gamesArray = json_decode($gamesJson, true);

        if (!is_array($gamesArray)) {
            $output->writeln('<error>Invalid JSON input.</error>');
            return Command::FAILURE;
        }

        foreach ($gamesArray as $game) {
            if (count($game) !== $this->scoreBoard->memberPerTeam) {
                $output->writeln(sprintf(
                    '<error>Each game must have exactly %d teams.</error>',
                    $this->scoreBoard->memberPerTeam
                ));
                return Command::FAILURE;
            }

            $teams = array_keys($game);
            $scores = array_values($game);

            $home = $teams[0];
            $away = $teams[1];
            $homeScore = (int)$scores[0];
            $awayScore = (int)$scores[1];

            // Start game and update score
            $this->scoreBoard->startGame($home, $away);
            $this->scoreBoard->updateScore($home, $away, $homeScore, $awayScore);
        }

        // Print summary
        foreach ($this->scoreBoard->getSummary() as $game) {
            $output->writeln((string)$game);
        }

        return Command::SUCCESS;
    }
}
