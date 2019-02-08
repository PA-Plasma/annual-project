<?php

namespace App\Repository;

use App\Entity\Modules;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Modules|null find($id, $lockMode = null, $lockVersion = null)
 * @method Modules|null findOneBy(array $criteria, array $orderBy = null)
 * @method Modules[]    findAll()
 * @method Modules[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModulesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Modules::class);
    }

    function getActiveModules()
    {
        return $this
            ->createQueryBuilder('m')
            ->where('m.deleted = ?1')
            ->andWhere('m.active = ?2')
            ->setParameter(1, false)
            ->setParameter(2, true)
            ->orderBy('m.name', 'ASC');
    }

    // /**
    //  * @return Modules[] Returns an array of Modules objects
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
    public function findOneBySomeField($value): ?Modules
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
