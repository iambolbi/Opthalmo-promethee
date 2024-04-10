<?php

namespace App\Controller\Settings;

use App\Entity\TLogin;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('roles', name: 'roles_ctrl_')]
class RolesController extends AbstractController
{
  
    #[Route('', name: 'roles')]
    #[Template('settings/roles.html.twig')]
    public function index(): array
    {

        
        // $user = new TLogin();
        // $user->setUsername('adminit');

        // $pass = 'adminit';
        // $hashPassword = $passwordHasher->hashPassword($user,$pass);

        // $user->setPassword($hashPassword);
        
        // $entityManager->persist($user);
        // $entityManager->flush();

        return [];
    }
}
