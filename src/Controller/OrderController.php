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
        //private readonly OrderRepository $orderRepository,
    ) {
    }

    #[Route(path: '/order/{id}', name: 'order', methods: ['GET'])]
    public function order(): Response
    {
        return $this->render('order/index.html.twig');
    }
}