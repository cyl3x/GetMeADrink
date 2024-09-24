<?php declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TableController extends AbstractController
{
    #[Route(path: '/tables', name: 'tables', methods: ['GET'])]
    public function tables(): Response
    {
        return $this->render('tables/index.html.twig');
    }
}
