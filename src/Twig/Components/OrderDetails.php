<?php declare(strict_types=1);

namespace App\Twig\Components;

use App\Entity\OrderEntity;
use App\Entity\OrderProductEntity;
use App\Repository\OrderProductRepository;
use App\Repository\OrderRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
class OrderDetails
{
    use DefaultActionTrait;

    #[LiveProp(writable: false)]
    public OrderEntity $order;

    public function __construct(
        private readonly OrderRepository $orderRepository,
        private readonly OrderProductRepository $orderProductRepository,
    ) {
    }

    #[LiveListener('product:add')]
    public function addProduct(#[LiveArg] int $productId): void
    {
        $this->orderProductRepository->addFromProduct($this->order, $productId);
    }

    #[LiveListener('product:remove')]
    public function removeProduct(#[LiveArg] int $productId): void
    {
        $this->orderProductRepository->removeFromProduct($this->order, $productId);
    }

    #[LiveListener('order-product:deliver')]
    public function deliverProduct(#[LiveArg] int $orderProductId): void
    {
        $orderProduct = $this->order->getOrderProducts()->findFirst(
            static fn (int $key) => $key === $orderProductId
        );

        if (!$orderProduct) {
            return;
        }

        $this->orderProductRepository->deliver($orderProduct);
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
