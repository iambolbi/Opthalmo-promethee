<?php

namespace App\Controller\Settings;

use App\Entity\TLogin;
use App\Repository\TLoginRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('users', name: 'users_ctrl_')]
class UsersController extends AbstractController
{
    private TLoginRepository $loginRepository;

     public function __construct(TLoginRepository $loginRepository)
    {
         $this->loginRepository = $loginRepository;        
     }



    #[Route('', name: 'users')]
    #[Template('settings/users.html.twig')]
    public function index(): array
    {

        $users = $this->loginRepository->findBy(['state'=>true]);

        
        // $user = new TLogin();
        // $user->setUsername('adminit');

        // $pass = 'adminit';
        // $hashPassword = $passwordHasher->hashPassword($user,$pass);

        // $user->setPassword($hashPassword);
        
        // $entityManager->persist($user);
        // $entityManager->flush();

        return [
            'users'=> $users
        ];
    }
}
