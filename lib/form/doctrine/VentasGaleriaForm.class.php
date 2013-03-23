<?php

/**
 * VentasGaleria form.
 *
 * @package    JerryML
 * @subpackage form
 * @author     Dioner911
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class VentasGaleriaForm extends BaseVentasGaleriaForm
{
  public function configure()
  {
      $this->widgetSchema['tipo_archivo'] = new sfWidgetFormInputHidden();
      $this->widgetSchema['position'] = new sfWidgetFormInputHidden();
      if(!$this->isNew()){
        $this->widgetSchema['contenido'] = new sfWidgetFormTextareaTinyMCE(array(
                    'width' => 500,
                    'height' => 250,
        ));
        $tipos=Doctrine_Core::getTable('VentasGaleria')->getTiposArchivo();
        $tipo=$this->getObject()->getTipoArchivoValid();
        switch($tipo){
            case $tipos['Imagen']:
                $this->setConfigImagen();
                break;
            case $tipos['Link']:
                $this->setConfigLink();
                break;
            case $tipos['Musica']:
                $this->setConfigLink();
                break;
            default:
                $this->setConfigArchivoSimple();
            }
      }else{
         $this->widgetSchema['contenido']= new sfWidgetFormInputHidden();
         $this->widgetSchema['titulo']= new sfWidgetFormInputHidden();
      }
      
      $this->widgetSchema['thumbnail'] = new sfWidgetFormInputFileEditable(array(
        'label'     => 'Miniatura',
        'file_src'  => $this->getObject()->getThumbnailValid(),
        'is_image'  => true,
        'edit_mode' => !$this->isNew(),
        'template'  => '<div><img src="'.$this->getObject()->getThumbnailValid().'" style="max-heigth:200px"/><br /><label></label>%input%<br />%delete% %delete_label%<label></label></div>',
      ));
      $this->validatorSchema['thumbnail'] = new sfValidatorFile(array(
        'required'   => false,
        'mime_types' => 'web_images',
        'path' => sfConfig::get('sf_upload_dir').'/ventas/thumbnails'
      ));
  }
  
  public function setConfigImagen(){
    $this->widgetSchema['archivo'] = new sfWidgetFormInputFileEditable(array(
        'label'     => 'Imagen',
        'file_src'  => '/uploads/ventas/'.$this->getObject()->getArchivo(),
        'is_image'  => true,
        'edit_mode' => !$this->isNew(),
        'template'  => '<div><img src="/uploads/ventas/'.$this->getObject()->getArchivo().'" style="max-heigth:400px"/><br /><label></label>%input%<br />%delete% %delete_label%<label></label></div>',
    ));
    $this->validatorSchema['archivo'] = new sfValidatorFile(array(
        'required'   => false,
        'mime_types' => 'web_images',
        'path' => sfConfig::get('sf_upload_dir').'/ventas'
    ));
  }
  public function setConfigLink(){
    $preview=$this->getObject()->getArchivoView();  
    $this->widgetSchema['archivo'] = new sfWidgetFormInputFileEditable(array(
    'label'     => 'Flash',
    'file_src'  => '/uploads/ventas/'.$this->getObject()->getArchivo(),
    'is_image'  => false,
    'edit_mode' => !$this->isNew(),
    'template'  => '<div><div >'.$preview.'</div><br/><label></label>%input%<br />%delete% %delete_label%<label></label></div>',
    ));
    $this->validatorSchema['archivo'] = new sfValidatorFile(array(
    'required'   => false,
    'path' => sfConfig::get('sf_upload_dir').'/ventas'
    ));
  }
  public function setConfigArchivoSimple(){
        $this->widgetSchema['archivo'] = new sfWidgetFormInputFile(array(
        'label' => 'Archivo',
        ));
        $this->validatorSchema['archivo'] = new sfValidatorFile(array(
        'required'   => false,
        'path'       => sfConfig::get('sf_upload_dir').'/ventas',
        ));
  }
}