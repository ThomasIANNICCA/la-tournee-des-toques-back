<?php

namespace App\Controller\Api\V1;

use App\Entity\Dish;
use App\Repository\DishRepository;
use App\Repository\TruckRepository;
use App\Repository\UserRepository;
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

class DishController extends AbstractController
{

    #[Route('/api/v1/user/{userId<\d+>}/truck/{truckId<\d+>}', name: 'app_user_addDish', methods: 'POST')]
    public function addDish(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, ValidatorInterface $validator, int $truckId, int $userId, UserRepository $userRepository, TruckRepository $truckRepository): JsonResponse
    {
        $truck = $truckRepository->find($truckId);
        if (is_null($truck)) {
            $data = [
                "success" => false,
                "message" => "truck not found"
            ];
    
            return $this->json($data, Response::HTTP_NOT_FOUND);
        }
        $user = $userRepository->find($userId);
        if (is_null($user)) {
            $data = [
                "success" => false,
                "message" => "user not found"
            ];
    
            return $this->json($data, Response::HTTP_NOT_FOUND);
        }
        if ($truck->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }
        
        $json = $request->request->get('data');
        
        
        $dish = $serializer->deserialize($json, Dish::class, "json");

        $file = $request->files->get('pictureFile');

        if ($file) {
             $dish->setPictureFile($file);
        }

        $errors = $validator->validate($dish);

        if (count($errors) > 0)
        {
            $data = [
                'success' => false,
                'errors' => (string) $errors,
            ];

            return $this->json($data, Response::HTTP_BAD_REQUEST);
        }
        $em->persist($dish);
        $em->flush();

        return $this->json($dish, Response::HTTP_OK, [], ["groups" => ["main_dish"]]);

    }

    #[Route('/api/v1/user/{userId<\d+>}/dish/{dishId}', name: 'app_user_deleteDish', methods: 'DELETE')]
    public function deleteDish(int $userId, int $dishId, DishRepository $dishRepository, UserRepository $userRepository, EntityManagerInterface $em): JsonResponse
    {

        $dish = $dishRepository->find($dishId);
        if (is_null($dish)) {
            $data = [
                "success" => false,
                "message" => "dish not found"
            ];
    
            return $this->json($data, Response::HTTP_NOT_FOUND);
        }
        $user = $userRepository->find($userId);
        if (is_null($user)) {
            $data = [
                "success" => false,
                "message" => "user not found"
            ];
    
            return $this->json($data, Response::HTTP_NOT_FOUND);
        }

        if ($user !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }


        $em->remove($dish);
        $em->flush();

        $data = [
            "success" => true,
            "message" => "dish deleted",
        ];

        
        return $this->json($data);
    }

     #[Route('/api/v1/user/{userId<\d+>}/dish/{dishId}/edit', name: 'app_user_editDish', methods: 'POST')]
    public function edit(
        int $userId, 
        int $dishId, 
        EntityManagerInterface $em, 
        DishRepository $dishRepository, 
        UserRepository $userRepository,
        Request $request, 
        SerializerInterface $serializer,
        ValidatorInterface $validator
    ): JsonResponse
    {
        $dish = $dishRepository->find($dishId);
        if (is_null($dish)) {
            $data = [
                "success" => false,
                "message" => "dish not found"
            ];
    
            return $this->json($data, Response::HTTP_NOT_FOUND);
        }
        $user = $userRepository->find($userId);
        if (is_null($user)) {
            $data = [
                "success" => false,
                "message" => "user not found"
            ];
    
            return $this->json($data, Response::HTTP_NOT_FOUND);
        }
        if ($user !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        // on récupère le json fourni dans la requete HTTP
        $json = $request->request->get('data');

        // on rempli notre objet avec les informations du json
        $serializer->deserialize($json, Dish::class, "json", [AbstractNormalizer::OBJECT_TO_POPULATE => $dish]);

        $file = $request->files->get('pictureFile');
        if ($file instanceof UploadedFile && $file->isValid()) {
             $dish->setPictureFile($file);
        }


        // on valide les données recues
        $errors = $validator->validate($dish);

        if (count($errors) > 0)
        {
            $data = [
                'success' => false,
                'errors' => (string) $errors,
            ];

            return $this->json($data, Response::HTTP_BAD_REQUEST);
        }
        $em->flush();

        
        return $this->json($dish, Response::HTTP_OK, [], ["groups" => ["main_dish"]]);
    }
    
}
