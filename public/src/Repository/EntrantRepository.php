<?php

namespace App\Repository;

use App\Entity\Entrant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Entrant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Entrant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Entrant[]    findAll()
 * @method Entrant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntrantRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Entrant::class);
    }

    public function findAllEntrantsByEvent($event)
    {
        $queryBuilder = $this->createQueryBuilder('e');

        $queryBuilder->where('e.event = :event')
            ->setParameter('event', $event);
//            ->andWhere('e.team is NULL')

        return $queryBuilder;
    }

    public function findAllEntrantsRegisteredByEvent($event)
    {
        $queryBuilder = $this->createQueryBuilder('e');

        $queryBuilder->where('e.event = :event')
            ->andWhere('e.deleted != true')
            ->setParameter('event', $event);
//            ->andWhere('e.team is NULL')

        return $queryBuilder;
    }


    public function findEntrantRegisteredByEvent($event, $user)
    {
        $queryBuilder = $this->createQueryBuilder('e');

        $queryBuilder->where('e.user_related = :userId')
            ->andWhere('e.deleted != true')
            ->andwhere('e.event = :event')
            ->setParameter('event', $event)
            ->setParameter('userId', $user);
        return $queryBuilder;
    }

    // /**
    //  * @return Entrant[] Returns an array of Entrant objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Entrant
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
