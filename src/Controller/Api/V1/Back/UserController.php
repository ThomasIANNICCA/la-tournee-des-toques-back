<?php

namespace App\Controller\Api\V1\Back;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Services\MyMailer;
use App\Services\PasswordRandomizer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    #[Route('/api/v1/back/users', name: 'app_back_users_browse', methods: 'GET')]
    public function browse(UserRepository $userRepository): JsonResponse
    {
        $userList = $userRepository->findAll();
        return $this->json($userList, Response::HTTP_OK, [], ['groups' => ['main_user']]);
    }
    #[Route('/api/v1/back/users/{id<\d+>}', name: 'app_back_users_read', methods: 'GET')]
    public function read(int $id, UserRepository $userRepository): JsonResponse
    {
        $user = $userRepository->find($id);
        if (is_null($user)) {
            $data = [
                "success" => false,
                "message" => "not found"
            ];
    
            return $this->json($data, Response::HTTP_NOT_FOUND);
        }
        return $this->json($user, Response::HTTP_OK, [], ['groups' => ['main_user']]);
    }
    #[Route('/api/v1/back/users', name: 'app_back_user_add', methods: 'POST')]
    public function add(
        Request $request,
        SerializerInterface $serializer,
        EntityManagerInterface $em,
        ValidatorInterface $validator,
        UserPasswordHasherInterface $passwordHasher,
        PasswordRandomizer $passwordRandomizer, 
        MyMailer $mailer
    ): JsonResponse
    {
        $json = $request->getContent();

        
        $user = $serializer->deserialize($json, User::class, "json");
        $password = $passwordRandomizer->createPassword();
        $hashedPassword = $passwordHasher->hashPassword($user, $password);
        $user->setPassword($hashedPassword);

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

        
        $em->persist($user);
        $em->flush();

        // $toEmail = ($user->getEmail());
        // $mailer->sendCredentialsMail($toEmail);
        $firstname = $data['firstname'];
        $lastname = $data['lastname'];
        $email = $data['email'];

        $mailer->sendCredentialsMail($firstname, $lastname, $email, $password);

        return $this->json($user, Response::HTTP_CREATED, [], ['groups' => ['main_user']]);
    }
    #[Route('/api/v1/back/users/{id<\d+>}', name: 'app_back_user_delete', methods: 'DELETE')]
    public function delete(int $id, UserRepository $userRepository, EntityManagerInterface $em): JsonResponse
    {
        $user = $userRepository->find($id);
        if (is_null($user)) {
           return $this->notFound();
        }

        $em->remove($user);
        $em->flush();

        $data = [
            "success" => true,
            "message" => "user deleted",
        ];

        
        return $this->json($data);
    }

}
