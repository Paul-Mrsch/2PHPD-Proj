<?php

namespace App\Controller;

use App\Entity\Tournament;
use App\Entity\Game;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiTournamentsGamesController extends AbstractController
{
    #[Route('/api/tournaments/{idTournament}/games', name: 'api_tournaments_games_index', methods: ['GET'])]
    public function index(EntityManagerInterface $em, $idTournament, SerializerInterface $serializer): JsonResponse
    {
        //Recherche de tous les jeux d'un tournoi donné (idTournament)
        $tournament = $em->getRepository(Tournament::class)->find($idTournament);

        if (!$tournament) {
            return new JsonResponse(['error' => 'Tournament not found'], Response::HTTP_NOT_FOUND);
        }

        $games = $em->getRepository(Game::class)->findBy(['tournament' => $idTournament]);

        $games = $serializer->serialize($games, 'json', ['groups' => 'tournament:read']);

        return $this->json($games);
    }

    #[Route('/api/tournaments/{idTournament}/games', name: 'api_tournaments_games_create', methods: ['POST'])]
    public function create(EntityManagerInterface $em, SerializerInterface $serializerinterface, Request $request, ValidatorInterface $validator, $idTournament): JsonResponse
    {
        //Création d'un jeu pour un tournoi donné (idTournament)
        $game = $serializerinterface->deserialize($request->getContent(), Game::class, 'json');

        $tournament = $em->getRepository(Tournament::class)->find($idTournament);

        if (!$tournament) {
            return new JsonResponse(['error' => 'Tournament not found'], Response::HTTP_NOT_FOUND);
        }

        $game->setTournament($tournament);

        $errors = $validator->validate($game);

        if (count($errors) > 0) {
            $errorString = (string) $errors;
            return new JsonResponse(['error' => $errorString], Response::HTTP_BAD_REQUEST);
        }

        $em->persist($game);
        $em->flush();

        return new JsonResponse(['message' => 'Game created!'], Response::HTTP_CREATED);
    }

    #[Route('/api/tournaments/{idTournament}/games/{idGame}', name: 'api_tournaments_games_show', methods: ['GET'])]
    public function show($idTournament, $idGame, EntityManagerInterface $em): JsonResponse
    {
        $game = $em->getRepository(Game::class)->find($idGame);

        if (!$game) {
            return new JsonResponse(['error' => 'Game not found'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($game);
    }

    #[Route('/api/tournaments/{idTournament}/games/{idGame}', name: 'api_tournaments_games_edit', methods: ['PUT'])]
    public function modify(EntityManagerInterface $em, SerializerInterface $serializerinterface, Request $request, ValidatorInterface $validator, $idTournament, $idGame)
    {
        $game = $em->getRepository(Game::class)->find($idGame);

        if (!$game) {
            return new JsonResponse(['error' => 'Game not found'], Response::HTTP_NOT_FOUND);
        }

        $serializerinterface->deserialize($request->getContent(), Game::class, 'json', ['object_to_populate' => $game]);

        $errors = $validator->validate($game);

        if (count($errors) > 0) {
            $errorString = (string) $errors;
            return new JsonResponse(['error' => $errorString], Response::HTTP_BAD_REQUEST);
        }

        $em->flush();

        return new JsonResponse(['message' => 'Game modified!'], Response::HTTP_OK);
    }

    #[Route('/api/tournaments/{idTournament}/games/{idGame}', name: 'api_tournaments_games_delete', methods: ['DELETE'])]
    public function delete(EntityManagerInterface $em, $idTournament, $idGame): JsonResponse
    {
        $tournament = $em->getRepository(Tournament::class)->find($idTournament);

        if (!$tournament) {
            return new JsonResponse(['error' => 'Tournament not found'], Response::HTTP_NOT_FOUND);
        }

        // Trouver le jeu à supprimer qui appartient au tournoi donné
        $game = $em->getRepository(Game::class)->findOneBy(['tournament' => $idTournament, 'id' => $idGame]);

        if (!$game) {
            return new JsonResponse(['error' => 'Game not found'], Response::HTTP_NOT_FOUND);
        }

        $em->remove($game);
        $em->flush();

        return new JsonResponse(['message' => 'Game deleted!'], Response::HTTP_OK);
    }
}
