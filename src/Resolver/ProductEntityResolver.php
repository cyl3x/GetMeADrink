<?php declare(strict_types=1);

namespace App\Resolver;

use App\Entity\ProductEntity;
use App\Exception\ResolveException;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\ParameterBag;
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

        $productId = $this->getId($request->attributes);

        if (!$productId) {
            throw new ResolveException(ProductEntity::class, 'No property named "productId" found in request');
        }

        $product = $this->productRepository->find($productId);

        if (!$product) {
            throw new ResolveException(ProductEntity::class, 'Product does not exists');
        }

        yield $product;
    }

    public function getId(ParameterBag $attributes): mixed
    {
        if ($attributes->has('id')) {
            return $attributes->get('id');
        }

        if ($attributes->has('productId')) {
            return $attributes->get('productId');
        }

        if ($attributes->has('_live_request_data')) {
            $liveData = $attributes->get('_live_request_data');

            if (\array_key_exists('args', $liveData)) {
                return $liveData['args']['id'] ?? $liveData['args']['productId'] ?? null;
            }
        }

        return null;
    }
}
