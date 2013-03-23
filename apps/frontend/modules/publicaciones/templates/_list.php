<?php use_helper('Escaping')?>

    <?php foreach($list_registros as $publicacion):?>
    <article class="publicaciones-item">
        <div class="publicaciones-item-imagen">
            <a href="<?php echo url_for('publicacion',$publicacion)?>">
                <img src="<?php echo $publicacion->getThumbnailValid()?>"/>
            </a>
        </div>
        <div class="publicaciones-item-titulo">
            <?php echo $publicacion->getTitulo()?>
        </div>
	<div class="publicaciones-item-texto">
            <?php echo $publicacion->getContenidoCorto(ESC_RAW);//echo sfRichSys::cut_string($publicacion->getContenido(ESC_RAW),150)?>    
        </div>
    </article>
    <?php endforeach;?>