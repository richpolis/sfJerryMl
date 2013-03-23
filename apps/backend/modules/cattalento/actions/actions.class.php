<?php

require_once dirname(__FILE__).'/../lib/cattalentoGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/cattalentoGeneratorHelper.class.php';

/**
 * cattalento actions.
 *
 * @package    JerryML
 * @subpackage cattalento
 * @author     Ricardo Alcantara <richpolis@gmail.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class cattalentoActions extends autoCattalentoActions
{
	/**
    * ajax pour definir l'ordre des photos dans une galerie
    *
    * @param sfWebRequest $request
    */
    public function executeAjaxRegistroOrder(sfWebRequest $request)
    {
        if ($request->isXmlHttpRequest()) {
            $categoria = Doctrine_Core::getTable('CategoriasTalento')->find($request->getParameter("id"));
            $registro_order = $request->getParameter('registro');
            foreach($registro_order as $order=>$id)
            {
                $registro=  Doctrine_Core::getTable('Talento')->find($id);
                //if($registro->getPosition()!=($order+1)){
                try{
                    $registro->setPosition($order+1);
                    $registro->update();
                //}
                }catch(Exception $e){
                    return $this->renderText($e->getMessage());
                }    
            }
            $list_registros=Doctrine_core::getTable('Talento')->getPublicacionesPorCategoria($categoria->getId());
            return $this->renderPartial('photoListe', array('list_registros' =>$list_registros));
            
        }
        else {
            $this->redirect404();
        }
    }


    /**
     * ajax pour effacer une photo
     *
     * @param sfWebRequest $request
     */
    public function executeAjaxRegistroDelete(sfWebRequest $request) {
        if ($request->isXmlHttpRequest()) {
            $registro = $this->getRoute()->getObject();
            $category = $registro->getCategoriaId();
            $registro_id = $registro->getId();
            try{
               $registro->delete();
            }catch(Exception $e){
                return $e->getMessage();
            }

            $list_registros=Doctrine_core::getTable('Talento')->getPublicacionesPorCategoria($category);
            return $this->renderPartial('photoListe', array('list_registros' => $list_registros));
        }
        else {
            $this->redirect404();
        }
    }

    /**
     * ajax pour avoir la liste des photos
     *
     * @param sfWebRequest $request
     */
    public function executeAjaxRegistrosLista(sfWebRequest $request) {
        if($request->isXmlHttpRequest()) {
            $list_registros=Doctrine_core::getTable('Talento')->getPublicacionesPorCategoria($request->getParameter('categoria_id'));
            return $this->renderPartial('photoListe', array('list_registros' => $list_registros));
        }else{
            $this->redirect404();
        }
    }
    
    public function executePromote()
    {
      $object=Doctrine::getTable('CategoriasTalento')->findOneById($this->getRequestParameter('id'));

      $object->promote();
      $this->redirect("@categorias_talento");
    }

    public function executeDemote()
    {
          $object=Doctrine::getTable('CategoriasTalento')->findOneById($this->getRequestParameter('id'));

          $object->demote();
          $this->redirect("@categorias_talento");
    }
}
