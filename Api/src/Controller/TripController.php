<?php

namespace App\Controller;

use App\Domain\TripAmountDue\TripService as TripAmountDueService;
use App\Service\TripService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TripController extends AbstractController
{
    #[Route('/trip/worker/{workerId}', name: 'app_trip', methods: ['GET'])]
    public function trips(int $workerId, TripAmountDueService $tripService): JsonResponse
    {
        return $this->json($tripService->tripsByWorker($workerId));
    }

    #[Route('/trip', name: 'app_trip_add', methods: ['POST'])]
    public function addTrip(TripService $tripService, Request $request): JsonResponse
    {
        $errors = $tripService->add($request);
        if (count($errors) == 0) {

            return $this->json([], Response::HTTP_CREATED);
        } else {

            return $this->json($errors, Response::HTTP_BAD_REQUEST);
        }
    }
}
