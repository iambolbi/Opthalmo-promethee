<?php

namespace App\Controller\Settings;

use App\Entity\TLogin;
use App\Entity\TUserRole;
use App\Repository\TLoginRepository;
use App\Repository\TRoleRepository;
use App\Repository\TUserRoleRepository;
use App\Shared\ErrorHttp;
use App\Shared\Functions;
use App\Shared\Vars;
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

#[Route('users', name: 'users_ctrl_')]
#[IsGranted('ROLE_ADMIN')]
class UsersController extends AbstractController
{
    private TRoleRepository $roleRepository;
    private Functions $functions;
    private TLoginRepository $loginRepository;
    private TUserRoleRepository $userRoleRepository;
   

    public function __construct(TUserRoleRepository $userRoleRepository, TRoleRepository $roleRepository,TLoginRepository $loginRepository,   Functions $functions)
    {
        $this->roleRepository = $roleRepository;
        $this->functions = $functions;
        $this->loginRepository = $loginRepository;
        $this->userRoleRepository = $userRoleRepository;
      
    }
  
//    Affichage  des utilisateurs
    #[Route('', name: 'users')]
    #[Template('settings/users.html.twig')]
    public function users(): array
    {

        return [
           'users' => $this->loginRepository->findBy(['state'=>true]),
           'roles' => $this->roleRepository->findBy(['state'=>true])
        ];
    }
//    Creer un utilisateur
    #[Route('/create', name: 'create')]
    public function createuser(): JsonResponse
    {
        $data = $this->functions->jsondecode();
        if (!isset($data->username,$data->password,$data->roles))
            return $this->functions->error(ErrorHttp::MSG_FORM_INVALID);

        $user = (new TLogin())->setUsername($data->username);

        $user->setPassword($this->functions->hasher()->hashPassword($user,$data->password));
        $this->functions->em()->persist($user);


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
