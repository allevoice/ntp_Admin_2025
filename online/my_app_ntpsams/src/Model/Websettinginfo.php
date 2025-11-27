<?php


namespace App\Model;


class Websettinginfo extends Mainmodel
{

    public function pageinfo(){
        return [
          'id'=>'1',
          'titlesite'=>'ntpsams',
          'versioncss'=>'1.2.3',
          'favory'=>'1737321753-20250119_ntpsams.png',
          'logo'=>'logo_editer.png',
          'titlesitefooter'=>'NTPSAMS-TECHNOLOGY',
        'addfull'=>'<p>02136 Massachusetts <br> Boston <br>United States</p>',
        'phone1'=>'+1 347-444-0986',
        'phone2'=>'+1 347-354-9327',
        'infomail'=>'info@ntpsams.com',
        'geomap'=>'https://www.google.com/maps/embed/v1/place?q=Massachusetts%20Boston%20United%20States%2002136&key=AIzaSyBFw0Qbyq9zTFTd-tUY6dZWTgaQzuU17R8',
//        'geomap'=>'https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q=8721%20Broadway%20Avenue,%20New%20York,%20NY%2010023+(NTPSAMS)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed',
        'timeropen'=>'Monday-Friday: 9AM - 6PM',
          'contentfooter'=>'Transform your operations with cutting-edge technology and intelligent automation. Seamlessly integrate tools, optimize processes, and achieve scalable efficiency across your enterprise.',


            'right_year'=>'2018',
            'right_title'=>'NTPSAMS-TECHNOLOGY LLC',
            'right_design'=>'NTPSAMS-TECHNOLOGY LLC',
            'right_design_link'=>'https://ntpsams.com',



        ];
    }


    public function pagemedia(){
        return [
          [
              'id'=>'1',
              'title'=>'facebook',
              'url'=>'https://www.facebook.com/NTPSAMS',
              'icon'=>'bi bi-facebook',
          ],
            [
              'id'=>'2',
                'title'=>'instagram',
                'url'=>'https://instagram.com/ntpsams',
                'icon'=>'bi bi-instagram',
          ],
            [
              'id'=>'3',
                'title'=>'twitter',
                'url'=>'https://twitter.com/ntpsams',
                'icon'=>'bi bi-twitter-x',
          ],





        ];
    }



}
