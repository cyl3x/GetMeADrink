<?php declare(strict_types=1);

namespace App\Resolver;

use App\Entity\OrderProductEntity;
use App\Exception\ResolveException;
use App\Repository\OrderProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class OrderProductEntityResolver implements ValueResolverInterface
{
    public function __construct(
        private readonly OrderProductRepository $orderProductRepository,
    ) {
    }

    /**
     * @throws ResolveException
     *
     * @return iterable<OrderProductEntity>
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if (!$argument->getType() || !\is_a($argument->getType(), OrderProductEntity::class, true)) {
            return [];
        }

        $orderId = $request->attributes->get('orderId');
        if (!$orderId) {
            throw new ResolveException(OrderProductEntity::class, 'No property named "orderId" found in request');
        }

        $orderProductId = $request->attributes->get('orderProductId');
        if (!$orderProductId) {
            throw new ResolveException(OrderProductEntity::class, 'No property named "orderProductId" found in request');
        }

        $orderProduct = \current($this->orderProductRepository->findBy([
            'id' => $orderProductId,
            'order' => $orderId,
        ]));

        if (!$orderProduct) {
            throw new ResolveException(OrderProductEntity::class, 'OrderProduct does not exists');
        }

        yield $orderProduct;
    }
}
