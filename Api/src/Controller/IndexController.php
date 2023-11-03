<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(): RedirectResponse
    {
        return $this->redirectToRoute('app_health_check');
    }

    #[Route('/healthCheck', name: 'app_health_check')]
    public function healthCheck(): JsonResponse
    {
        $dt = new \DateTimeImmutable();

        return $this->json([
            'status' => 'OK',
            'now' => $dt->format(\DateTimeInterface::W3C),
        ]);
    }
}
