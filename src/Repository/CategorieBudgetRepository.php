<?php

namespace App\Repository;

use App\Entity\CategorieBudget;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CatergorieBudget>
 *
 * @method CatergorieBudget|null find($id, $lockMode = null, $lockVersion = null)
 * @method CatergorieBudget|null findOneBy(array $criteria, array $orderBy = null)
 * @method CatergorieBudget[]    findAll()
 * @method CatergorieBudget[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieBudgetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategorieBudget::class);
    }

    public function add(CategorieBudget $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CategorieBudget $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findNomCategories(): array
    {
        return $this->createQueryBuilder('c')
        ->select('c.id', 'c.nomCategorie')
            ->getQuery()
            ->getResult();
    }

  

//    /**
//     * @return CatergorieBudget[] Returns an array of CatergorieBudget objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CatergorieBudget
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
