<?php


namespace App\Model;


class Teams extends Mainmodel
{



    public function liste()
    {

        return [

            [
            'id'=>'3',
            'img'=>'jules.jpg',
            'title'=>'Jean Samuel Jules',
            'poste'=>'CEO | CTO',
            'content'=>'Defining the strategic vision and the technological roadmap. Leadership, product management, financial and technical decision-making.',
        ],
            [
                'id'=>'1',
                'img'=>'person-f-7.webp',
                'title'=>'Emma Thompson',
                'poste'=>'VP of Marketing',
                'content'=>'Growth strategist with expertise in digital marketing campaigns that drive user acquisition and brand recognition worldwide.',
            ],
            
            [
                'id'=>'1',
                'img'=>'max.jpg',
                'title'=>'Hubens K. Maxime',
                'poste'=>'Design | Administrator',
                'content'=>'Creating the visual identity (branding) and ensuring an optimal user experience (UX). Proficiency in design tools (Figma, Adobe XD, Adobe Suite).',
            ],
            [
                'id'=>'2',
                'img'=>'person-f-4.webp',
                'title'=>'Lisa Park',
                'poste'=>'Customer Success Lead',
                'content'=>'Dedicated to ensuring every customer achieves their goals through personalized support and strategic guidance.',
            ],

            [
                'id'=>'1',
                'img'=>'joseph.jpg',
                'title'=>'Rodney Joseph',
                'poste'=>'Web Developer',
                'content'=>'Designing, developing, and maintaining web applications. Proficiency in back-end (e.g., PHP, Python, Node.js) and front-end languages (HTML, CSS, JavaScript, Frameworks).',
            ],




        ];


    }






}
