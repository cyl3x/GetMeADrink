<?php declare(strict_types=1);

namespace App\Twig\Components;

use App\Entity\OrderEntity;
use App\Entity\OrderProductEntity;
use App\Entity\ProductEntity;
use App\Repository\OrderProductRepository;
use App\Repository\OrderRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
class OrderDetails
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public OrderEntity $order;

    public function __construct(
        private readonly OrderRepository $orderRepository,
        private readonly OrderProductRepository $orderProductRepository,
    ) {
    }

    public function getPendingProducts(): \ArrayIterator
    {
        return $this->order
            ->getOrderProducts()
            ->filter(static fn (OrderProductEntity $prod) => $prod->getPendingQuantity() !== 0)
            ->getIterator();
    }

    public function getDeliveredProducts(): \ArrayIterator
    {
        return $this->order
            ->getOrderProducts()
            ->filter(static fn (OrderProductEntity $prod) => $prod->getQuantity() !== 0)
            ->getIterator();
    }
}
