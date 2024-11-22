<?php declare(strict_types=1);

namespace App\Controller;

use App\Repository\TableRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/api', name: 'api.', format: 'json')]
class TableController extends AbstractController
{
    public function __construct(
        private readonly TableRepository $tableRepository,
    ) {
    }

    #[Route(path: '/tables', name: 'tables', methods: ['GET'])]
    public function getTables(): JsonResponse
    {
        $tables = $this->tableRepository->findAll();

        return new JsonResponse($tables);
    }

    #[Route(path: '/table/{id}', name: 'table', methods: ['GET'])]
    public function getTable(int $id): JsonResponse
    {
        $table = $this->tableRepository->find($id);

        return new JsonResponse($table);
    }

    #[Route(path: '/table', name: 'table.create', methods: ['POST'])]
    public function createTable(): JsonResponse
    {
        $this->tableRepository->create();

        return new JsonResponse([], 200);
    }

    #[Route(path: '/table/{id}', name: 'table.delete', methods: ['DELETE'])]
    public function deleteTable(int $id): JsonResponse
    {
        $table = $this->tableRepository->find($id);

        if (!$table) {
            return new JsonResponse([
                'title' => 'Invalid request',
                'detail' => 'The table of id ' . $id . ' does not exist',
            ], 400);
        }

        $this->tableRepository->delete($table);

        return new JsonResponse([], 200);
    }
}
