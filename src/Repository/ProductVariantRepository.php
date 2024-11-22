<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\ProductVariantEntity;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends AbstractRepository<ProductVariantEntity>
 */
class ProductVariantRepository extends AbstractRepository
{
    public function __construct(
        ManagerRegistry $registry,
    ) {
        parent::__construct($registry, ProductVariantEntity::class);
    }
}
