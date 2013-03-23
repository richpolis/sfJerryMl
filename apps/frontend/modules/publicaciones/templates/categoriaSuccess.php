<h1 class="titulo-pagina-h1">
    <span class="titulo-pagina-span">
        notas & prensa / <?php echo $categoria_actual->getCategoria(); ?>
    </span>
</h1>
<aside class="categorias-publicaciones-menu">
    <?php include_partial('publicaciones/categorias', array('categorias' => $categorias,'categoria_actual'=>$categoria_actual));?>
</aside>
<section class="publicaciones">
    <?php include_partial('publicaciones/list', array('pager' => $pager,'list_registros'=>$list_registros,'categoria_actual'=>$categoria_actual,'categorias'=>$categorias));?>
</section>
<div style="clear: both;"></div>

<section class="footer-section">
    <?php include_partial('publicaciones/paginador_categoria', array('pager' => $pager,'categoria_actual'=>$categoria_actual));?>
</section>
<script>
jQuery.showCategoryPage=function(urlCategoryPage){
   $("img.control-page").fadeOut('fast',function(){
     $(".contenedor-archivo-galeria").fadeOut('fast',function(){
            //$("#overlay").show('fast',function(){
                $("#preloader").show('fast')
            //});
        });
   });
    $.get(urlCategoryPage, {},
        function(data){
         $("#galeria-list").html(data);
    });
}
</script>