<?php

require_once dirname(__FILE__).'/../lib/templates_newslettersGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/templates_newslettersGeneratorHelper.class.php';

/**
 * templates_newsletters actions.
 *
 * @package    JerryML
 * @subpackage templates_newsletters
 * @author     Ricardo Alcantara <richpolis@gmail.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class templates_newslettersActions extends autoTemplates_newslettersActions
{
    /**
    * AjaxReigstroOrder
    *
    * @param sfWebRequest $request
    */
    public function executeAjaxRegistroOrder(sfWebRequest $request)
    {
        if ($request->isXmlHttpRequest()) {
            $template = Doctrine_Core::getTable('TemplatesNewsletters')->find($request->getParameter("id"));
            $registro_order = $request->getParameter('registro');
            foreach($registro_order as $order=>$id)
            {
                $registro=  Doctrine_Core::getTable('PublicacionesNewsletters')->find($id);
                if($registro->getPosition()!=($order+1)){
                    try{
                        $registro->setPosition($order+1);
                        $registro->update();
                    }catch(Exception $e){
                        return $this->renderText($e->getMessage());
                    }
                }
            }
            $list_registros=Doctrine_core::getTable('PublicacionesNewsletters')->getPublicacionesPorTemplate($template->getId());
            return $this->renderPartial('photoListe', array('list_registros' =>$list_registros));
            
        }
        else {
            $this->redirect404();
        }
    }

    /**
     * AjaxRegistroDelete
     *
     * @param sfWebRequest $request
     */
    public function executeAjaxRegistroDelete(sfWebRequest $request) {
        if ($request->isXmlHttpRequest()) {
            $registro = $this->getRoute()->getObject();
            $template = $registro->getTemplateId();
            $registro_id = $registro->getId();
            try{
               $registro->delete();
            }catch(Exception $e){
                return $e->getMessage();
            }

            $list_registros=Doctrine_core::getTable('PublicacionesNewsletters')->getPublicacionesPorTemplate($template);
            return $this->renderPartial('photoListe', array('list_registros' => $list_registros));
        }
        else {
            $this->redirect404();
        }
    }

    /**
     * AjaxRegistrosLista
     *
     * @param sfWebRequest $request
     */
    public function executeAjaxRegistrosLista(sfWebRequest $request) {
        if($request->isXmlHttpRequest()) {
            $list_registros=Doctrine_core::getTable('PublicacionesNewsletters')->getPublicacionesPorTemplate($request->getParameter('template_id'));
            return $this->renderPartial('photoListe', array('list_registros' => $list_registros));
        }else{
            $this->redirect404();
        }
    }
    
    public function executePromote()
    {
      $object=Doctrine::getTable('TemplatesNewsletters')->findOneById($this->getRequestParameter('id'));
      $object->promote();
      $this->redirect("@templates_newsletters");
    }

    public function executeDemote()
    {
      $object=Doctrine::getTable('TemplatesNewsletters')->findOneById($this->getRequestParameter('id'));
      $object->demote();
      $this->redirect("@templates_newsletters");
    }
}
