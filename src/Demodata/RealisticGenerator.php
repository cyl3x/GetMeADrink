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
            ['0.03L', '0.1L', '0.15L', '0.2L', '0.25L', '0.3L', '0.33L', '0.5L'],
        );

        $categories = \array_map(
            function (string $name) use ($em) {
                $categorie = (new ProductCategoryEntity())->setName($name);
                $em->persist($categorie);

                return $categorie;
            },
            ['Heißgetränke', 'Kaltgetränke', 'Alkoholische Getränke', 'Softgetränke'],
        );

        $products = \array_map(
            function (array $array) use ($em) {
                $product = (new ProductEntity())
                ->setName($array[0])
                ->addCategory($array[2])
                ->setVariant($array[1])
                ->setPrice($array[3])
                ->setVat(0.07);

                if ($array[4] !== null) {
                    $imagePath = __DIR__ . '/Images/' . $array[4];
                    $image = file_get_contents($imagePath, true);
                    $product->setImage($image);
                }

                $array[2]->addProduct($product);

                $em->persist($product);

                return $product;
            },
            [
                ['Coca Cola', $variants[6], $categories[3], 1.49, 'Coca_Cola.png'],
                ['Coca Cola', $variants[7], $categories[3], 1.99, 'Coca_Cola.png'],
                ['Coca Cola Light', $variants[6], $categories[3], 1.49, 'coca cola light.png'],
                ['Coca Cola Light', $variants[7], $categories[3], 1.99, 'coca cola light.png'],
                ['Coca Cola Zero', $variants[6], $categories[3], 1.49, 'Coca_Cola_Zero.png'],
                ['Coca Cola Zero', $variants[7], $categories[3], 1.99, 'Coca_Cola_Zero.png'],
                ['Sprite', $variants[6], $categories[3], 1.49, 'Sprite.png'],
                ['Sprite', $variants[7], $categories[3], 1.99, 'Sprite.png'],
                ['Sprite Zero', $variants[6], $categories[3], 1.49, 'Sprite Zero.png'],
                ['Sprite Zero', $variants[7], $categories[3], 1.99, 'Sprite Zero.png'],
                ['Fanta', $variants[6], $categories[3], 1.49, 'fanta.png'],
                ['Fanta', $variants[7], $categories[3], 1.99, 'fanta.png'],
                ['Mezzo Mix', $variants[6], $categories[3], 1.49, 'mezzo-mix-seeklogo.png'],
                ['Mezzo Mix', $variants[7], $categories[3], 1.99, 'mezzo-mix-seeklogo.png'],
                ['Paulaner Spezi', $variants[6], $categories[3], 1.49, 'spezi.png'],
                ['Paulaner Spezi', $variants[7], $categories[3], 1.99, 'spezi.png'],
                ['Dr.Pepper', $variants[6], $categories[3], 1.49, 'drpepper.png'],
                ['Dr.Pepper', $variants[7], $categories[3], 1.99, 'drpepper.png'],
                ['Schwarzer Kaffee', $variants[4], $categories[0], 2.50, 'schwarzerkaffee.png'],
                ['Espresso', $variants[0], $categories[0], 2.50, 'espresso.png'],
                ['Americano', $variants[4], $categories[0], 3.00, 'americano.png'],
                ['Cappuccino', $variants[3], $categories[0], 3.00, 'cappuccino.png'],
                ['Latte Macciato', $variants[5], $categories[0], 3.50, 'lattemaciatto.png'],
                ['Heiße Schokolade', $variants[4], $categories[0], 3.00, 'schokolade.png'],
                ['Grüner Tee', $variants[4], $categories[0], 2.50, 'greentea.png'],
                ['Gerolsteiner Sprudel', $variants[7], $categories[1], 0.99, 'gerolsteiner.png'],
                ['Gerolsteiner Medium', $variants[7], $categories[1], 0.99, 'gerolsteiner.png'],
                ['Gerolsteiner Naturell', $variants[7], $categories[1], 0.99, 'gerolsteiner.png'],
                ['Pfanner Pfirsich Eistee', $variants[6], $categories[1], 1.49, 'pfanner.png'],
                ['Orangensaft', $variants[6], $categories[1], 1.49, 'orange.png'],
                ['Apfelsaft', $variants[6], $categories[1], 1.49, 'applejuice.png'],
                ['Gin Tonic', $variants[4], $categories[2], 6.50, 'gin-tonic_transparent.png'],
                ['Whisky Cola', $variants[4], $categories[2], 7.00, 'whisky-cola_transparent.png'],
                ['Mojito', $variants[5], $categories[2], 7.50, 'mojito_transparent.png'],
                ['Caipirinha', $variants[5], $categories[2], 7.50, 'caipirinha_transparent.png'],
                ['Aperol Spritz', $variants[5], $categories[2], 6.80, 'aperol.png'],
                ['Margarita', $variants[4], $categories[2], 8.00, 'Margarita_transparent.png'],
                ['Old Fashioned', $variants[3], $categories[2], 9.00, 'old-fashioned_transparent.png'],
                ['Martini', $variants[2], $categories[2], 7.50, 'Martini_transparent.png'],
                ['Piña Colada', $variants[5], $categories[2], 8.50, 'pina-colada_transparent.png'],
                ['Tequila Sunrise', $variants[4], $categories[2], 7.00, 'tequila-sunrise_transparent.png'],
                ['Bloody Mary', $variants[4], $categories[2], 7.50, 'bloody-mary_transparent.png'],
                ['Cosmopolitan', $variants[2], $categories[2], 8.00, 'cosmopolitan_transparent.png'],
                ['Mai Tai', $variants[4], $categories[2], 8.50, 'mai-tai_transparent.png'],
                ['Long Island Iced Tea', $variants[5], $categories[2], 9.00, 'long-island-iced-tea_transparent.png'],
                ['Gin Fizz', $variants[4], $categories[2], 7.00, 'Gin-Fizz_transparent.png'],
                ['Negroni', $variants[3], $categories[2], 8.50, 'Negroni_transparent.png'],
                ['Whiskey Sour', $variants[3], $categories[2], 7.50, 'Whiskey-Sour_transparent.png'],
                ['Rum Cola', $variants[4], $categories[2], 6.50, 'rum-cola_transparent.png'],
                ['Campari Soda', $variants[3], $categories[2], 6.00, 'Campari-Soda_transparent.png'],
                ['Bellini', $variants[2], $categories[2], 7.00, 'Bellini_transparent.png'],
            ],
        );

        $em->flush();
    }
}
