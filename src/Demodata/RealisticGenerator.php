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

                if ($array[4] !== null){
                    $imagePath = __DIR__ . '/Images/' . $array[4];
                    $image = file_get_contents($imagePath, true);
                    $product->setImage($image);
                }

                $array[2]->addProduct($product);

                $em->persist($product);
                return $product;
            },
            [
                ['Coca Cola', $variants[6], $categories[3], 1.49,"Coca_Cola.png"],
                ['Coca Cola', $variants[7], $categories[3], 1.99, "Coca_Cola.png"],
                ['Coca Cola Light', $variants[6], $categories[3], 1.49,"Coca_Cola_Light.png"],
                ['Coca Cola Light', $variants[7], $categories[3], 1.99, "Coca_Cola_Light.png"],
                ['Coca Cola Zero', $variants[6], $categories[3], 1.49, "Coca_Cola_Zero.png"],
                ['Coca Cola Zero', $variants[7], $categories[3], 1.99, "Coca_Cola_Zero.png"],
                ['Sprite', $variants[6], $categories[3], 1.49, null],
                ['Sprite', $variants[7], $categories[3], 1.99, null],
                ['Sprite Zero', $variants[6], $categories[3], 1.49, null],
                ['Sprite Zero', $variants[7], $categories[3], 1.99, null],
                ['Fanta', $variants[6], $categories[3], 1.49, null],
                ['Fanta', $variants[7], $categories[3], 1.99, null],
                ['Mezzo Mix', $variants[6], $categories[3], 1.49, null],
                ['Mezzo Mix', $variants[7], $categories[3], 1.99, null],
                ['Paulaner Spezi', $variants[6], $categories[3], 1.49, null],
                ['Paulaner Spezi', $variants[7], $categories[3], 1.99, null],
                ['Dr.Pepper', $variants[6], $categories[3], 1.49, null],
                ['Dr.Pepper', $variants[7], $categories[3], 1.99, null],
                ['Schwarzer Kaffee', $variants[4], $categories[0], 2.50, null],
                ['Espresso', $variants[0], $categories[0], 2.50, null],
                ['Americano', $variants[4], $categories[0], 3.00, null],
                ['Cappuccino', $variants[3], $categories[0], 3.00, null],
                ['Latte Macciato', $variants[5], $categories[0], 3.50, null],
                ['Heiße Schokolade', $variants[4], $categories[0], 3.00, null],
                ['Grüner Tee', $variants[4], $categories[0], 2.50, null],
                ['Gerolsteiner Sprudel', $variants[7], $categories[1], 0.99, null],
                ['Gerolsteiner Medium', $variants[7], $categories[1], 0.99, null],
                ['Gerolsteiner Naturell', $variants[7], $categories[1], 0.99, null],
                ['Pfanner Pfirsich Eistee', $variants[6], $categories[1], 1.49, null],
                ['Orangensaft', $variants[6], $categories[1], 1.49, null],
                ['Apfelsaft', $variants[6], $categories[1], 1.49, null],
                ['Gin Tonic', $variants[4], $categories[2], 6.50, null],
                ['Whisky Cola', $variants[4], $categories[2], 7.00, null],
                ['Mojito', $variants[5], $categories[2], 7.50, null],
                ['Caipirinha', $variants[5], $categories[2], 7.50, null],
                ['Aperol Spritz', $variants[5], $categories[2], 6.80, null],
                ['Margarita', $variants[4], $categories[2], 8.00, null],
                ['Old Fashioned', $variants[3], $categories[2], 9.00, null],
                ['Martini', $variants[2], $categories[2], 7.50, null],
                ['Piña Colada', $variants[5], $categories[2], 8.50, null],
                ['Tequila Sunrise', $variants[4], $categories[2], 7.00, null],
                ['Bloody Mary', $variants[4], $categories[2], 7.50, null],
                ['Cosmopolitan', $variants[2], $categories[2], 8.00, null],
                ['Mai Tai', $variants[4], $categories[2], 8.50, null],
                ['Long Island Iced Tea', $variants[5], $categories[2], 9.00, null],
                ['Gin Fizz', $variants[4], $categories[2], 7.00, null],
                ['Negroni', $variants[3], $categories[2], 8.50, null],
                ['Whiskey Sour', $variants[3], $categories[2], 7.50, null],
                ['Rum Cola', $variants[4], $categories[2], 6.50, null],
                ['Campari Soda', $variants[3], $categories[2], 6.00, null],
                ['Bellini', $variants[2], $categories[2], 7.00, null]
            ],
        );

        $em->flush();
    }
}
