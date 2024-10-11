<?php declare(strict_types=1);

namespace App\Entity;

use App\Entity\Contract\EntityDateTrait;
use App\Repository\TableRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TableRepository::class)]
#[ORM\Table(name: '`table`')]
#[ORM\HasLifecycleCallbacks]
class TableEntity implements \JsonSerializable
{
    use EntityDateTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue()]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    /**
     * @var Collection<int, OrderEntity>
     */
    #[ORM\OneToMany(targetEntity: OrderEntity::class, mappedBy: 'table', indexBy: 'id')]
    private Collection $orders;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return Collection<int, OrderEntity>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function getPendingOrder(): ?OrderEntity
    {
        return $this->orders
            ->findFirst(static fn (int $id, OrderEntity $order) => $order->getStatus() === OrderStatus::Pending);
    }

    public function quantityProducts(): int
    {
        if (!$this->getPendingOrder()) {
            return 0;
        }

        return $this
            ->getPendingOrder()
            ->getOrderProducts()
            ->reduce(fn (int $carry, OrderProductEntity $orderProduct) => $carry + $orderProduct->getQuantity(), 0);
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'pendingOrder' => $this->getPendingOrder(),
            'quantityProducts' => $this->quantityProducts(),
            'createdAt' => $this->createdAt->format(\DateTime::RFC3339),
            'updatedAt' => $this->updatedAt?->format(\DateTime::RFC3339),
        ];
    }
}
