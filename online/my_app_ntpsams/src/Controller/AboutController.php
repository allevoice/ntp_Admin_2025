<?php

namespace App\Controller;

use App\Model\About;
use App\Model\Service;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use function Twig\string;

#[Route(path: '/{_locale}',requirements: ['_locale' => '%app.locales%'],name: 'app_about_',defaults: ['_locale' => '%app.default_locale%'])]
final class AboutController extends AbstractController
{
    #[Route('/about/{id}', name: 'home')]
    public function index(Request $request,TranslatorInterface $translator,Service $service,About $about): Response
    {

        $id=$request->attributes->get('id');




        $service_liste = $service->liste_service_all();
        $m_liste = $service->liste_projet_t();

        if($id=='1'){
            $filteredArray_data = $about->liste_about_who_info();
            //id == 1 Who we are?
            $title = $translator->trans('title_pub_page_about_who_we_are');
        }elseif($id=='2'){
            $filteredArray_data = $about->liste_about_choose_info();
            //id == 2 Why choose us?
            $title = $translator->trans('title_pub_page_about_why_choose_us');
        }else{
            //id == 3 Our Mission
            $title = $translator->trans('title_pub_page_about_our_mission');
            $filteredArray_data = $about->liste_about_mission_info();
        }


        //dd($filteredArray_data);


        return $this->render('about/index.html.twig', [
            'title_page_name' => $title,
            'title_page' => $title,


            'about_liste_all' => $filteredArray_data,

            'services_liste_all' => $service_liste,
            'm_liste' => $m_liste,

        ]);
    }

}
