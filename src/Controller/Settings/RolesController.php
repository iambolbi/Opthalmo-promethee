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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('roles', name: 'roles_ctrl_')]
#[IsGranted('ROLE_ADMIN')]
class RolesController extends AbstractController
{
    private TRoleRepository $roleRepository;
    private Functions $functions;

    public function __construct(TRoleRepository $roleRepository, Functions $functions)
    {
        $this->roleRepository = $roleRepository;
        $this->functions = $functions;
    }
  

    //    Affichage  des rôles
    #[Route('', name: 'roles')]
    #[Template('settings/roles.html.twig')]
    public function roles(): array
    {


        return [
           'roles' => $this->roleRepository->findBy(['state'=>true]),
           'app_roles' => Vars::ROLES
        ];
    }


    //    Creer un rôle
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


    //   Modifier un rôle
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

    //    Afficher un rôle
    #[Route('/find', name: 'find')]
    public function findrole(Request $request): JsonResponse
    {
        $id = $request->query->get('code');

        $role = $this->roleRepository->findOneBy(['id' => $id, 'state' =>  true]);
        if (!$id || !$role)
            return $this->functions->error(ErrorHttp::MSG_ROLE_NOT_FOUND, ['action' => __METHOD__, 'fk_login' => $this->getUser()]);

        $this->functions->log(['action' => __METHOD__, 'fk_login' => $this->getUser()]);
        return $this->functions->success($role->toArray());
    }

    //   Supprimer un rôle
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
