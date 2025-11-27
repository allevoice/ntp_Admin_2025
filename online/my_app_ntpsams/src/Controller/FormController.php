<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;





#[Route('/{_locale}', requirements: ['_locale' => '%app.locales%'],name: 'app_form_')]
class FormController extends AbstractController
{
    #[Route('/form', name: 'liste')]
    public function index(): Response
    {
        return $this->render('form/index.html.twig', [
            'title_page' => 'Registration form',
            'controller_name' => 'FormController',
        ]);
    }
}
