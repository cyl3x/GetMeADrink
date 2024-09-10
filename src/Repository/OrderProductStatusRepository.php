<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\OrderProductStatusEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OrderProductStatusEntity>
 */
class OrderProductStatusRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
    ) {
        parent::__construct($registry, OrderProductStatusEntity::class);
    }
}
