<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\TableEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TableRepository extends ServiceEntityRepository
{
    /**
     * @param class-string<T> $entityClass
     */
    public function __construct(
        ManagerRegistry $registry,
    ) {
        parent::__construct($registry, TableEntity::class);
    }
}