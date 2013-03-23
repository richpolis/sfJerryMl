<?php

/**
 * PublicacionesGaleria
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    JerryML
 * @subpackage model
 * @author     Dioner911
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
class PublicacionesGaleria extends BasePublicacionesGaleria
{
    public function getThumbnailValid(){
        $elsefile='';
        switch($this->getTipoArchivo()){
            case PublicacionesGaleriaTable::$tipos_archivos['Link']:
                return $this->getThumbnail();
                break;
            case PublicacionesGaleriaTable::$tipos_archivos['Imagen']:
                $elsefile='sin_imagen_galeria.jpg';
                $file=$this->getThumbnail();
                if($file!=""){
                    if(file_exists(sfConfig::get('sf_upload_dir').'/publicaciones/thumbnails/'.$file)){
                        return "http://".$_SERVER['HTTP_HOST'].'/uploads/publicaciones/thumbnails/'.$file;
                    }elseif(file_exists(sfConfig::get('sf_upload_dir').'/publicaciones/'.$this->getArchivo())){
                        $thumbnail=sfRichSys::crearThumbnailGaleria(sfConfig::get('sf_upload_dir').'/publicaciones/',$this->getArchivo(),false);
                        $this->setThumbnail($thumbnail);
                        parent::save();
                        return "http://".$_SERVER['HTTP_HOST'].'/uploads/publicaciones/thumbnails/'.$this->getThumbnail();
                    }
                }else{
                    if($elsefile=='')$elsefile='sin_video_galeria.jpg';
                    return "http://".$_SERVER['HTTP_HOST'].'/uploads/'.$file;
                }
                
            case PublicacionesGaleriaTable::$tipos_archivos['Video']:
                $file=$this->getThumbnail();
                if(file_exists(sfConfig::get('sf_upload_dir').'/publicaciones/thumbnails/'.$file)){
                    return "http://".$_SERVER['HTTP_HOST'].'/uploads/publicaciones/thumbnails/'.$file;
                }else{
                    if($elsefile=='')$elsefile='sin_video_galeria.jpg';
                    return "http://".$_SERVER['HTTP_HOST'].'/uploads/'.$file;
                }
                
                break;
        }
    }
    public function getArchivoValid(){
        $elsefile='';
        switch($this->getTipoArchivo()){
            case PublicacionesGaleriaTable::$tipos_archivos['Link']:
                return $this->getArchivo();
                break;
            case PublicacionesGaleriaTable::$tipos_archivos['Imagen']:
                $elsefile='sin_imagen_galeria.jpg';
            case PublicacionesGaleriaTable::$tipos_archivos['Video']:
                $file=$this->getArchivo();
                if(file_exists(sfConfig::get('sf_upload_dir').'/publicaciones/'.$file)){
                return "http://".$_SERVER['HTTP_HOST'].'/uploads/publicaciones/'.$file;
                }else{
                    if($elsefile=='')$elsefile='sin_video_galeria.jpg';
                    return "http://".$_SERVER['HTTP_HOST'].'/uploads/'.$file;
                }
                
                break;
        }
    }
    
    /*
     * Para crear la ruta para render la imagen
     * /imagenes/:path/:width/:heigth/:imagen.:sf_format
     */
    public function getRenderImagen($width,$height){
        $elsefile='';
        switch($this->getTipoArchivo()){
            case PublicacionesGaleriaTable::$tipos_archivos['Link']:
                return $this->getThumbnail();
                break;
            case PublicacionesGaleriaTable::$tipos_archivos['Imagen']:
                $elsefile='sin_imagen_galeria.jpg';
            case PublicacionesGaleriaTable::$tipos_archivos['Video']:
                $file=$this->getArchivo();
                if(file_exists(sfConfig::get('sf_upload_dir').'/publicaciones/'.$file)){
                    return '/imagenes/publicaciones/'.$width.'/'.$height.'/'.$file;
                }else{
                    if($elsefile=='')$elsefile='sin_video_galeria.jpg';
                    return '/imagenes/publicaciones/'.$width.'/'.$height.'/'.$elsefile;
                }
                
                break;
        }
    }
    
    
    public function getHtmlThumbnail(){
            return sprintf(<<<EOF
<div class="contenedor-archivo-galeria"> 
<a href="%s" rel="prettyPhoto[pp_gal]">
<img src="%s" />
</a>
</div>                    
EOF
    ,$this->getArchivoValid(),$this->getThumbnailValid());


     }
     
    public function getTituloCorto($max=15){
        return sfRichSys::cut_string($this->getTitulo(),$max);
    }
    public function getTituloCortoBackend($max=15){
        return substr($this->getTitulo(),0,$max);
    }
     
    public function getContenidoCorto($max=15){
        $texto=strip_tags($this->getContenido());
        return sfRichSys::cut_string($texto,$max);
    }
    
    
     public function  delete(Doctrine_Connection $conn = null) {
         $file=$this->getArchivo();
         $thumbnail=$this->getThumbnail();
         if(file_exists(sfConfig::get('sf_upload_dir').'/publicaciones/'.$file)){
                unlink(sfConfig::get('sf_upload_dir').'/publicaciones/'.$file);
         }
         if(file_exists(sfConfig::get('sf_upload_dir').'/publicaciones/thumbnails/'.$thumbnail)){
                unlink(sfConfig::get('sf_upload_dir').'/publicaciones/thumbnails/'.$thumbnail);
         }
         parent::delete($conn);
    }
    public function save(Doctrine_Connection $conn = null) {
        $this->setTipoArchivo($this->getTipoArchivoValid());
        switch($this->getTipoArchivo()){
            case PublicacionesGaleriaTable::$tipos_archivos['Link']:
               $infoVideo=sfRichSys::getTitleAndImageVideoYoutube($this->getArchivo());
                $this->setThumbnail($infoVideo['thumbnail']);
                $this->setArchivo($infoVideo['urlVideo']);
                $this->setTitulo($infoVideo['title']);
                $this->setContenido($infoVideo['description']);
                break;
            case PublicacionesGaleriaTable::$tipos_archivos['Imagen']:
                $file=$this->getArchivo();
                if(file_exists(sfConfig::get('sf_upload_dir').'/publicaciones/'.$file)){
                        $thumbnail=sfRichSys::crearThumbnailGaleria(sfConfig::get('sf_upload_dir').'/publicaciones/',$this->getArchivo(),true);
                        $this->setThumbnail($thumbnail);
                }
                break;
            case PublicacionesGaleriaTable::$tipos_archivos['Video']:
                if(!($this->getThumbnail()=='' || $this->getThumbnail()=='sin_imagen.jpg')){
                    $thumbnail=$this->getThumbnail();
                    if(file_exists(sfConfig::get('sf_upload_dir').'/publicaciones/'.$thumbnail)){
                       $thumbnail=sfRichSys::crearThumbnailGaleria(sfConfig::get('sf_upload_dir').'/publicaciones/',$thumbnail);
                       $this->setThumbnail($thumbnail);
                    }
                }
                
                break;
        }
        
        if(!$this->getPosition()){
            $this->setPosition(Doctrine_Core::getTable('PublicacionesGaleria')->getMaximo());
        }
              
        return parent::save($conn);
    }
    public function getTipoArchivoValid(){
        $archivo=explode(".", $this->getArchivo());
        $tipos=Doctrine_Core::getTable('PublicacionesGaleria')->getTiposArchivo();
        $resp=1;
        switch ($archivo[1]){
            case "png":
            case "jpg":
            case "gif":
            case "jpeg":    
              $resp=$tipos['Imagen'];
              break;
            case "flv":
            case "mpg":
            case "mp4":
            case "avi":    
              $resp=$tipos['Video'];
              break;
            default:    
              $resp=$tipos['Link'];
              break;
        }
        return $resp;
    }
    public function getArchivoView(){
        $tipoarchivo=$this->getTipoArchivo();
        switch($tipoarchivo){
            case 'Imagen':
                $respuesta='<img src="http://'.$_SERVER['HTTP_HOST'].'/uploads/galeria/'.$this->getArchivo().'" style="max-width:600px;max-height:400px;" title="'.$this->getTitulo().'"/>';
                break;
            case 'Musica':
                $respuesta= sprintf(<<<EOF
<link href="/css/jplayer.blue.monday.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/jquery.jplayer.min.js"></script>
<script>
$(document).ready(function(){
 $("#jquery_jplayer_%s").jPlayer({
  ready: function () {
   $(this).jPlayer("setMedia", {
    mp3: "/uploads/galeria/%s",
    oga: "/uploads/galeria/sound.ogg"
   });
  },
  swfPath: "/swf",
  supplied: "mp3, oga"
 });
}); 
</script>
<div id="jquery_jplayer_%s" class="jp-jplayer"></div>
    <div id="jp_container_1" class="jp-audio">
			<div class="jp-type-single">
				<div class="jp-gui jp-interface">
					<ul class="jp-controls">
						<li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
						<li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
						<li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>
						<li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>
						<li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
						<li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li>
					</ul>
					<div class="jp-progress">
						<div class="jp-seek-bar">
							<div class="jp-play-bar"></div>
						</div>
					</div>
					<div class="jp-volume-bar">
						<div class="jp-volume-bar-value"></div>
					</div>
					<div class="jp-time-holder">
						<div class="jp-current-time"></div>
						<div class="jp-duration"></div>

						<ul class="jp-toggles">
							<li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat">repeat</a></li>
							<li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off">repeat off</a></li>
						</ul>
					</div>
				</div>
				<div class="jp-title">
					<ul>
						<li>Cro Magnon Man</li>
					</ul>
				</div>
				<div class="jp-no-solution">
					<span>Update Required</span>
					To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
				</div>
			</div>
		</div>

EOF
      ,
      $this->getId(),
      $this->getArchivo(),
      $this->getId()
                  
    );
                break;
            case 'Flash':
                $respuesta= '<object id="archivo_galeria_'.$this->getId().'" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="600" height="400"><param name="wmode" value="true" /><param name="allowfullscreen" value="false" /><param name="allowscriptaccess" value="always" /><param name="movie" value="http://'.$_SERVER['HTTP_HOST'].'/uploads/galeria/'.$this->getArchivo().'" /><embed src="http://'.$_SERVER['HTTP_HOST'].'/uploads/galeria/'.$this->getArchivo().'" type="application/x-shockwave-flash" allowfullscreen="false" allowscriptaccess="always" width="600" height="400" wmode="true"></embed></object>';
                break;
            case 'Link':
                $video_link=$this->getArchivo();
                $wVideo=560;
                $hVideo=312;
                $withLayout=0;
                if(preg_match('/youtube\.com\/watch/i',$video_link)){
                    $respuesta='<iframe src ="http://www.youtube.com/embed/'.sfRichSys::getVideoIdYoutube($video_link).'?rel=1&autoplay=0" width="$wVideo" height="$hVideo" frameborder="no"></iframe>';
                }elseif(preg_match('/vimeo\.com/i',$video_link)){
                    $regExp="/http:\/\/(www\.)?vimeo.com\/(\d+)/";
                    preg_match($regExp,$video_link,$matches);
                    $respuesta='<iframe src="http://player.vimeo.com/video/'. $matches[2].'?autoplay=0" width="560" height="312" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
                }
                break;
             case 'Video':
                $respuesta= sprintf(<<<EOF
<script type="text/javascript" src="/js/flowplayer-3.2.9.min.js"></script>
<a href="/uploads/galeria/%s"
   style="display:block;width:520px;height:330px"  
   id="player_%s"> 
</a> 
<!-- this will install flowplayer inside previous A- tag. -->
<script>
    flowplayer("player_%s", "/swf/flowplayer-3.2.10.swf");
</script>
EOF
      ,
      $this->getArchivo(),
      $this->getId(),
      $this->getId()
                  
    );
                break;
        }
        return $respuesta;
     }
}
