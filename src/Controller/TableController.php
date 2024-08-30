<?php

namespace App\Controller;

use App\Repository\TableRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TableController extends AbstractController
{
    public function __construct(
        private readonly TableRepository $tableRepository,
    ) {
    }

    #[Route(path: '/tables', name: 'tables', methods: ['GET'])]
    public function tables(): Response
    {
        $tables = $this->tableRepository->findAll();

        return $this->render('tables/index.html.twig', [
            'tables' => $tables,
        ]);
    }
}