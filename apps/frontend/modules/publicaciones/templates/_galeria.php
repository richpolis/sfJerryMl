<ul id="publicacion-galeria-content" style="width: <?php echo $list_galeria->count()*319?>px;">
    <?php foreach ($list_galeria as $galeria): ?>
     <li class="publicacion-galeria-item" style="text-align:center;">
     <a href="<?php echo $galeria->getArchivoValid()?>" title="<?php echo $galeria->getContenidoCorto(ESC_RAW)?>" rel="prettyPhoto[pp_gal]" style="padding: 0px; margin:0px;" class="image-wrap">
     <?php if($galeria->getTipoArchivo()==1):?>
        <img class="galeria-imagen" src="<?php echo $galeria->getThumbnailValid()?>" alt=""/>
        <span class="zoom-icon"></span>
     <?php elseif($galeria->getTipoArchivo()==0):?>
        <img class="galeria-imagen" src="<?php echo $galeria->getThumbnailValid()?>" alt=""/>
        <span class="video-icon"></span>
     <?php endif;?>
     </a>
     </li>
     <?php endforeach; ?>
</ul>
<!--div id="publicacion-galeria-frame">
    
    
</div-->
 