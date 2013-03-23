<?php

class myUser extends sfGuardSecurityUser
{
    public function setShowHeader($header){
        $this->setAttribute('header',$header);
    }
    public function getShowHeader(){
        return $this->getAttribute('header',1);
    }
    public function supervisarVentas(){
        if(!$this->hasAttribute('actualizacion-ventas')){
            $actualizacion=Doctrine_Core::getTable('Configuracion')->getSeccion('actualizacion-ventas');
            $fecha_actual=date('Y-m-d',time());
            if($actualizacion==null){
                $configuracion=new Configuracion();
                $configuracion->setSeccion('Actualizacion Ventas');
                $configuracion->setContenido($fecha_actual);
                $configuracion->save();
                Doctrine_Core::getTable('Ventas')->doActualizarRegistros($fecha_actual);
            }else{
                $fecha_actualizacion=$actualizacion->getUpdatedAt('Y-m-d');
                if($fecha_actualizacion<$fecha_actual){
                    Doctrine_Core::getTable('Ventas')->doActualizarRegistros($fecha_actual);
                    $actualizacion->setContenido($fecha_actual);
                    $actualizacion->setUpdatedAt($fecha_actual);
                    $actualizacion->save();
                }
            }
            $this->setAttribute('actualizacion-ventas', true);
        }
    }
    public function getImagenPrincipal(){
        //if(!$this->hasAttribute('imagen-principal')){
            $imagen_principal=Doctrine_Core::getTable('Configuracion')->getSeccion('imagen-principal');
        //    $this->setAttribute('imagen-principal', $imagen_principal);
        //}
        //return $this->getAttribute('imagen-principal');
        return $imagen_principal;    
    }
    
    public function getMensajeTwitter(){
        if(!$this->hasAttribute('mensaje-twitter')){
            $mensaje_twitter=Doctrine_Core::getTable('Configuracion')->getSeccion('mensaje-twitter');
            if(!$mensaje_twitter==null){
                $this->setAttribute('mensaje-twitter', $mensaje_twitter->getContenido());
            }else{
                $seccion=new Configuracion();
                $seccion->setSeccion('mensaje-twitter');
                $seccion->setContenido("Leyendo una excelente nota desde: ");
                $seccion->save();
                return $this->getMensajeTwitter();
            }
            
        }
        return $this->getAttribute('mensaje-twitter');
    }
    public function getCategoriaPublicacion(){
        return $this->getAttribute('categorias-publicaciones',0);
    }
    public function setCategoriaPublicacion($categoria=0){
        $this->setAttribute('categorias-publicaciones',$categoria);
    }
    public function getCategoriaEspecial(){
        return $this->getAttribute('categorias-especial',0);
    }
    public function setCategoriaEspecial($categoria=0){
        $this->setAttribute('categorias-especial',$categoria);
    }
    public function getCategoriaVentas(){
        return $this->getAttribute('categorias-ventas',0);
    }
    public function setCategoriaVentas($categoria=0){
        $this->setAttribute('categorias-ventas',$categoria);
    }
    
}
