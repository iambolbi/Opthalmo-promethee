<?php

namespace App\Controller\Dashboard;

use App\Entity\TLogin;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('dashboard', name: 'dashboard_ctrl_')]
class DashboardController extends AbstractController
{
    // private ObjectManager $manager;

    // public function __construct(ObjectManager $manager)
    // {
    //     $this->manager = $manager;        
    // }



    #[Route('/', name: 'dashboard')]
    #[Template('dashboard/dashboard.html.twig')]
    public function home(): array
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
