<?php declare(strict_types=1);

namespace App\Entity;

use App\Entity\Contract\EntityDateTrait;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\Table(name: '`product`')]
#[ORM\HasLifecycleCallbacks]
class ProductEntity implements \JsonSerializable
{
    use EntityDateTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue()]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[Groups(groups: ['admin-write'])]
    #[ORM\ManyToOne(targetEntity: ProductVariantEntity::class, inversedBy: 'products')]
    private ProductVariantEntity $variant;

    #[Groups(groups: ['admin-write'])]
    #[ORM\Column(type: Types::STRING)]
    private string $name;

    #[Groups(groups: ['admin-write'])]
    #[ORM\Column(type: Types::FLOAT)]
    private float $price;

    #[Groups(groups: ['admin-write'])]
    #[ORM\Column(type: Types::FLOAT)]
    private float $vat;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private mixed $image = null;

    /**
     * @var Collection<int, ProductCategoryEntity>
     */
    #[Groups(groups: ['admin-write'])]
    #[ORM\ManyToMany(targetEntity: ProductCategoryEntity::class, inversedBy: 'products', cascade: ['persist'])]
    private Collection $categories;

    public function __construct()
    {
        $this->categories ??= new ArrayCollection();
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

    public function hasImage(): bool
    {
        return \is_resource($this->image);
    }

    public function getImage(): mixed
    {
        return $this->image;
    }

    public function getImageBase64(): ?string
    {
        return $this->hasImage()
            ? \base64_encode(\stream_get_contents($this->getImage()))
            : null;
    }

    public function setImage(mixed $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, ProductCategoryEntity>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    /**
     * @param Collection<int, ProductCategoryEntity> $categories
     */
    public function setCategories(Collection $categories): self
    {
        $this->categories = $categories;

        return $this;
    }

    public function addCategory(ProductCategoryEntity $category): self
    {
        $this->categories->add($category);

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'variant' => $this->variant->jsonSerialize(),
            'name' => $this->name,
            'price' => $this->price,
            'vat' => $this->vat,
            'image' => $this->hasImage() ? '/api/product/' . $this->id . '/image' : null,
            'categories' => $this->categories
                ->map(static fn (ProductCategoryEntity $category) => $category->getName())
                ->toArray(),
            'createdAt' => $this->createdAt->format(\DateTime::RFC3339),
            'updatedAt' => $this->updatedAt?->format(\DateTime::RFC3339),
        ];
    }
}
