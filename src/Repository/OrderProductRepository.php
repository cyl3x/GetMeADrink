<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\OrderEntity;
use App\Entity\OrderProductEntity;
use App\Entity\ProductEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OrderProductEntity>
 */
class OrderProductRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
    ) {
        parent::__construct($registry, OrderProductEntity::class);
    }

    public function addFromProduct(OrderEntity $order, int $productId): OrderProductEntity
    {
        $em = $this->getEntityManager();

        $existing = $this->findOneBy([
            'product' => $productId,
            'order' => $order,
        ]);

        if ($existing) {
            $existing->addPendingQuantity();

            $em->persist($existing);
            $em->flush();

            return $existing;
        }

        $product = $em->getReference(ProductEntity::class, $productId);

        $orderProduct = (new OrderProductEntity())
            ->setProduct($product)
            ->setOrder($order);

        $em->persist($orderProduct);
        $em->flush();

        return $orderProduct;
    }

    public function removeFromProduct(OrderEntity $order, int $productId): OrderProductEntity
    {
        $em = $this->getEntityManager();

        $existing = $this->findOneBy([
            'product' => $productId,
            'order' => $order,
        ]);

        if ($existing) {
            $existing->addPendingQuantity(-1);

            $em->persist($existing);
            $em->flush();

            return $existing;
        }
    }

    public function deliver(OrderProductEntity $orderProduct): void
    {
        if ($orderProduct->getPendingQuantity() === 0) {
            return;
        }

        $orderProduct->addPendingQuantity(-1);
        $orderProduct->addQuantity();

        $this->getEntityManager()->persist($orderProduct);
        $this->getEntityManager()->flush();
    }
}
