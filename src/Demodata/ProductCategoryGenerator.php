<?php declare(strict_types=1);

namespace App\Demodata;

use App\Entity\ProductCategoryEntity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\AsTaggedItem;

#[AsTaggedItem(priority: 10)]
class ProductCategoryGenerator implements DemodataGeneratorInterface
{
    public function generate(EntityManagerInterface $em): void
    {
        foreach (['Hot Drinks', 'Cold Drinks', 'Alcoholics'] as $name) {
            $variant = (new ProductCategoryEntity())->setName($name);

            $em->persist($variant);
        }

        $em->flush();
    }
}
