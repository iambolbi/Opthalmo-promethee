<?php

namespace App\Controller\Meetings;

use App\Entity\TLogin;
use App\Entity\TRendezPrestation;
use App\Entity\TRendezVous;
use App\Repository\TAssuranceRepository;
use App\Repository\TMedecinRepository;
use App\Repository\TPatientRepository;
use App\Repository\TPrestationRepository;
use App\Shared\ErrorHttp;
use App\Shared\Functions;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('meetings', name: 'meetings_ctrl_')]
class MeetingsController extends AbstractController
{

    private TMedecinRepository $medecinRepository;
    private TPatientRepository $patientRepository;
    private TAssuranceRepository $assuranceRepository;
    private TPrestationRepository $prestationRepository;
    private Functions $functions;
  

    public function __construct(Functions $functions,TMedecinRepository $medecinRepository, TPatientRepository $patientRepository, TAssuranceRepository $assuranceRepository, TPrestationRepository $prestationRepository )
    {
        $this->functions = $functions;      
        $this->medecinRepository = $medecinRepository;
        $this->assuranceRepository = $assuranceRepository;
        $this->prestationRepository = $prestationRepository;  
        $this->patientRepository = $patientRepository;
    }


    #[Route('', name: 'meetings')]
    #[Template('meetings/index.html.twig')]
    public function index(): array
    {

        return [
            'medecins' => $this->medecinRepository->findBy(['state'=>true]),
            'assurances' => $this->assuranceRepository->findBy(['state'=>true]),
            'patients' =>$this->patientRepository->findBy(['state'=>true]),
            'prestations' => $this->prestationRepository->findBy(['state'=>true])
        ];
    }



    //    Creer un rendez-vous
    #[Route('/create', name: 'create')]
    public function createuser(): JsonResponse
    {
        $data = $this->functions->jsondecode();
        if (!isset($data->fk_medecin,$data->fk_patient,$data->fk_assurance,$data->fk_prestation,$data->pourcentage, $data->espece, $data->date_rendez_vous, $data->description))
            return $this->functions->error(ErrorHttp::MSG_FORM_INVALID);

        $medecin = $this->medecinRepository->findOneBy(['state'=>true, 'id'=>$data->fk_medecin]);
        if ($medecin)
            return $this->functions->error(ErrorHttp::MSG_MEDECIN_NOT_FOUND, ['action' => __METHOD__, 'fk_login' => $this->getUser()]);
    
        $patient = $this->patientRepository->findOneBy(['state'=>true, 'id'=>$data->fk_patient]);
        if ($patient)
            return $this->functions->error(ErrorHttp::MSG_MEDECIN_NOT_FOUND, ['action' => __METHOD__, 'fk_login' => $this->getUser()]);

        $assurance = $this->assuranceRepository->findOneBy(['state'=>true, 'id'=>$data->fk_medecin]);
        if ($assurance)
            return $this->functions->error(ErrorHttp::MSG_ASSURANCE_NOT_FOUND, ['action' => __METHOD__, 'fk_login' => $this->getUser()]);

        $prestation = $this->prestationRepository->findOneBy(['state'=>true, 'id'=>$data->fk_medecin]);
        if ($prestation)
            return $this->functions->error(ErrorHttp::MSG_PRESTATION_NOT_FOUND, ['action' => __METHOD__, 'fk_login' => $this->getUser()]);
        
    
        
        $rendezvous = (new TRendezVous())->setDiagnostic($data->description)
        ->setFkLogin($this->functions->getUser($this->getUser()))
        ->setFkPatient($patient)
            ->setDateRendezVous($this->functions->dateCreate($data->date_rendez_vous));

        $this->functions->em()->persist($rendezvous);
        $this->functions->em()->flush();
        $rendezvous->setCode($this->functions->getCodeRendezVous(null,$rendezvous));

        $rendezVousPrestation = (new TRendezPrestation())->setFkMedecin($medecin)
                                                        ->setFkPrestation($prestation)
                                                        ->setFkAssurance($assurance);
                                                        
                                                        

        $this->functions->log(['action' => __METHOD__, 'fk_login' => $this->getUser()]);
        return $this->functions->success();
    }
}
