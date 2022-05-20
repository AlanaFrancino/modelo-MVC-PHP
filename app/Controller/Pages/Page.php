<?php

namespace App\Controller\Pages;

use \App\Utils\View;

class Page{

  
    /**
     * Metodo responsavel por renderizar o top do site
     *
     * @return string
     */
    private static function getHeader()
    {
        return View::render('pages/Header');
    }

    /**
     * Metodo responsavel por renderizar o rodape do site
     *
     * @return string
     */
    private static function getFooter()
    {
        return View::render('pages/Footer');
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @param Pagination $pagination
     * @return string
     */
    public static function getPagination($request, $pagination)
    {
        $pages = $pagination->getPages();

        if(count($pages) <= 1) return '';

        $links = '';
        
        $url = $request->getrouter()->getCurrentUrl();

        $queryParams = $request->getQueryParams();

        foreach($pages as $page){
            $queryParams['page'] = $page['page'];

            $link = $url.'?'.http_build_query($queryParams);
            
            $links .= View::render('pages/pagination/link', [
                'page'   => $page['page'],
                'link'   => $link,
                'active' => $page['current'] ? 'active' : ''
            ]);
        }

        return View::render('pages/pagination/box', [
            'links'   => $links
        ]);
    }
  
   /**
   * Metodo responsavel por retornar o conteudo (view) da pagina padão
   *
   * @param [type] $title
   * @param [type] $content
   * @return string
   */
    public static function getPage($title,$content)
    {
        return View::render('pages/Page', [
            'title'   => $title,
            'content' => $content,
            'header'  => self::getHeader(),
            'footer'  => self::getFooter()
        ]);
    }
}