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
            ->findFirst(static fn (int $id, OrderEntity $order) => $order->getStatus()->getId() === OrderStatusEntity::PENDING);
    }

    public function hasPendingProducts(): bool
    {
        return !$this->getPendingOrder()?->getOrderProducts()
            ->filter(static fn (OrderProductEntity $product) => $product->getPendingQuantity() > 0)
            ->isEmpty() ?? false;
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'pendingOrder' => $this->getPendingOrder(),
            'pendingProducts' => $this->hasPendingProducts(),
            'createdAt' => $this->createdAt->format(\DateTime::RFC3339),
            'updatedAt' => $this->updatedAt?->format(\DateTime::RFC3339),
        ];
    }
}
