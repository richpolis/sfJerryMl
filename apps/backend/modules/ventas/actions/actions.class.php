<?php

require_once dirname(__FILE__).'/../lib/ventasGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/ventasGeneratorHelper.class.php';

/**
 * ventas actions.
 *
 * @package    JerryML
 * @subpackage ventas
 * @author     Ricardo Alcantara <richpolis@gmail.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ventasActions extends autoVentasActions
{
    public function executeUpload(sfWebRequest $request) {
        $this->ventas = Doctrine_Core::getTable('Ventas')->find($request->getParameter("ventas_id"));
        $this->forward404unless($this->ventas);
        if(!$request->hasParameter('tipo_archivo')){
            // list of valid extensions, ex. array("jpeg", "xml", "bmp")
            $allowedExtensions = array("jpeg","png","gif","jpg","swf");
            // max file size in bytes
            $sizeLimit = 6 * 1024 * 1024;
            $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
            $result = $uploader->handleUpload(sfConfig::get("sf_upload_dir")."/ventas/");
            // to pass data through iframe you will need to encode all html tags
            /*****************************************************************/
            //$file = $request->getParameter("qqfile");
            if(isset($result["success"])){
                $registro = new VentasGaleria();
                $registro->setVentasId($this->ventas->getId());
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
             $registro = new VentasGaleria();
             $registro->setVentasId($this->ventas->getId());
             $registro->setArchivo($request->getParameter('archivo'));
             $registro->save();
             $list_registros=Doctrine_core::getTable('VentasGaleria')->getGaleriaPorVentas($request->getParameter('ventas_id'));
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
            $ventas = Doctrine_Core::getTable('Ventas')->find($request->getParameter("id"));
            $registro_order = $request->getParameter('registro');
            foreach($registro_order as $order=>$id)
            {
                $registro=  Doctrine_Core::getTable('VentasGaleria')->find($id);
                //if($registro->getPosition()!=($order+1)){
                try{
                    $registro->setPosition($order+1);
                    $registro->save();
                //}
                }catch(Exception $e){
                    return $this->renderText($e->getMessage());
                }    
            }
            $ventas->save();
            $list_registros=Doctrine_core::getTable('VentasGaleria')->getGaleriaPorVentas($ventas->getId());
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
            $ventas = $registro->getVentasId();
            $registro_id = $registro->getId();
            try{
               $registro->delete();
            }catch(Exception $e){
                return $e->getMessage();
            }

            $list_registros=Doctrine_core::getTable('VentasGaleria')->getGaleriaPorVentas($ventas);
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
            $list_registros=Doctrine_core::getTable('VentasGaleria')->getGaleriaPorVentas($request->getParameter('ventas_id'));
            return $this->renderPartial('photoListe', array('list_registros' => $list_registros));
        }else{
            $this->redirect404();
        }
    }
    public function executeNew(sfWebRequest $request)
    {
      if($request->hasParameter('categoria_id')){
            $this->getUser()->setAttribute('categoria_id',$request->getParameter('categoria_id')); 
            $ventas=new Ventas();
            $ventas->setCategoriaId($request->getParameter('categoria_id'));
            $this->form=new VentasForm($ventas);
            $this->ventas = $this->form->getObject();
      }else{
            $this->form = $this->configuration->getForm();
            $this->ventas = $this->form->getObject();
      }          
    }
    
 
}

