<?php declare(strict_types=1);

namespace App\Controller;

use App\Entity\OrderEntity;
use App\Entity\OrderStatusEntity;
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
        $tables = $this->tableRepository->findAll();

        return $this->render('tables/index.html.twig', [
            'tables' => $tables,
        ]);
    }

    #[Route(path: '/table/{tableId}', name: 'table.select', methods: ['POST'])]
    public function selectTable(TableEntity $table): Response
    {
        $order = $this->orderRepository->byTableId($table->getId());

        if (!$order) {
            $status = $this->em->getReference(OrderStatusEntity::class, OrderStatusEntity::PENDING);

            $order = (new OrderEntity())
                ->setTable($table)
                ->setStatus($status)
                ->setTotalPrice(0);

            $this->em->persist($order);
            $this->em->flush();
        }

        return $this->redirectToRoute('order', ['orderId' => $order->getId()]);
    }
}
