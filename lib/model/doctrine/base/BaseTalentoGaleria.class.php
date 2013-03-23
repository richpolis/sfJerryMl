<?php

/**
 * BaseTalentoGaleria
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $publicacion_id
 * @property string $titulo
 * @property text $contenido
 * @property string $tipo_archivo
 * @property string $archivo
 * @property string $thumbnail
 * @property integer $position
 * @property Talento $Talento
 * 
 * @method integer        getPublicacionId()  Returns the current record's "publicacion_id" value
 * @method string         getTitulo()         Returns the current record's "titulo" value
 * @method text           getContenido()      Returns the current record's "contenido" value
 * @method string         getTipoArchivo()    Returns the current record's "tipo_archivo" value
 * @method string         getArchivo()        Returns the current record's "archivo" value
 * @method string         getThumbnail()      Returns the current record's "thumbnail" value
 * @method integer        getPosition()       Returns the current record's "position" value
 * @method Talento        getTalento()        Returns the current record's "Talento" value
 * @method TalentoGaleria setPublicacionId()  Sets the current record's "publicacion_id" value
 * @method TalentoGaleria setTitulo()         Sets the current record's "titulo" value
 * @method TalentoGaleria setContenido()      Sets the current record's "contenido" value
 * @method TalentoGaleria setTipoArchivo()    Sets the current record's "tipo_archivo" value
 * @method TalentoGaleria setArchivo()        Sets the current record's "archivo" value
 * @method TalentoGaleria setThumbnail()      Sets the current record's "thumbnail" value
 * @method TalentoGaleria setPosition()       Sets the current record's "position" value
 * @method TalentoGaleria setTalento()        Sets the current record's "Talento" value
 * 
 * @package    JerryML
 * @subpackage model
 * @author     Ricardo Alcantara <richpolis@gmail.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseTalentoGaleria extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('talento_galeria');
        $this->hasColumn('publicacion_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('titulo', 'string', 255, array(
             'type' => 'string',
             'notnull' => false,
             'default' => '',
             'length' => 255,
             ));
        $this->hasColumn('contenido', 'text', null, array(
             'type' => 'text',
             'notnull' => false,
             'default' => '',
             ));
        $this->hasColumn('tipo_archivo', 'string', 255, array(
             'type' => 'string',
             'notnull' => false,
             'default' => 1,
             'length' => 255,
             ));
        $this->hasColumn('archivo', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('thumbnail', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'default' => 'sin_imagen.jpg',
             'length' => 255,
             ));
        $this->hasColumn('position', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Talento', array(
             'local' => 'publicacion_id',
             'foreign' => 'id',
             'onDelete' => 'cascade'));
    }
}