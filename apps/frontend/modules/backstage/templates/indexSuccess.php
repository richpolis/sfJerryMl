<h1 class="titulo-pagina-h1">
    <span class="titulo-pagina-span">
        Backstage / Ultimas Publicaciones
    </span>
</h1>
<aside class="categorias-publicaciones-menu">
    <?php include_partial('categorias_backstage', array('categorias' => $categorias,'categoria_actual'=>$categoria_actual));?>
</aside>
<section class="publicaciones">
    <?php include_partial('list_backstage', array('pager' => $pager,'list_registros'=>$list_registros,'categoria_actual'=>$categoria_actual,'categorias'=>$categorias));?>
</section>
<div style="clear: both;"></div>

<section class="footer-section">
    <?php include_partial('paginador', array('pager' => $pager,'categoria_actual'=>$categoria_actual));?>
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
