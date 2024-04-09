<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('', name: 'public_ctrl_')]
class PublicController extends AbstractController
{
    
    public function getUrl(): string
    {
        return $this->isGranted('ROLE_USER')? $this->generateUrl(''):($this->isGranted('ROLE_MEDECIN')?$this->generateUrl(''):$this->generateUrl('auth_ctrl_login'));
    }


    #[Route('/', name: 'home')]
    public function home(): RedirectResponse
    {
        return $this->redirect($this->getUrl());
    }
}
