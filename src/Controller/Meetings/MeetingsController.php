<?php

namespace App\Controller\Meetings;

use App\Entity\TLogin;
use App\Entity\TRendezPrestation;
use App\Entity\TRendezVous;
use App\Repository\TAssuranceRepository;
use App\Repository\TMedecinRepository;
use App\Repository\TPatientRepository;
use App\Repository\TPrestationRepository;
use App\Repository\TRendezVousRepository;
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

#[Route('meetings', name: 'meetings_ctrl_')]
class MeetingsController extends AbstractController
{

    private TMedecinRepository $medecinRepository;
    private TPatientRepository $patientRepository;
    private TAssuranceRepository $assuranceRepository;
    private TPrestationRepository $prestationRepository;
    private Functions $functions;
    private TRendezVousRepository $rendezvousRepository;
  

    public function __construct(TRendezVousRepository $rendezvousRepository, Functions $functions,TMedecinRepository $medecinRepository, TPatientRepository $patientRepository, TAssuranceRepository $assuranceRepository, TPrestationRepository $prestationRepository )
    {
        $this->functions = $functions;      
        $this->medecinRepository = $medecinRepository;
        $this->assuranceRepository = $assuranceRepository;
        $this->prestationRepository = $prestationRepository;  
        $this->patientRepository = $patientRepository;
        $this->rendezvousRepository = $rendezvousRepository;
    }


    #[Route('', name: 'meetings')]
    #[Template('meetings/index.html.twig')]
    public function meetings(): array
    {
       $rendezVous = $this->rendezvousRepository->findOneBy(['state'=>true]);

        //dd($rendezVous->getCode());
        return [
            'medecins' => $this->medecinRepository->findBy(['state'=>true]),
            'assurances' => $this->assuranceRepository->findBy(['state'=>true]),
            'patients' =>$this->patientRepository->findBy(['state'=>true]),
            'prestations' => $this->prestationRepository->findBy(['state'=>true]),
            'rendezVous' => $this->rendezvousRepository->findBy(['state'=>true],['id'=>'DESC'])
        ];
    }



    //    Creer un rendez-vous
    #[Route('/create', name: 'create')]
    public function createMetting(): JsonResponse
    {
        $data = $this->functions->jsondecode();
        if (!isset($data->fk_medecin,$data->fk_patient,$data->fk_assurance,$data->date_rendez_vous,$data->fk_prestation,$data->pourcentage, $data->description))
            return $this->functions->error(ErrorHttp::MSG_FORM_INVALID);

        //dd($data);
        $medecin = $this->medecinRepository->findOneBy(['state'=>true, 'id'=>$data->fk_medecin]);
        if (!$medecin)
            return $this->functions->error(ErrorHttp::MSG_MEDECIN_NOT_FOUND, ['action' => __METHOD__, 'fk_login' => $this->getUser()]);
    
        $patient = $this->patientRepository->findOneBy(['state'=>true, 'id'=>$data->fk_patient]);
        if (!$patient)
            return $this->functions->error(ErrorHttp::MSG_MEDECIN_NOT_FOUND, ['action' => __METHOD__, 'fk_login' => $this->getUser()]);

        $assurance = $this->assuranceRepository->findOneBy(['state'=>true, 'id'=>$data->fk_assurance]);
        if (!$assurance)
            return $this->functions->error(ErrorHttp::MSG_ASSURANCE_NOT_FOUND, ['action' => __METHOD__, 'fk_login' => $this->getUser()]);

        $prestation = $this->prestationRepository->findOneBy(['state'=>true, 'id'=>$data->fk_prestation]);
        if (!$prestation)
            return $this->functions->error(ErrorHttp::MSG_PRESTATION_NOT_FOUND, ['action' => __METHOD__, 'fk_login' => $this->getUser()]);
        
   // dd($data->date_rendez_vous);

        $rendezvous = (new TRendezVous())->setDiagnostic($data->description)
        ->setFkLogin($this->functions->getUser($this->getUser()))
        ->setFkPatient($patient)
        ->setStatut(0)
            ->setDateRendezVous($this->functions->dateCreate($data->date_rendez_vous,'Y-m-d H:i'));

        $this->functions->em()->persist($rendezvous);
        $this->functions->em()->flush();
        $rendezvous->setCode($this->functions->getCodeRendezVous($rendezvous));
        $this->functions->em()->persist($rendezvous);


        $pourcentage = $prestation->getValeur() * $data->pourcentage / 100;
        $espece = $prestation->getValeur() - $pourcentage ;

       
        $rendezVousPrestation = (new TRendezPrestation())->setPartAssurance($pourcentage)
                                                         ->setPartPatient($espece)
                                                         ->setFkRendezVous($rendezvous)
                                                        ->setFkMedecin($medecin)
                                                        ->setFkPrestation($prestation)
                                                        ->setFkAssurance($assurance);

        $this->functions->em()->persist($rendezVousPrestation);
                                                                                     
        $this->functions->em()->flush();
        $this->functions->log(['action' => __METHOD__, 'fk_login' => $this->getUser()]);
        return $this->functions->success();
    }



    #[Route('/find', name: 'find')]
    #[Template('meetings/meeting-detail.html.twig')]
    public function findMeeting(Request $request): array
    {
        $code = $request->query->get('code');
        $rendezVous = $this->rendezvousRepository->findOneBy(['state'=>true, 'id'=>$code]);

        //dd($rendezVous->getCode());
        return [
            'medecins' => $this->medecinRepository->findBy(['state'=>true]),
            'assurances' => $this->assuranceRepository->findBy(['state'=>true]),
            'patients' =>$this->patientRepository->findBy(['state'=>true]),
            'prestations' => $this->prestationRepository->findBy(['state'=>true]),
            'rendezVous' => $rendezVous
        ];
    }
}
