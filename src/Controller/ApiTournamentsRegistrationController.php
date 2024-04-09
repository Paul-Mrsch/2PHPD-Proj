<?php

namespace App\Controller;

use App\Entity\Tournament;
use App\Entity\Registration;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ApiTournamentsRegistrationController extends AbstractController
{
    #[Route('/api/tournaments/{id}/registrations', name: 'api_tournaments_registrations_index', methods: ['GET'])]
    public function index(EntityManagerInterface $em, $id, SerializerInterface $serializer): JsonResponse
    {
        //Recherche de tous les joueurs inscrits à un tournoi donné (id)
        $registrations = $em->getRepository(Registration::class)->findBy(['tournament' => $id]);

        $registrations = $serializer->serialize($registrations, 'json', ['groups' => 'tournament:read']);

        return $this->json($registrations);
    }

    #[Route('/api/tournaments/{id}/registrations', name: 'api_tournaments_registrations_create', methods: ['POST'])]
    public function create(EntityManagerInterface $em, SerializerInterface $serializerinterface, Request $request, ValidatorInterface $validator, $id): JsonResponse
    {
        //Création d'une inscription à un tournoi donné (id)
        $registration = $serializerinterface->deserialize($request->getContent(), Registration::class, 'json');

        $tournament = $em->getRepository(Tournament::class)->find($id);

        if (!$tournament) {
            return new JsonResponse(['error' => 'Tournament not found'], Response::HTTP_NOT_FOUND);
        }

        $registration->setTournament($tournament);

        $errors = $validator->validate($registration);

        if (count($errors) > 0) {
            $errorString = (string) $errors;
            return new JsonResponse(['error' => $errorString], Response::HTTP_BAD_REQUEST);
        }

        $em->persist($registration);
        $em->flush();

        return new JsonResponse(['message' => 'Registration created!'], Response::HTTP_CREATED);
    }
}
