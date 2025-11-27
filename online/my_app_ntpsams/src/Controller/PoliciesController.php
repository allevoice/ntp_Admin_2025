<?php

namespace App\Controller;

use App\Model\PoliciesPrivacy;
use App\Model\Teams;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route(path: '/{_locale}',requirements: ['_locale' => '%app.locales%'],name: 'app_poliices_',defaults: ['_locale' => '%app.default_locale%'])]
final class PoliciesController extends AbstractController
{
    #[Route('/policy/web', name: 'privacy_web')]
    public function index(TranslatorInterface $translator,PoliciesPrivacy $policiesPrivacy): Response
    {


        return $this->render('policies/web.html.twig', [
            'title_page_name' => $translator->trans('title_pub_policy_privacy_web').' – NTPSAMS',
            'title_page' => $translator->trans('title_pub_policy_privacy_web').' – NTPSAMS',
            'policies'=>$policiesPrivacy->webpolicies_fr(),

        ]);
    }
}
