<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/admin', name: 'app_admin_')]
class RoleController extends AbstractController
{
    #[Route('/role', name: 'role')]
    public function index(): Response
    {

        return $this->render('admin/role/index.html.twig', [
            'nav_link' => 'components-nav',
            'titlepage' => 'Roles',

        ]);
    }


    #[Route('/role/new', name: 'role_new')]
    public function new(): Response
    {
        return $this->render('admin/role/new.html.twig', [
            'nav_link' => 'components-nav',
            'titlepage' => 'Roles New',
        ]);
    }










}
