<?php

namespace App\Controller\RendezVous;

use App\Entity\TLogin;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('auth', name: 'auth_ctrl_')]
class RendezVousController extends AbstractController
{
    // private ObjectManager $manager;

    // public function __construct(ObjectManager $manager)
    // {
    //     $this->manager = $manager;        
    // }



    
}
