<?php

/**
 * BasePublicacionesGaleria
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
 * @property Publicaciones $Publicaciones
 * 
 * @method integer              getPublicacionId()  Returns the current record's "publicacion_id" value
 * @method string               getTitulo()         Returns the current record's "titulo" value
 * @method text                 getContenido()      Returns the current record's "contenido" value
 * @method string               getTipoArchivo()    Returns the current record's "tipo_archivo" value
 * @method string               getArchivo()        Returns the current record's "archivo" value
 * @method string               getThumbnail()      Returns the current record's "thumbnail" value
 * @method integer              getPosition()       Returns the current record's "position" value
 * @method Publicaciones        getPublicaciones()  Returns the current record's "Publicaciones" value
 * @method PublicacionesGaleria setPublicacionId()  Sets the current record's "publicacion_id" value
 * @method PublicacionesGaleria setTitulo()         Sets the current record's "titulo" value
 * @method PublicacionesGaleria setContenido()      Sets the current record's "contenido" value
 * @method PublicacionesGaleria setTipoArchivo()    Sets the current record's "tipo_archivo" value
 * @method PublicacionesGaleria setArchivo()        Sets the current record's "archivo" value
 * @method PublicacionesGaleria setThumbnail()      Sets the current record's "thumbnail" value
 * @method PublicacionesGaleria setPosition()       Sets the current record's "position" value
 * @method PublicacionesGaleria setPublicaciones()  Sets the current record's "Publicaciones" value
 * 
 * @package    JerryML
 * @subpackage model
 * @author     Ricardo Alcantara <richpolis@gmail.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasePublicacionesGaleria extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('publicaciones_galeria');
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
        $this->hasOne('Publicaciones', array(
             'local' => 'publicacion_id',
             'foreign' => 'id',
             'onDelete' => 'cascade'));
    }
}