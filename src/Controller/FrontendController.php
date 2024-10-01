<?php declare(strict_types=1);

namespace App\Controller;

use App\Service\HmrService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FrontendController extends AbstractController
{
    public function __construct(
        private readonly HmrService $hmrService,
    ) {}

    #[Route(path: '/', name: 'frontend')]
    public function frontend(): Response
    {
        return $this->render('index.html.twig', [
            'hmr' => $this->hmrService->isHmr(),
        ]);
    }
}
