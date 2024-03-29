<?php

class TalentoGaleriaTable extends Doctrine_Table
{
    static $tipos_archivos = array('Link'=>0, 'Imagen'=>1, 'Video'=>2,'PDF'=>3);
    public function getTiposArchivo()
    {
        
        return self::$tipos_archivos;
    }
    public function getCriteriaOrdenada(){
        $q=Doctrine_Query::create()
                ->from('TalentoGaleria i')
                ->orderBy('i.position asc');
        return $q;
    }
    public function getCriteriaUltimosArchivos(){
        $q=$this->getCriteriaOrdenada();
        $q->addOrderBy('i.created_at desc');
        return $q;
    }
    public function getCriteriaPorPublicacion($publicacion){
        $q=$this->getCriteriaOrdenada();
        $q->addWhere('i.publicacion_id=?',$publicacion);
        return $q;
    }
    public function getGaleriaPorPublicacion($publicacion){
        $q=$this->getCriteriaPorPublicacion($publicacion);
        return $q->execute();
    }
    public function getPrimerArchivoPorPublicacion($publicacion){
        $q=$this->getCriteriaPorPublicacion($publicacion);
        return $q->fetchOne();
    }
    public function getMaximo(){
        $q=$this->getCriteriaOrdenada();
        $cmd=$q->execute();
        return $cmd->count()+1;
    }
    public function retrieveBackendBackstageList(Doctrine_Query $q)
    {
     $rootAlias = $q->getRootAlias();
     $q->leftJoin($rootAlias . '.TalentoGaleria c');
     return $q;
    }
}
