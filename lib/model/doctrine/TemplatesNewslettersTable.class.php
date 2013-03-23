<?php

class TemplatesNewslettersTable extends Doctrine_Table
{
    public function getTemplatesActivos(){
        $q=Doctrine_Query::create()
                ->from('TemplatesNewsletters t')
                ->where('t.is_active=?',true)
                ->orderBy('t.position asc');
        return $q->execute();
                
    }
    public function getCriteriaOrdenada(){
        $q=Doctrine_Query::create()
           ->from('TemplatesNewsletters t')
           ->orderBy('t.position asc');
        return $q;
    }
    public function getTemplateConPubliacionesForSlug($slug){
        $q=$this->getCriteriaOrdenada();
        $q->addWhere('t.slug=?',$slug);
        $rootAlias = $q->getRootAlias();
        $q->leftJoin($rootAlias . '.PublicacionesNewsletters p');
        $q->addOrderBy('p.position asc');
        return $q->fetchOne();
    }
}
