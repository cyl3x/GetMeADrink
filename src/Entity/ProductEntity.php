<?php declare(strict_types=1);

namespace App\Entity;

use App\Entity\Contract\EntityDateTrait;
use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\Table(name: '`product`')]
#[ORM\HasLifecycleCallbacks]
class ProductEntity
{
    use EntityDateTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue()]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: ProductVariantEntity::class, inversedBy: 'products')]
    private ProductVariantEntity $variant;

    #[ORM\Column(type: Types::STRING)]
    private string $name;

    #[ORM\Column(type: Types::FLOAT)]
    private float $price;

    #[ORM\Column(type: Types::FLOAT)]
    private float $vat;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private mixed $image = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getVariant(): ProductVariantEntity
    {
        return $this->variant;
    }

    public function setVariant(ProductVariantEntity $variant): self
    {
        $this->variant = $variant;

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

    public function getImage(): mixed
    {
        return $this->image;
    }

    public function setImage(mixed $image): self
    {
        $this->image = mb_check_encoding($image, 'UTF-8')
            ? $image
            : mb_convert_encoding($image, 'UTF-8');

        return $this;
    }
}
