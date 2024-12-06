<?php declare(strict_types=1);

namespace App\Entity;

use App\Entity\Contract\EntityDateTrait;
use App\Repository\ProductVariantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: ProductVariantRepository::class)]
#[ORM\Table(name: '`product_category`')]
#[ORM\HasLifecycleCallbacks]
class ProductCategoryEntity implements \JsonSerializable
{
    use EntityDateTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue()]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[Groups(groups: ['admin-write'])]
    #[ORM\Column(type: Types::STRING)]
    private string $name;

    /**
     * @var Collection<int, ProductEntity>
     */
    #[ORM\ManyToMany(targetEntity: ProductEntity::class, inversedBy: 'categories', cascade: ['persist'])]
    private Collection $products;

    public function __construct()
    {
        $this->products ??= new ArrayCollection();
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

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, ProductEntity>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(ProductEntity $product): self
    {
        $this->products->add($product);

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
            'products' => $this->products
                ->map(static fn (ProductEntity $product) => $product->jsonSerialize())
                ->toArray(),
        ];
    }
}
