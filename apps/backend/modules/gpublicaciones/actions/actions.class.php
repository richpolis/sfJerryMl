<?php

require_once dirname(__FILE__).'/../lib/gpublicacionesGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/gpublicacionesGeneratorHelper.class.php';

/**
 * gpublicaciones actions.
 *
 * @package    JerryML
 * @subpackage gpublicaciones
 * @author     Ricardo Alcantara <richpolis@gmail.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class gpublicacionesActions extends autoGpublicacionesActions
{
    protected function processForm(sfWebRequest $request, sfForm $form)
    {
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
        if ($form->isValid())
        {
        $notice = $form->getObject()->isNew() ? 'Registro fue creado correctamente.' : 'Registro fue actualizado correctamente.';

        try {
            $publicaciones_galeria = $form->save();
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

        $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $publicaciones_galeria)));

            if ($request->hasParameter('_save_and_add'))
            {
                $this->getUser()->setFlash('notice', $notice.' You can add another one below.');

                $this->redirect('@publicaciones_galeria_new');
            }
            else
            {
                $this->getUser()->setFlash('notice', $notice);

                $this->redirect(array('sf_route' => 'publicaciones_galeria_edit', 'sf_subject' => $publicaciones_galeria));
            }
        }
        else
        {
        $this->getUser()->setFlash('error', 'The item has not been saved due to some errors.', false);
        }
    }
    
    /**
     * por GET
     *
     * @param sfWebRequest $request
     */
    public function executeUpdateRegistroGaleria(sfWebRequest $request) {
        if ($request->isXmlHttpRequest()) {
            try{
                $registro = Doctrine_core::getTable('PublicacionesGaleria')->find($request->getParameter('id'));
                $registro->setTitulo($request->getParameter('title'));
                $registro->setContenido($request->getParameter('contenido'));
                $registro->save();
            }catch(Exception $e){
                return $e->getMessage();
            }

            //return $this->renderPartial('li_galeria', array('registro' => $registro));
            $list_registros=Doctrine_core::getTable('PublicacionesGaleria')->getGaleriaPorPublicacion($registro->getPublicaciones()->getId());
            return $this->renderPartial('publicaciones/photoListe', array('list_registros' =>$list_registros));
        }
        else {
            $this->redirect404();
        }
    }
    public function executeNew(sfWebRequest $request)
    {
        if($request->hasParameter('publicacion_id')){
            $objeto=new PublicacionesGaleria();
            $objeto->setPublicacionId($request->getParameter('publicacion_id'));
            $this->form=new PublicacionesGaleriaForm($objeto);
            $this->publicaciones_galeria = $this->form->getObject();
        }else{
            $this->form = $this->configuration->getForm();
            $this->publicaciones_galeria = $this->form->getObject();
        }
    }
}
