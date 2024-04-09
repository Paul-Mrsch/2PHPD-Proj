<?php

namespace App\Controller;

use App\Entity\Tournament;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiTournamentsController extends AbstractController
{
    #[Route('/api/tournaments', name: 'api_tournaments_index', methods: ['GET'])]
    public function index(EntityManagerInterface $em): JsonResponse
    {
        $tournaments = $em->getRepository(Tournament::class)->findAll();

        return $this->json($tournaments);
    }

    #[Route('/api/tournaments', name: 'api_tournaments_create', methods: ['POST'])]
    public function create(EntityManagerInterface $em, SerializerInterface $serializerinterface, Request $request, ValidatorInterface $validator): JsonResponse
    {
        $tournament = $serializerinterface->deserialize($request->getContent(), Tournament::class, 'json');

        $errors = $validator->validate($tournament);

        if (count($errors) > 0) {
            $errorString = (string) $errors;
            return new JsonResponse(['error' => $errorString], Response::HTTP_BAD_REQUEST);
        }

        $em->persist($tournament);
        $em->flush();

        return new JsonResponse(['message' => 'Tournament created!'], Response::HTTP_CREATED);
    }

    #[Route('/api/tournaments/{id}', name: 'api_tournaments_show', methods: ['GET'])]
    public function show($id, EntityManagerInterface $em): JsonResponse
    {
        $tournament = $em->getRepository(Tournament::class)->find($id);

        if (!$tournament) {
            return new JsonResponse(['error' => 'Tournament not found'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($tournament);
    }

    #[Route('/api/tournaments/{id}', name: 'api_tournaments_edit', methods: ['PUT'])]
    public function modify(EntityManagerInterface $em, SerializerInterface $serializerinterface, Request $request, ValidatorInterface $validator, $id)
    {
        $tournament = $em->getRepository(Tournament::class)->find($id);

        if (!$tournament) {
            return new JsonResponse(['error' => 'Tournament not found'], Response::HTTP_NOT_FOUND);
        }

        $serializerinterface->deserialize($request->getContent(), Tournament::class, 'json', ['object_to_populate' => $tournament]);

        $errors = $validator->validate($tournament);

        if (count($errors) > 0) {
            $errorString = (string) $errors;
            return new JsonResponse(['error' => $errorString], Response::HTTP_BAD_REQUEST);
        }

        $em->flush();

        return new JsonResponse(['message' => 'Tournament updated!'], Response::HTTP_OK);
    }

    #[Route('/api/tournaments/{id}', name: 'api_tournaments_delete', methods: ['DELETE'])]
    public function delete(EntityManagerInterface $em, $id): JsonResponse
    {
        $tournament = $em->getRepository(Tournament::class)->find($id);

        if (!$tournament) {
            return new JsonResponse(['error' => 'Tournament not found'], Response::HTTP_NOT_FOUND);
        }

        $em->remove($tournament);
        $em->flush();

        return new JsonResponse(['message' => 'Tournament deleted!'], Response::HTTP_OK);
    }
}
