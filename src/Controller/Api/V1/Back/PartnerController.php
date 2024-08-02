<?php

namespace App\Controller\Api\V1\Back;

use App\Entity\Partner;
use App\Repository\PartnerRepository;
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

class PartnerController extends AbstractController
{
    #[Route('/api/v1/back/partners', name: 'app_back_partners_browse', methods: 'GET')]
    public function browse(PartnerRepository $partnerRepository): JsonResponse
    {
        $partnerList = $partnerRepository->findAll();
        return $this->json($partnerList, Response::HTTP_OK, [], []);
    }
    #[Route('/api/v1/back/partners/{id<\d+>}', name: 'app_back_partners_read', methods: 'GET')]
    public function read(int $id, PartnerRepository $partnerRepository): JsonResponse
    {
        $partner = $partnerRepository->find($id);
        if (is_null($partner)) {
            $data = [
                "success" => false,
                "message" => "not found"
            ];
    
            return $this->json($data, Response::HTTP_NOT_FOUND);
        }
        return $this->json($partner, Response::HTTP_OK, [], []);
    }
    #[Route('/api/v1/back/partners/{id<\d+>}/edit', name: 'app_back_partners_edit', methods: 'POST')]
    public function edit(
        int $id, 
        EntityManagerInterface $em, 
        PartnerRepository $partnerRepository, 
        Request $request, 
        SerializerInterface $serializer,
        ValidatorInterface $validator
    ): JsonResponse
    {
        // on récupère le partner qui correspond à l'id dans l'url
        $partner = $partnerRepository->find($id);
        if (is_null($partner)) {
           return $this->notFound();
        }

        // on récupère le json fourni dans la requete HTTP
        $json = $request->request->get('data');

        // on rempli notre objet avec les informations du json
        $serializer->deserialize($json, Partner::class, "json", [AbstractNormalizer::OBJECT_TO_POPULATE => $partner]);

        $file = $request->files->get('logoFile');
        if ($file instanceof UploadedFile && $file->isValid()) {
             $partner->setLogoFile($file);
        }
        // on valide les données recues
        $errors = $validator->validate($partner);

        if (count($errors) > 0)
        {
            $data = [
                'success' => false,
                'errors' => (string) $errors,
            ];

            return $this->json($data, Response::HTTP_BAD_REQUEST);
        }

        $em->flush();

        
        return $this->json($partner, Response::HTTP_OK, [], []);
    }

    #[Route('/api/v1/back/partners', name: 'app_back_partners_add', methods: 'POST')]
    public function add(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, ValidatorInterface $validator): JsonResponse
    {
        // Extract JSON data
        $json = $request->request->get('data');

        // Deserialize the JSON data
        $partner = $serializer->deserialize($json, Partner::class, "json");

        // Get the uploaded file
        $file = $request->files->get('logoFile');

        if ($file) {
            $partner->setLogoFile($file);
        }

        // Validate the entity
        $errors = $validator->validate($partner);

        if (count($errors) > 0) {
            $data = [
                'success' => false,
                'errors' => (string) $errors,
            ];

            return $this->json($data, Response::HTTP_BAD_REQUEST);
        }

        // Persist and flush the entity
        $em->persist($partner);
        $em->flush();

        return $this->json($partner, Response::HTTP_CREATED, [], []);
    }

    #[Route('/api/v1/back/partners/{id<\d+>}', name: 'app_back_partners_delete', methods: 'DELETE')]
    public function delete(int $id, partnerRepository $partnerRepository, EntityManagerInterface $em): JsonResponse
    {
        $partner = $partnerRepository->find($id);
        if (is_null($partner)) {
           return $this->notFound();
        }

        $em->remove($partner);
        $em->flush();

        $data = [
            "success" => true,
            "message" => "partner deleted",
        ];

        
        return $this->json($data);
    }
}
