<?php

namespace App\Repository;

use App\Entity\Documental;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Documental>
 *
 * @method Documental|null find($id, $lockMode = null, $lockVersion = null)
 * @method Documental|null findOneBy(array $criteria, array $orderBy = null)
 * @method Documental[]    findAll()
 * @method Documental[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DocumentalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Documental::class);
    }

//    /**
//     * @return Documental[] Returns an array of Documental objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Documental
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
