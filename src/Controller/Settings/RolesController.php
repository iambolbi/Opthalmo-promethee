<?php

namespace App\Controller\Settings;

use App\Entity\TLogin;
use App\Repository\TRoleRepository;
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

    public function __construct(TRoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository ;
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


    public function createRole(): JsonResponse
    {
        $data = $this->functions->jsondecode();
        if (!isset($data->intitule, $data->roles))
            return $this->functions->error(ErrorHttp::MSG_FORM_INVALID);

        $app_roles = [];
        foreach ($data->roles as $roleItem) {
            if (in_array($roleItem, Vars::ROLES))
                $app_roles[] = $roleItem;
        }
        $role = (new TRole())->setIntitule($data->intitule)
            ->setRoles($app_roles);

        $this->functions->em()->persist($role);
        $this->functions->em()->flush();

        $this->functions->log(['action' => __METHOD__, 'fk_login' => $this->getUser()]);
        return $this->functions->success();
    }




}
