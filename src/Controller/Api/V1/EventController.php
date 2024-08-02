<?php

namespace App\Controller\Api\V1;

use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\MakerBundle\EventRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EventController extends AbstractController
{
    #[Route('/api/v1/events', name: 'app_events_browse', methods: 'GET')]
    public function browse(EventRepository $eventRepository): JsonResponse
    {
        $eventList = $eventRepository->findAll();
        return $this->json($eventList, Response::HTTP_OK, [], []);
    }
    #[Route('/api/v1/events/{id<\d+>}', name: 'app_events_read', methods: 'GET')]
    public function read(int $id, EventRepository $eventRepository): JsonResponse
    {
        $event = $eventRepository->find($id);
        return $this->json($event, Response::HTTP_OK, [], []);
    }
}
