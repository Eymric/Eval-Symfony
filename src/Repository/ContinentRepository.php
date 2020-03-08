<?php

namespace App\Repository;

use App\Entity\Continent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;

/**
 * @method Continent|null find($id, $lockMode = null, $lockVersion = null)
 * @method Continent|null findOneBy(array $criteria, array $orderBy = null)
 * @method Continent[]    findAll()
 * @method Continent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContinentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Continent::class);
    }

    // /**
    //  * @return Continent[] Returns an array of Continent objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    public function findAllIndexed()
    {
        $qb = $this->createQueryBuilder('c');
        $query = $qb->indexBy('c', 'c.name')->getQuery();
//        dd($query->getResult());
        return $query->getResult();
    }

    public function findId()
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT id FROM continent
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // returns an array of arrays (i.e. a raw data set)
        return($stmt->fetchAll());
    }

    public function test():Query
    {
        $results = $this->createQueryBuilder('c')
            ->select('c.id')
//            ->distinct()
            ->getQuery()
        ;

        return $results;
    }

    /*
    public function findOneBySomeField($value): ?Continent
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
