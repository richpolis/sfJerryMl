<?php

class VentasGaleriaTable extends Doctrine_Table
{
    static $tipos_archivos = array('Link'=>0, 'Imagen'=>1, 'Swf'=>2);
    public function getTiposArchivo()
    {
        return self::$tipos_archivos;
    }
    public function getCriteriaOrdenada(){
        $q=Doctrine_Query::create()
                ->from('VentasGaleria i')
                ->orderBy('i.position asc');
        return $q;
    }
    public function getCriteriaUltimosArchivos(){
        $q=$this->getCriteriaOrdenada();
        $q->addOrderBy('i.created_at desc');
        return $q;
    }
    public function getCriteriaPorVentas($ventas){
        $q=$this->getCriteriaOrdenada();
        $q->addWhere('i.ventas_id=?',$ventas);
        return $q;
    }
    public function getGaleriaPorVentas($ventas){
        $q=$this->getCriteriaPorVentas($ventas);
        return $q->execute();
    }
    public function getPrimerArchivoPorVentas($ventas){
        $q=$this->getCriteriaPorVentas($ventas);
        return $q->fetchOne();
    }
    public function getMaximo(){
        $q=$this->getCriteriaOrdenada();
        $cmd=$q->execute();
        return $cmd->count()+1;
    }
}
