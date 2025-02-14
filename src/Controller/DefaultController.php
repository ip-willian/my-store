<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'store_index')]
    public function index(): Response
    {
        return $this->render('index.html.twig');
    }

    #[Route('/register', name: 'register_users')]
    public function register(UserPasswordHasherInterface $hasher, EntityManagerInterface $entityManager): Response
    {
        $usersData = [
            ['email' => 'picking@mystore.com', 'role' => 'ROLE_PICKING'],
            ['email' => 'shipping@mystore.com', 'role' => 'ROLE_SHIPPING'],
            ['email' => 'manager@mystore.com', 'role' => 'ROLE_MANAGEMENT'],
        ];

        foreach ($usersData as $userData) {
            $user = new User();
            $user->setEmail($userData['email']);
            $user->setRoles([$userData['role']]);
            $password = $hasher->hashPassword($user, '123456');
            $user->setPassword($password);
            $entityManager->persist($user);
            $entityManager->flush();
        }

        try {
            $entityManager->flush();
        } catch (Exception $err) {
            return new Response('Users already defined!');
        }

        return $this->render('index.html.twig');
    }
}
