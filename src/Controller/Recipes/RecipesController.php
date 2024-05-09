<?php

namespace App\Controller\Recipes;

use App\Entity\TLogin;
use App\Repository\TRendezVousRepository;
use App\Shared\Functions;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('recipes', name: 'recipes_ctrl_')]
class RecipesController extends AbstractController
{
    private Functions $functions;
    private TRendezVousRepository $rendezvousRepository;


    public function __construct(Functions $functions, TRendezVousRepository $rendezVousRepository)
    {
        $this->functions= $functions ;
        $this->rendezvousRepository = $rendezVousRepository;
        
    }

    #[Route('/', name: 'recipes')]
    #[Template('recipes/index.html.twig')]
    public function recipes(): array
    {
        $rend = $this->rendezvousRepository->findOneBy(['state'=>true],['id'=>'DESC']);

        //dd(count($rend->getTRendezPrestations()));
        foreach($rend->getTRendezPrestations() as $item)
        {
            dd($item);
        }

        return [
            'rendezVous' => $this->rendezvousRepository->findBy(['state'=>true],['id'=>'DESC'])
        ];
    }
}
