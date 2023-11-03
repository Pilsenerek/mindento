<?php

namespace App\Controller;

use App\Domain\Worker\WorkerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WorkerController extends AbstractController
{
    #[Route('/worker', name: 'app_worker_add', methods: ['POST'])]
    public function addWorker(WorkerService $workerService): JsonResponse
    {
        return $this->json($workerService->addWorker(), Response::HTTP_CREATED);
    }
}
