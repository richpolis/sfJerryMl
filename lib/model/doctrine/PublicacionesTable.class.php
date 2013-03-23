<?php

class PublicacionesTable extends Doctrine_Table
{
    public function getCriteriaOrdenada(){
        $q=Doctrine_Query::create()
           ->from('Publicaciones i')
           ->orderBy('i.position asc');
        return $q;
    }
    public function getCriteriaOrdenadaPorActualizacion(){
        $q=Doctrine_Query::create()
                ->from('Publicaciones i')
                ->orderBy('i.updated_at DESC');
        return $q;
    }
    public function getCriteriaUltimasPublicaciones($todas=false){
        $q=$this->getCriteriaOrdenadaPorActualizacion();
        $rootAlias = $q->getRootAlias();
        $q->leftJoin($rootAlias . '.CategoriasPublicaciones c');
        if(!$todas){
        $q->whereNotIn('c.categoria',array('Publicaciones'));
        }
        return $q;
    }
    public function getCriteriaPorCategoria($categoria){
        $q=$this->getCriteriaOrdenada();
        $q->addWhere('i.categoria_id=?',$categoria);
        $rootAlias = $q->getRootAlias();
        $q->leftJoin($rootAlias . '.CategoriasPublicaciones c');
        return $q;
    }
    public function getPublicacionConGaleria($publicacion){
        $q=$this->getCriteriaOrdenada();
        $q->addWhere('i.publicacion_id=?',$publicacion);
        $rootAlias = $q->getRootAlias();
        $q->leftJoin($rootAlias . '.PublicacionesGaleriaJerryML g');
        return $q->fetchOne();
    }
    
    public function getPublicacionesConGaleriaPorFecha($fecha_inicial,$fecha_final){
        $q=$this->getCriteriaOrdenada();
        $q->addWhere('i.updated_at BETWEEN ? to ?',array($fecha_inicial,$fecha_final));
        $rootAlias = $q->getRootAlias();
        $q->leftJoin($rootAlias . '.PublicacionesGaleria g');
        $q->addOrderBy('g.position asc');
        return $q->execute();
    }
    
    public function getPublicacionConGaleriaForSlug($slug){
        $q=$this->getCriteriaOrdenada();
        $q->addWhere('i.slug=?',$slug);
        $rootAlias = $q->getRootAlias();
        $q->leftJoin($rootAlias . '.PublicacionesGaleria g');
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
        $q=$this->getCriteriaOrdenada();   
        $rootAlias = $q->getRootAlias();
        $q->leftJoin($rootAlias . '.CategoriasPublicaciones c');
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

        $q = Doctrine_Query::create()
             ->from('Publicaciones i')   
             ->whereIn('i.id', $pks)
             ->limit(20);

        $q = Doctrine_Core::getTable('Publicaciones')->addCriteriaPublicacionesActivas($q);

        return $q->execute();
    }
    
    public function getSqlQuery($query){
        $q = Doctrine_Query::create()
             ->from('Publicaciones i')   
             ->where('i.contenido like ?', $query)
             ->orWhere('i.titulo like ?',$query)
             ->limit(20);
        $q = Doctrine_Core::getTable('Publicaciones')->addCriteriaPublicacionesActivas($q);

        return $q->execute();
    }
}