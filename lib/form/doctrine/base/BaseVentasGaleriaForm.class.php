<?php

/**
 * VentasGaleria form base class.
 *
 * @method VentasGaleria getObject() Returns the current form's model object
 *
 * @package    JerryML
 * @subpackage form
 * @author     Ricardo Alcantara <richpolis@gmail.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseVentasGaleriaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'ventas_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Ventas'), 'add_empty' => true)),
      'titulo'       => new sfWidgetFormInputText(),
      'contenido'    => new sfWidgetFormInputText(),
      'tipo_archivo' => new sfWidgetFormInputText(),
      'archivo'      => new sfWidgetFormInputText(),
      'thumbnail'    => new sfWidgetFormInputText(),
      'position'     => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'ventas_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Ventas'), 'required' => false)),
      'titulo'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'contenido'    => new sfValidatorPass(array('required' => false)),
      'tipo_archivo' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'archivo'      => new sfValidatorString(array('max_length' => 255)),
      'thumbnail'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'position'     => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('ventas_galeria[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'VentasGaleria';
  }

}
