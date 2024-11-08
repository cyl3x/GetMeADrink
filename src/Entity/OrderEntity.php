<?php declare(strict_types=1);

namespace App\Entity;

use App\Entity\Contract\EntityDateTrait;
use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
#[ORM\HasLifecycleCallbacks]
class OrderEntity implements \JsonSerializable
{
    use EntityDateTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue()]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: TableEntity::class, inversedBy: 'orders')]
    #[ORM\JoinColumn(onDelete: 'restrict')]
    private TableEntity $table;

    #[ORM\Column(type: Types::STRING, enumType: OrderStatus::class)]
    private OrderStatus $status;

    #[ORM\Column(type: Types::FLOAT)]
    private float $totalPrice;

    /**
     * @var Collection<int, OrderProductEntity>
     */
    #[ORM\OneToMany(targetEntity: OrderProductEntity::class, mappedBy: 'order', indexBy: 'id', fetch: 'EAGER', cascade: ['persist', 'remove'])]
    private Collection $orderProducts;

    public function __construct()
    {
        $this->orderProducts = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getTable(): TableEntity
    {
        return $this->table;
    }

    public function setTable(TableEntity $table): self
    {
        $this->table = $table;

        return $this;
    }

    public function getStatus(): OrderStatus
    {
        return $this->status;
    }

    public function setStatus(OrderStatus $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getTotalPrice(): float
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(float $totalPrice): self
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    /**
     * @return Collection<int, OrderProductEntity>
     */
    public function getOrderProducts(): Collection
    {
        return $this->orderProducts;
    }

    /**
     * @param Collection<int, OrderProductEntity> $orderProducts
     */
    public function setOrderProducts(Collection $orderProducts): self
    {
        $this->orderProducts = $orderProducts;

        return $this;
    }

    public function addOrderProduct(OrderProductEntity $orderProduct): self
    {
        $this->orderProducts->add($orderProduct);

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'table' => $this->table->getId(),
            'status' => $this->status->value,
            'totalPrice' => $this->totalPrice,
            'orderProducts' => $this->orderProducts
                ->map(fn (OrderProductEntity $orderProduct) => $orderProduct->jsonSerialize())
                ->getValues(),
            'createdAt' => $this->createdAt->format(\DateTime::RFC3339),
            'updatedAt' => $this->updatedAt?->format(\DateTime::RFC3339),
        ];
    }
}
