<?php

namespace App\Controller;

use App\Model\Teams;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/{_locale}',requirements: ['_locale' => '%app.locales%'],name: 'app_service_',defaults: ['_locale' => '%app.default_locale%'])]
final class TeamsController extends AbstractController
{
    #[Route('/teams', name: 'app_teams')]
    public function index(Teams $teams): Response
    {


        $data = $teams->liste();




        return $this->render('teams/index.html.twig', [
            'data_team'=>$data,




        ]);
    }
}
