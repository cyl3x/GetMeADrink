<?php declare(strict_types=1);

namespace App\Resolver;

use App\Entity\TableEntity;
use App\Exception\ResolveException;
use App\Repository\TableRepository;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class TableEntityResolver implements ValueResolverInterface
{
    public function __construct(
        private readonly TableRepository $tableRepository,
    ) {
    }

    /**
     * @throws ResolveException
     *
     * @return iterable<TableEntity>
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if (!$argument->getType() || !\is_a($argument->getType(), TableEntity::class, true)) {
            return [];
        }

        $tableId = $this->getId($request->attributes);

        if (!$tableId) {
            throw new ResolveException(TableEntity::class, 'No property named "tableId" found in request');
        }

        $table = $this->tableRepository->find($tableId);

        if (!$table) {
            throw new ResolveException(TableEntity::class, 'Table does not exists');
        }

        yield $table;
    }

    public function getId(ParameterBag $attributes): mixed
    {
        if ($attributes->has('id')) {
            return $attributes->get('id');
        }

        if ($attributes->has('tableId')) {
            return $attributes->get('tableId');
        }

        if ($attributes->has('_live_request_data')) {
            $liveData = $attributes->get('_live_request_data');

            if (\array_key_exists('args', $liveData)) {
                return $liveData['args']['id'] ?? $liveData['args']['tableId'] ?? null;
            }
        }

        return null;
    }
}
