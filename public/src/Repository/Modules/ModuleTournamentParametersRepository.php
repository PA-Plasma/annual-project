<?php

namespace App\Repository\Modules;

use App\Entity\Modules\ModuleTournamentParameters;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ModuleTournamentParameters|null find($id, $lockMode = null, $lockVersion = null)
 * @method ModuleTournamentParameters|null findOneBy(array $criteria, array $orderBy = null)
 * @method ModuleTournamentParameters[]    findAll()
 * @method ModuleTournamentParameters[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModuleTournamentParametersRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ModuleTournamentParameters::class);
    }

    // /**
    //  * @return ModuleTournamentParameters[] Returns an array of ModuleTournamentParameters objects
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
    public function findOneBySomeField($value): ?ModuleTournamentParameters
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
