<?php declare(strict_types=1);

namespace App\Controller;

use App\Entity\TableEntity;
use App\Repository\OrderRepository;
use App\Repository\TableRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TableController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly TableRepository $tableRepository,
        private readonly OrderRepository $orderRepository,
    ) {
    }

    #[Route(path: '/tables', name: 'tables', methods: ['GET'])]
    public function tables(): Response
    {
        return $this->render('tables/index.html.twig');
    }
}
