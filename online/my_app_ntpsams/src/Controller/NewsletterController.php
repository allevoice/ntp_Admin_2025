<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


#[Route(path: '/{_locale}',requirements: ['_locale' => '%app.locales%'],name: 'app_newsletter_',defaults: ['_locale' => '%app.default_locale%'])]
class NewsletterController extends AbstractController
{
    #[Route('/newsletter', name: 'form')]
    public function index(): Response
    {

        // Rediriger vers une URL externe
//        return $this->redirect('https://squareup.com/outreach/MLSfjZ/subscribe');

        $this->addFlash(
            'success',
//            'Félicitations ! Votre inscription a été enregistrée avec succès.'
            'Congratulations! Your registration has been successfully submitted.'
        );

        // 2. REDIRECTION
        // Le message flash sera conservé DANS LA SESSION après la redirection
        return $this->redirectToRoute('app_home_ln');

    }





}
