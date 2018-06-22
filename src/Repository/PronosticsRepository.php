<?php

namespace App\Repository;

use App\Entity\Pronostics;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Pronostics|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pronostics|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pronostics[]    findAll()
 * @method Pronostics[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PronosticsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Pronostics::class);
    }

    public function findPronosticsByUser($userId)
    {
        return $this->createQueryBuilder('p')
            ->join('p.contest','m')
            ->andWhere('p.pronouser = :user')
            ->setParameter('user', $userId)
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Pronostics[] Returns an array of Pronostics objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Pronostics
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
