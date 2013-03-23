<?php

class CategoriasTalentoTable extends Doctrine_Table
{
    public function getCriteriaOrdenada(){
        $q=Doctrine_Query::create()
                ->from('CategoriasTalento c')
                ->where('c.is_active=?',true)
                ->orderBy('c.position asc');
        return $q;
    }
    public function getCategoriaConPublicacionesForSlug($slug){
        $q=$this->getCriteriaOrdenada();
        $q->addWhere('c.slug=?',$slug);
        $rootAlias = $q->getRootAlias();
        $q->leftJoin($rootAlias . '.Talento s');
        return $q->fetchOne();
    }
    public function getCategoriasActivas(){
        $q=$this->getCriteriaOrdenada();
        return $q->execute();
    }
    public function getCategoriaEspecialPorSlug($slug){
        $q=$this->getCriteriaOrdenada();
        $q->addWhere('c.slug=?',$slug);
        return $q->fetchOne();
    }
    public function getCategoriasConPublicaciones($aleatorias=false){
        $q=$this->getCriteriaOrdenada();
        $rootAlias = $q->getRootAlias();
        $q->leftJoin($rootAlias . '.Talento s');
        if($aleatorias){
            $q->addOrderBy('RAND()');
        }
        return $q->execute();
    }
}
