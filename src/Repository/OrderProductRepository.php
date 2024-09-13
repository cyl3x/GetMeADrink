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

    public function fromProduct(OrderEntity $order, ProductEntity $product): OrderProductEntity
    {
        $em = $this->getEntityManager();

        $existing = $this->findOneBy([
            'product' => $product,
            'order' => $order,
        ]);

        if ($existing) {
            $existing->addPendingQuantity();

            $em->persist($existing);
            $em->flush();

            return $existing;
        }

        $orderProduct = (new OrderProductEntity())
            ->setProduct($product)
            ->setOrder($order);

        $em->persist($orderProduct);
        $em->flush();

        return $orderProduct;
    }
}
