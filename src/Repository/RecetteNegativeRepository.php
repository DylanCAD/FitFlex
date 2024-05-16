<?php

namespace App\Repository;

use Doctrine\ORM\Query;
use App\Entity\RecetteNegative;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<RecetteNegative>
 *
 * @method RecetteNegative|null find($id, $lockMode = null, $lockVersion = null)
 * @method RecetteNegative|null findOneBy(array $criteria, array $orderBy = null)
 * @method RecetteNegative[]    findAll()
 * @method RecetteNegative[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecetteNegativeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RecetteNegative::class);
    }

    public function add(RecetteNegative $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(RecetteNegative $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Query Returns an array of Equipement objects
     */
    public function listeRecetteNegativesComplete($nom=null): ?Query
    {
        $query= $this->createQueryBuilder('rn')
            ->orderBy('rn.id', 'ASC');

            if($nom != null){
                $query->andWhere('rn.nomRecetteNegative LIKE :nomcherche')
                ->setParameter('nomcherche', "%{$nom}%");
            }
        ;
        return $query->getQuery();
    }

//    public function findOneBySomeField($value): ?RecetteNegative
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
