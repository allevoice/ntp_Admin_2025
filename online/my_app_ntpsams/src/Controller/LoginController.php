<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class LoginController extends AbstractController
{
    #[Route('/{_locale}/login', requirements: ['_locale' => '%app.locales%'],name: 'app_login')]
    public function index(): Response
    {
        return $this->render('login/index.html.twig', [
            'title_page' => 'Login',
            'controller_name' => 'LoginController',
        ]);
    }



    #[Route('/{_locale}/login/auth', requirements: ['_locale' => '%app.locales%'],name: 'app_login_auth')]
    public function auth(TranslatorInterface $translator, Request $request,Session $session,Users $users): Response
    {



        dd($request->request);










        return $this->render('login/index.html.twig', [
            'controller_name' => 'LoginController',
        ]);
    }




}
