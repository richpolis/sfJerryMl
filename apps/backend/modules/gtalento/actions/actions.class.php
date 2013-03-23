<?php

require_once dirname(__FILE__).'/../lib/gtalentoGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/gtalentoGeneratorHelper.class.php';

/**
 * gtalento actions.
 *
 * @package    JerryML
 * @subpackage gtalento
 * @author     Ricardo Alcantara <richpolis@gmail.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class gtalentoActions extends autoGtalentoActions
{
    /**
     * por GET
     *
     * @param sfWebRequest $request
     */
    public function executeUpdateRegistroGaleria(sfWebRequest $request) {
        if ($request->isXmlHttpRequest()) {
            try{
                $registro = Doctrine_core::getTable('TalentoGaleria')->find($request->getParameter('id'));
                $registro->setTitulo($request->getParameter('title'));
                $registro->setContenido($request->getParameter('contenido'));
                $registro->save();
            }catch(Exception $e){
                return $e->getMessage();
            }

            //return $this->renderPartial('li_galeria', array('registro' => $registro));
            $list_registros=Doctrine_core::getTable('TalentoGaleria')->getGaleriaPorPublicacion($registro->getTalento()->getId());
            return $this->renderPartial('talento/photoListe', array('list_registros' =>$list_registros));
        }
        else {
            $this->redirect404();
        }
    }
    
    public function executeNew(sfWebRequest $request)
    {
        if($request->hasParameter('publicacion_id')){
            $objeto=new TalentoGaleria();
            $objeto->setPublicacionId($request->getParameter('publicacion_id'));
            $this->form=new TalentoGaleriaForm($objeto);
            $this->talento_galeria = $this->form->getObject();
        }else{
            $this->form = $this->configuration->getForm();
            $this->talento_galeria = $this->form->getObject();
        }
    }
    
    public function executeCreate(sfWebRequest $request)
    {
        sfRichSys::setDebugMensaje('Entro a Talento Galeria Create');
        
        
        $this->form = $this->configuration->getForm();
        $this->talento_galeria = $this->form->getObject();

        sfRichSys::setDebugMensaje($this->talento_galeria->getArchivo());
        
        $this->processForm($request, $this->form);

        $this->setTemplate('new');
    }
}
