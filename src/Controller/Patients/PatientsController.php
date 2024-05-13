<?php

namespace App\Controller\Patients;

use App\Entity\TLogin;
use App\Entity\TPatient;
use App\Repository\TPatientRepository;
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

#[Route('patients', name: 'patients_ctrl_')]
#[IsGranted('ROLE_ADMIN')]
class PatientsController extends AbstractController
{
   
    private Functions $functions;
    private TPatientRepository $patientRepository;

    public function __construct(TPatientRepository $patientRepository, Functions $functions)
    {
        $this->patientRepository = $patientRepository;
        $this->functions = $functions;
        
    }

    #[Route('/', name: 'patients')]
    #[Template('patients/index.html.twig')]
    public function patients(): array
    {

        return [
            'patients' => $this->patientRepository->findBy(['state'=>true])
        ];
    }




    //    Creer un utilisateur
    #[Route('/create', name: 'create')]
    public function createpatient(): JsonResponse
    {
        $data = $this->functions->jsondecode();
        if (!isset($data->nom,$data->prenom,$data->contact,$data->adresse))
            return $this->functions->error(ErrorHttp::MSG_FORM_INVALID);

        $patient = (new TPatient())->setNom($data->nom)
            ->setPrenom($data->prenom)
            ->setContact($data->contact)
            ->setAdresse($data->adresse)
            ;

       
        $this->functions->em()->persist($patient);

        $this->functions->em()->flush();

        $this->functions->log(['action' => __METHOD__, 'fk_login' => $this->getUser()]);
        return $this->functions->success();
    }

//    Modfiier un utilisateur 
    #[Route('/update', name: 'update')]
    public function updatepatient(): JsonResponse
    {
      
        $data = $this->functions->jsondecode();
        if (!isset($data->id,$data->nom,$data->prenom,$data->contact,$data->adresse))
            return $this->functions->error(ErrorHttp::MSG_FORM_INVALID);

        $patient = $this->patientRepository->findOneBy(['id'=>$data->id, 'state'=>true]);   
        if (!$patient) return $this->functions->error(ErrorHttp::MSG_PATIENT_NOT_FOUND, ['action' => __METHOD__, 'fk_login' => $this->getUser()]);

        $patient->setNom($data->nom)
        ->setPrenom($data->prenom)
        ->setContact($data->contact)
        ->setAdresse($data->adresse);

   
        $this->functions->em()->persist($patient);

        $this->functions->em()->flush();


        $this->functions->log(['action' => __METHOD__, 'fk_login' => $this->getUser()]);
        return $this->functions->success();
    }


//    Rechercher un utilisateur
    #[Route('/find', name: 'find')]
    public function findpatient(Request $request): JsonResponse
    {
        $id = $request->query->get('code');
        
        $patient = $this->patientRepository->findOneBy(['id' => $id, 'state' =>  true]);
        if (!$id || !$patient)
            return $this->functions->error(ErrorHttp::MSG_PATIENT_NOT_FOUND, ['action' => __METHOD__, 'fk_login' => $this->getUser()]);

        $this->functions->log(['action' => __METHOD__, 'fk_login' => $this->getUser()]);
        return $this->functions->success($patient->toArray());
    }

    //    Detail des informations sur patient 
    #[Route('/detail', name: 'detail')]
    #[Template('patients/detail-patient.html.twig')]
    public function detailpatient(Request $request): array
    {
        $id = $request->query->get('code');
        
        $patient = $this->patientRepository->findOneBy(['id' => $id, 'state' =>  true]);
        if (!$id || !$patient)
            return $this->functions->error(ErrorHttp::MSG_PATIENT_NOT_FOUND, ['action' => __METHOD__, 'fk_login' => $this->getUser()]);

        $this->functions->log(['action' => __METHOD__, 'fk_login' => $this->getUser()]);
        return [
            'patient' => $patient
        ];
    }

//    Supprimer un utilisateur
    #[Route('/delete', name: 'delete')]
    public function deletepatient(Request $request): JsonResponse
    {
        $id = $request->query->get('code');

        $patient = $this->patientRepository->findOneBy(['id' => $id, 'state' =>  true]);
        if (!$id || !$patient)
            return $this->functions->error(ErrorHttp::MSG_PATIENT_NOT_FOUND, ['action' => __METHOD__, 'fk_login' => $this->getUser()]);

        $patient->setState(false);
        $this->functions->em()->persist($patient);
        $this->functions->em()->flush();

        $this->functions->log(['action' => __METHOD__, 'fk_login' => $this->getUser()]);
        return $this->functions->success();
    }
}
