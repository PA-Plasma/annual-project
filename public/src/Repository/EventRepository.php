<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\Query\Expr\Join;

/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function findUserRegistered(Event $event, $user)
    {
        $q = $this->createQueryBuilder('g')
            ->select('gu')
            ->innerJoin('App:Entrant', 'gu', Join::WITH, 'g.id = gu.event')
            ->andWhere('g.id = :eventId')
            ->setParameter('eventId', $event->getId())
            ->andWhere('gu.user_related = :entrantId')
            ->setParameter('entrantId', $user)
            ->andWhere('gu.deleted = :deleted')
            ->setParameter('deleted', false);

        return ($q->getQuery()->getResult());
    }

    public function getList($name = '', $date = null)
    {
        $query = $this->createQueryBuilder('e')
            ->andWhere('e.deleted = false')
            ->andWhere('e.active = true');
        if ($name !== '') {
            $query->andWhere('e.name LIKE :name')
                ->setParameter('name', '%'.$name.'%');
        }
        if ($date !== null) {
            $query->andWhere('e.end_date <= :date')
                ->andWhere('e.beginnig_date >= :date')
                ->setParameter('date', $date->format('Y/m/d'));
        }
        return $query->getQuery()->getResult();
    }

    // /**
    //  * @return Event[] Returns an array of Event objects
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
    public function findOneBySomeField($value): ?Event
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
