<?php

namespace App\Repository;

use App\Entity\Parti;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Parti|null find($id, $lockMode = null, $lockVersion = null)
 * @method Parti|null findOneBy(array $criteria, array $orderBy = null)
 * @method Parti[]    findAll()
 * @method Parti[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PartiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Parti::class);
    }

    public function findBySexe($sexe)
    {
        $queryBuilder = $this->createQueryBuilder('s');    
        $queryBuilder->where('s.sexe = :sexe')         
            ->setParameter('sexe', $sexe);
        return $queryBuilder->getQuery()->getResult(); 

        /*return $this->getEntityManager()->createQuery('SELECT a
                                                    FROM App\Entity\Parti a
                                                    WHERE a.sexe LIKE :sexe'
        )->setParameter('sexe', "%" . $sexe . "%")
            ->getResult();*/
    }

    // /**
    //  * @return Parti[] Returns an array of Parti objects
    //  */
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
    public function findOneBySomeField($value): ?Parti
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
