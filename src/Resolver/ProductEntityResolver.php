<?php declare(strict_types=1);

namespace App\Resolver;

use App\Entity\ProductEntity;
use App\Exception\ResolveException;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class ProductEntityResolver implements ValueResolverInterface
{
    public function __construct(
        private readonly ProductRepository $productRepository,
    ) {
    }

    /**
     * @throws ResolveException
     *
     * @return iterable<ProductEntity>
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if (!$argument->getType() || !\is_a($argument->getType(), ProductEntity::class, true)) {
            return [];
        }

        $productId = $request->attributes->get('productId');

        if (!$productId) {
            throw new ResolveException(ProductEntity::class, 'No property named "productId" found in request');
        }

        $product = $this->productRepository->find($productId);

        if (!$product) {
            throw new ResolveException(ProductEntity::class, 'Product does not exists');
        }

        yield $product;
    }
}
