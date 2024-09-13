<?php declare(strict_types=1);

namespace App\Controller;

use App\Entity\OrderEntity;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OrderController extends AbstractController
{
    public function __construct(
        private readonly ProductRepository $productRepository,
    ) {
    }

    #[Route(path: '/order/{orderId}', name: 'order', methods: ['GET'])]
    public function order(OrderEntity $order): Response
    {
        $products = $this->productRepository->findAll();

        return $this->render('order/index.html.twig', [
            'order' => $order,
            'products' => $products,
        ]);
    }

    #[Route(path: '/order/{orderId}/select/{productId}', name: 'order.product.select', methods: ['POST'])]
    public function orderSelectProduct(OrderEntity $order, string $productId)
    {
        if (!$order) {
            throw $this->createNotFoundException('Order not found');
        }

        $product = $this->productRepository->find($productId);

        if (!$product) {
            throw $this->createNotFoundException('Product not found');
        }

        return $this->redirectToRoute('order', ['orderId' => $order->getId()]);
    }
}
