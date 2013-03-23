<?php

require_once dirname(__FILE__).'/../lib/talentoGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/talentoGeneratorHelper.class.php';

/**
 * talento actions.
 *
 * @package    JerryML
 * @subpackage talento
 * @author     Ricardo Alcantara <richpolis@gmail.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class talentoActions extends autoTalentoActions
{
    public function executeUpload(sfWebRequest $request) {
        
        sfRichSys::setDebugMensaje('Entro a Upload Talento Galeria');
        
        
        $this->publicacion = Doctrine_Core::getTable('Talento')->find($request->getParameter("publicacion_id"));
        $this->forward404unless($this->publicacion);
        if(!$request->hasParameter('tipo_archivo')){
            // list of valid extensions, ex. array("jpeg", "xml", "bmp")
            $allowedExtensions = array("jpeg","png","gif","jpg","flv","mp4","avi","pdf");
            // max file size in bytes
            $sizeLimit = 6 * 1024 * 1024;
            $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
            $result = $uploader->handleUpload(sfConfig::get("sf_upload_dir")."/publicaciones/");
            // to pass data through iframe you will need to encode all html tags
            /*****************************************************************/
            //$file = $request->getParameter("qqfile");
            if(isset($result["success"])){
                $registro = new TalentoGaleria();
                $registro->setPublicacionId($this->publicacion->getId());
                $registro->setArchivo($result["filename"]);
                $registro->setTitulo($result["titulo"]);
                $registro->setContenido($result["contenido"]);
                unset($result["filename"],$result['original'],$result['titulo'],$result['contenido']);
                if ($registro->save()) {
                    $ok = 'success';
                }else{
                    $ok = "failed";
                }
            }
    //        echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
            return $this->renderText(htmlspecialchars(json_encode($result), ENT_NOQUOTES));
        }else{//if($request->getParameter('tipo_archivo')==2){
            sfRichSys::setDebugMensaje($request->getParameter('archivo'));
             try {
                $registro = new TalentoGaleria();
                $registro->setPublicacionId($request->getParameter('publicacion_id'));
                $registro->setArchivo($request->getParameter('archivo'));
                $registro->save();
                $list_registros=Doctrine_core::getTable('TalentoGaleria')->getGaleriaPorPublicacion($request->getParameter('publicacion_id'));
                return $this->renderPartial('photoListe', array('list_registros' => $list_registros));
             } catch(Exception $e){
                throw $e->getMessage();
             }
        }
        return $this->renderText("Publicacion ID: ".$request->getParameter('publicacion_id')." Archivo: ".$request->getParameter('archivo'));
    }
    /**
    * ajax pour definir l'ordre des photos dans une galerie
    *
    * @param sfWebRequest $request
    */
    public function executeAjaxRegistroOrder(sfWebRequest $request)
    {
        if ($request->isXmlHttpRequest()) {
            $publicacion = Doctrine_Core::getTable('Talento')->find($request->getParameter("id"));
            $registro_order = $request->getParameter('registro');
            foreach($registro_order as $order=>$id)
            {
                $registro=  Doctrine_Core::getTable('TalentoGaleria')->find($id);
                //if($registro->getPosition()!=($order+1)){
                try{
                    $registro->setPosition($order+1);
                    $registro->save();
                //}
                }catch(Exception $e){
                    return $this->renderText($e->getMessage());
                }    
            }
            $publicacion->save();
            $list_registros=Doctrine_core::getTable('TalentoGaleria')->getGaleriaPorPublicacion($publicacion->getId());
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
            $publicacion = $registro->getPublicacionId();
            $registro_id = $registro->getId();
            try{
               $registro->delete();
            }catch(Exception $e){
                return $e->getMessage();
            }

            $list_registros=Doctrine_core::getTable('TalentoGaleria')->getGaleriaPorPublicacion($publicacion);
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
            $list_registros=Doctrine_core::getTable('TalentoGaleria')->getGaleriaPorPublicacion($request->getParameter('publicacion_id'));
            return $this->renderPartial('photoListe', array('list_registros' => $list_registros));
        }else{
            $this->redirect404();
        }
    }
    public function executeNew(sfWebRequest $request)
    {
      if($request->hasParameter('categoria_id')){
            $this->getUser()->setAttribute('categoria_id',$request->getParameter('categoria_id'));
            $especial=new Talento();
            $especial->setCategoriaId($request->getParameter('categoria_id'));
            $this->form=new TalentoForm($especial);
            $this->talento = $this->form->getObject();
       }else{
            $this->form = $this->configuration->getForm();
            $this->talento = $this->form->getObject();
            
       } 
    }
    public function executeCreate(sfWebRequest $request)
    {
        try{
         if($request->hasAttribute('archivo'))
             $this->getUser()->setAttribute($request->getAttribute('archivo'));
         
            $this->form = $this->configuration->getForm();
            $this->talento = $this->form->getObject();

            $this->processForm($request, $this->form);

            $this->setTemplate('new');
        }catch(Exception $e){
            throw $e->getMessage();
        }
    }
}
