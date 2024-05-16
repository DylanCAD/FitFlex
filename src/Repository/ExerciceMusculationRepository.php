<?php

namespace App\Repository;

use Doctrine\ORM\Query;
use App\Entity\ExerciceMusculation;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<ExerciceMusculation>
 *
 * @method ExerciceMusculation|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExerciceMusculation|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExerciceMusculation[]    findAll()
 * @method ExerciceMusculation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExerciceMusculationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExerciceMusculation::class);
    }

    public function add(ExerciceMusculation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ExerciceMusculation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Query Returns an array of Equipement objects
     */
    public function listeExerciceMusculationsComplete($nom=null): ?Query
    {
        $query= $this->createQueryBuilder('ex')
            ->orderBy('ex.id', 'ASC');

            if($nom != null){
                $query->andWhere('ex.nomExerciceMusculation LIKE :nomcherche')
                ->setParameter('nomcherche', "%{$nom}%");
            }
        ;
        return $query->getQuery();
    }

//    public function findOneBySomeField($value): ?ExerciceMusculation
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
