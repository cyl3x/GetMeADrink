<?php declare(strict_types=1);

namespace App\Demodata;

use App\Entity\ProductVariantEntity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\AsTaggedItem;

#[AsTaggedItem(priority: 10)]
class ProductVariantGenerator implements DemodataGeneratorInterface
{
    public function generate(EntityManagerInterface $em): void
    {
        foreach (['100ml', '250ml', '500ml', '1l'] as $name) {
            $variant = (new ProductVariantEntity())->setName($name);

            $em->persist($variant);
        }

        $em->flush();
    }
}
