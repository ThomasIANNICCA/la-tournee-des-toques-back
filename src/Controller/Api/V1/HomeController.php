<?php

namespace App\Controller\Api\V1;

use App\Repository\EventRepository;
use App\Repository\PartnerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/api/v1/home', name: 'app_home_browse', methods: 'GET')]
    public function browse(PartnerRepository $partnerRepository, EventRepository $eventRepository): JsonResponse
    {

        $partnerList = $partnerRepository->findAll();
        $eventPartialList = $eventRepository->findClosestEvents();
         $data = [
            'partnerList' => $partnerList,
            'eventList' => $eventPartialList
         ];


        return $this->json($data, Response::HTTP_OK, [],[]);
    }
}
