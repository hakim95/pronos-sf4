<?php

namespace App\Repository;

use App\Entity\Matchs;
use App\Entity\Groups;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Matchs|null find($id, $lockMode = null, $lockVersion = null)
 * @method Matchs|null findOneBy(array $criteria, array $orderBy = null)
 * @method Matchs[]    findAll()
 * @method Matchs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MatchsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Matchs::class);
    }

    public function findMatchesByGroupstages()
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery("SELECT g.name as groupname, m.name as matchname, m.results as results from App\Entity\Groups g, App\Entity\Matchs m where g.id = m.groupstage and g.id in (select gr.id from App\Entity\Groups gr)");

        return $query->execute();
    }

    public function findActiveMatches()
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery("SELECT m.id, m.name FROM App\Entity\Matchs m WHERE m.results = ''");

        return $query->execute();
    }

//    /**
//     * @return Matchs[] Returns an array of Matchs objects
//     */
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
    public function findOneBySomeField($value): ?Matchs
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
