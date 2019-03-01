<?php

namespace App\Repository\Modules;

use App\Entity\Modules\ModuleTournament;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ModuleTournament|null find($id, $lockMode = null, $lockVersion = null)
 * @method ModuleTournament|null findOneBy(array $criteria, array $orderBy = null)
 * @method ModuleTournament[]    findAll()
 * @method ModuleTournament[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModuleTournamentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ModuleTournament::class);
    }

    // /**
    //  * @return ModuleTournament[] Returns an array of ModuleTournament objects
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
    public function findOneBySomeField($value): ?ModuleTournament
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
