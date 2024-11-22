<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\ProductEntity;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends AbstractRepository<ProductEntity>
 */
class ProductRepository extends AbstractRepository
{
    public function __construct(
        ManagerRegistry $registry,
    ) {
        parent::__construct($registry, ProductEntity::class);
    }
}
