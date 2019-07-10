<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param string $slug
     * @return User[]
     */
    public function findLikeSlug(string $slug): array
    {
        $query = $this->createQueryBuilder('u')
            ->where(' u.pseudo LIKE :slug')
            ->setParameter('slug', '%' . $slug . '%');

        $datas = $query->getQuery()->getResult();

        // returns an array of Product objects
        return $datas;
    }


    public function findAllEventsByEntrant($user)
    {
        $queryBuilder = $this->createQueryBuilder('u')
            ->select('e')
            ->innerJoin('App:Entrant', 'e2', Join::WITH, 'u.id = e2.user_related')
            ->innerJoin('App:Event', 'e', Join::WITH, 'e2.event = e.id')
            ->andWhere('u.id = :userId')
            ->setParameter('userId', $user);
        return $queryBuilder;
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
