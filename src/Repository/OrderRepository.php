<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\OrderEntity;
use App\Entity\OrderStatusEntity;
use App\Entity\TableEntity;
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

    public function byTableId(int $pTableId): ?OrderEntity
    {
        return $this
            ->createQueryBuilder('o')
            ->where('o.table = (:pTableId)')
            ->andWhere('o.status = (:pStatusId)')
            ->setParameter('pTableId', $pTableId)
            ->setParameter('pStatusId', OrderStatusEntity::PENDING)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function fromTable(TableEntity $table): OrderEntity
    {
        $existingOrder = $this->findOneBy([
            'table' => $table,
            'status' => OrderStatusEntity::PENDING,
        ]);

        if ($existingOrder) {
            return $existingOrder;
        }

        $em = $this->getEntityManager();

        $status = $em->getReference(OrderStatusEntity::class, OrderStatusEntity::PENDING);

        $order = (new OrderEntity())
            ->setTable($table)
            ->setStatus($status)
            ->setTotalPrice(0);

        $em->persist($order);
        $em->flush();

        return $order;
    }
}
