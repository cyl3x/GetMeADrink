<?php declare(strict_types=1);

namespace App\Twig\Components;

use App\Entity\OrderEntity;
use App\Repository\OrderProductRepository;
use App\Repository\ProductRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
class Products
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public OrderEntity $order;

    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly OrderProductRepository $orderProductRepository,
    ) {
    }

    public function getProducts(): array
    {
        return $this->productRepository->findAll();
    }

    #[LiveAction]
    public function addProduct(#[LiveArg] string $productId): void
    {
        $product = $this->productRepository->find($productId);

        $this->orderProductRepository->fromProduct($this->order, $product);
    }
}
