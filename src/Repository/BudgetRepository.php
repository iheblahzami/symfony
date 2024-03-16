<?php

namespace App\Repository;

use App\Entity\Budget;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Budget>
 *
 * @method Budget|null find($id, $lockMode = null, $lockVersion = null)
 * @method Budget|null findOneBy(array $criteria, array $orderBy = null)
 * @method Budget[]    findAll()
 * @method Budget[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BudgetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Budget::class);
    }

    public function add(Budget $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Budget $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();

        if ($flush) {
        }
    }
    public function findAllWithCategories(): array
    {
        return $this->createQueryBuilder('b')
            ->addSelect('c') // Assuming the association property is named 'categorie'
            ->leftJoin('b.categorie', 'c')
            ->getQuery()
            ->getResult();
    }

    public function findAllMontant(): array // Update method name
    {
        return $this->createQueryBuilder('b')
            ->select('b.montant') // Update property name
            ->getQuery()
            ->getResult();
    }
    


//    /**
//     * @return Budget[] Returns an array of Budget objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Budget
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
