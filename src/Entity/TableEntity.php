<?php declare(strict_types=1);

namespace App\Entity;

use App\Entity\Contract\EntityDateTrait;
use App\Repository\TableRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TableRepository::class)]
#[ORM\Table(name: '`table`')]
#[ORM\HasLifecycleCallbacks]
class TableEntity
{
    use EntityDateTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue()]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    /**
     * @var Collection<int, OrderEntity>
     */
    #[ORM\OneToMany(targetEntity: OrderEntity::class, mappedBy: 'table', indexBy: 'id')]
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

    /**
     * @return Collection<int, OrderEntity>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }
}
