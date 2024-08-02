<?php

namespace App\Controller\Api\V1\Back;

use App\Entity\Tag;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TagController extends AbstractController
{
    #[Route('/api/v1/back/tags', name: 'app_back_tags_browse', methods: 'GET')]
    public function browse(TagRepository $tagRepository): JsonResponse
    {
        $tagList = $tagRepository->findAll();
        return $this->json($tagList, Response::HTTP_OK, [], ['groups' => ['main_truck']]);
    }
    #[Route('/api/v1/back/tags/{id<\d+>}', name: 'app_back_tags_read', methods: 'GET')]
    public function read(int $id, TagRepository $tagRepository): JsonResponse
    {
        $tag = $tagRepository->find($id);
        if (is_null($tag)) {
           return $this->notFound();
        }
        return $this->json($tag, Response::HTTP_OK, [], ['groups' => ['main_truck']]);
    }

    #[Route('/api/v1/back/tags/{id<\d+>}', name: 'app_back_tags_edit', methods: 'PUT')]
    public function edit(
        int $id, 
        EntityManagerInterface $em, 
        TagRepository $tagRepository, 
        Request $request, 
        SerializerInterface $serializer,
        ValidatorInterface $validator
    ): JsonResponse
    {
        // on récupère le tag qui correspond à l'id dans l'url
        $tag = $tagRepository->find($id);
        if (is_null($tag)) {
           return $this->notFound();
        }

        // on récupère le json fourni dans la requete HTTP
        $json = $request->getContent();

        // on rempli notre objet avec les informations du json
        $serializer->deserialize($json, Tag::class, "json", [AbstractNormalizer::OBJECT_TO_POPULATE => $tag]);

        // on valide les données recues
        $errors = $validator->validate($tag);

        if (count($errors) > 0)
        {
            $data = [
                'success' => false,
                'errors' => (string) $errors,
            ];

            return $this->json($data, Response::HTTP_BAD_REQUEST);
        }

        $em->flush();

        
        return $this->json($tag, Response::HTTP_OK, [], ['groups' => ['main_truck']]);
    }

    #[Route('/api/v1/back/tags', name: 'app_back_tags_add', methods: 'POST')]
    public function add(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, ValidatorInterface $validator): JsonResponse
    {
        $json = $request->getContent();

        
        $tag = $serializer->deserialize($json, Tag::class, "json");
        // on valide les données recues
        $errors = $validator->validate($tag);

        if (count($errors) > 0)
        {
            $data = [
                'success' => false,
                'errors' => (string) $errors,
            ];

            return $this->json($data, Response::HTTP_BAD_REQUEST);
        }
        $em->persist($tag);
        $em->flush();

        return $this->json($tag, Response::HTTP_CREATED, [], ['groups' => ['main_truck']]);
    }

    #[Route('/api/v1/back/tags/{id<\d+>}', name: 'app_back_tags_delete', methods: 'DELETE')]
    public function delete(int $id, TagRepository $tagRepository, EntityManagerInterface $em): JsonResponse
    {
        $tag = $tagRepository->find($id);
        if (is_null($tag)) {
           return $this->notFound();
        }

        $em->remove($tag);
        $em->flush();

        $data = [
            "success" => true,
            "message" => "tag deleted",
        ];

        
        return $this->json($data);
    }


}
