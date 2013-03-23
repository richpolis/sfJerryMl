<?php

/**
 * ventas actions.
 *
 * @package    JerryML
 * @subpackage ventas
 * @author     Ricardo Alcantara <richpolis@gmail.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ventasActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  
  public function executeIndex(sfWebRequest $request)
  {
    $this->list_categorias=Doctrine_Core::getTable('CategoriasVentas')->findBy('slug', 'ventas');
    $this->categoria_actual=$this->list_categorias[0];
    if($this->categoria_actual){
        $q=  Doctrine_Core::getTable('Ventas')->getCriteriaPorCategoria($this->categoria_actual->getId());   
        $cuantos_registros=$q->execute()->count();   
        $this->pager = new sfDoctrinePager('Ventas',$cuantos_registros);
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
       return $this->renderPartial('ventas/list', array('pager' => $this->pager,'list_registros'=>$this->list_registros,'categoria_actual'=>$this->categoria_actual));
    }
  }
  public function executeBackstage(sfWebRequest $request)
  {
    $this->list_categorias=Doctrine_Core::getTable('CategoriasVentas')->findBy('slug', 'backstage');
    $this->categoria_actual=$this->list_categorias[0];
    if($this->categoria_actual){
        $q=  Doctrine_Core::getTable('Ventas')->getCriteriaPorCategoria($this->categoria_actual->getId());
        $cuantos_registros=$q->execute()->count();   
        $this->pager = new sfDoctrinePager('Ventas',$cuantos_registros);
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
       return $this->renderPartial('ventas/list', array('pager' => $this->pager,'list_registros'=>$this->list_registros,'categoria_actual'=>$this->categoria_actual));
    }
    $this->setTemplate('index');
  }
  
}
