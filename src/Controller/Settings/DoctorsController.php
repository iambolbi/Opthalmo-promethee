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

#[Route('doctors', name: 'doctors_ctrl_')]
class DoctorsController extends AbstractController
{
   

    #[Route('', name: 'doctors')]
    #[Template('settings/doctors.html.twig')]
    public function home(): array
    {

        return [];
    }
}
