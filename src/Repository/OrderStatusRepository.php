<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\OrderStatusEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OrderStatusEntity>
 */
class OrderStatusRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
    ) {
        parent::__construct($registry, OrderStatusEntity::class);
    }
}
