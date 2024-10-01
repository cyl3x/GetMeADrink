<?php declare(strict_types=1);

namespace App\Controller;

use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TableController extends AbstractController
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    #[Route(path: '/tables', name: 'tables', methods: ['GET'])]
    public function tables(): Response
    {
        return $this->render('tables/index.html.twig');
    }

    #[Route(path: '/test', name: 'test', methods: ['GET'])]
    public function test(): Response
    {
        $image = file_get_contents('/home/cyl3x/Bilder/random/ofelia-quadrat.jpg');

        $product = $this->productRepository->find(1);

        $product->setImage($image);

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        return new Response();
    }
}
