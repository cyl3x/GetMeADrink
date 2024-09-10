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

    #[ORM\Column(type: Types::BLOB)]
    private mixed $image;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getVariant(): ProductVariantEntity
    {
        return $this->variant;
    }

    public function setVariant(ProductVariantEntity $variant): void
    {
        $this->variant = $variant;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
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

    public function getImage(): mixed
    {
        return $this->image;
    }

    public function setImage(mixed $image): void
    {
        $this->image = mb_check_encoding($image, 'UTF-8')
            ? $image
            : mb_convert_encoding($image, 'UTF-8');
    }
}
