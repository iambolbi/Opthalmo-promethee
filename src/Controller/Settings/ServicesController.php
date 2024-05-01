<?php

namespace App\Controller\Settings;

use App\Entity\TLogin;
use App\Entity\TPrestation;
use App\Repository\TPrestationRepository;
use App\Shared\ErrorHttp;
use App\Shared\Functions;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('services', name: 'services_ctrl_')]
#[IsGranted('ROLE_ADMIN')]
class ServicesController extends AbstractController
{
    private  Functions $functions;
    private TPrestationRepository $prestationRepository;

    public function __construct(TPrestationRepository $prestationRepository, Functions $functions)
    {
        $this->functions = $functions;    
        $this->prestationRepository = $prestationRepository;    
    }


    //    Affichage  des prestations
    #[Route('', name: 'services')]
    #[Template('settings/services.html.twig')]
    public function services(): array
    {

        return [
            'prestations' => $this->prestationRepository->findBy(['state' =>true])
        ];
    }


    //    Creer une prestation
    #[Route('/create', name: 'create')]
    public function createservice(): JsonResponse
    {
        $data = $this->functions->jsondecode();
       
        if (!isset($data->libelle,$data->valeur))
            return $this->functions->error(ErrorHttp::MSG_FORM_INVALID);

        $prestation = (new TPrestation())->setLibelle($data->libelle)
        ->setValeur($data->valeur)
       ;


        $this->functions->em()->persist($prestation);
        $this->functions->em()->flush();

        $this->functions->log(['action' => __METHOD__, 'fk_login' => $this->getUser()]);
        return $this->functions->success();
    }

    //    Mdifier une prestation
    #[Route('/update', name: 'update')]
    public function updateservice(): JsonResponse
    {
        $data = $this->functions->jsondecode();

        if (!isset($data->id, $data->libelle, $data->valeur))
            return $this->functions->error(ErrorHttp::MSG_FORM_INVALID);

        $prestation = $this->prestationRepository->findOneBy(['id' => $data->id, 'state' => true]);
        if (!$prestation) return $this->functions->error(ErrorHttp::MSG_PRESTATION_NOT_FOUND, ['action' => __METHOD__, 'fk_login' => $this->getUser()]);

       $prestation->setLibelle($data->libelle)
       ->setValeur($data->valeur);

        $this->functions->em()->persist($prestation);
        $this->functions->em()->flush();

        $this->functions->log(['action' => __METHOD__, 'fk_login' => $this->getUser()]);
        return $this->functions->success();
    }


    //    Affichage  d'utilisateur
    #[Route('/find', name: 'find')]
    public function findservice(Request $request): JsonResponse
    {
        $id = $request->query->get('code');

        $prestation= $this->prestationRepository->findOneBy(['id' => $id, 'state' =>  true]);
        if (!$id || !$prestation)
            return $this->functions->error(ErrorHttp::MSG_PRESTATION_NOT_FOUND, ['action' => __METHOD__, 'fk_login' => $this->getUser()]);

        $this->functions->log(['action' => __METHOD__, 'fk_login' => $this->getUser()]);
        return $this->functions->success($prestation->toArray());
    }

    //    Supprimer un utilsateur
    #[Route('/delete', name: 'delete')]
    public function deleteservice(Request $request): JsonResponse
    {
        $id = $request->query->get('code');

        $prestation = $this->prestationRepository->findOneBy(['id' => $id, 'state' =>  true]);
        
        if (!$id || !$prestation)
            return $this->functions->error(ErrorHttp::MSG_PRESTATION_NOT_FOUND, ['action' => __METHOD__, 'fk_login' => $this->getUser()]);

        $prestation->setState(false);
        $this->functions->em()->persist($prestation);
        $this->functions->em()->flush();

        $this->functions->log(['action' => __METHOD__, 'fk_login' => $this->getUser()]);
        return $this->functions->success();
    }
}
