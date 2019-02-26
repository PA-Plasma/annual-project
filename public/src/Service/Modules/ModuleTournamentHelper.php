<?php

namespace App\Service\Modules;


use App\Entity\Modules\ModuleTournament;
use App\Entity\Modules\ModuleTournamentMatch;
use \Doctrine\Common\Persistence\ManagerRegistry;

class ModuleTournamentHelper
{
    public $em;

    public function __construct(ManagerRegistry $em)
    {
        $this->em = $em->getManager();
    }

    public function newMatch(ModuleTournament $tournament, $round = 1)
    {
        $match = new ModuleTournamentMatch();
        $match->setRound($round);
        $tournament->addMatch($match);
        $this->em->persist($match);
        $this->em->flush();
        return $match;
    }
}