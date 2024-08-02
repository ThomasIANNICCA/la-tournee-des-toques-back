<?php

namespace App\Controller\Api\V1;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Services\MyMailer;
use App\Services\PasswordRandomizer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController
{


    #[Route('/api/v1/user/{id<\d+>}', name: 'app_user_show', methods:'GET')]
    public function show(int $id, UserRepository $userRepository, User $user): JsonResponse
    {
        if ($user !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        if ($user->getRoles() === "ROLE_USER"){

        
        $user = $userRepository->findUserWithTrucks($id);
        if (is_null($user)) {
            $data = [
                "success" => false,
                "message" => "not found"
            ];
    
            return $this->json($data, Response::HTTP_NOT_FOUND);
        }}
        return $this->json($user, Response::HTTP_OK, [], ['groups' => ['main_user']]);
    }
 
  
    #[Route('/api/v1/user/{id<\d+>}', name: 'app_user_deleteUser', methods: 'DELETE')]
    public function deleteUser(User $user, EntityManagerInterface $em): JsonResponse
    {
        if ($user !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }
      

        if (is_null($user)) {
            $data = [
                "success" => false,
                "message" => "user not found"
            ];
        }

        $em->remove($user);
        $em->flush();

        $data = [
            "success" => true,
            "message" => "user deleted",
        ];

        
        return $this->json($data);
    }

    #[Route('/api/v1/user/{id<\d+>}', name: 'app_user_editUser', methods: 'PUT')]
    public function editUser(
        int $id, 
        EntityManagerInterface $em, 
        User $user, 
        Request $request, 
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        UserPasswordHasherInterface $passwordHasher
    ): JsonResponse
    {

        if ($user !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        // on récupère le json fourni dans la requete HTTP
        $json = $request->getContent();
       

        // on rempli notre objet avec les informations du json
        $serializer->deserialize($json, User::class, "json", [AbstractNormalizer::OBJECT_TO_POPULATE => $user]);

        // on valide les données recues
        $errors = $validator->validate($user);

        if (count($errors) > 0)
        {
            $data = [
                'success' => false,
                'errors' => (string) $errors,
            ];

            return $this->json($data, Response::HTTP_BAD_REQUEST);
        }
        $data = json_decode($json, true);
            if (!empty($data['password'])) {
            // Hash le nouveau mot de passe
            $hashedPassword = $passwordHasher->hashPassword($user, $data['password']);
            $user->setPassword($hashedPassword);
        }

        $em->flush();

        
        return $this->json($user, Response::HTTP_OK, [], ["groups" => ["main_user"]]);
    }

    #[Route('api/v1/lost-password', name: 'app_user_lostPassword', methods: 'POST')]
    public function lostPassword (Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher, PasswordRandomizer $passwordRandomizer, EntityManagerInterface $em, MyMailer $mailer): JsonResponse
    {
        $json = $request->getContent();
        $decodedJson = json_decode($json, true);
        $email = $decodedJson['email'];

        $user = $userRepository->findByEmail($email);
        if (is_null($user)) {
            $data = [
                "success" => false,
                "message" => "not found"
            ];
    
            return $this->json($data, Response::HTTP_NOT_FOUND);
        }

        $newPassword = $passwordRandomizer->createPassword();

        $hashedPassword = $passwordHasher->hashPassword($user, $newPassword);
        $user->setPassword($hashedPassword);

        $em->flush();

        $mailer->sendNewPassword($newPassword);

        $data = [
            "success" => true,
            "message" => "Email sent"
           ];
           return $this->json($data, Response::HTTP_OK, [], []);

    }
}
