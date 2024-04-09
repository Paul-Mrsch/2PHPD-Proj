<?php

namespace App\Controller;

use App\Entity\User;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiPlayerController extends AbstractController
{
    #[Route('/api/players', name: 'api_players_index', methods: ['GET'])]
    public function index(EntityManagerInterface $em, SerializerInterface $serializer): JsonResponse
    {
        $players = $em->getRepository(User::class)->findAll();

        $players = $serializer->serialize($players, 'json', ['groups' => 'user:read']);

        return $this->json($players);
    }

    #[Route('/register', name: 'api_players_create', methods: ['POST'])]
    public function create(EntityManagerInterface $em, SerializerInterface $serializerinterface, Request $request, ValidatorInterface $validator): JsonResponse
    {
        // With hashing the password

        $player = $serializerinterface->deserialize($request->getContent(), User::class, 'json');

        $player->setPassword(
            password_hash(
                $player->getPassword(),
                PASSWORD_DEFAULT
            )
        );

        $errors = $validator->validate($player);

        if (count($errors) > 0) {
            $errorString = (string) $errors;
            return new JsonResponse(['error' => $errorString], Response::HTTP_BAD_REQUEST);
        }

        $em->persist($player);
        $em->flush();

        return new JsonResponse(['message' => 'Player created!'], Response::HTTP_CREATED);
    }

    #[Route('/api/players/{id}', name: 'api_players_show', methods: ['GET'])]
    public function show($id, EntityManagerInterface $em, SerializerInterface $serializer): JsonResponse
    {
        $player = $em->getRepository(User::class)->find($id);

        if (!$player) {
            return new JsonResponse(['error' => 'Player not found'], Response::HTTP_NOT_FOUND);
        }

        $player = $serializer->serialize($player, 'json', ['groups' => 'user:read']);

        return $this->json($player);
    }

    #[Route('/api/players/{id}', name: 'api_players_edit', methods: ['PUT'])]
    public function modify(EntityManagerInterface $em, SerializerInterface $serializerinterface, Request $request, ValidatorInterface $validator, $id)
    {
        $player = $em->getRepository(User::class)->find($id);

        if (!$player) {
            return new JsonResponse(['error' => 'Player not found'], Response::HTTP_NOT_FOUND);
        }

        $serializerinterface->deserialize($request->getContent(), User::class, 'json', ['object_to_populate' => $player]);

        $errors = $validator->validate($player);

        if (count($errors) > 0) {
            $errorString = (string) $errors;
            return new JsonResponse(['error' => $errorString], Response::HTTP_BAD_REQUEST);
        }

        $em->persist($player);
        $em->flush();

        return new JsonResponse(['message' => 'Player updated!'], Response::HTTP_OK);
    }

    #[Route('/api/players/{id}', name: 'api_players_delete', methods: ['DELETE'])]
    public function delete(EntityManagerInterface $em, $id): JsonResponse
    {
        $player = $em->getRepository(User::class)->find($id);

        if (!$player) {
            return new JsonResponse(['error' => 'Player not found'], Response::HTTP_NOT_FOUND);
        }

        $em->remove($player);
        $em->flush();

        return new JsonResponse(['message' => 'Player deleted!'], Response::HTTP_OK);
    }
}
