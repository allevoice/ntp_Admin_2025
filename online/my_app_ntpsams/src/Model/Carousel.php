<?php


namespace App\Model;


class Carousel extends Mainmodel
{



    public function liste()
    {
        if($this->getLocaleFromSession() =='fr'){

            $data=[
                'id'=>1,
                'title'=>'La puissance de la technologie entre vos mains pour aller plus loin.',
                'content'=>'Nous accompagnons les entreprises dans leur transformation numérique. Des solutions performantes, durables et adaptées à vos ambitions les plus élevées.',
                'urlstatuts'=>'1',
                'idimg'=>NULL,
                'urldata'=>'https://www.ntpsams.com/us/service',
                'urlname'=>'Nos Services',
                'simpleimg'=>'s2.jpeg',
            ];
            return $data;
        }else{
            $data=[
                'id'=>1,
                'title'=>'The power of technology in your hands to go further',
                'content'=>'We support businesses in their digital transformation with high-performing, sustainable solutions aligned with your highest aspirations.',
                'urlstatuts'=>'1',
                'idimg'=>NULL,
                'urldata'=>'https://www.ntpsams.com/us/service',
                'urlname'=>'We Services',
                'simpleimg'=>'s2.jpeg',
            ];
            return $data;
        }






    }


    public function mediacarousel()
    {

        return [
                    [
                        'id'=>1,
                        'start'=>'1',
                        'image'=>'s1.jpeg',
                    ],

                    [
                        'id'=>2,
                        'idcarousel'=>'1',
                        'start'=>'0',
                        'image'=>'s3.jpeg',
                    ],

                    [
                        'id'=>3,
                        'start'=>'0',
                        'image'=>'s2.jpeg',
                    ],
            ];
    }







}
