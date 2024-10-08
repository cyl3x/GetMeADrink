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

        return $order;
    }

    public function updateTotalPrice(OrderEntity $order): float
    {
        $em = $this->getEntityManager();
        $totalPrice = 0;

        foreach ($order->getOrderProducts() as $orderProduct) {
            $totalPrice += ($orderProduct->getPrice() * $orderProduct->getQuantity());
        }

        $em->persist($order->setTotalPrice($totalPrice));

        return $totalPrice;
    }


    public function hasPendingProducts(TableEntity $table): bool
    {
        // Erstelle den QueryBuilder für die Abfrage
        $qb = $this->createQueryBuilder('o')
            ->select('COUNT(op.id)')
            ->innerJoin('o.orderProducts', 'op')  // Verbinde die Order mit ihren Produkten
            ->where('o.table = :table')  // Filtere nach der übergebenen Tabelle
            ->andWhere('op.pendingQuantity > 0')  // Nur Produkte mit offenen Mengen
            ->setParameter('table', $table);

        // Führe die Abfrage aus und erhalte die Anzahl der offenen Produkte
        $pendingProductCount = (int) $qb->getQuery()->getSingleScalarResult();

        // Gibt true zurück, wenn es mindestens ein offenes Produkt gibt
        return $pendingProductCount > 0;
    }
}
