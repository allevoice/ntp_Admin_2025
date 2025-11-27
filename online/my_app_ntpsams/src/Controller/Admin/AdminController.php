<?php

namespace App\Controller\Admin;

use App\Model\Mainmodel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/admin', name: 'app_admin_')]
class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin')]
    public function index(Request $request, Session $session,Mainmodel $mainmodel): Response
    {

        //$langue =  $session->get('_locale');
        // stores an attribute for reuse during a later user request
        $session->set('_locale', 'us'); //on recupere la variable de langues et on ajoute un nouveau langues

        // gets an attribute by name
        //$foo = $session->get('foo');

        // the second argument is the value returned when the attribute doesn't exist
        //$filters = $session->get('filters', []);

        $langue =  $session->get('_locale');




        //$searchTerm = $request->query->get('q', '');
        //$currentPage = $request->query->getInt('page', 1);

        //$limite = '10';
        // 1. Appel du Service
        //$data = $mainmodel->getPaginatedItems($currentPage, $limite, $searchTerm);
        //$totalItems = $data['total'];
        $totalItems = [];

        // 2. Calcul des variables de pagination
        //$totalPages = (int) ceil($totalItems /$limite);
        $totalPages = NULL;

        // Assurer que la page actuelle est valide
        //$currentPage = max(1, min($currentPage, $totalPages > 0 ? $totalPages : 1));
        $currentPage = NULL;

        return $this->render('admin/admin/index.html.twig', [
            'titlepage' => 'Dashboard',
            'nav_link' => '',
            'items' => [],      // Les éléments de la page
//            'items' => $data['items'],      // Les éléments de la page
            'searchTerm' => [],    // Le terme de recherche
//            'searchTerm' => $searchTerm,    // Le terme de recherche
            'currentPage' => $currentPage,  // Page actuelle
            'totalPages' => $totalPages,    // Total des pages
        ]);


    }
}
