<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\ProductVariantEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProductVariantEntity>
 */
class ProductVariantRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
    ) {
        parent::__construct($registry, ProductVariantEntity::class);
    }
}
