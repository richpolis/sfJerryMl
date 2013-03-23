<?php

/**
 * BaseMovimientosNewsletters
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property date $fecha_enviados
 * @property integer $cuantos_enviados
 * 
 * @method date                   getFechaEnviados()    Returns the current record's "fecha_enviados" value
 * @method integer                getCuantosEnviados()  Returns the current record's "cuantos_enviados" value
 * @method MovimientosNewsletters setFechaEnviados()    Sets the current record's "fecha_enviados" value
 * @method MovimientosNewsletters setCuantosEnviados()  Sets the current record's "cuantos_enviados" value
 * 
 * @package    JerryML
 * @subpackage model
 * @author     Ricardo Alcantara <richpolis@gmail.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseMovimientosNewsletters extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('movimientos_newsletters');
        $this->hasColumn('fecha_enviados', 'date', null, array(
             'type' => 'date',
             'notnull' => false,
             ));
        $this->hasColumn('cuantos_enviados', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => false,
             'default' => 0,
             'length' => 4,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}