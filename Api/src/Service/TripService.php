<?php

namespace App\Service;

use App\Form\TripType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Domain\TripManage\TripService as TripManageTripService;

class TripService
{

    public function __construct(
        protected FormFactoryInterface  $formFactory,
        protected TripManageTripService $tripService
    )
    {
    }

    public function add(Request $request): array
    {
        $form = $this->formFactory->createNamed('', TripType::class);
        $form->handleRequest($request);
        $errors = [];
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $errors = $this->tripService->add($form->getData());
                if (count($errors) == 0) {

                    return [];
                }
            } else {
                $errors = $this->retrieveErrorsFromForm($form);
            }
        } else {
            $errors[] = 'Trip data are not detected';
        }

        return $errors;
    }

    private function retrieveErrorsFromForm(FormInterface $form): array
    {
        $errors = [];
        foreach ($form->getErrors(true) as $error) {
            $errors[] = $error->getMessage();
        }

        return $errors;
    }
}
