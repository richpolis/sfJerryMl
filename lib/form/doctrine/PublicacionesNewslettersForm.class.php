<?php

/**
 * PublicacionesNewsletters form.
 *
 * @package    JerryML
 * @subpackage form
 * @author     Ricardo Alcantara <richpolis@gmail.com>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PublicacionesNewslettersForm extends BasePublicacionesNewslettersForm
{
  public function configure()
  {
      unset($this['created_at'], $this['updated_at']);
      $this->widgetSchema['position'] = new sfWidgetFormInputHidden();
      $this->widgetSchema['contenido'] = new sfWidgetFormTextareaTinyMCE(array(
                    'width' => 500,
                    'height' => 250,
      ));
      
      if(!$this->isNew()){
        $tipos=Doctrine_Core::getTable('PublicacionesGaleria')->getTiposArchivo();
        $tipo=$this->getObject()->getTipoArchivoValid();
        switch($tipo){
            case $tipos['Imagen']:
                $this->setConfigImagen();
                break;
            case $tipos['Link']:
                $this->setConfigLink();
                break;
            case $tipos['Video']:
                $this->setConfigLink();
                break;
            default:
                $this->setConfigArchivoSimple();
            }
      }else{
          $this->setConfigArchivoSimple();
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
        'path' => sfConfig::get('sf_upload_dir').'/newsletters/thumbnails'
      ));
  }
  
  public function setConfigImagen(){
    $this->widgetSchema['archivo'] = new sfWidgetFormInputFileEditable(array(
        'label'     => 'Imagen',
        'file_src'  => '/uploads/newsletters/'.$this->getObject()->getArchivo(),
        'is_image'  => true,
        'edit_mode' => !$this->isNew(),
        'template'  => '<div><img src="/uploads/newsletters/'.$this->getObject()->getArchivo().'" style="max-heigth:400px"/><br /><label></label>%input%<br />%delete% %delete_label%<label></label></div>',
    ));
    $this->validatorSchema['archivo'] = new sfValidatorFile(array(
        'required'   => false,
        'mime_types' => 'web_images',
        'path' => sfConfig::get('sf_upload_dir').'/newsletters'
    ));
  }
  public function setConfigLink(){
    $preview=$this->getObject()->getArchivoView();  
    $this->widgetSchema['archivo'] = new sfWidgetFormInputFileEditable(array(
    'label'     => 'Flash',
    'file_src'  => '/uploads/newsletters/'.$this->getObject()->getArchivo(),
    'is_image'  => false,
    'edit_mode' => !$this->isNew(),
    'template'  => '<div><div >'.$preview.'</div><br/><label></label>%input%<br />%delete% %delete_label%<label></label></div>',
    ));
    $this->validatorSchema['archivo'] = new sfValidatorFile(array(
    'required'   => false,
    'path' => sfConfig::get('sf_upload_dir').'/newsletters'
    ));
  }
  public function setConfigArchivoSimple(){
        $this->widgetSchema['archivo'] = new sfWidgetFormInputFile(array(
        'label' => 'Archivo',
        ));
        $this->validatorSchema['archivo'] = new sfValidatorFile(array(
        'required'   => false,
        'path'       => sfConfig::get('sf_upload_dir').'/newsletters',
        ));
  }
  
}
