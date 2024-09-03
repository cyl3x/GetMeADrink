<?php

namespace App\Controller;

use App\Repository\TableRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class OrderController extends AbstractController
{
    public function __construct(
        //private readonly TableRepository $tableRepository,
    ) {
    }

    #[Route(path: '/order', name: 'order', methods: ['GET'])]
    public function order(Request $request): Response
    {
        dd($request);
        //$tables = $this->tableRepository->findAll();

        return $this->render('tables/index.html.twig', [
            //'order' => $orders,
        ]);
    }
}