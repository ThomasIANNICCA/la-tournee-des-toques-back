<?php

namespace App\Controller\Api\V1;

use App\Services\MyMailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\DTO\Contact;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends AbstractController
{
    #[Route('/api/v1/contact', name: 'app_api_v1_contact', methods: 'POST')]
    public function index(MyMailer $mailer, Request $request, SerializerInterface $serializer, ValidatorInterface $validator): JsonResponse
    {
       
       // Désérialiser les données JSON en un objet ContactDTO
       $contact = $serializer->deserialize($request->getContent(), Contact::class, 'json');

       // Valider les données du formulaire
       $errors = $validator->validate($contact);

       if (count($errors) > 0)
       {
           $data = [
               'success' => false,
               'errors' => (string) $errors,
           ];

           return $this->json($data, Response::HTTP_BAD_REQUEST);
       }
       $firstname = $contact->getFirstname();
       $name = $contact->getName();
       $email = $contact->getEmail();
       $subject = $contact->getReason();
       $message = $contact->getMessage();

       $mailer->sendContactMail($firstname, $name, $email, $subject, $message);

       $data = [
        "success" => true,
        "message" => "Email sent"
       ];
       return $this->json($data, Response::HTTP_OK, [], []);
    }
}
