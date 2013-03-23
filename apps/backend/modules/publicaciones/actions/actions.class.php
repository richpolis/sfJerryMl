<?php

require_once dirname(__FILE__).'/../lib/publicacionesGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/publicacionesGeneratorHelper.class.php';

/**
 * publicaciones actions.
 *
 * @package    JerryML
 * @subpackage publicaciones
 * @author     Ricardo Alcantara <richpolis@gmail.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class publicacionesActions extends autoPublicacionesActions
{
    public function executeUpload(sfWebRequest $request) {
        $this->publicacion = Doctrine_Core::getTable('Publicaciones')->find($request->getParameter("publicacion_id"));
        $this->forward404unless($this->publicacion);
        if(!$request->hasParameter('tipo_archivo')){
            // list of valid extensions, ex. array("jpeg", "xml", "bmp")
            $allowedExtensions = array("jpeg","png","gif","jpg","flv","mp4","avi");
            // max file size in bytes
            $sizeLimit = 6 * 1024 * 1024;
            $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
            $result = $uploader->handleUpload(sfConfig::get("sf_upload_dir")."/publicaciones/");
            // to pass data through iframe you will need to encode all html tags
            /*****************************************************************/
            //$file = $request->getParameter("qqfile");
            if(isset($result["success"])){
                $registro = new PublicacionesGaleria();
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
        }elseif($request->getParameter('tipo_archivo')==2){
             $registro = new PublicacionesGaleria();
             $registro->setPublicacionId($this->publicacion->getId());
             $registro->setArchivo($request->getParameter('archivo'));
             $registro->save();
             $list_registros=Doctrine_core::getTable('PublicacionesGaleria')->getGaleriaPorPublicacion($request->getParameter('publicacion_id'));
             return $this->renderPartial('photoListe', array('list_registros' => $list_registros));
             
        }
    }
    /**
    * ajax pour definir l'ordre des photos dans une galerie
    *
    * @param sfWebRequest $request
    */
    public function executeAjaxRegistroOrder(sfWebRequest $request)
    {
        if ($request->isXmlHttpRequest()) {
            $publicacion = Doctrine_Core::getTable('Publicaciones')->find($request->getParameter("id"));
            $registro_order = $request->getParameter('registro');
            foreach($registro_order as $order=>$id)
            {
                $registro=  Doctrine_Core::getTable('PublicacionesGaleria')->find($id);
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
            $list_registros=Doctrine_core::getTable('PublicacionesGaleria')->getGaleriaPorPublicacion($publicacion->getId());
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

            $list_registros=Doctrine_core::getTable('PublicacionesGaleria')->getGaleriaPorPublicacion($publicacion);
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
            $list_registros=Doctrine_core::getTable('PublicacionesGaleria')->getGaleriaPorPublicacion($request->getParameter('publicacion_id'));
            return $this->renderPartial('photoListe', array('list_registros' => $list_registros));
        }else{
            $this->redirect404();
        }
    }
    public function executeNew(sfWebRequest $request)
    {
        if($request->hasParameter('categoria_id')){
            $this->getUser()->setAttribute('categoria_id',$request->getParameter('categoria_id'));
            $publicacion=new Publicaciones();
            $publicacion->setCategoriaId($request->getParameter('categoria_id'));
            $this->form=new PublicacionesForm($publicacion);
            $this->publicaciones = $this->form->getObject();
        }else{
            $this->form = $this->configuration->getForm();
            $this->publicaciones = $this->form->getObject();
	}
    }
    public function executeUpdate(sfWebRequest $request)
    {
        $this->publicaciones = $this->getRoute()->getObject();
        $this->form = $this->configuration->getForm($this->publicaciones);
        
        $this->processForm($request, $this->form);
        
        $this->setTemplate('edit');
    }
    protected function processForm(sfWebRequest $request, sfForm $form)
    {
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
        if ($form->isValid())
        {
        $notice = $form->getObject()->isNew() ? 'The item was created successfully.' : 'The item was updated successfully.';

        try {
            $publicaciones = $form->save();
        } catch (Doctrine_Validator_Exception $e) {

            $errorStack = $form->getObject()->getErrorStack();

            $message = get_class($form->getObject()) . ' has ' . count($errorStack) . " field" . (count($errorStack) > 1 ?  's' : null) . " with validation errors: ";
            foreach ($errorStack as $field => $errors) {
                $message .= "$field (" . implode(", ", $errors) . "), ";
            }
            $message = trim($message, ', ');

            $this->getUser()->setFlash('error', $message);
            return sfView::SUCCESS;
        }

        $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $publicaciones)));

        if ($request->hasParameter('_save_and_add'))
        {
            $this->getUser()->setFlash('notice', $notice.' You can add another one below.');

            $this->redirect('@publicaciones_new');
        }
        else
        {
            $this->getUser()->setFlash('notice', $notice);

            $this->redirect(array('sf_route' => 'publicaciones_edit', 'sf_subject' => $publicaciones));
        }
        }
        else
        {
        $this->getUser()->setFlash('error', 'The item has not been saved due to some errors.', false);
        }
    }

    
 
}
