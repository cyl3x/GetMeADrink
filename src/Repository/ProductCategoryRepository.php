<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\ProductCategoryEntity;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends AbstractRepository<ProductCategoryEntity>
 */
class ProductCategoryRepository extends AbstractRepository
{
    public function __construct(
        ManagerRegistry $registry,
    ) {
        parent::__construct($registry, ProductCategoryEntity::class);
    }
}
