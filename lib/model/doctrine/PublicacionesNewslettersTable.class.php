<?php

class PublicacionesNewslettersTable extends Doctrine_Table
{
    static $tipos_archivos = array('Link'=>0, 'Imagen'=>1, 'Video'=>2);
    public function getTiposArchivo()
    {
        return self::$tipos_archivos;
    }
    public function getCriteriaOrdenada(){
        $q=Doctrine_Query::create()
           ->from('PublicacionesNewsletters p')
           ->orderBy('p.position asc');
        return $q;
    }
    public function getCriteriaUltimosArchivos(){
        $q=$this->getCriteriaOrdenada();
        $q->addOrderBy('p.created_at desc');
        return $q;
    }
    public function getCriteriaPorTemplate($template){
        $q=$this->getCriteriaOrdenada();
        $q->addWhere('p.template_id=?',$template);
        return $q;
    }
    public function getPublicacionesPorTemplate($template){
        $q=$this->getCriteriaPorTemplate($template);
        return $q->execute();
    }
    public function getMaximo(){
        $q=$this->getCriteriaOrdenada();
        $cmd=$q->execute();
        return $cmd->count()+1;
    }
}
