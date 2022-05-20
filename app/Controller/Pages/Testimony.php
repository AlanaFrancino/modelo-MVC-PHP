<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\Testemony as EntityTestmony;
use \WilliamCosta\DatabaseManager\Pagination;

class Testimony extends Page{

    
    private static function getTestimoniesItems($request, &$pagination)
    {
        $itens = '';

        $quantidadePaginas = EntityTestmony::getTestimonies(null, null, null, 'COUNT(*) AS qtd')->fetchObject()->qtd;

        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;
        
        $pagination = new Pagination($quantidadePaginas,$paginaAtual,3);

        $results = EntityTestmony::getTestimonies(null, 'id DESC', $pagination->getLimit());

        while($testimony = $results->fetchObject(EntityTestmony::class)){
            $itens .=  View::render('pages/testimony/item', [
                'nome'      => $testimony->nome,
                'mensagem'  => $testimony->mensagem,
                'data'      => date('d/m/Y H:i:s', strtotime($testimony->data))
            ]);
        }
        return $itens;
    }

    public static function getTestimonies($request)
    {
        //View 
        $content =  View::render('pages/Testimonies', [
            'itens'      => self::getTestimoniesItems($request, $pagination),
            'pagination' => parent::getPagination($request, $pagination),
        ]);

        //Retorna a view da pagina
        return parent::getPage('Depoimentos Teste',$content);
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return string
     */
    public static function InsereTestimonies($request)
    {
        $postVars = $request->getPostVars();
        
        $testimony = new EntityTestmony;
        $testimony->nome = $postVars['nome'];
        $testimony->mensagem = $postVars['mensagem'];

        $testimony->Cadastrar();
        //Retorna a view da pagina
        return self::getTestimonies($request);
    }
}