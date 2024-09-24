<?php declare(strict_types=1);

namespace App\Resolver;

use App\Entity\OrderProductEntity;
use App\Exception\ResolveException;
use App\Repository\OrderProductRepository;
use Symfony\Component\HttpFoundation\ParameterBag;
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

        $orderProductId = $this->getId($request->attributes);

        if (!$orderProductId) {
            throw new ResolveException(OrderProductEntity::class, 'No property named "orderProductId" found in request');
        }

        $orderProduct = $this->orderProductRepository->find($orderProductId);

        if (!$orderProduct) {
            throw new ResolveException(OrderProductEntity::class, 'OrderProduct does not exists');
        }

        yield $orderProduct;
    }

    public function getId(ParameterBag $attributes): mixed
    {
        if ($attributes->has('id')) {
            return $attributes->get('id');
        }

        if ($attributes->has('orderProductId')) {
            return $attributes->get('orderProductId');
        }

        if ($attributes->has('_live_request_data')) {
            $liveData = $attributes->get('_live_request_data');

            if (\array_key_exists('args', $liveData)) {
                return $liveData['args']['id'] ?? $liveData['args']['orderProductId'] ?? null;
            }
        }

        return null;
    }
}
