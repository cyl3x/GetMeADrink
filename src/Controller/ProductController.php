<?php declare(strict_types=1);

namespace App\Controller;

use App\Entity\ProductCategoryEntity;
use App\Entity\ProductEntity;
use App\Entity\ProductVariantEntity;
use App\Repository\ProductCategoryRepository;
use App\Repository\ProductRepository;
use App\Repository\ProductVariantRepository;
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
        private readonly ProductVariantRepository $productVariantRepository,
    ) {
    }

    #[Route(path: '/product/{productId}', name: 'product', methods: ['GET'])]
    public function getProduct(ProductEntity $product): JsonResponse
    {
        return new JsonResponse($product);
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

    #[Route(path: '/product-category/{productCategoryId}', name: 'product-category', methods: ['GET'])]
    public function getProductCategory(ProductCategoryEntity $category): JsonResponse
    {
        return new JsonResponse($category);
    }

    #[Route(path: '/product-variants', name: 'product-variants', methods: ['GET'])]
    public function getProductVariants(): JsonResponse
    {
        $productVariants = $this->productVariantRepository->findAll();

        return new JsonResponse($productVariants);
    }

    #[Route(path: '/product-variant/{productVariantId}', name: 'product-variant', methods: ['GET'])]
    public function getProductVariant(ProductVariantEntity $variant): JsonResponse
    {
        return new JsonResponse($variant);
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

    #[Route(path: '/product', name: 'product.upsert', methods: ['POST'])]
    public function createProduct(Request $request): JsonResponse
    {
        $data = \json_decode($request->getContent(), true, 512, \JSON_THROW_ON_ERROR);

        if (isset($data['price']) && \is_int($data['price'])) {
            $data['price'] = (float) $data['price'];
        }

        if (isset($data['vat']) && \is_int($data['vat'])) {
            $data['vat'] = (float) $data['vat'];
        }

        $entity = $this->productRepository->upsert($data);

        return new JsonResponse($entity);
    }

    #[Route(path: '/product/{productId}', name: 'product.delete', methods: ['DELETE'])]
    public function deleteProduct(int $productId): JsonResponse
    {
        $this->productRepository->delete($productId);

        return new JsonResponse([]);
    }

    #[Route(path: '/product-category', name: 'product-category.upsert', methods: ['POST'])]
    public function upsertProductCategory(Request $request): JsonResponse
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

    #[Route(path: '/product-variant', name: 'product-variant.upsert', methods: ['POST'])]
    public function upsertProductVariant(Request $request): JsonResponse
    {
        $data = \json_decode($request->getContent(), true, 512, \JSON_THROW_ON_ERROR);

        $entity = $this->productVariantRepository->upsert($data);

        return new JsonResponse($entity);
    }

    #[Route(path: '/product-variant/{productVariantId}', name: 'product-variant.delete', methods: ['DELETE'])]
    public function deleteProductVariant(int $productVariantId): JsonResponse
    {
        $this->productVariantRepository->delete($productVariantId);

        return new JsonResponse([]);
    }
}
