<?php

namespace App\Repository\Modules;

use App\Entity\Modules\ModuleTeam;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ModuleTeam|null find($id, $lockMode = null, $lockVersion = null)
 * @method ModuleTeam|null findOneBy(array $criteria, array $orderBy = null)
 * @method ModuleTeam[]    findAll()
 * @method ModuleTeam[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModuleTeamRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ModuleTeam::class);
    }

    // /**
    //  * @return ModuleTeam[] Returns an array of ModuleTeam objects
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
    public function findOneBySomeField($value): ?ModuleTeam
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
