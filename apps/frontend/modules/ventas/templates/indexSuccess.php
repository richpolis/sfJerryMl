<?php use_helper('Escaping')?>
<h1 class="titulo-pagina-h1">
    <span class="titulo-pagina-span">
        <?php echo $categoria_actual->getCategoria()?>
    </span>
</h1>
<section class="section-ventas">
    <?php foreach($list_registros as $registro):?>
    <article class="ventas-item">
        <div class="ventas-item-imagen">
            <img src="<?php echo $registro->getThumbnailValid()?>"/>
        </div>
        <div class="ventas-item-descripcion">
            <h3><?php echo $registro->getTitulo()?></h3>
            <h6 style="top: -10px;"><?php echo $registro->getCategorias()?></h6>
            <?php echo $registro->getContenido(ESC_RAW)?>
        </div>
        <div class="ventas-item-disponible-para">
            <h6>Disponible Para</h6>
            <?php echo $registro->getDisponiblePara(ESC_RAW)?>
        </div>
    </article>
    <?php endforeach;?>
    <!--article class="footer-section" style="float: left;">
        <?php //include_partial('ventas/paginador', array('pager' => $pager,'categoria_actual'=>$categoria_actual));?>
    </article-->
</section>
