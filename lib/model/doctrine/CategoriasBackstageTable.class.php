<?php

class CategoriasBackstageTable extends Doctrine_Table
{
    public function getCategoriasActivas(){
        $q=Doctrine_Query::create()
                ->from('CategoriasBackstage c')
                ->where('c.is_active=?',true)
                ->orderBy('c.position asc');
        return $q->execute();
                
    }
    
   
}
