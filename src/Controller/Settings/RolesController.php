<?php

namespace App\Controller\Settings;

use App\Entity\TLogin;
use App\Entity\TRole;
use App\Repository\TRoleRepository;
use App\Shared\ErrorHttp;
use App\Shared\Functions;
use App\Shared\Vars;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('roles', name: 'roles_ctrl_')]
class RolesController extends AbstractController
{
    private TRoleRepository $roleRepository;
    private Functions $functions;

    public function __construct(TRoleRepository $roleRepository, Functions $functions)
    {
        $this->roleRepository = $roleRepository;
        $this->functions = $functions;
    }
  
    #[Route('', name: 'roles')]
    #[Template('settings/roles.html.twig')]
    public function roles(): array
    {


        return [
           'roles' => $this->roleRepository->findBy(['state'=>true]),
           'app_roles' => Vars::ROLES
        ];
    }

    #[Route('/create', name: 'create')]
    public function createrole(): JsonResponse
    {
        $data = $this->functions->jsondecode();
        if (!isset($data->intitule, $data->roles))
            return $this->functions->error(ErrorHttp::MSG_FORM_INVALID);

        $app_roles = [];
        foreach ($data->roles as $roleItem) {
            if (in_array($roleItem, Vars::ROLES))
                $app_roles[] = $roleItem;
        }
        $role = (new TRole())->setLibelle($data->intitule)
        ->setRoles($app_roles);


        $this->functions->em()->persist($role);
        $this->functions->em()->flush();

        $this->functions->log(['action' => __METHOD__, 'fk_login' => $this->getUser()]);
        return $this->functions->success();
    }


    #[Route('/update', name: 'update')]
    public function updaterole(): JsonResponse
    {
        $data = $this->functions->jsondecode();
        if (!isset($data->intitule, $data->roles))
            return $this->functions->error(ErrorHttp::MSG_FORM_INVALID);

        $app_roles = [];
        foreach ($data->roles as $roleItem) {
            if (in_array($roleItem, Vars::ROLES))
                $app_roles[] = $roleItem;
        }
        $role = (new TRole())->setLibelle($data->intitule)
            ->setRoles($app_roles);

        $this->functions->em()->persist($role);
        $this->functions->em()->flush();

        $this->functions->log(['action' => __METHOD__, 'fk_login' => $this->getUser()]);
        return $this->functions->success();
    }



    #[Route('/find', name: 'find')]
    public function findrole(): JsonResponse
    {
        $data = $this->functions->jsondecode();
        if (!isset($data->intitule, $data->roles))
            return $this->functions->error(ErrorHttp::MSG_FORM_INVALID);

        $app_roles = [];
        foreach ($data->roles as $roleItem) {
            if (in_array($roleItem, Vars::ROLES))
                $app_roles[] = $roleItem;
        }
        $role = (new TRole())->setLibelle($data->intitule)
            ->setRoles($app_roles);

        $this->functions->em()->persist($role);
        $this->functions->em()->flush();

        $this->functions->log(['action' => __METHOD__, 'fk_login' => $this->getUser()]);
        return $this->functions->success();
    }


    #[Route('/delete', name: 'delete')]
    public function deleterole(): JsonResponse
    {
        $data = $this->functions->jsondecode();
        if (!isset($data->intitule, $data->roles))
            return $this->functions->error(ErrorHttp::MSG_FORM_INVALID);

        $app_roles = [];
        foreach ($data->roles as $roleItem) {
            if (in_array($roleItem, Vars::ROLES))
                $app_roles[] = $roleItem;
        }
        $role = (new TRole())->setLibelle($data->intitule)
            ->setRoles($app_roles);

        $this->functions->em()->persist($role);
        $this->functions->em()->flush();

        $this->functions->log(['action' => __METHOD__, 'fk_login' => $this->getUser()]);
        return $this->functions->success();
    }




}
