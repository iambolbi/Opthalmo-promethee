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

        // $user = new TLogin();
        // $user->setUsername('adminit');

        // $pass = 'adminit';
        // $hashPassword = $passwordHasher->hashPassword($user,$pass);

        // $user->setPassword($hashPassword);
        
        // $entityManager->persist($user);
        // $entityManager->flush();

        return [
            'patients' => $this->patientRepository->findBy(['state'=>true])
        ];
    }




    //    Creer un utilisateur
    #[Route('/create', name: 'create')]
    public function createuser(): JsonResponse
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
    public function updaterole(): JsonResponse
    {
      
        $data = $this->functions->jsondecode();
        if (!isset($data->id,$data->username,$data->password,$data->roles))
            return $this->functions->error(ErrorHttp::MSG_FORM_INVALID);

        $user = $this->loginRepository->findOneBy(['id'=>$data->id, 'state'=>true]);   
        if (!$user) return $this->functions->error(ErrorHttp::MSG_USER_NOT_FOUND, ['action' => __METHOD__, 'fk_login' => $this->getUser()]);

        $user->setUsername($data->username);

        if(strlen($data->password)>0)
            $user->setPassword($this->functions->hasher()->hashPassword($user,$data->password));

        $this->functions->em()->persist($user);

        $userRoles = $this->userRoleRepository->findBy(['fk_login'=>$user->getId(),'state'=>true]);

        foreach($userRoles  as $userRole)
        {
            $userRole->setState(false);
            $this->functions->em()->persist($userRole);
        }

        foreach($data->roles as $role)
        {
            $role = $this->roleRepository->findOneBy(['id' => $role, 'state' => true]);
            // if (!$role) return $this->functions->error(ErrorHttp::MSG_ROLE_NOT_FOUND, ['action' => __METHOD__, 'fk_login' => $this->getUser()]);
            if($role)
            {
                $userRole = (new TUserRole())->setFkLogin($user)
                ->setFkRole($role);
                $this->functions->em()->persist($userRole);
            }
        }
      
        $this->functions->em()->persist($user);
        $this->functions->em()->flush();


        $this->functions->log(['action' => __METHOD__, 'fk_login' => $this->getUser()]);
        return $this->functions->success();
    }


//    Rechercher un utilisateur
    #[Route('/find', name: 'find')]
    public function finduser(Request $request): JsonResponse
    {
        $id = $request->query->get('code');
        
        $login = $this->loginRepository->findOneBy(['id' => $id, 'state' =>  true]);
        if (!$id || !$login)
            return $this->functions->error(ErrorHttp::MSG_USER_NOT_FOUND, ['action' => __METHOD__, 'fk_login' => $this->getUser()]);

        $this->functions->log(['action' => __METHOD__, 'fk_login' => $this->getUser()]);
        return $this->functions->success($login->toArray());
    }

//    Supprimer un utilisateur
    #[Route('/delete', name: 'delete')]
    public function deleteuser(Request $request): JsonResponse
    {
        $id = $request->query->get('code');

        $user = $this->loginRepository->findOneBy(['id' => $id, 'state' =>  true]);
        if (!$id || !$user)
            return $this->functions->error(ErrorHttp::MSG_USER_NOT_FOUND, ['action' => __METHOD__, 'fk_login' => $this->getUser()]);

        $user->setState(false);
        $this->functions->em()->persist($user);
        $this->functions->em()->flush();

        $this->functions->log(['action' => __METHOD__, 'fk_login' => $this->getUser()]);
        return $this->functions->success();
    }
}
