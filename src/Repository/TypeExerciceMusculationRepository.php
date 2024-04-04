<?php

namespace App\Repository;

use App\Entity\TypeExerciceMusculation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TypeExerciceMusculation>
 *
 * @method TypeExerciceMusculation|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeExerciceMusculation|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeExerciceMusculation[]    findAll()
 * @method TypeExerciceMusculation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeExerciceMusculationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeExerciceMusculation::class);
    }

    public function add(TypeExerciceMusculation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TypeExerciceMusculation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return TypeExerciceMusculation[] Returns an array of TypeExerciceMusculation objects
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

//    public function findOneBySomeField($value): ?TypeExerciceMusculation
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
