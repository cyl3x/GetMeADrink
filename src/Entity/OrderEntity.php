<?php declare(strict_types=1);

namespace App\Entity;

use App\Entity\Contract\EntityDateTrait;
use App\Repository\OrderRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
#[ORM\HasLifecycleCallbacks]
class OrderEntity
{
    use EntityDateTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue()]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: TableEntity::class, inversedBy: 'orders')]
    #[ORM\JoinColumn(onDelete: 'restrict')]
    private TableEntity $table;

    #[ORM\ManyToOne(targetEntity: OrderStatusEntity::class, inversedBy: 'orders')]
    #[ORM\JoinColumn(onDelete: 'restrict')]
    private OrderStatusEntity $status;

    #[ORM\Column(type: Types::FLOAT)]
    private float $totalPrice;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getTable(): TableEntity
    {
        return $this->table;
    }

    public function setTable(TableEntity $table): void
    {
        $this->table = $table;
    }

    public function getStatus(): OrderStatusEntity
    {
        return $this->status;
    }

    public function setStatus(OrderStatusEntity $status): void
    {
        $this->status = $status;
    }

    public function getTotalPrice(): float
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(float $totalPrice): void
    {
        $this->totalPrice = $totalPrice;
    }
}