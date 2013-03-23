<?php

/**
 * PublicacionesNewsletters filter form base class.
 *
 * @package    JerryML
 * @subpackage filter
 * @author     Ricardo Alcantara <richpolis@gmail.com>
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasePublicacionesNewslettersFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'template_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TemplatesNewsletters'), 'add_empty' => true)),
      'titulo'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'contenido'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'tipo_archivo' => new sfWidgetFormFilterInput(),
      'archivo'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'thumbnail'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'is_active'    => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'position'     => new sfWidgetFormFilterInput(),
      'created_at'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'slug'         => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'template_id'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TemplatesNewsletters'), 'column' => 'id')),
      'titulo'       => new sfValidatorPass(array('required' => false)),
      'contenido'    => new sfValidatorPass(array('required' => false)),
      'tipo_archivo' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'archivo'      => new sfValidatorPass(array('required' => false)),
      'thumbnail'    => new sfValidatorPass(array('required' => false)),
      'is_active'    => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'position'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'slug'         => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('publicaciones_newsletters_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'PublicacionesNewsletters';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'template_id'  => 'ForeignKey',
      'titulo'       => 'Text',
      'contenido'    => 'Text',
      'tipo_archivo' => 'Number',
      'archivo'      => 'Text',
      'thumbnail'    => 'Text',
      'is_active'    => 'Boolean',
      'position'     => 'Number',
      'created_at'   => 'Date',
      'updated_at'   => 'Date',
      'slug'         => 'Text',
    );
  }
}
