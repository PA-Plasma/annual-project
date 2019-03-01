<?php

namespace App\Repository\Modules;

use App\Entity\Modules\ModuleTournament;
use App\Entity\Modules\ModuleTournamentMatch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ModuleTournamentMatch|null find($id, $lockMode = null, $lockVersion = null)
 * @method ModuleTournamentMatch|null findOneBy(array $criteria, array $orderBy = null)
 * @method ModuleTournamentMatch[]    findAll()
 * @method ModuleTournamentMatch[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModuleTournamentMatchRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ModuleTournamentMatch::class);
    }

    /**
     * @param ModuleTournament $tournament
     * @param int $round
     * @return int|mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getMatchNumber(ModuleTournament $tournament, $round = 1)
    {
        $query = $this->createQueryBuilder('m')
            ->select('MAX(m.number) as max_number')
            ->andWhere('m.tournament = :tournament')
            ->setParameter('tournament', $tournament)
            ->andWhere('m.round = :round')
            ->setParameter('round', $round)
            ->getQuery()
            ->getOneOrNullResult();
        if (empty($query)) {
            return 1;
        }
        return $query['max_number']+1;
    }

    public function getMatchByRound(ModuleTournament $tournament)
    {
        $query = $this->createQueryBuilder('m')
            ->andWhere('m.tournament = :tournament')->setParameter('tournament', $tournament)
            ->groupBy('m.round')
            ->orderBy('m.round', 'ASC')
            ->getQuery()
            ->getResult();
        return $query;
    }

    // /**
    //  * @return ModuleTournamentMatch[] Returns an array of ModuleTournamentMatch objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ModuleTournamentMatch
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
