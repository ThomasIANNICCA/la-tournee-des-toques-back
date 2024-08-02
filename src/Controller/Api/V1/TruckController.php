<?php

namespace App\Controller\Api\V1;

use App\Entity\Truck;
use App\Repository\CategoryRepository;
use App\Repository\TagRepository;
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

class TruckController extends AbstractController
{
    #[Route('/api/v1/trucks', name: 'app_trucks_browse', methods: 'GET')]
    public function browse(TruckRepository $truckRepository, CategoryRepository $categoryRepository): JsonResponse
    {
        $truckList = $truckRepository->findByValidatedStatus();
        $categoryList = $categoryRepository->findAll();
        $data = [
            'categoryList' => $categoryList,
            'truckList' => $truckList
        ];
        return $this->json($data, Response::HTTP_OK, [], ['groups' => ['partial_truck']]);
    }

    #[Route('/api/v1/trucks/{id<\d+>}', name: 'app_trucks_read', methods: 'GET')]
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

    #[Route('/api/v1/tags-categories', name: 'app_tags_gategories_read', methods: 'GET')]
    public function tagCategoryRead(TagRepository $tagRepository, CategoryRepository $categoryRepository): JsonResponse
    {
        $tagList = $tagRepository->findAll();

        $categoryList = $categoryRepository->findAll();

        $data = [
            'tagList' => $tagList,
            'categoryList' => $categoryList
        ];
        
        return $this->json($data, Response::HTTP_OK, [], ['groups' => ['main_truck']]);
    }

    #[Route('/api/v1/user/{userId<\d+>}/truck/{truckId<\d+>}', name: 'app_user_showTruck', methods:'GET')]
    public function showTruck(int $truckId, int $userId, TruckRepository $truckRepository, UserRepository $userRepository): JsonResponse
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
        $data = [
            'truck' => $truck,
            'user' => $user
        ];
        if ($truck->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }
        return $this->json($data, Response::HTTP_OK, [], ['groups' => ['main_truck']]);
    }


    #[Route('/api/v1/user/{userId<\d+>}/add', name: 'app_user_addTruck', methods: 'POST')]
    public function addTruck(int $userId, UserRepository $userRepository, Request $request, SerializerInterface $serializer, EntityManagerInterface $em, ValidatorInterface $validator): JsonResponse
    {
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
    
        $json = $request->request->get('data');
       
        
        
        $truck = $serializer->deserialize($json, Truck::class, "json");
        // Get the uploaded files
        $file = $request->files->get('pictureFile');

        if ($file instanceof UploadedFile && $file->isValid()) {
             $truck->setPictureFile($file);
        }
       
        $chefFile = $request->files->get('chefPictureFile');

        if ($chefFile instanceof UploadedFile && $file->isValid()) {
             $truck->setChefPictureFile($chefFile);
        }

        $errors = $validator->validate($truck);

        if (count($errors) > 0)
        {
            $data = [
                'success' => false,
                'errors' => (string) $errors,
            ];

            return $this->json($data, Response::HTTP_BAD_REQUEST);
        }
        $em->persist($truck);
        $em->flush();   

        return $this->json($truck, Response::HTTP_OK, [], ["groups" => ["main_truck"]]);

    }

    #[Route('/api/v1/user/{userId<\d+>}/truck/{truckId<\d+>}/edit', name: 'app_user_editTruck', methods: 'POST')]
    public function edit(
        int $userId, 
        int $truckId, 
        EntityManagerInterface $em, 
        TruckRepository $truckRepository, 
        UserRepository $userRepository,
        Request $request, 
        SerializerInterface $serializer,
        ValidatorInterface $validator
    ): JsonResponse
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
        if ($user !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        // on récupère le json fourni dans la requete HTTP
        $json = $request->request->get('data');

        // on rempli notre objet avec les informations du json
        $serializer->deserialize($json, Truck::class, "json", [AbstractNormalizer::OBJECT_TO_POPULATE => $truck]);

        $file = $request->files->get('pictureFile');
        if ($file instanceof UploadedFile && $file->isValid()) {
             $truck->setPictureFile($file);
        }
        $chefFile = $request->files->get('chefPictureFile');
        if ($chefFile instanceof UploadedFile && $chefFile->isValid()) {
            $truck->setChefPictureFile($chefFile);
       }

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

        
        return $this->json($truck, Response::HTTP_OK, [], ["groups" => ["main_truck"]]);
    }
}
