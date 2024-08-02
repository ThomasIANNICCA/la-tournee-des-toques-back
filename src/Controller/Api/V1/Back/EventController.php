<?php

namespace App\Controller\Api\V1\Back;

use App\Entity\Event;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class EventController extends AbstractController
{
    #[Route('/api/v1/back/events', name: 'app_back_events_browse', methods: 'GET')]
    public function browse(EventRepository $eventRepository): JsonResponse
    {
        $eventList = $eventRepository->findAll();
        return $this->json($eventList, Response::HTTP_OK, [], []);
    }
    #[Route('/api/v1/back/events/{id<\d+>}', name: 'app_back_events_read', methods: 'GET')]
    public function read(int $id, EventRepository $eventRepository): JsonResponse
    {
        $event = $eventRepository->find($id);
        if (is_null($event)) {
            $data = [
                "success" => false,
                "message" => "not found"
            ];
    
            return $this->json($data, Response::HTTP_NOT_FOUND);
        }
        return $this->json($event, Response::HTTP_OK, [], []);
    }
    #[Route('/api/v1/back/events/{id<\d+>}/edit', name: 'app_back_events_edit', methods: 'POST')]
    public function edit(
        int $id, 
        EntityManagerInterface $em, 
        EventRepository $eventRepository, 
        Request $request, 
        SerializerInterface $serializer,
        ValidatorInterface $validator
    ): JsonResponse
    {
        // on récupère le event qui correspond à l'id dans l'url
        $event = $eventRepository->find($id);
        if (is_null($event)) {
           return $this->notFound();
        }

        // on récupère le json fourni dans la requete HTTP
        $json = $request->request->get('data');

        // on rempli notre objet avec les informations du json
        $serializer->deserialize($json, Event::class, "json", [AbstractNormalizer::OBJECT_TO_POPULATE => $event]);

        $file = $request->files->get('pictureFile');
        if ($file instanceof UploadedFile && $file->isValid()) {
             $event->setPictureFile($file);
        }
        // on valide les données recues
        $errors = $validator->validate($event);

        if (count($errors) > 0)
        {
            $data = [
                'success' => false,
                'errors' => (string) $errors,
            ];

            return $this->json($data, Response::HTTP_BAD_REQUEST);
        }

        $em->flush();

        
        return $this->json($event, Response::HTTP_OK, [], []);
    }

    #[Route('/api/v1/back/events', name: 'app_back_events_add', methods: 'POST')]
    public function add(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, ValidatorInterface $validator): JsonResponse
    {
        $json = $request->request->get('data');
dd($this->getParameter('kernel.project_dir'));
        
        $event = $serializer->deserialize($json, Event::class, "json");

         // Get the uploaded file
         $file = $request->files->get('pictureFile');

         if ($file) {
             $event->setPictureFile($file);
         }
        // on valide les données recues
        $errors = $validator->validate($event);

        if (count($errors) > 0)
        {
            $data = [
                'success' => false,
                'errors' => (string) $errors,
            ];

            return $this->json($data, Response::HTTP_BAD_REQUEST);
        }
        $em->persist($event);
        $em->flush();

        return $this->json($event, Response::HTTP_CREATED, [], []);
    }

    #[Route('/api/v1/back/events/{id<\d+>}', name: 'app_back_events_delete', methods: 'DELETE')]
    public function delete(int $id, EventRepository $eventRepository, EntityManagerInterface $em): JsonResponse
    {
        $event = $eventRepository->find($id);
        if (is_null($event)) {
           return $this->notFound();
        }

        $em->remove($event);
        $em->flush();

        $data = [
            "success" => true,
            "message" => "event deleted",
        ];

        
        return $this->json($data);
    }
}
