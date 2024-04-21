<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Tournament;
use App\Entity\Game;
use App\Entity\Registration;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        $user1 = new User();
        $user1->setFirstName('John');
        $user1->setLastName('Doe');
        $user1->setUsername('example_user');
        $user1->setStatus('active');
        $user1->setEmail('test@test.com');
        $user1->setRoles(['ROLE_USER']);
        $user1->setPassword($this->passwordHasher->hashPassword($user1, 'password123'));

        $manager->persist($user1);
        $manager->flush();

        $user2 = new User();
        $user2->setFirstName('Jane');
        $user2->setLastName('Doe');
        $user2->setUsername('example_user2');
        $user2->setStatus('active');
        $user2->setEmail('test2@test.com');
        $user2->setRoles(['ROLE_USER']);
        $user2->setPassword($this->passwordHasher->hashPassword($user2, 'password123'));

        $manager->persist($user2);
        $manager->flush();

        $tourament1 = new Tournament();
        $tourament1->setTournamentName('Tournament 1');
        $tourament1->setStartDate(new \DateTime('2021-10-01'));
        $tourament1->setEndDate(new \DateTime('2021-10-02'));
        $tourament1->setLocation('Location 1');
        $tourament1->setDescription('Description 1');
        $tourament1->setMaxParticipants(10);
        $tourament1->setGame('Game 1');
        $tourament1->setStatus('En attente');
        $tourament1->setOrganizer($user1);

        $manager->persist($tourament1);
        $manager->flush();

        $tourament2 = new Tournament();
        $tourament2->setTournamentName('Tournament 2');
        $tourament2->setStartDate(new \DateTime('2024-04-03'));
        $tourament2->setEndDate(new \DateTime('2024-08-04'));
        $tourament2->setLocation('Location 2');
        $tourament2->setDescription('Description 2');
        $tourament2->setMaxParticipants(10);
        $tourament2->setGame('Game 2');
        $tourament2->setStatus('En cours');
        $tourament2->setOrganizer($user2);

        $manager->persist($tourament2);
        $manager->flush();

        $Game = new Game();
        $Game->setGameDate(new \DateTime('2021-10-01'));
        $Game->setScorePlayer1(1);
        $Game->setScorePlayer2(2);
        $Game->addPlayer($user1);
        $Game->addPlayer($user2);
        $Game->setTournament($tourament1);

        $manager->persist($Game);
        $manager->flush();

        $registration = new Registration();
        $registration->setRegistrationDate(new \DateTime('2021-10-01'));
        $registration->setPlayer($user1);
        $registration->setTournament($tourament2);

        $manager->persist($registration);
        $manager->flush();
    }
}
