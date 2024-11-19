<?php declare(strict_types=1);

namespace App\Controller;

use App\Entity\ProductEntity;
use App\Repository\ProductCategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/api', name: 'api.', format: 'json')]
class ProductController extends AbstractController
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly ProductCategoryRepository $productCategoryRepository,
    ) {
    }

    #[Route(path: '/products', name: 'products', methods: ['GET'])]
    public function getProducts(): JsonResponse
    {
        $products = $this->productRepository->findAll();

        return new JsonResponse($products);
    }

    #[Route(path: '/product-categories', name: 'product-categories', methods: ['GET'])]
    public function getProductCategories(): JsonResponse
    {
        $productCategories = $this->productCategoryRepository->findAll();

        return new JsonResponse($productCategories);
    }

    #[Route(path: '/product/{productId}/image', name: 'frontend')]
    public function getProductImage(ProductEntity $product): Response
    {
        if (!$product->hasImage()) {
            return new Response(status: 404);
        }

        return new Response(
            \stream_get_contents($product->getImage()),
            headers: [
                'Content-Type' => \mime_content_type($product->getImage()) ?: null,
            ]
        );
    }
}
