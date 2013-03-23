<?php

/**
 * BaseTemplatesNewsletters
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $titulo
 * @property date $date_newsletter
 * @property string $slug
 * @property boolean $is_active
 * @property Doctrine_Collection $PublicacionesNewsletters
 * 
 * @method string               getTitulo()                   Returns the current record's "titulo" value
 * @method date                 getDateNewsletter()           Returns the current record's "date_newsletter" value
 * @method string               getSlug()                     Returns the current record's "slug" value
 * @method boolean              getIsActive()                 Returns the current record's "is_active" value
 * @method Doctrine_Collection  getPublicacionesNewsletters() Returns the current record's "PublicacionesNewsletters" collection
 * @method TemplatesNewsletters setTitulo()                   Sets the current record's "titulo" value
 * @method TemplatesNewsletters setDateNewsletter()           Sets the current record's "date_newsletter" value
 * @method TemplatesNewsletters setSlug()                     Sets the current record's "slug" value
 * @method TemplatesNewsletters setIsActive()                 Sets the current record's "is_active" value
 * @method TemplatesNewsletters setPublicacionesNewsletters() Sets the current record's "PublicacionesNewsletters" collection
 * 
 * @package    JerryML
 * @subpackage model
 * @author     Ricardo Alcantara <richpolis@gmail.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseTemplatesNewsletters extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('templates_newsletters');
        $this->hasColumn('titulo', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('date_newsletter', 'date', null, array(
             'type' => 'date',
             'notnull' => false,
             ));
        $this->hasColumn('slug', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('is_active', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => false,
             'default' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('PublicacionesNewsletters', array(
             'local' => 'id',
             'foreign' => 'template_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $sortable0 = new Doctrine_Template_Sortable();
        $sluggable0 = new Doctrine_Template_Sluggable(array(
             'fields' => 
             array(
              0 => 'titulo',
             ),
             'unique' => true,
             'canUpdate' => true,
             ));
        $this->actAs($timestampable0);
        $this->actAs($sortable0);
        $this->actAs($sluggable0);
    }
}