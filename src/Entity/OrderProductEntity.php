<?php declare(strict_types=1);

namespace App\Entity;

use App\Entity\Contract\EntityDateTrait;
use App\Repository\OrderProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderProductRepository::class)]
#[ORM\Table(name: '`order_product`')]
#[ORM\HasLifecycleCallbacks]
class OrderProductEntity implements \JsonSerializable
{
    use EntityDateTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue()]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: OrderEntity::class, inversedBy: 'order_products')]
    private OrderEntity $order;

    #[ORM\Column(type: Types::STRING)]
    private string $name;

    #[ORM\Column(type: Types::STRING)]
    private string $variantName;

    #[ORM\Column(type: Types::FLOAT)]
    private float $price;

    #[ORM\Column(type: Types::FLOAT)]
    private float $vat;

    #[ORM\Column(type: Types::INTEGER)]
    private int $quantity = 0;

    #[ORM\Column(type: Types::INTEGER)]
    private int $pendingQuantity = 1;

    #[ORM\ManyToOne(targetEntity: ProductEntity::class)]
    #[ORM\JoinColumn(onDelete: 'cascade')]
    private ?ProductEntity $product = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getOrder(): OrderEntity
    {
        return $this->order;
    }

    public function setOrder(OrderEntity $order): self
    {
        $this->order = $order;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getVariantName(): string
    {
        return $this->variantName;
    }

    public function setVariantName(string $variantName): self
    {
        $this->variantName = $variantName;

        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getVat(): float
    {
        return $this->vat;
    }

    public function setVat(float $vat): self
    {
        $this->vat = $vat;

        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        if ($this->quantity < 0) {
            $this->quantity = 0;
        }

        return $this;
    }

    public function addQuantity(int $quantity = 1): self
    {
        $this->quantity += $quantity;

        if ($this->quantity < 0) {
            $this->quantity = 0;
        }

        return $this;
    }

    public function getPendingQuantity(): int
    {
        return $this->pendingQuantity;
    }

    public function setPendingQuantity(int $pendingQuantity): self
    {
        $this->pendingQuantity = $pendingQuantity;

        if ($this->pendingQuantity < 0) {
            $this->pendingQuantity = 0;
        }

        return $this;
    }

    public function addPendingQuantity(int $pendingQuantity = 1): self
    {
        $this->pendingQuantity += $pendingQuantity;

        if ($this->pendingQuantity < 0) {
            $this->pendingQuantity = 0;
        }

        return $this;
    }

    public function getProduct(): ?ProductEntity
    {
        return $this->product;
    }

    public function setProduct(?ProductEntity $product): self
    {
        $this->product = $product;

        $this->name = $product->getName();
        $this->variantName = $product->getVariant()->getName();
        $this->price = $product->getPrice();
        $this->vat = $product->getVat();

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'variantName' => $this->variantName,
            'price' => $this->price,
            'vat' => $this->vat,
            'quantity' => $this->quantity,
            'pendingQuantity' => $this->pendingQuantity,
            'product' => $this->product->getId(),
            'order' => $this->order->getId(),
            'createdAt' => $this->createdAt->format(\DateTime::RFC3339),
            'updatedAt' => $this->updatedAt?->format(\DateTime::RFC3339),
        ];
    }
}
