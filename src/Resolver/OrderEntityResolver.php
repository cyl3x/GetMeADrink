<?php declare(strict_types=1);

namespace App\Resolver;

use App\Entity\OrderEntity;
use App\Exception\ResolveException;
use App\Repository\OrderRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class OrderEntityResolver implements ValueResolverInterface
{
    public function __construct(
        private readonly OrderRepository $orderRepository,
    ) {
    }

    /**
     * @throws ResolveException
     *
     * @return iterable<OrderEntity>
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if (!$argument->getType() || !\is_a($argument->getType(), OrderEntity::class, true)) {
            return [];
        }

        $orderId = $request->attributes->get('orderId');
        if (!$orderId) {
            throw new ResolveException(OrderEntity::class, 'No property named "orderId" found in request');
        }

        $order = $this->orderRepository->find($orderId);

        if (!$order) {
            throw new ResolveException(OrderEntity::class, 'Order does not exists');
        }

        yield $order;
    }
}
