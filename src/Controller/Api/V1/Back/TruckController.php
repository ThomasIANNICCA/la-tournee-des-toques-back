<?php

namespace App\Controller\Api\V1\Back;

use App\Entity\Truck;
use App\Repository\TruckRepository;
use App\Services\MyMailer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TruckController extends AbstractController
{
    #[Route('/api/v1/back/trucks', name: 'app_back_trucks_browse', methods: 'GET')]
    public function browse(TruckRepository $truckRepository): JsonResponse
    {
        $truckList = $truckRepository->findAll();
        return $this->json($truckList, Response::HTTP_OK, [], ['groups' => ['main_truck']]);
    }

    #[Route('/api/v1/back/trucks/{id<\d+>}', name: 'app_back_trucks_read', methods: 'GET')]
    public function read(int $id, TruckRepository $truckRepository): JsonResponse
    {
        $truck = $truckRepository->find($id);
        if (is_null($truck)) {
            $data = [
                "success" => false,
                "message" => "not found"
            ];
    
            return $this->json($data, Response::HTTP_NOT_FOUND);
        }
        return $this->json($truck, Response::HTTP_OK, [], ['groups' => ['main_truck']]);
    }

    #[Route('/api/v1/back/trucks/{id<\d+>}', name: 'app_back_trucks_edit', methods: 'PUT')]
    public function edit(
        int $id, 
        EntityManagerInterface $em, 
        TruckRepository $truckRepository, 
        Request $request, 
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        MyMailer $mailer
    ): JsonResponse
    {
        // on récupère le truck qui correspond à l'id dans l'url
        $truck = $truckRepository->find($id);
        if (is_null($truck)) {
           return $this->notFound();
        }

        // on récupère le json fourni dans la requete HTTP
        $json = $request->getContent();

        // on rempli notre objet avec les informations du json
        $serializer->deserialize($json, Truck::class, "json", [AbstractNormalizer::OBJECT_TO_POPULATE => $truck]);

        // on valide les données recues
        $errors = $validator->validate($truck);

        if (count($errors) > 0)
        {
            $data = [
                'success' => false,
                'errors' => (string) $errors,
            ];

            return $this->json($data, Response::HTTP_BAD_REQUEST);
        }

        $em->flush();

        if ($truck->getStatus() === 'validated') {
            if ($truck->getStatus() === 'validated') {
               $mailer->sendValidationMail();
            }
        }
        if ($truck->getStatus() === 'refused') {
           $mailer->sendRefusalMail();
        }
        
        return $this->json($truck, Response::HTTP_OK, [], ['groups' => ['back_truck']]);
    }
}
