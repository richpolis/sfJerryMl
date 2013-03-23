<?php

/**
 * Talento form.
 *
 * @package    JerryML
 * @subpackage form
 * @author     Ricardo Alcantara <richpolis@gmail.com>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TalentoForm extends BaseTalentoForm
{
  public function configure()
  {
	  unset($this['created_at'], $this['updated_at']);
          $this->widgetSchema['position'] = new sfWidgetFormInputHidden();
          $this->widgetSchema['slug'] = new sfWidgetFormInputHidden();
          $this->widgetSchema['contenido'] = new sfWidgetFormTextareaTinyMCE(array(
                'width' => 500,
                'height' => 250,
          ));
          
          $this->widgetSchema['actualmente'] = new sfWidgetFormTextareaTinyMCE(array(
                'width' => 500,
                'height' => 250,
          ));
          $this->widgetSchema['thumbnail'] = new sfWidgetFormInputFileEditable(array(
                'label'     => 'Imagen',
                'file_src'  => $this->getObject()->getThumbnailValid(),
                'is_image'  => true,
                'edit_mode' => !$this->isNew(),
                'template'  => '<div><img src="'.$this->getObject()->getThumbnailValid().'" style="max-heigth:200px"/><br /><label></label>%input%<br />%delete% %delete_label%<label></label></div>',
          ));
          $this->validatorSchema['thumbnail'] = new sfValidatorFile(array(
                'required'   => false,
                'mime_types' => 'web_images',
                'path' => sfConfig::get('sf_upload_dir').'/publicaciones'
          ));
          $this->validatorSchema['pagina_web'] = new sfValidatorUrl(array('required' => false));
  }
}
