<?php

namespace App\Repository;

use App\Entity\TipoSuscripcion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TipoSuscripcion>
 *
 * @method TipoSuscripcion|null find($id, $lockMode = null, $lockVersion = null)
 * @method TipoSuscripcion|null findOneBy(array $criteria, array $orderBy = null)
 * @method TipoSuscripcion[]    findAll()
 * @method TipoSuscripcion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TipoSuscripcionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TipoSuscripcion::class);
    }

//    /**
//     * @return TipoSuscripcion[] Returns an array of TipoSuscripcion objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TipoSuscripcion
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
