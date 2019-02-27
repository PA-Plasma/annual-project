<?php

namespace App\Service\Modules;


use App\Entity\Modules\ModuleTournament;
use App\Entity\Modules\ModuleTournamentMatch;
use App\Repository\Modules\ModuleTournamentMatchRepository;
use \Doctrine\Common\Persistence\ManagerRegistry;

class ModuleTournamentHelper
{
    public $em;
    public $matchRepository;

    public function __construct(ManagerRegistry $em, ModuleTournamentMatchRepository $matchRepository)
    {
        $this->em = $em->getManager();
        $this->matchRepository = $matchRepository;
    }

    /**
     * @param ModuleTournament $tournament
     * @param int $round
     * @return ModuleTournamentMatch
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function newMatch(ModuleTournament $tournament, $round = 1)
    {
        $match = new ModuleTournamentMatch();
        $match->setRound($round)
            ->setNumber($this->matchRepository->getMatchNumber($tournament, $round));
        $tournament->addMatch($match);
        return $match;
    }

    public function getRounds(ModuleTournament $tournament)
    {
        $i = 1;
        $round = $this->matchRepository->findBy(['round' => $i, 'tournament' => $tournament]);
        $outDatas = [];
        while (!empty($round)) {
            $outDatas[$i] = $round;
            $i++;
            $round = $this->matchRepository->findBy(['round' => $i, 'tournament' => $tournament]);
        }
        return $outDatas;
    }

    public function getMatchWinner(ModuleTournamentMatch $match)
    {
        $scores = $match->getScores();
        $winner = null;
        $scoreW = 0;
        foreach ($scores as $score) {
            if ($scoreW < $score->getScore()) {
                $winner = $score->getPlayer();
                $scoreW = $score->getScore();
            }
        }
        return $winner;
    }

    public function getTournamentWinner(ModuleTournament $tournament)
    {
        $tournamentRounds = $this->getRounds($tournament);
        $lastRound = $tournamentRounds[count($tournamentRounds)];
        if (count($lastRound) === 1) {
            return $this->getMatchWinner($lastRound[0]);
        } else {
            return null;
        }
    }
}