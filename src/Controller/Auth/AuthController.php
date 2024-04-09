<?php

namespace App\Controller\Auth;

use App\Entity\TLogin;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route('auth', name: 'auth_ctrl_')]
class AuthController extends AbstractController
{
    // private ObjectManager $manager;

    // public function __construct(ObjectManager $manager)
    // {
    //     $this->manager = $manager;        
    // }



    #[Route('/login', name: 'login')]
    #[Template('auth/auth.html.twig')]
    public function auth(AuthenticationUtils $authenticationUtils): array
    {


        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();
        // $user = new TLogin();
        // $user->setUsername('adminit');

        // $pass = 'adminit';
        // $hashPassword = $passwordHasher->hashPassword($user,$pass);

        // $user->setPassword($hashPassword);
        
        // $entityManager->persist($user);
        // $entityManager->flush();

        return [
            'last_username' => $lastUsername,
            'error'         => $error,
        ];
    }
}
