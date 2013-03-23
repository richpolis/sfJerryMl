<?php

class VentasTable extends Doctrine_Table
{
    public function getCriteriaOrdenada(){
        $q=Doctrine_Query::create()
           ->from('Ventas i')
           ->orderBy('i.created_at asc');
        return $q;
    }
    public function getCriteriaOrdenadaPosition(){
        $q=Doctrine_Query::create()
           ->from('Ventas i')
           ->orderBy('i.position asc');
        return $q;
    }
    
    public function getCriteriaUltimasVentas(){
        $q=Doctrine_Query::create()
           ->from('Ventas i')
           ->orderBy('i.created_at desc');
        return $q;
        
    }
    public function getCriteriaPorCategoria($categoria){
        $q=$this->getCriteriaOrdenadaPosition();
        $q->addWhere('i.categoria_id=?',$categoria);
        return $q;
    }
    public function getVentasPorCategoria($categoria){
        $q=$this->getCriteriaPorCategoria($categoria);
        return $q->execute();
    }
    public function getVentasConGaleriaForSlug($slug){
        $q=$this->getCriteriaOrdenadaPosition();
        $q->addWhere('i.slug=?',$slug);
        $rootAlias = $q->getRootAlias();
        $q->leftJoin($rootAlias . '.VentasGaleria g');
        $q->addOrderBy('g.position asc');
        return $q->fetchOne();
    }
    public function getVentas($categoria){
        $q=$this->getCriteriaOrdenadaPosition();
        $q->addWhere('i.is_active=?',true);
        $q->addWhere('i.categoria_id=?',$categoria);
        return $q->execute();
    }
    public function getListVentas(){
        $q=$this->getCriteriaOrdenadaPosition();
        $q->addWhere('i.is_active=?',true);
        return $q->execute();
    }
    public function getMaximo(){
        $q=$this->getCriteriaOrdenada();
        $cmd=$q->execute();
        return $cmd->count()+1;
    }
    public function retrieveBackendCategoriasList(Doctrine_Query $q)
    {$q=$this->getCriteriaOrdenadaPosition();
     $rootAlias = $q->getRootAlias();
     $q->leftJoin($rootAlias . '.CategoriasVentas c');
     return $q;
    }
    public function doActualizarRegistros($fecha_actual){
        $q = Doctrine_Query::create()
            ->update('Ventas p')
            ->set('p.is_active', '?', false)
            ->where('p.fecha_inicio<p.fecha_final AND p.fecha_final<? AND p.is_active=?', array($fecha_actual,true));
            $q->execute(); 
    }
}