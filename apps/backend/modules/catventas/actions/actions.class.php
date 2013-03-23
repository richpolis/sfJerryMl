<?php

require_once dirname(__FILE__).'/../lib/catventasGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/catventasGeneratorHelper.class.php';

/**
 * catventas actions.
 *
 * @package    JerryML
 * @subpackage catventas
 * @author     Ricardo Alcantara <richpolis@gmail.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class catventasActions extends autoCatventasActions
{
    /**
    * ajax pour definir l'ordre des photos dans une galerie
    *
    * @param sfWebRequest $request
    */
    public function executeAjaxRegistroOrder(sfWebRequest $request)
    {
        if ($request->isXmlHttpRequest()) {
            $categoria = Doctrine_Core::getTable('CategoriasVentas')->find($request->getParameter("id"));
            $registro_order = $request->getParameter('registro');
            foreach($registro_order as $order=>$id)
            {
                $registro=  Doctrine_Core::getTable('Ventas')->find($id);
                //if($registro->getPosition()!=($order+1)){
                try{
                    $registro->setPosition($order+1);
                    $registro->update();
                //}
                }catch(Exception $e){
                    return $this->renderText($e->getMessage());
                }    
            }
            $list_registros=Doctrine_core::getTable('Ventas')->getVentasPorCategoria($categoria->getId());
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

            $list_registros=Doctrine_core::getTable('Ventas')->getVentasPorCategoria($category);
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
            $list_registros=Doctrine_core::getTable('Ventas')->getVentasPorCategoria($request->getParameter('categoria_id'));
            return $this->renderPartial('photoListe', array('list_registros' => $list_registros));
        }else{
            $this->redirect404();
        }
    }
    
   

    
}


