<?php use_stylesheet('prettyPhoto.css') ?>
<?php use_stylesheet('galeria.css') ?>
<?php use_javascript('jquery.prettyPhoto.js') ?>
<?php use_javascript('sfrichpolis.js') ?>
<?php use_helper('Escaping') ?>

<?php if (isset($publicacion_actual)): ?>
    <?php slot('metas-galeria') ?>
    <meta property="og:title" content="<?php echo (strlen($publicacion_actual->getTitulo()) > 0 ? $publicacion_actual->getTitulo() : 'Imagen de la pagina de JerryML.com'); ?>" />
    <meta property="og:type" content="album" />
    <meta property="og:url" content="<?php echo url_for('publicacion', $publicacion_actual) ?>" />
    <meta property="og:image" content="<?php echo $publicacion_actual->getThumbnailValid() ?>" />
    <meta property="og:site_name" content="JerryML.com" />
    <!--meta property="fb:admins" content="USER_ID1,USER_ID2"/-->
    <meta property="og:description" content="<?php echo $publicacion_actual->getContenidoCorto(50) ?>" />
    <?php end_slot() ?>
<?php endif; ?>

<h1 class="titulo-pagina-h1">
    <span class="titulo-pagina-span">
        Prensa & Notas / <?php echo $publicacion_actual->getCategoriasPublicaciones()->getCategoria(); ?> 
    </span>
</h1>

<section class="publicacion">
    <?php if (!isset($publicacion_actual)) $publicacion_actual = null; ?>
    <table>
        <tr>
            <td>
                <img id="publicacion-galeria-previous" src="/images/anterior.jpg" alt="move previous" />
            </td>
            <td>
                <div id="publicacion-galeria">
                    <?php include_partial('publicaciones/galeria', array('list_galeria' => $list_galeria)); ?>   
                </div>
            </td>
            <td>
                <img id="publicacion-galeria-next" src="/images/siguiente.jpg" alt="move next" />
            </td>
        </tr>
    </table>

    <div id="publicacion-titulo">
        <h3><?php echo $publicacion_actual->getTitulo(); ?></h3>
    </div>    
    <div class="publicacion-contenido">
        <?php echo $publicacion_actual->getContenido(ESC_RAW); ?>
    </div>
    <div style="height: 50px;">
        <div class="control-pagina-regresar" style="float: left; margin-left: 20px; width: 200px;">
            <a href="<?php echo url_for('categorias_publicaciones', $publicacion_actual->getCategoriasPublicaciones()) ?>">
                Regresar
            </a>
        </div>
        <div class="social_networks-3" style="float: right; margin-right: 20px; width: 400px;">		
            <ul class="social-networks">
                <li>
                    <a rel="external" title="facebook" target="_blank" href="http://www.facebook.com/sharer.php?u=<?php echo urlencode(url_for('publicacion', $publicacion_actual, true)) ?>&t=<?php echo $publicacion_actual->getTitulo(); ?>">
                        <span style="background:url(/images/facebook.png) no-repeat; width:26px; height:26px; display:block;"></span>
                    </a>
                </li>
                <li>
                    <a rel="external" title="twitter" href="http://twitter.com/home?status=<?php echo $sf_user->getMensajeTwitter() . urlencode(url_for('publicacion', $publicacion_actual, true)) ?>" target="_black">
                        <span style="background:url(/images/twitter.png) no-repeat; width:26px; height:26px; display:block;"></span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</section>

<script>
    $(document).ready(function(){
        $.configPrettyPhotoDark();

        var $listImagenGaleria=$("li.publicacion-galeria-item"),
        largoListGaleria=Math.ceil($listImagenGaleria.length/3)-1,
        indiceListGaleria=0,
        $controlAnterior=$("#publicacion-galeria-previous"),
        $controlSiguiente=$("#publicacion-galeria-next");

        $controlSiguiente.click(function(){
            if(indiceListGaleria<largoListGaleria){
                indiceListGaleria++;
            }
            var posicion=(indiceListGaleria*319)*3;
            $("#publicacion-galeria-content").animate({'left':'-'+posicion+'px'},"slow");
			
        });
        $controlAnterior.click(function(){
            if(indiceListGaleria  >= 1){
                indiceListGaleria--;
            }
            var posicion=(indiceListGaleria*319)*3;
            $("#publicacion-galeria-content").animate({'left':'-'+posicion+'px'},"slow");
        });
    });
     
</script>