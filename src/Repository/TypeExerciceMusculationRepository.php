<?php

namespace App\Repository;

use Doctrine\ORM\Query;
use App\Entity\TypeExerciceMusculation;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

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

    /**
     * @return Query Returns an array of Equipement objects
     */
    public function listeTypeExerciceMusculationsComplete($nom=null): ?Query
    {
        $query= $this->createQueryBuilder('tex')
            ->orderBy('tex.id', 'ASC');

            if($nom != null){
                $query->andWhere('tex.nomTypeExerciceMusculation LIKE :nomcherche')
                ->setParameter('nomcherche', "%{$nom}%");
            }
        ;
        return $query->getQuery();
    }

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
