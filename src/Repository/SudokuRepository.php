<?php

namespace App\Repository;

use App\Entity\Sudoku;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * @extends ServiceEntityRepository<Sudoku>
 *
 * @method Sudoku|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sudoku|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sudoku[]    findAll()
 * @method Sudoku[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SudokuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sudoku::class);
    }

    public function save(Sudoku $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Sudoku $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Sudoku[] Returns an array of Sudoku objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Sudoku
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function findOneRandom(): ?Sudoku
    {
        if ($id = $this->findRandomId()) {
            return $this->find($id);
        }
        return null;
    }

    private function findRandomId(): ?int
    {
        $postgresSql = 'select id FROM sudoku s, ceil(random() * (select max(id) from sudoku)) rid where s.id = rid';

        try {
            $stmt = $this->getEntityManager()->getConnection()->prepare($postgresSql);
            return $stmt->executeQuery()->fetchOne();
        } catch (Exception) {
            return null;
        }
    }
}
