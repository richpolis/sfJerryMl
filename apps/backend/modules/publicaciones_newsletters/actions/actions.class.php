<?php

require_once dirname(__FILE__).'/../lib/publicaciones_newslettersGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/publicaciones_newslettersGeneratorHelper.class.php';

/**
 * publicaciones_newsletters actions.
 *
 * @package    JerryML
 * @subpackage publicaciones_newsletters
 * @author     Ricardo Alcantara <richpolis@gmail.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class publicaciones_newslettersActions extends autoPublicaciones_newslettersActions
{
    /**
     * por GET
     *
     * @param sfWebRequest $request
     */
    public function executeUpdateTitle(sfWebRequest $request) {
        if ($request->isXmlHttpRequest()) {
            try{
                $registro = Doctrine_core::getTable('PublicacionesNewsletters')->find($request->getParameter('id'));
                $registro->setTitulo($request->getParameter('title'));
                $registro->setContenido($request->getParameter('contenido'));
                $registro->save();
            }catch(Exception $e){
                return $e->getMessage();
            }

            //return $this->renderPartial('li_galeria', array('registro' => $registro));
            $list_registros=Doctrine_core::getTable('PublicacionesNewsletters')->getPublicacionesPorTemplate($registro->getTemplatesNewsletters()->getId());
            return $this->renderPartial('templates_newsletters/photoListe', array('list_registros' =>$list_registros));
        }
        else {
            $this->redirect404();
        }
    }
    
    public function executeNew(sfWebRequest $request)
    {
        if($request->hasParameter('template_id')){
            $this->getUser()->setAttribute('template_id',$request->getParameter('template_id'));
            $objeto=new PublicacionesNewsletters();
            $objeto->setTemplateId($request->getParameter('template_id'));
            $this->form=new PublicacionesNewslettersForm($objeto);
            $this->publicaciones_newsletters = $this->form->getObject();
        }else{
            $this->form = $this->configuration->getForm();
            $this->publicaciones_newsletters = $this->form->getObject();
        }
    }
    
}
