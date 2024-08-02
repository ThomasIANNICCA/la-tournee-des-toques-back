<?php

namespace App\Controller\Api\V1\Back;

use App\Repository\TruckRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/api/v1/back/home', name: 'app_api_v1_back_home')]
    public function home(TruckRepository $truckRepository): JsonResponse
    {
        $truckList = $truckRepository->findByPendingStatus();
        return $this->json($truckList, Response::HTTP_OK, [], ['groups' => ['back_truck']]);
    }
}
