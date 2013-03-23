<?php

/**
 * backstage actions.
 *
 * @package    JerryML
 * @subpackage backstage
 * @author     Ricardo Alcantara <richpolis@gmail.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class backstageActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->categoria_actual=new CategoriasPublicaciones();
    $this->categoria_actual->setCategoria("Ultimas notas");
    $q=  Doctrine_Core::getTable('Backstage')->getCriteriaUltimasPublicaciones();   
    $this->pager = new sfDoctrinePager('Backstage',6);
    $this->pager->setQuery($q);
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
    $this->list_registros=$this->pager->getResults();
    
    $this->categorias = Doctrine_Core::getTable('CategoriasBackstage')->getCategoriasActivas();
    
     if ($request->isXmlHttpRequest()){
       try{
           return $this->renderPartial('backstage/list', array('pager' => $this->pager,'list_registros'=>$this->list_registros,'categoria_actual'=>$this->categoria_actual,'categorias'=>$this->categorias));
       } catch(Exception $e){
           throw $e->getMessage();
       }
    }
    
     
  } 
    
    
  public function executeCategoria(sfWebRequest $request)
  {
    $this->categorias=Doctrine_Core::getTable('CategoriasBackstage')->getCategoriasActivas();
    if($request->hasParameter('slug')){
       $this->categoria=Doctrine_Core::getTable('CategoriasBackstage')->findBy('slug', $request->getParameter('slug'));
       $this->categoria_actual=$this->categoria[0];
    }else{
        if($this->categorias!=null){
            $this->categoria_actual=$this->categorias[0];
        }else{
            $this->categoria_actual=0;
        }
    }
    if($this->categoria_actual){
        $q=  Doctrine_Core::getTable('Backstage')->getCriteriaPorCategoria($this->categoria_actual->getId());   
        $this->pager = new sfDoctrinePager('Backstage',6);
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
       return $this->renderPartial('backstage/list', array('pager' => $this->pager,'list_registros'=>$this->list_registros,'categoria_actual'=>$this->categoria_actual));
    }
    
   
  }
  public function executePublicacion(sfWebRequest $request)
  {
        if($request->hasParameter('slug')){
            $this->publicacion_actual=Doctrine_Core::getTable('Backstage')->getPublicacionConGaleriaForSlug($request->getParameter('slug')) ;
        }
        if($this->publicacion_actual){
            $this->list_galeria=$this->publicacion_actual->getBackstageGaleria();
        }else{
            $this->list_galeria=null;
        }

  }
}
