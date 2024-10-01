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
}
