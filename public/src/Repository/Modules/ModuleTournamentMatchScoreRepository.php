<?php

namespace App\Repository\Modules;

use App\Entity\Modules\ModuleTournamentMatch;
use App\Entity\Modules\ModuleTournamentMatchScore;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ModuleTournamentMatchScore|null find($id, $lockMode = null, $lockVersion = null)
 * @method ModuleTournamentMatchScore|null findOneBy(array $criteria, array $orderBy = null)
 * @method ModuleTournamentMatchScore[]    findAll()
 * @method ModuleTournamentMatchScore[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModuleTournamentMatchScoreRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ModuleTournamentMatchScore::class);
    }

    // /**
    //  * @return ModuleTournamentMatchScore[] Returns an array of ModuleTournamentMatchScore objects
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
    public function findOneBySomeField($value): ?ModuleTournamentMatchScore
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
