<?php

class TalentoTable extends Doctrine_Table
{
	public function getCriteriaOrdenada(){
        $q=Doctrine_Query::create()
                ->from('Talento i')
                ->orderBy('i.position asc');
        return $q;
    }
    public function getCriteriaUltimasPublicaciones(){
        $q=$this->getCriteriaOrdenada();
        $q->addOrderBy('i.created_at desc');
        $rootAlias = $q->getRootAlias();
        $q->leftJoin($rootAlias . '.CategoriasTalento c');
        return $q;
    }
    public function getCriteriaPorCategoria($categoria){
        $q=$this->getCriteriaOrdenada();
        $q->addWhere('i.categoria_id=?',$categoria);
        $rootAlias = $q->getRootAlias();
        $q->leftJoin($rootAlias . '.CategoriasTalento c');
        return $q;
    }
    public function getPublicacionConGaleria($publicacion){
        $q=$this->getCriteriaOrdenada();
        $q->addWhere('i.publicacion_id=?',$publicacion);
        $rootAlias = $q->getRootAlias();
        $q->leftJoin($rootAlias . '.TalentoGaleria g');
        $q->addOrderBy('g.position asc');
        return $q->fetchOne();
    }
    public function getPublicacionConGaleriaForSlug($slug){
        $q=$this->getCriteriaOrdenada();
        $q->addWhere('i.slug=?',$slug);
        $rootAlias = $q->getRootAlias();
        $q->leftJoin($rootAlias . '.TalentoGaleria g');
        $q->addOrderBy('g.position asc');
        return $q->fetchOne();
    }
    public function getPublicacionesPorCategoria($categoria){
        $q=$this->getCriteriaPorCategoria($categoria);
        return $q->execute();
    }
    public function addCriteriaPublicacionesActivas($q){
        $q->addWhere('i.is_active=?',true);
        return $q;
    }
    public function getMaximo(){
        $q=$this->getCriteriaOrdenada();
        $cmd=$q->execute();
        return $cmd->count()+1;
    }
    public function retrieveBackendCategoriasList(Doctrine_Query $q)
    {
     $rootAlias = $q->getRootAlias();
     $q->leftJoin($rootAlias . '.CategoriasTalento c');
     return $q;
    }
    
    public static function getLuceneIndex()
    {
        ProjectConfiguration::registerZend();

        if (file_exists($index = self::getLuceneIndexFile()))
        {
            return Zend_Search_Lucene::open($index);
        }
        else
        {
            return Zend_Search_Lucene::create($index);
        }
    }

    public static function getLuceneIndexFile()
    {
        return sfConfig::get('sf_data_dir').'/publicacion.'.sfConfig::get('sf_environment').'.index';
    }
    
    public static function getForLuceneQuery($query)
    {
        $hits = self::getLuceneIndex()->find($query);

        $pks = array();
        foreach ($hits as $hit)
        {
            $pks[] = $hit->pk;
        }

        if (empty($pks))
        {
            return array();
        }

        $q = $this->createQuery('j')
            ->whereIn('j.id', $pks)
            ->limit(20);

        $q = $this->addCriteriaPublicacionesActivas($q);

        return $q->execute();
    }
}
