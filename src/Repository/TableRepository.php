<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\TableEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TableEntity>
 */
class TableRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
    ) {
        parent::__construct($registry, TableEntity::class);
    }

    public function create(): TableEntity
    {
        $table = new TableEntity();

        $this->getEntityManager()->persist($table);
        $this->getEntityManager()->flush();

        return $table;
    }

    public function delete(TableEntity $table): void
    {
        $this->getEntityManager()->remove($table);
        $this->getEntityManager()->flush();
    }
}
