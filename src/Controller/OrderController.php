<?php declare(strict_types=1);

namespace App\Controller;

use App\Entity\OrderEntity;
use App\Entity\OrderProductEntity;
use App\Entity\TableEntity;
use App\Repository\OrderProductRepository;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/api', name: 'api.', format: 'json')]
class OrderController extends AbstractController
{
    public function __construct(
        private readonly OrderRepository $orderRepository,
        private readonly OrderProductRepository $orderProductRepository,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    #[Route(path: '/order/ensure/{tableId}', name: 'order.ensure', methods: ['POST'])]
    public function ensureOrder(TableEntity $table): JsonResponse
    {
        $order = $this->orderRepository->fromTable($table);
        $this->orderRepository->updateTotalPrice($order);

        $this->entityManager->flush();

        return new JsonResponse($order);
    }

    #[Route(path: '/order/{orderId}', name: 'order', methods: ['GET'])]
    public function getOrder(OrderEntity $order): JsonResponse
    {
        return new JsonResponse($order);
    }

    #[Route(path: '/order/{orderId}/add/{productId}', name: 'order.product.add', methods: ['POST'])]
    public function addOrderProduct(OrderEntity $order, int $productId): JsonResponse
    {
        $this->orderProductRepository->addFromProduct($order, $productId);

        $this->entityManager->flush();

        return new JsonResponse($order);
    }

    #[Route(path: '/order/{orderId}/remove/{productId}', name: 'order.product.remove', methods: ['POST'])]
    public function removeOrderProduct(OrderEntity $order, int $productId): JsonResponse
    {
        $this->orderProductRepository->removeFromProduct($order, $productId);

        $this->entityManager->flush();

        return new JsonResponse($order);
    }

    #[Route(path: '/order/{orderId}/deliver/{orderProductId}', name: 'order.product.deliver', methods: ['POST'])]
    public function deliverOrderProduct(OrderProductEntity $orderProduct): JsonResponse
    {
        $this->orderProductRepository->deliver($orderProduct);
        $this->orderRepository->updateTotalPrice($orderProduct->getOrder());

        $this->entityManager->flush();

        return new JsonResponse($orderProduct->getOrder());
    }
}
