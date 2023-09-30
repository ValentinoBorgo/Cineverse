<?php

namespace App\Repository;

use App\Entity\Interaccion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Interaccion>
 *
 * @method Interaccion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Interaccion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Interaccion[]    findAll()
 * @method Interaccion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InteraccionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Interaccion::class);
    }

//    /**
//     * @return Interaccion[] Returns an array of Interaccion objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Interaccion
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
