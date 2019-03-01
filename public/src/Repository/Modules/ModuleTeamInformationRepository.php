<?php

namespace App\Repository\Modules;

use App\Entity\Modules\ModuleTeamInformation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ModuleTeamInformation|null find($id, $lockMode = null, $lockVersion = null)
 * @method ModuleTeamInformation|null findOneBy(array $criteria, array $orderBy = null)
 * @method ModuleTeamInformation[]    findAll()
 * @method ModuleTeamInformation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModuleTeamInformationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ModuleTeamInformation::class);
    }

    // /**
    //  * @return ModuleTeamInformation[] Returns an array of ModuleTeamInformation objects
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
    public function findOneBySomeField($value): ?ModuleTeamInformation
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
