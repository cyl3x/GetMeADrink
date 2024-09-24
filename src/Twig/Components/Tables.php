<?php declare(strict_types=1);

namespace App\Twig\Components;

use App\Entity\TableEntity;
use App\Repository\OrderRepository;
use App\Repository\TableRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
class Tables extends AbstractController
{
    use DefaultActionTrait;

    public function __construct(
        private readonly TableRepository $tableRepository,
        private readonly OrderRepository $orderRepository,
    ) {
    }

    public function getTables(): array
    {
        return $this->tableRepository->findAll();
    }

    #[LiveAction]
    public function selectTable(#[LiveArg] string $tableId): Response
    {
        $table = $this->tableRepository->find($tableId);
        $order = $this->orderRepository->fromTable($table);

        return $this->redirectToRoute('order', ['orderId' => $order->getId()]);
    }
}
