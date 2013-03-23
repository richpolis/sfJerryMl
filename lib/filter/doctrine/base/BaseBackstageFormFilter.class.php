<?php

/**
 * Backstage filter form base class.
 *
 * @package    JerryML
 * @subpackage filter
 * @author     Ricardo Alcantara <richpolis@gmail.com>
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseBackstageFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'categoria_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CategoriasBackstage'), 'add_empty' => true)),
      'titulo'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'contenido'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'descripcion_corta' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'is_active'         => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'thumbnail'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'position'          => new sfWidgetFormFilterInput(),
      'created_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'slug'              => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'categoria_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('CategoriasBackstage'), 'column' => 'id')),
      'titulo'            => new sfValidatorPass(array('required' => false)),
      'contenido'         => new sfValidatorPass(array('required' => false)),
      'descripcion_corta' => new sfValidatorPass(array('required' => false)),
      'is_active'         => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'thumbnail'         => new sfValidatorPass(array('required' => false)),
      'position'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'slug'              => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('backstage_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Backstage';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'categoria_id'      => 'ForeignKey',
      'titulo'            => 'Text',
      'contenido'         => 'Text',
      'descripcion_corta' => 'Text',
      'is_active'         => 'Boolean',
      'thumbnail'         => 'Text',
      'position'          => 'Number',
      'created_at'        => 'Date',
      'updated_at'        => 'Date',
      'slug'              => 'Text',
    );
  }
}
