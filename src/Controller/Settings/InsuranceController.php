<?php

namespace App\Controller\Settings;

use App\Entity\TAssurance;
use App\Entity\TLogin;
use App\Entity\TPrestation;
use App\Repository\TAssuranceRepository;
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

#[Route('insurance', name: 'insurance_ctrl_')]
#[IsGranted('ROLE_ADMIN')]
class InsuranceController extends AbstractController
{
   
    private TAssuranceRepository $assuranceRepository;
    private Functions $functions;

    public function __construct(TAssuranceRepository $assuranceRepository, Functions $functions)
    {
        $this->assuranceRepository = $assuranceRepository;
        $this->functions = $functions;
    }


    //    Affichage  des assurances
    #[Route('', name: 'insurance')]
    #[Template('settings/insurance.html.twig')]
    public function insurance(): array
    {
        return [
            'insurances' => $this->assuranceRepository->findBy(['state'=>true])
        ];
    }


    //    Creer une assurance
    #[Route('/create', name: 'create')]
    public function createinsurance(): JsonResponse
    {
        $data = $this->functions->jsondecode();
        if (!isset($data->libelle))
            return $this->functions->error(ErrorHttp::MSG_FORM_INVALID);

        $assurance = (new TAssurance())->setLibelle($data->libelle)
       ;


        $this->functions->em()->persist($assurance);
        $this->functions->em()->flush();

        $this->functions->log(['action' => __METHOD__, 'fk_login' => $this->getUser()]);
        return $this->functions->success();
    }

    //   Modifier une assurance
    #[Route('/update', name: 'update')]
    public function updateinsurance(): JsonResponse
    {
        $data = $this->functions->jsondecode();

        if (!isset($data->id, $data->libelle))
            return $this->functions->error(ErrorHttp::MSG_FORM_INVALID);

        $assurance = $this->assuranceRepository->findOneBy(['id' => $data->id, 'state' => true]);
        if (!$assurance) return $this->functions->error(ErrorHttp::MSG_ASSURANCE_NOT_FOUND, ['action' => __METHOD__, 'fk_login' => $this->getUser()]);

       $assurance->setLibelle($data->libelle);

        $this->functions->em()->persist($assurance);
        $this->functions->em()->flush();

        $this->functions->log(['action' => __METHOD__, 'fk_login' => $this->getUser()]);
        return $this->functions->success();
    }

    //    Afficher une assurance
    #[Route('/find', name: 'find')]
    public function findinsurance(Request $request): JsonResponse
    {
        $id = $request->query->get('code');

        $assurance= $this->assuranceRepository->findOneBy(['id' => $id, 'state' =>  true]);
        if (!$id || !$assurance)
            return $this->functions->error(ErrorHttp::MSG_ASSURANCE_NOT_FOUND, ['action' => __METHOD__, 'fk_login' => $this->getUser()]);

        $this->functions->log(['action' => __METHOD__, 'fk_login' => $this->getUser()]);
        return $this->functions->success($assurance->toArray());
    }

    //    Supprimer une assurance
    #[Route('/delete', name: 'delete')]
    public function deleteinsurance(Request $request): JsonResponse
    {
        $id = $request->query->get('code');

        $assurance = $this->assuranceRepository->findOneBy(['id' => $id, 'state' =>  true]);
        
        if (!$id || !$assurance)
            return $this->functions->error(ErrorHttp::MSG_ASSURANCE_NOT_FOUND, ['action' => __METHOD__, 'fk_login' => $this->getUser()]);

        $assurance->setState(false);
        $this->functions->em()->persist($assurance);
        $this->functions->em()->flush();

        $this->functions->log(['action' => __METHOD__, 'fk_login' => $this->getUser()]);
        return $this->functions->success();
    }

}
