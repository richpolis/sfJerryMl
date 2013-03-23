<?php

/**
 * publicaciones actions.
 *
 * @package    JerryML
 * @subpackage publicaciones
 * @author     Dioner911
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class publicacionesActions extends sfActions
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
    $q=  Doctrine_Core::getTable('Publicaciones')->getCriteriaUltimasPublicaciones(true);   
    $this->pager = new sfDoctrinePager('Publicaciones',6);
    $this->pager->setQuery($q);
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
    $this->list_registros=$this->pager->getResults();
    
    $this->categorias = Doctrine_Core::getTable('CategoriasPublicaciones')->getCategoriasActivas();
    
     if ($request->isXmlHttpRequest()){
       try{
           return $this->renderPartial('publicaciones/list', array('pager' => $this->pager,'list_registros'=>$this->list_registros,'categoria_actual'=>$this->categoria_actual,'categorias'=>$this->categorias));
       } catch(Exception $e){
           throw $e->getMessage();
       }
    }
      
  } 
    
    
  public function executeCategoria(sfWebRequest $request)
  {
    $this->categorias=Doctrine_Core::getTable('CategoriasPublicaciones')->getCategoriasActivas();
    if($request->hasParameter('slug')){
       $this->categoria=Doctrine_Core::getTable('CategoriasPublicaciones')->findBy('slug', $request->getParameter('slug'));
       $this->categoria_actual=$this->categoria[0];
    }else{
        if($this->categorias!=null){
            $this->categoria_actual=$this->categorias[0];
        }else{
            $this->categoria_actual=0;
        }
    }
    if($this->categoria_actual){
        $q=  Doctrine_Core::getTable('Publicaciones')->getCriteriaPorCategoria($this->categoria_actual->getId());   
        $this->pager = new sfDoctrinePager('Publicaciones',6);
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
       return $this->renderPartial('publicaciones/list', array('pager' => $this->pager,'list_registros'=>$this->list_registros,'categoria_actual'=>$this->categoria_actual));
    }
    
  }
  public function executePublicacion(sfWebRequest $request)
  {
        if($request->hasParameter('slug')){
            $this->publicacion_actual=Doctrine_Core::getTable('Publicaciones')->getPublicacionConGaleriaForSlug($request->getParameter('slug')) ;
        }
        if($this->publicacion_actual){
            $this->list_galeria=$this->publicacion_actual->getPublicacionesGaleria();
        }else{
            $this->list_galeria=null;
        }
  }
  
  
  
}
