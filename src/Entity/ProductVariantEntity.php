<?php declare(strict_types=1);

namespace App\Entity;

use App\Entity\Contract\EntityDateTrait;
use App\Repository\ProductVariantRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: ProductVariantRepository::class)]
#[ORM\Table(name: '`product_variant`')]
#[ORM\HasLifecycleCallbacks]
class ProductVariantEntity implements \JsonSerializable
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
    #[ORM\OneToMany(targetEntity: ProductEntity::class, mappedBy: 'variant')]
    private Collection $products;

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'products' => [],
        ];
    }
}
