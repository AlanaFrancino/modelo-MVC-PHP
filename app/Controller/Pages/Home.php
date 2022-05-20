<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\Organization;

class Home extends Page{

    public static function getHome()
    {
        $obOrganization = new Organization;
        //View 
        $content =  View::render('pages/Home', [
            'nome'          => $obOrganization->name,
            'git'           => $obOrganization->git,
            'descripition'  => $obOrganization->description
        ]);

        //Retorna a view da pagina
        return parent::getPage('Home',$content);
    }
}