<?php use_stylesheet("photos.css") ?>

<?php
    $app_name = $sf_context->getConfiguration()->getApplication();
    if(strcmp($sf_context->getConfiguration()->getEnvironment(),'prod') != 0)
    {$app_name .= '_'.$sf_context->getConfiguration()->getEnvironment();}
?>
<style>
#gallery { float: left; width: 100%; min-height: 12em; }
* html #gallery { height: 12em; } /* IE6 */
.gallery.custom-state-active { background: #eee; }
.gallery li { float: left; width: 96px; height: 100px; padding: 0.4em; margin: 0 0.4em 0.4em 0; text-align: center; list-style-type: none; }
.gallery li h5 { margin: 0 0 0.4em; cursor: move; font-size: small; }
.gallery li a { float: right;}
.gallery li a.ui-icon-pencil { float: left; }
.gallery li img {cursor: move; }
</style>
<script>
    function eliminar(idImg,url){
        var imagen=$("#image_"+idImg+" .basic");
        var inputText=$("#field-hidden");
        $(".image-dialog").attr({src:imagen.attr("src"),id:idImg});
        inputText.val(url);
        $( "#dialog-confirm" ).dialog( "open" );
    }

    function titularizar(idImg){
        var imagen=$("#image_"+idImg+" .basic");
        var inputText=$("#field-editable");
        $(".image-dialog").attr({src:imagen.attr("src"),id:idImg});
        inputText.val(imagen.attr("title"));
        $( "#form-editable" ).dialog( "open" );
    }
    function saveTitle(Id,Title){
        
        $.post('/<?php echo $app_name ?>.php/publicaciones/updateTitle',
            {id: Id, title: Title},
            function(data){
                $('#image-loader').show();
                $('#sf_admin_container').prepend("<div class='notice'>"+data+"</div>");
                setTimeout(function(){
                    $('#image-loader').slideUp()
                }, 1000);
            });
    }

    function ajaxRegistroEdition(url){
       $.post(url,
            {},
            function(data){
                $("#pictures_list").html(data);
            });
    }



    
    $(function() {
           <?php if($list_registros->count()>0){?>
            $("#gallery" ).sortable({
                    handle: '.basic',
                    update: function(){
                    $('#image-loader').show();
                     var order = $('#gallery').sortable('serialize');
                         //alert(order);
                     $.post('/<?php echo $app_name ?>.php/categorias/ajaxRegistroOrder?id=<?php echo $list_registros[0]->getCategoriaId();?>&'+order,
                     {},
                     function(data){
                          $("#pictures_list").html(data);
                          $('#image-loader').hide();
                     });
                     }
            });
            $( "#gallery" ).disableSelection();
        //  <?php } ?>

      $("#form-editable").dialog({
			autoOpen: false,
			height: 300,
			width: 350,
			modal: true,
			buttons: {
			"Actualizar": function() {
				 var bValid = true;
                                 var fieldTitle=$("#field-editable");
				 bValid=(fieldTitle.val().length>0 && fieldTitle.val()!="Titulo de Imagen")?true:false;
  				 if ( bValid ) {
				    saveTitle($(".image-dialog").attr("id"),
                                             $("#field-editable").val());
				     $( this ).dialog( "close" );
                                    }
                                },
                         "Cancelar": function() {
                                    $( this ).dialog( "close" );
                            }
                    }
         });
      $( "#dialog-confirm" ).dialog({
                        autoOpen: false,
			resizable: false,
			height:300,
			modal: true,
			buttons: {
				"Eliminar": function() {
					ajaxRegistroEdition($("#field-hidden").val());
				        $( this ).dialog( "close" );
				},
				Cancelar: function() {
					$( this ).dialog( "close" );
				}
			}
	});
       
     });
</script>

<?php if ($sf_user->hasFlash('ajax_notice')): ?>
  <div class="notice"><?php echo $sf_user->getFlash('ajax_notice') ?></div>
<?php endif ?>

<?php if ($sf_user->hasFlash('ajax_error')): ?>
  <div class="error"><?php echo $sf_user->getFlash('ajax_error') ?></div>
<?php endif ?>

<table border="0" width="100%" cellpadding="0" cellspacing="0" id="gallery_content">
    <tr>
        <th rowspan="3"></th>
        <th class="gallery_topleft"></th>
        <td id="gallery_tbl-border-top">&nbsp;</td>
        <th class="gallery_topright"></th>
        <th rowspan="3"></th>
    </tr>
    <tr>
        <td id="gallery_tbl-border-left"></td>
        <td>
            <!--  start content-table-inner ...................................................................... START -->
            <div id="gallery_content-table-inner">
                <div id="image-loader" style="display: none;">
                    <img src="/images/loader.gif"/>
                </div>
                <!--  start table-content  -->
                <ul id="gallery" class="gallery ui-helper-reset ui-helper-clearfix">
                    <?php if($list_registros->count() > 0): ?>
                        
                        <?php foreach( $list_registros as $i=>$registro ): ?>
                           
                            <li id="registro-<?php echo $registro->getId()?>" class="ui-widget-content ui-corner-tr picture">
                                    <h5 class="ui-widget-header" <?php if($registro->getIsActive()):?> style=" background-color: maroon;"<?php endif;?>>
                                    <?php echo ($registro->getTitulo()==""?"Sin Titulo":$registro->getTituloCortoBackend(13)); ?></h5>
                                    <div id="image_<?php echo $registro->getId(); ?>">
                                    <img class="basic" src="<?php echo $registro->getThumbnailValid(); ?>"  title="<?php echo $registro->getTitulo(); ?>"/>
                                    </div>
                                    <a href="<?php echo url_for('publicaciones_edit',$registro)?>" title="Editar registro" class="ui-icon ui-icon-pencil">Editar registro</a>
                                    <a href="#" onclick="eliminar('<?php echo $registro->getId() ?>','<?php echo url_for('publicaciones_ajax_registro_delete', $registro) ?>')" title="Eliminar publicacion" class="ui-icon ui-icon-trash">Eliminar Publicacion</a>
                            </li>

                        <?php endforeach; ?>
                        </ul>
                        <div class="clear"></div>
                        <?php else: ?>
                        <p>No hay publicaciones en la categoria</p>
                        <?php endif; ?>

                <!--  end table-content  -->

                <div class="clear"></div>

            </div>
            <!--  end content-table-inner ............................................END  -->
        </td>
        <td id="gallery_tbl-border-right"></td>
    </tr>
    <tr>
        <th class="gallery_sized bottomleft"></th>
        <td id="gallery_tbl-border-bottom">&nbsp;</td>
        <th class="gallery_sized bottomright"></th>
    </tr>
</table>
<div id="form-editable" class="editable" title="Editar Titulo de Imagen">
   <div style="float: right; height: 120px;">
      <img class="image-dialog" src="" id=""/>
   </div>

  <p>Indique el titulo de la imagen que selecciono</p>
  <input id="field-editable" type="text" value="Titulo de Imagen"/>
</div>
<div id="dialog-confirm" class="eliminable" title="Eliminar Publicacion">
   <div style="float: right; height: 120px;">
      <img class="image-dialog" src="" id=""/>
   </div>
  <div style="clear: both;"></div>
  <p style=" margin-top: 20px;">¿Confirmar eliminar la publicacion?</p>
  <input id="field-hidden" type="hidden" value=""/>
</div>
