<?php

class NewsletterTable extends Doctrine_Table
{
    public function getCriteriaOrdenada(){
        $q=Doctrine_Query::create()
           ->from('Newsletter i')
           ->orderBy('i.position asc');
        return $q;
    }
    public function getCriteriaUltimosRegistros(){
        $q=$this->getCriteriaOrdenada();
        $q->addOrderBy('i.created_at desc');
        return $q;
    }
    public function getCriteriaPorEmail($email){
        $q=$this->getCriteriaOrdenada();
        $q->addWhere('i.email=?',$email);
        return $q;
    }
    public function getCriteriaPorStatus($status){
        $q=$this->getCriteriaOrdenada();
        $q->addWhere('i.is_active=?',$status);
        return $q;
    }
    public function getUsuarioPorEmail($email){
        $q=$this->getCriteriaPorEmail($email);
        return $q->fetchOne();
    }
    public function getBaseDeDatos($status){
        $q=$this->getCriteriaPorStatus($status);
        return $q->execute();
    }
    public function getMaximo(){
        $q=$this->getCriteriaOrdenada();
        $cmd=$q->execute();
        return $cmd->count()+1;
    }
}
