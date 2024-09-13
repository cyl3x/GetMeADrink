<?php declare(strict_types=1);

namespace App\Entity;

use App\Repository\OrderProductStatusRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderProductStatusRepository::class)]
#[ORM\Table(name: '`order_product_status`')]
#[ORM\HasLifecycleCallbacks]
class OrderProductStatusEntity
{
    public const PENDING = 1;
    public const DELIVERED = 2;

    #[ORM\Id]
    #[ORM\GeneratedValue()]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING)]
    private string $name;

    /**
     * @var Collection<int, OrderProductEntity>
     */
    #[ORM\OneToMany(targetEntity: OrderProductEntity::class, mappedBy: 'status')]
    private Collection $orderProducts;

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
     * @return Collection<int, OrderProductEntity>
     */
    public function getOrderProducts(): Collection
    {
        return $this->orderProducts;
    }
}
