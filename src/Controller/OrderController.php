<?php declare(strict_types=1);

namespace App\Controller;

use App\Entity\OrderEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OrderController extends AbstractController
{
    #[Route(path: '/order/{orderId}', name: 'order', methods: ['GET'])]
    public function order(OrderEntity $order): Response
    {
        return $this->render('order/index.html.twig', [
            'order' => $order,
        ]);
    }
}
