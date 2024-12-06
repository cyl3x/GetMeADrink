<?php declare(strict_types=1);

namespace App\Resolver;

use App\Entity\ProductVariantEntity;
use App\Exception\ResolveException;
use App\Repository\ProductVariantRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class ProductVariantEntityResolver implements ValueResolverInterface
{
    public function __construct(
        private readonly ProductVariantRepository $variantRepository,
    ) {
    }

    /**
     * @throws ResolveException
     *
     * @return iterable<ProductVariantEntity>
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if (!$argument->getType() || !\is_a($argument->getType(), ProductVariantEntity::class, true)) {
            return [];
        }

        $variantId = $request->attributes->get('productVariantId');
        if (!$variantId) {
            throw new ResolveException(ProductVariantEntity::class, 'No property named "productVariantId" found in request');
        }

        $variant = $this->variantRepository->find($variantId);

        if (!$variant) {
            throw new ResolveException(ProductVariantEntity::class, 'Product variant does not exists');
        }

        yield $variant;
    }
}
