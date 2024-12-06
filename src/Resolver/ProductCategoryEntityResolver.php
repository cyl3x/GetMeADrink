<?php declare(strict_types=1);

namespace App\Resolver;

use App\Entity\ProductCategoryEntity;
use App\Exception\ResolveException;
use App\Repository\ProductCategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class ProductCategoryEntityResolver implements ValueResolverInterface
{
    public function __construct(
        private readonly ProductCategoryRepository $categoryRepository,
    ) {
    }

    /**
     * @throws ResolveException
     *
     * @return iterable<ProductCategoryEntity>
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if (!$argument->getType() || !\is_a($argument->getType(), ProductCategoryEntity::class, true)) {
            return [];
        }

        $categoryId = $request->attributes->get('productCategoryId');
        if (!$categoryId) {
            throw new ResolveException(ProductCategoryEntity::class, 'No property named "productCategoryId" found in request');
        }

        $category = $this->categoryRepository->find($categoryId);

        if (!$category) {
            throw new ResolveException(ProductCategoryEntity::class, 'Product category does not exists');
        }

        yield $category;
    }
}
