<?php


namespace App\Model;


class WhyChooseUs extends Mainmodel
{

    protected $table='whychoose';
    protected $id;
    private $idsub;
    private $idondersub;


    public function datawhy()
    {

        if($this->getLocaleFromSession()== 'fr'){
            $data = [
                    'id' => 1,
                    'title' => 'POURQUOI NOUS CHOISIR ?',
                    'content' => 'L\'objectif de NTPSAMS Technology est de vous donner plus que vous n\'ayez jamais eu',
                    'image' => 's1.jpeg',
                    'title_etiquet' => 'Vous aider',
                    'content_etiquet' => 'pour vos projets',
                    'title_content' => 'POURQUOI NOUS CHOISIR ?',
                    'content_content' => 'NOUS SOMMES DÉDIÉS À 100% À LA SATISFACTION CLIENT ET À UNE RELATION BÂTIE SUR LA CONFIANCE',
                ];


        }else{
            $data = [
                'id'=>1,
                'title'=>'WHY CHOOSE US?',
                'content'=>'The goal of NTPSAMS Technology is give you more than you ever had',
                'image'=>'s1.jpeg',
                'title_etiquet'=>'Help you',
                'content_etiquet'=>'for your projects',
                'title_content'=>'WHY CHOOSE US?',
                'content_content'=>'WE ARE 100% DEDICATED TO CUSTOMER SATISFACTION AND RELATIONSHIP BUILT ON TRUST',
            ];
        }

        return $data;

    }








    public function datawhysub()
    {

        if($this->getLocaleFromSession()== 'fr'){
            $data = [
                [
                    'id'=>1,
                    'title'=>'Priorité au client',
                    'content'=>'',
                    'icon'=>'bi bi-person-fill',
                ],

            ];

        }else{
            $data = [
                [
                    'id'=>1,
                    'title'=>'Customer-Focused',
                    'content'=>'',
                    'icon'=>'bi bi-person-fill',
                ],

            ];
        }


        return $data;
    }


    public function datawhyonsub()
    {


        if($this->getLocaleFromSession()== 'fr'){
            $data = [
                     [
                        'id' => 1,
                        'idref' => '1',
                        'content' => 'Nous sommes dédiés à la satisfaction client et à une relation bâtie sur la confiance.',
                    ],
                    [
                        'id' => 2,
                        'idref' => '1',
                        'content' => 'Notre équipe d\'experts adopte une approche holistique pour résoudre tous vos problèmes techniques.',
                    ],
                    [
                        'id' => 3,
                        'idref' => '1',
                        'content' => 'Nous pratiquons une surveillance étroite pour identifier presque immédiatement quand un problème survient.',
                    ],
                    [
                        'id' => '4',
                        'idref' => '1',
                        'content' => 'Nous offrons plus de communication et plus de flexibilité que les grandes agences.',
                    ],
                    [
                        'id' => '5',
                        'idref' => '1',
                        'content' => 'La chose la plus courante dont les gens se plaignent concernant les entreprises informatiques en Haïti est la difficulté à trouver un réseau informatique qui s\'adapte à vos besoins à mesure que votre entreprise se développe.',
                    ],
                    [
                        'id' => '6',
                        'idref' => '1',
                        'content' => 'Un système de gestion informatique pour optimiser vos postes de travail en fonction des besoins de vos employés. Un plan de surveillance de vos systèmes informatiques pour anticiper vos besoins technologiques et contrôler vos coûts.',
                    ],


            ];

        }else{
            $data = [
                [
                    'id'=>1,
                    'idref'=>'1',
                    'content'=>'We are dedicated to customer satisfaction and relationship built on trust.',
                ],
                [
                    'id'=>2,
                    'idref'=>'1',
                    'content'=>'Our team of experts takes a holistic approach to solving all your technical problems.',
                ],

                [
                    'id'=>3,
                    'idref'=>'1',
                    'content'=>'We practice close monitoring to identify almost immediately when a problem occurs.',
                ],

                [
                    'id'=>'4',
                    'idref'=>'1',
                    'content'=>'We provide more communication and more flexibility than larger agencies.',
                ],

                [
                    'id'=>'5',
                    'idref'=>'1',
                    'content'=>' The most common thing people are complaining about IT companies in Haiti is the hassle of finding a computer network that adapts to your needs as your business grows.',
                ],

                [
                    'id'=>'6',
                    'idref'=>'1',
                    'content'=>'An IT management system to optimize your workstations relatively to the needs of your employees. A monitoring plan of your IT systems to anticipate your technology needs and control your costs.'
                ],



            ];
        }

        return $data;



    }











}
