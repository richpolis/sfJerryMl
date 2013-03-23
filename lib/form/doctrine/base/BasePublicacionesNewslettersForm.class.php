<?php

/**
 * PublicacionesNewsletters form base class.
 *
 * @method PublicacionesNewsletters getObject() Returns the current form's model object
 *
 * @package    JerryML
 * @subpackage form
 * @author     Ricardo Alcantara <richpolis@gmail.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasePublicacionesNewslettersForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'template_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TemplatesNewsletters'), 'add_empty' => true)),
      'titulo'       => new sfWidgetFormInputText(),
      'contenido'    => new sfWidgetFormInputText(),
      'tipo_archivo' => new sfWidgetFormInputText(),
      'archivo'      => new sfWidgetFormInputText(),
      'thumbnail'    => new sfWidgetFormInputText(),
      'is_active'    => new sfWidgetFormInputCheckbox(),
      'position'     => new sfWidgetFormInputText(),
      'created_at'   => new sfWidgetFormDateTime(),
      'updated_at'   => new sfWidgetFormDateTime(),
      'slug'         => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'template_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TemplatesNewsletters'), 'required' => false)),
      'titulo'       => new sfValidatorString(array('max_length' => 255)),
      'contenido'    => new sfValidatorPass(),
      'tipo_archivo' => new sfValidatorInteger(array('required' => false)),
      'archivo'      => new sfValidatorString(array('max_length' => 255)),
      'thumbnail'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'is_active'    => new sfValidatorBoolean(array('required' => false)),
      'position'     => new sfValidatorInteger(array('required' => false)),
      'created_at'   => new sfValidatorDateTime(),
      'updated_at'   => new sfValidatorDateTime(),
      'slug'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'PublicacionesNewsletters', 'column' => array('slug')))
    );

    $this->widgetSchema->setNameFormat('publicaciones_newsletters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'PublicacionesNewsletters';
  }

}
