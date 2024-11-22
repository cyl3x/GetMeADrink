<?php declare(strict_types=1);

namespace App\Controller;

use App\Entity\ProductEntity;
use App\Repository\ProductCategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route(path: '/product', name: 'product.create', methods: ['POST'])]
    public function createProduct(Request $request): JsonResponse
    {
        $data = \json_decode($request->getContent(), true, 512, \JSON_THROW_ON_ERROR);

        $entity = $this->productRepository->upsert($data);

        return new JsonResponse($entity);
    }

    #[Route(path: '/product/{productId}', name: 'product.delete', methods: ['DELETE'])]
    public function deleteProduct(int $productId): JsonResponse
    {
        $this->productRepository->delete($productId);

        return new JsonResponse([]);
    }

    #[Route(path: '/product-category', name: 'product-category.create', methods: ['POST'])]
    public function createProductCategory(Request $request): JsonResponse
    {
        $data = \json_decode($request->getContent(), true, 512, \JSON_THROW_ON_ERROR);

        $entity = $this->productCategoryRepository->upsert($data);

        return new JsonResponse($entity);
    }

    #[Route(path: '/product-category/{productCategoryId}', name: 'product-category.delete', methods: ['DELETE'])]
    public function deleteProductCategory(int $productCategoryId): JsonResponse
    {
        $this->productCategoryRepository->delete($productCategoryId);

        return new JsonResponse([]);
    }
}
