<?php

class ConfiguracionTable extends Doctrine_Table
{
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Configuracion');
    }
	
    public function getSeccion($seccion){
        $q=Doctrine_Query::create()
                ->from('Configuracion c')
                ->where('c.slug=?',$seccion);
        return $q->fetchOne();
    }
}
