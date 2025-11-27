<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LocaleController extends AbstractController
{
    #[Route('/change-locale/{locale}', name: 'change_locale')]
    public function changeLocale(Request $request, string $locale): Response
    {
        // 1. Stocke la nouvelle locale en session
        $request->getSession()->set('_locale', $locale);

        // 2. Récupère l'URL de la page précédente (HTTP_REFERER)
        $referer = $request->headers->get('referer');

        // 3. Redirige vers la page précédente, sinon vers la page d'accueil
        if ($referer) {
            return $this->redirect($referer);
        }

        // Si l'URL de référence n'est pas disponible, redirige vers une route sécurisée (ex: home)
        return $this->redirectToRoute('app_home'); // Remplacez 'app_home' par votre route d'accueil
    }
}
