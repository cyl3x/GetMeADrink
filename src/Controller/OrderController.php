<?php declare(strict_types=1);

namespace App\Controller;

use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use App\Entity\OrderStatusEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OrderController extends AbstractController
{
    public function __construct(
        private OrderRepository $orderRepository,
        private readonly ProductRepository $productRepository,
    ) {
    }

    #[Route(path: '/order/{id}', name: 'order', methods: ['GET'])]
    public function order(string $id): Response
    {
        $order = $this->orderRepository->byTableId($id);
        $products = $this->productRepository->findAll();

        return $this->render('order/index.html.twig', [
            'order' => $order,
            'products' => $products,
        ]);
    }

    #[Route(path: '/product/select', name: 'product.select', methods: ['POST'])]
    public function addToOrder(Request $request)
    {
        $productId = $request->request->get('product_id');


    }

}
