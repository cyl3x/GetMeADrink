<?php declare(strict_types=1);

namespace App\Demodata;

use App\Entity\ProductCategoryEntity;
use App\Entity\ProductEntity;
use App\Entity\ProductVariantEntity;
use App\Repository\ProductVariantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Generator;

class RealisticGenerator implements DemodataGeneratorInterface
{
    public function __construct(
        private readonly Generator $faker,
        private readonly ProductVariantRepository $productVariantRepository,
    ) {
    }

    public function generate(EntityManagerInterface $em): void
    {
        $variants = \array_map(
            function (string $name) use ($em) {
                $product = (new ProductVariantEntity())->setName($name);
                $em->persist($product);
                return $product;
            },
            ['0.03L','0.1L','0.15L','0.2L','0.25L','0.3L','0.33L','0.5L'],
        );

        $categories = \array_map(
            function (string $name) use ($em) {
                $categorie = (new ProductCategoryEntity())->setName($name);
                $em->persist($categorie);
                return $categorie;
            },
            ['Heißgetränke','Kaltgetränke','Alkoholische Getränke','Softgetränke'],
        );

        $products = \array_map(
            function (array $array) use ($em) {
                $product = (new ProductEntity())
                ->setName($array[0])
                ->addCategory($array[2])
                ->setVariant($array[1])
                ->setPrice($array[3])
                ->setVat(0.07);

                $array[2]->addProduct($product);

                $em->persist($product);
                return $product;
            },
            [
                ['Coca Cola', $variants[6], $categories[3], 1.49],
                ['Sprite', $variants[6], $categories[3], 1.49],
                ['Sprite', $variants[7], $categories[3], 1.99],
                ['Sprite Zero', $variants[6], $categories[3], 1.49],
                ['Sprite Zero', $variants[7], $categories[3], 1.99],
                ['Fanta', $variants[6], $categories[3], 1.49],
                ['Fanta', $variants[7], $categories[3], 1.99],
                ['Mezzo Mix', $variants[6], $categories[3], 1.49],
                ['Mezzo Mix', $variants[7], $categories[3], 1.99],
                ['Paulaner Spezi', $variants[6], $categories[3], 1.49],
                ['Paulaner Spezi', $variants[7], $categories[3], 1.99],
                ['Dr.Pepper', $variants[6], $categories[3], 1.49],
                ['Dr.Pepper', $variants[7], $categories[3], 1.99],
                ['Schwarzer Kaffee', $variants[4], $categories[0], 2.50],
                ['Espresso', $variants[0], $categories[0], 2.50],
                ['Americano', $variants[4], $categories[0], 3.00],
                ['Cappuccino', $variants[3], $categories[0], 3.00],
                ['Latte Macciato', $variants[5], $categories[0], 3.50],
                ['Heiße Schokolade', $variants[4], $categories[0], 3.00],
                ['Grüner Tee', $variants[4], $categories[0], 2.50],
                ['Gerolsteiner Sprudel', $variants[7], $categories[1], 0.99],
                ['Gerolsteiner Medium', $variants[7], $categories[1], 0.99],
                ['Gerolsteiner Naturell', $variants[7], $categories[1], 0.99],
                ['Pfanner Pfirsich Eistee', $variants[6], $categories[1], 1.49],
                ['Orangensaft', $variants[6], $categories[1], 1.49],
                ['Apfelsaft', $variants[6], $categories[1], 1.49],
                ['Gin Tonic', $variants[4], $categories[2], 6.50],
                ['Whisky Cola', $variants[4], $categories[2], 7.00],
                ['Mojito', $variants[5], $categories[2], 7.50],
                ['Caipirinha', $variants[5], $categories[2], 7.50],
                ['Aperol Spritz', $variants[5], $categories[2], 6.80],
                ['Margarita', $variants[4], $categories[2], 8.00],
                ['Old Fashioned', $variants[3], $categories[2], 9.00],
                ['Martini', $variants[2], $categories[2], 7.50],
                ['Piña Colada', $variants[5], $categories[2], 8.50],
                ['Tequila Sunrise', $variants[4], $categories[2], 7.00],
                ['Bloody Mary', $variants[4], $categories[2], 7.50],
                ['Cosmopolitan', $variants[2], $categories[2], 8.00],
                ['Mai Tai', $variants[4], $categories[2], 8.50],
                ['Long Island Iced Tea', $variants[5], $categories[2], 9.00],
                ['Gin Fizz', $variants[4], $categories[2], 7.00],
                ['Negroni', $variants[3], $categories[2], 8.50],
                ['Whiskey Sour', $variants[3], $categories[2], 7.50],
                ['Rum Cola', $variants[4], $categories[2], 6.50],
                ['Campari Soda', $variants[3], $categories[2], 6.00],
                ['Bellini', $variants[2], $categories[2], 7.00]
            ],
        );

        $em->flush();
    }
}
