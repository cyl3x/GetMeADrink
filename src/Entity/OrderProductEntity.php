<?php declare(strict_types=1);

namespace App\Entity;

use App\Entity\Contract\EntityDateTrait;
use App\Repository\OrderProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderProductRepository::class)]
#[ORM\Table(name: '`order_product`')]
#[ORM\HasLifecycleCallbacks]
class OrderProductEntity
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
    private int $count;

    #[ORM\ManyToOne(targetEntity: ProductEntity::class)]
    #[ORM\JoinColumn(onDelete: 'cascade')]
    private ?ProductEntity $product = null;

    #[ORM\ManyToOne(targetEntity: OrderProductStatusEntity::class)]
    #[ORM\JoinColumn(onDelete: 'restrict')]
    private OrderProductStatusEntity $status;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getVariantName(): string
    {
        return $this->variantName;
    }

    public function setVariantName(string $variantName): void
    {
        $this->variantName = $variantName;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function getVat(): float
    {
        return $this->vat;
    }

    public function setVat(float $vat): void
    {
        $this->vat = $vat;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function setCount(int $count): void
    {
        $this->count = $count;
    }

    public function getProduct(): ?ProductEntity
    {
        return $this->product;
    }

    public function setProduct(?ProductEntity $product): void
    {
        $this->product = $product;
    }

    public function getStatus(): OrderProductStatusEntity
    {
        return $this->status;
    }

    public function setStatus(OrderProductStatusEntity $status): void
    {
        $this->status = $status;
    }
}
