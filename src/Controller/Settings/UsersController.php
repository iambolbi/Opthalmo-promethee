<?php

namespace App\Controller\Settings;

use App\Entity\TLogin;
use App\Entity\TUserRole;
use App\Repository\TLoginRepository;
use App\Repository\TRoleRepository;
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

#[Route('users', name: 'users_ctrl_')]
class UsersController extends AbstractController
{
    private TRoleRepository $roleRepository;
    private Functions $functions;
    private TLoginRepository $loginRepository;
   

    public function __construct(TRoleRepository $roleRepository,TLoginRepository $loginRepository,   Functions $functions)
    {
        $this->roleRepository = $roleRepository;
        $this->functions = $functions;
        $this->loginRepository = $loginRepository;
      
    }
  
    #[Route('', name: 'users')]
    #[Template('settings/users.html.twig')]
    public function users(): array
    {

        return [
           'users' => $this->loginRepository->findBy(['state'=>true]),
           'roles' => $this->roleRepository->findBy(['state'=>true])
        ];
    }

    #[Route('/create', name: 'create')]
    public function createuser(UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $data = $this->functions->jsondecode();
        if (!isset($data->username,$data->password,$data->role))
            return $this->functions->error(ErrorHttp::MSG_FORM_INVALID);

        $role = $this->roleRepository->findOneBy(['id' => $data->role, 'state' => true]);
        if (!$role) return $this->functions->error(ErrorHttp::MSG_ROLE_NOT_FOUND, ['action' => __METHOD__, 'fk_login' => $this->getUser()]);

      
        $user = (new TLogin())->setUsername($data->username);

        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $data->password
        );
        $user->setPassword($hashedPassword);
        $this->functions->em()->persist($user);


        $userRole = (new TUserRole())->setFkLogin($user)
                                    ->setFkRole($role);
        $this->functions->em()->persist($userRole);


        $this->functions->em()->persist($user);
        $this->functions->em()->flush();

        $this->functions->log(['action' => __METHOD__, 'fk_login' => $this->getUser()]);
        return $this->functions->success();
    }


    #[Route('/update', name: 'update')]
    public function updaterole(): JsonResponse
    {
        $data = $this->functions->jsondecode();

        if (!isset($data->id, $data->intitule, $data->roles))
            return $this->functions->error(ErrorHttp::MSG_FORM_INVALID);

        $role = $this->roleRepository->findOneBy(['id' => $data->id, 'state' => true]);
        if (!$role) return $this->functions->error(ErrorHttp::MSG_ROLE_NOT_FOUND, ['action' => __METHOD__, 'fk_login' => $this->getUser()]);

        $app_roles = [];
        foreach ($data->roles as $roleItem) {
            if (in_array($roleItem, Vars::ROLES))
                $app_roles[] = $roleItem;
        }
        $role->setLibelle($data->intitule)
            ->setRoles($app_roles);

        $this->functions->em()->persist($role);
        $this->functions->em()->flush();

        $this->functions->log(['action' => __METHOD__, 'fk_login' => $this->getUser()]);
        return $this->functions->success();
    }



    #[Route('/find', name: 'find')]
    public function findrole(Request $request): JsonResponse
    {
        $id = $request->query->get('code');
        
        
        $login = $this->loginRepository->findOneBy(['id' => $id, 'state' =>  true]);
        if (!$id || !$login)
            return $this->functions->error(ErrorHttp::MSG_USER_NOT_FOUND, ['action' => __METHOD__, 'fk_login' => $this->getUser()]);

       // dd($login);
        $this->functions->log(['action' => __METHOD__, 'fk_login' => $this->getUser()]);
        return $this->functions->success($login->toArray());
    }


    #[Route('/delete', name: 'delete')]
    public function deleterole(Request $request): JsonResponse
    {
        $id = $request->query->get('code');

        $role = $this->roleRepository->findOneBy(['id' => $id, 'state' =>  true]);
        if (!$id || !$role)
            return $this->functions->error(ErrorHttp::MSG_ROLE_NOT_FOUND, ['action' => __METHOD__, 'fk_login' => $this->getUser()]);

        $role->setState(false);
        $this->functions->em()->persist($role);
        $this->functions->em()->flush();

        $this->functions->log(['action' => __METHOD__, 'fk_login' => $this->getUser()]);
        return $this->functions->success();
    }
}
