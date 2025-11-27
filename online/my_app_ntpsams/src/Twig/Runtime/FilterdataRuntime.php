<?php

namespace App\Twig\Runtime;


use App\Model\About;
use App\Model\Service;
use App\Model\Websettinginfo;
use App\Model\WhyChooseUs;
use Twig\Extension\RuntimeExtensionInterface;

class FilterdataRuntime implements RuntimeExtensionInterface
{
    public function __construct()
    {
        // Inject dependencies if needed
    }
//
//    public function doSomething($value)
//    {
//        // ...
//    }

    public function whyonsub($data){
        $liste = new WhyChooseUs();
        $targetIdref = (string) $data;
        $filteredArray = array_filter($liste->datawhyonsub(), function ($item) use ($targetIdref) {
            return $item['idref'] === $targetIdref;
        });
        return $filteredArray;
    }


    public function array_listename($data){
        $liste = new Service();
        $targetIdref = (string) $data;
        $filteredArray = array_filter($liste->liste_projet_t(), function ($item) use ($targetIdref) {
            return $item['id'] === $targetIdref;
        });
        return $filteredArray;
    }

    public function array_service_info_liste(){
        $liste = new Service();
        return $liste->liste_service();
    }

    public function array_media_service($data){
        $liste = new Service();
        $targetIdref = (string) $data;
        $filteredArray = array_filter($liste->media_service(), function ($item) use ($targetIdref) {
            return $item['id_ref'] === $targetIdref;
        });
        return $filteredArray;
    }

    public function array_media_about($data){
        $liste = new About();
        $targetIdref = (string) $data;
        $filteredArray = array_filter($liste->media_about(), function ($item) use ($targetIdref) {
            return $item['id_ref'] === $targetIdref;
        });
        return $filteredArray;
    }




    public function lng_dataread($value)
    {
        switch ($value) {
            case 1: $a="fr";break;
            case 2: $a= "us";break;
            case 3: $a= "en";break;

            default: $a= "empty";
        }
        return $a;
    }



    public function statuts_dataread($value)
    {
        switch ($value) {
            case 1: $a="statuts_pub";break;
            case 2: $a= "statuts_br";break;
            case 3: $a= "statuts_achv";break;

            default: $a= "empty";
        }
        return $a;
    }





    public function pageinfo(){
        $data = new Websettinginfo();
        return $data->pageinfo();
    }



    public function pageinfomedia(){
        $data = new Websettinginfo();
        return $data->pagemedia();
    }



}
