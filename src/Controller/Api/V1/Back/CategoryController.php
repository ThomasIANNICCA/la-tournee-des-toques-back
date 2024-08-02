<?php

namespace App\Controller\Api\V1\Back;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CategoryController extends AbstractController
{
    #[Route('/api/v1/back/categories', name: 'app_back_categories_browse', methods: 'GET')]
    public function browse(CategoryRepository $categoryRepository): JsonResponse
    {
        //select all category entites in DB
        $categoryList = $categoryRepository->findAll();

        //return the data related to these entities where properties have the "main_category" group
        return $this->json($categoryList, Response::HTTP_OK, [], ['groups' => ['main_category']]);
    }
    #[Route('/api/v1/back/categories/{id<\d+>}', name: 'app_back_categories_read', methods: 'GET')]
    public function read(int $id, CategoryRepository $categoryRepository): JsonResponse
    {
        // the category selected by the ID of the URL
        $category = $categoryRepository->find($id);
        if (is_null($category)) {
            $data = [
                "success" => false,
                "message" => "not found"
            ];
    
            return $this->json($data, Response::HTTP_NOT_FOUND);
        }
        //return the data related to this entity where properties have the "main_category" group
        return $this->json($category, Response::HTTP_OK, [], ['groups' => ['main_category']]);
    }
    #[Route('/api/v1/back/categories/{id<\d+>}', name: 'app_back_categories_edit', methods: 'PUT')]
    public function edit(
        int $id, 
        EntityManagerInterface $em, 
        CategoryRepository $categoryRepository, 
        Request $request, 
        SerializerInterface $serializer,
        ValidatorInterface $validator
    ): JsonResponse
    {
        // the category selected by the ID of the URL
        $category = $categoryRepository->find($id);
        if (is_null($category)) {
           return $this->notFound();
        }

        // the JSON from the HTTP request
        $json = $request->getContent();

        //hydration of the object with the JSON data
        $serializer->deserialize($json, Category::class, "json", [AbstractNormalizer::OBJECT_TO_POPULATE => $category]);

        // data validation
        $errors = $validator->validate($category);

        if (count($errors) > 0)
        {
            $data = [
                'success' => false,
                'errors' => (string) $errors,
            ];

            return $this->json($data, Response::HTTP_BAD_REQUEST);
        }
        //replace fields in DB with new data
        $em->flush();

        //return the data related to this entity where properties have the "main_truck" group
        return $this->json($category, Response::HTTP_OK, [], ['groups' => ["main_truck"]]);
    }

    #[Route('/api/v1/back/categories', name: 'app_back_categories_add', methods: 'POST')]
    public function add(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, ValidatorInterface $validator): JsonResponse
    {
        
        // the JSON from the HTTP request
        $json = $request->getContent();

        // hydration of an object from Catagory class
        $category = $serializer->deserialize($json, Category::class, "json");

        // data validation
        $errors = $validator->validate($category);

        if (count($errors) > 0)
        {
            $data = [
                'success' => false,
                'errors' => (string) $errors,
            ];

            return $this->json($data, Response::HTTP_BAD_REQUEST);
        }

        //persist the new object
        $em->persist($category);
        // add the new entity in DB
        $em->flush();

        //return the data related to this entity where properties have the "main_truck" group
        return $this->json($category, Response::HTTP_CREATED, [], ["groups" => ["main_truck"]]);
    }

    #[Route('/api/v1/back/categories/{id<\d+>}', name: 'app_back_categories_delete', methods: 'DELETE')]
    public function delete(int $id, categoryRepository $categoryRepository, EntityManagerInterface $em): JsonResponse
    {
        // the category selected by the ID of the URL
        $category = $categoryRepository->find($id);
        if (is_null($category)) {
           return $this->notFound();
        }
        //set the entity to be removed
        $em->remove($category);
        //removal of th entity in DB
        $em->flush();

        $data = [
            "success" => true,
            "message" => "category deleted",
        ];

        
        return $this->json($data);
    }
}
