<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\OrderEntity;
use App\Entity\OrderStatusEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OrderEntity>
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
    ) {
        parent::__construct($registry, OrderEntity::class);
    }

    public function byTableId(String $pTableId): mixed
    {
        $sql = "
            SELECT *
            FROM `order`
            WHERE table_id = :pTableId
            AND status_id = :pStatusId;
        ";

        $em = $this->getEntityManager();
        $stmt = $em->getConnection()->executeQuery($sql, [
            'pTableId' => $pTableId,
            'pStatusId' => OrderStatusEntity::PENDING,
        ]);
        return $stmt->fetchOne();
    }
}
