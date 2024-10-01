<?php declare(strict_types=1);

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/api', name: 'api.', format: 'json')]
class ProductController extends AbstractController
{
    public function __construct(
        private readonly ProductRepository $productRepository,
    ) {
    }

    #[Route(path: '/products', name: 'products', methods: ['GET'])]
    public function getProducts(): JsonResponse
    {
        $products = $this->productRepository->findAll();

        return new JsonResponse($products);
    }
}
