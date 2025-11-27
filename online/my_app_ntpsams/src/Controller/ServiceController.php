<?php

namespace App\Controller;

use App\Model\Service;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route(path: '/{_locale}',requirements: ['_locale' => '%app.locales%'],name: 'app_service_',defaults: ['_locale' => '%app.default_locale%'])]
final class ServiceController extends AbstractController
{
    #[Route('/service', name: 'liste')]
    public function index(TranslatorInterface $translator,Service $service): Response
    {


        $data_serv = $service->service_info();
        $service_liste = $service->liste_service_all();
        $m_liste = $service->liste_projet_t();


        return $this->render('service/index.html.twig', [
            'title_page_name' => $translator->trans('title_pub_page_service'),
            'title_page' => $translator->trans('title_pub_page_service'),

            'services_data' => $data_serv,
            'services_liste_all' => $service_liste,
            'm_liste' => $m_liste,
        ]);
    }




    #[Route('/service/detail/{id}/{cmd}', name: 'detail_page')]
    public function detailAction(Request $request,TranslatorInterface $translator,Service $service): Response
    {


        $id = (string)$request->attributes->get('id');
        $cmd = (string)$request->attributes->get('cmd');


        if ($cmd == '1') {
            //service == cmd = 1
            $filteredArray_data = array_filter($service->liste_service_array_info(), function ($item) use ($id) {
                return $item['id'] === $id;
            });
        } else {
            //service == cmd = 2
            $filteredArray_data = array_filter($service->liste_service_array(), function ($item) use ($id) {
                return $item['id'] === $id;
            });
        }


        if ($cmd == '1') {

            $media_filer = array_filter($service->media_service_header(), function ($item) use ($id) {
                return $item['id_ref'] === $id;
            });

        }else {

            $media_filer = array_filter($service->media_service(), function ($item) use ($id) {
                return $item['id_ref'] === $id;
            });
        }




        //dd(reset($filteredArray_data), $media_filer);



        return $this->render('service/details.html.twig', [
            'title_page_name' => $translator->trans('title_pub_page_service_detail'),
            'title_page' => $translator->trans('title_pub_page_service_detail'),

            'detail'=>reset($filteredArray_data),
            'media_data'=>$media_filer,
        ]);
    }












}
