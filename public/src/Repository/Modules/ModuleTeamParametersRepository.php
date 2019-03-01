<?php

namespace App\Repository\Modules;

use App\Entity\Modules\ModuleTeamParameters;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ModuleTeamParameters|null find($id, $lockMode = null, $lockVersion = null)
 * @method ModuleTeamParameters|null findOneBy(array $criteria, array $orderBy = null)
 * @method ModuleTeamParameters[]    findAll()
 * @method ModuleTeamParameters[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModuleTeamParametersRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ModuleTeamParameters::class);
    }

    // /**
    //  * @return ModuleTeamParameters[] Returns an array of ModuleTeamParameters objects
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
    public function findOneBySomeField($value): ?ModuleTeamParameters
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
