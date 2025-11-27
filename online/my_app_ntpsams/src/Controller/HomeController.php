<?php

namespace App\Controller;

use App\Model\Carousel;
use App\Model\Mainmodel;
use App\Model\Service;
use App\Model\Teams;
use App\Model\WhyChooseUs;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Contracts\Translation\TranslatorInterface;



final class HomeController extends AbstractController
{

    #[Route(path: '/{_locale}',requirements: ['_locale' => '%app.locales%'],name: 'app_home_ln',defaults: ['_locale' => '%app.default_locale%'])]
    public function index(TranslatorInterface $translator,WhyChooseUs $whyChooseUs,Carousel $carousel,Service $service,Teams $teams): Response
    {





        //carousel information
        $carouseldata = $carousel->liste();
        $carouselimg = $carousel->mediacarousel();

        //Why choose information
        $why= $whyChooseUs->datawhy();
        $whysub= $whyChooseUs->datawhysub();

        //serives
        $data_serv = $service->service_info();


        //teams liste
        $team_data = $teams->liste();


        //dd($appSecret = $this->getParameter('kernel.secret'));
        return $this->render('home/index.html.twig', [
            'title_page_name' => $translator->trans('title_pub_page_home'),

            'why' => $why,
            'carouseles' => $carouseldata,

            'liste_carousel_image' => $carouselimg,
            'whysub' => $whysub,

            'services_data' => $data_serv,

            'teams_liste' => $team_data,
        ]);
    }





}
