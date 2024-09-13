<?php declare(strict_types=1);

namespace App\Entity;

use App\Repository\OrderStatusRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderStatusRepository::class)]
#[ORM\Table(name: '`order_status`')]
#[ORM\HasLifecycleCallbacks]
class OrderStatusEntity
{
    public const PENDING = 1;
    public const COMPLETED = 2;
    public const CANCELED = 3;

    #[ORM\Id]
    #[ORM\GeneratedValue()]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING)]
    private string $name;

    /**
     * @var Collection<int, OrderEntity>
     */
    #[ORM\OneToMany(targetEntity: OrderEntity::class, mappedBy: 'table')]
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
     * @return Collection<int, OrderEntity>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }
}
