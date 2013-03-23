<?php

/**
 * BaseNewsletter
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $nombre
 * @property text $email
 * @property boolean $is_active
 * 
 * @method string     getNombre()    Returns the current record's "nombre" value
 * @method text       getEmail()     Returns the current record's "email" value
 * @method boolean    getIsActive()  Returns the current record's "is_active" value
 * @method Newsletter setNombre()    Sets the current record's "nombre" value
 * @method Newsletter setEmail()     Sets the current record's "email" value
 * @method Newsletter setIsActive()  Sets the current record's "is_active" value
 * 
 * @package    JerryML
 * @subpackage model
 * @author     Ricardo Alcantara <richpolis@gmail.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseNewsletter extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('newsletter');
        $this->hasColumn('nombre', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('email', 'text', null, array(
             'type' => 'text',
             'notnull' => true,
             ));
        $this->hasColumn('is_active', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => false,
             'default' => true,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $timestampable0 = new Doctrine_Template_Timestampable();
        $sortable0 = new Doctrine_Template_Sortable();
        $this->actAs($timestampable0);
        $this->actAs($sortable0);
    }
}