<?php

namespace App\Controller\Settings;

use App\Entity\TLogin;
use App\Entity\TMedecin;
use App\Repository\TMedecinRepository;
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

#[Route('doctors', name: 'doctors_ctrl_')]
#[IsGranted('ROLE_ADMIN')]
class DoctorsController extends AbstractController
{
   
    private TMedecinRepository $medecinRepository;
    private Functions $functions;

    public function __construct(TMedecinRepository $medecinRepository, Functions $functions)
    {
        $this->medecinRepository = $medecinRepository;
        $this->functions = $functions;
    }

    //    Affichage  des docteurs
    #[Route('', name: 'doctors')]
    #[Template('settings/doctors.html.twig')]
    public function medecins(): array
    {

        return [
            'medecins' => $this->medecinRepository->findBy(['state' => true])
        ];
    }

    //   Creer un docteur
    #[Route('/create', name: 'create')]
    public function createdoctor(): JsonResponse
    {
        $data = $this->functions->jsondecode();
        if (!isset($data->nom,$data->prenom,$data->tel,$data->adresse))
            return $this->functions->error(ErrorHttp::MSG_FORM_INVALID);

        $medecin= (new TMedecin())->setNom($data->nom)
        ->setPrenom($data->prenom)
        ->setContact($data->tel)
        ->setAdresse($data->adresse)
       ;


        $this->functions->em()->persist($medecin);
        $this->functions->em()->flush();

        $this->functions->log(['action' => __METHOD__, 'fk_login' => $this->getUser()]);
        return $this->functions->success();
    }

    //    Modifier un docteur
    #[Route('/update', name: 'update')]
    public function updatedoctor(): JsonResponse
    {
        $data = $this->functions->jsondecode();

        if (!isset($data->id, $data->intitule, $data->roles))
            return $this->functions->error(ErrorHttp::MSG_FORM_INVALID);

        $medecin = $this->medecinRepository->findOneBy(['id' => $data->id, 'state' => true]);
        if (!$medecin) return $this->functions->error(ErrorHttp::MSG_MEDECIN_NOT_FOUND, ['action' => __METHOD__, 'fk_login' => $this->getUser()]);

       

        $this->functions->em()->persist($medecin);
        $this->functions->em()->flush();

        $this->functions->log(['action' => __METHOD__, 'fk_login' => $this->getUser()]);
        return $this->functions->success();
    }

    //    Afficher  un docteur
    #[Route('/find', name: 'find')]
    public function finddoctor(Request $request): JsonResponse
    {
        $id = $request->query->get('code');

        $medecin = $this->medecinRepository->findOneBy(['id' => $id, 'state' =>  true]);
        if (!$id || !$medecin)
            return $this->functions->error(ErrorHttp::MSG_MEDECIN_NOT_FOUND, ['action' => __METHOD__, 'fk_login' => $this->getUser()]);

        $this->functions->log(['action' => __METHOD__, 'fk_login' => $this->getUser()]);
        return $this->functions->success($medecin->toArray());
    }


    //    Supprimer un docteur
    #[Route('/delete', name: 'delete')]
    public function deletedoctor(Request $request): JsonResponse
    {
        $id = $request->query->get('code');

        $medecin = $this->medecinRepository->findOneBy(['id' => $id, 'state' =>  true]);

        if (!$id || !$medecin)
            return $this->functions->error(ErrorHttp::MSG_MEDECIN_NOT_FOUND, ['action' => __METHOD__, 'fk_login' => $this->getUser()]);

        $medecin->setState(false);
        $this->functions->em()->persist($medecin);
        $this->functions->em()->flush();

        $this->functions->log(['action' => __METHOD__, 'fk_login' => $this->getUser()]);
        return $this->functions->success();
    }
}
