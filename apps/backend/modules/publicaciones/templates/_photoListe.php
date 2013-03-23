<?php use_stylesheet('prettyPhoto.css');?>
<?php use_stylesheet("photos.css") ?>
<?php use_javascript('jquery.prettyPhoto.js') ?>
<?php use_javascript('sfrichpolis.js')?>
<?php use_helper('Escaping')?>

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
.gallery li img {cursor: move; width: 100%; }
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
        var $ImgTitulo=$("#field-titulo");
        var $ImgDescripcion=$("#field-contenido");
        var $ImgUrl=$("#field-url");
        $(".image-dialog").attr({src:imagen.attr("src"),id:idImg});
        $ImgTitulo.val(imagen.attr("title"));
        $ImgDescripcion.val(imagen.attr("descripcion"));
        $ImgUrl.val(imagen.attr("url"));
       
        $( "#form-editable" ).dialog( "open" );
    }
    function updateRegistroGaleria(Id,Title,Description){
        $('#image-loader').show();
        $("#pictures_list").load('/<?php echo $app_name ?>.php/gpublicaciones/updateRegistroGaleria',
            {'id': Id, 'title': Title,'contenido': Description},
            function(){
                $.configPrettyPhotoDark();
                setTimeout(function(){
                    $('#image-loader').slideUp();
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
        $.configPrettyPhotoDark();
        
           <?php if($list_registros->count()>0){?>
            $("#gallery" ).sortable({
                    handle: '.basic',
                    update: function(){
                    $('#image-loader').show();
                     var order = $('#gallery').sortable('serialize');
                         //alert(order);
                     $("#pictures_list").load('/<?php echo $app_name ?>.php/publicaciones/ajaxRegistroOrder?id=<?php echo $list_registros[0]->getPublicacionId();?>&'+order,
                     {},
                     function(){
                          $('#image-loader').hide();
                     });
                     }
            });
            $( "#gallery" ).disableSelection();
        //  <?php } ?>

      $("#form-editable").dialog({
			autoOpen: false,
			height: 400,
			width: 400,
			modal: true,
			buttons: {
			"Actualizar": function() {
				 var bValid = true;
                                 var fieldTitle=$("#field-titulo"),fielDescription=$("#field-contenido");
				 bValid=(fieldTitle.val().length>0 && fieldTitle.val()!="Titulo de Imagen")?true:false;
                                 bValid=(fielDescription.val().length>0 && fielDescription.val()!="Descripcion")?true:false;
  				 if ( bValid ) {
				    updateRegistroGaleria(
                                            $(".image-dialog").attr("id"), 
                                            $("#field-titulo").val(),
                                            $("#field-contenido").val()
                                        );
				     $( this ).dialog( "close" );
                                    }
                                },
                         "Avanzada": function() {
                             
                             location.href=$("#field-url").val();
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
                                    <h5 class="ui-widget-header"><?php echo $registro->getTituloCortoBackend(12); ?></h5>
                                    <div id="image_<?php echo $registro->getId(); ?>">
                                        <!--a href="<?php echo $registro->getArchivoValid()?>" title="<?php echo $registro->getContenido()?>" rel="prettyPhoto[pp_gal]" style="padding: 0px; margin:0px;"-->
                                            <img class="basic" src="<?php echo $registro->getThumbnailValid(); ?>"  title="<?php echo $registro->getTitulo(); ?>" descripcion="<?php echo $registro->getContenido(); ?>" url="<?php echo url_for('publicaciones_galeria_edit',$registro,true)?>" />
                                        <!--/a-->
                                    </div>
                                    <a href="#" onclick="titularizar('<?php echo $registro->getId() ?>')" title="Editar registro" class="ui-icon ui-icon-pencil">Editar registro</a>
                                    <a href="#" onclick="eliminar('<?php echo $registro->getId() ?>','<?php echo url_for('publicaciones_galeria_ajax_registro_delete', $registro) ?>')" title="Eliminar registro" class="ui-icon ui-icon-trash">Eliminar registro</a>
                            </li>

                        <?php endforeach; ?>
                        </ul>
                        <div class="clear"></div>
                        <?php else: ?>
                        <p>No hay archivos aun en la categoria</p>
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
<div id="form-editable" class="editable" title="Editar Info Registro">
   <div style="float: right; height: 120px;">
      <img class="image-dialog" src="" id=""/>
   </div>

  <p>Indique el titulo y/o descripcion</p>
  <div style="clear: both;"></div>
  <div style="padding-top: 30px;">
    <div class="sf_admin_form_row sf_admin_text sf_admin_form_field_titulo">
	<div>
		<label for="field-titulo">Titulo</label>
		<div class="content">
			<input type="text" name="field-titulo" value="00071.jpg" id="field-titulo" />
		</div>
	</div>
    </div>
    <div class="sf_admin_form_row sf_admin_text sf_admin_form_field_contenido">
	<div>
		<label for="field-contenido">Contenido</label>
		<div class="content">
			<textarea name="field-contenido" id="field-contenido"></textarea>
			<script type="text/javascript">
			  tinyMCE.init({
				mode:                              "exact",
				elements:                          "publicaciones_galeria_contenido",
				theme:                             "advanced",
				plugins : "spellchecker",
				width:                             "500px",
				height:                            "250px",
				theme_advanced_toolbar_location:   "top",
				theme_advanced_toolbar_align:      "left",
				theme_advanced_statusbar_location: "bottom",
				theme_advanced_resizing:           true,
				gecko_spellcheck : true
			   
			  });
			</script>
		</div>
	</div>
    </div>		

  <input name="field-url" id="field-url" type="hidden" value=""/>
  </div>
</div>
<div id="dialog-confirm" class="eliminable" title="Eliminar registro">
   <div style="float: right; height: 120px;">
      <img class="image-dialog" src="" id=""/>
   </div>
  <div style="clear: both;"></div>
  <p style="margin-top:20px;">¿Confirmar eliminar el siguiente registro?</p>
  <input id="field-hidden" type="hidden" value=""/>
</div>
