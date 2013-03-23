<?php

/**
 * ventas actions.
 *
 * @package    JerryML
 * @subpackage talento
 * @author     Ricardo Alcantara <richpolis@gmail.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class talentoActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
      $this->categorias=  Doctrine_Core::getTable('CategoriasTalento')->getCategoriasConPublicaciones(true);
  }
  public function executeCategoria(sfWebRequest $request)
  {
    if($request->hasParameter('slug')){
       $this->list_categorias=Doctrine_Core::getTable('CategoriasTalento')->findBy('slug', $request->getParameter('slug'));
       $this->categoria_actual=$this->list_categorias[0];
    }else{
        if($this->list_categorias!=null){
            $this->categoria_actual=$this->list_categorias[0];
        }else{
            $this->categoria_actual=0;
        }
    }
    if($this->categoria_actual){
        $q=  Doctrine_Core::getTable('Talento')->getCriteriaPorCategoria($this->categoria_actual->getId());   
        //$this->cuantos_registros=$q->execute()->count();
        $this->pager = new sfDoctrinePager('Talento',50);
        $this->pager->setQuery($q);
        $this->pager->setPage($request->getParameter('page', 1));
        $this->pager->init();
        $this->list_registros=$this->pager->getResults();
    }else{
        $this->list_registros=null;
        $this->pager=null;
    }
        
    if ($request->isXmlHttpRequest())
    {
       return $this->renderPartial('talento/list', array('pager' => $this->pager,'list_registros'=>$this->list_registros,'categoria_actual'=>$this->categoria_actual));
    }
    
  }
  public function executeTalento(sfWebRequest $request)
  {
        if($request->hasParameter('slug')){
            $this->publicacion_actual=Doctrine_Core::getTable('Talento')->getPublicacionConGaleriaForSlug($request->getParameter('slug')) ;
        }
        if($this->publicacion_actual){
            $this->list_galeria=$this->publicacion_actual->getTalentoGaleria();
        }else{
            $this->list_galeria=null;
        }
  }
}
