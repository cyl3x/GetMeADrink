<?php declare(strict_types=1);

namespace App\Demodata;

use App\Entity\ProductEntity;
use App\Repository\ProductVariantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Generator;

class ProductGenerator implements DemodataGeneratorInterface
{
    public function __construct(
        private readonly Generator $faker,
        private readonly ProductVariantRepository $productVariantRepository,
    ) {
    }

    public function generate(EntityManagerInterface $em): void
    {
        $productVariants = $this->productVariantRepository->findAll();

        for ($i = 0; $i < 20; ++$i) {
            $product = (new ProductEntity())
                ->setName($this->faker->beverageName())
                ->setPrice($this->faker->randomFloat(2, 1, 100))
                ->setVariant($this->faker->randomElement($productVariants))
                ->setVat($this->faker->randomElement([0.07, 0.19]));

            $em->persist($product);
        }

        $em->flush();
    }
}
