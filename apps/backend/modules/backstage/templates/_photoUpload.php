<div id="pictures_list" class="sf_admin_form_row">
  <?php include_partial('photoListe', array('list_registros' => Doctrine_Core::getTable('BackstageGaleria')->getGaleriaPorPublicacion($form->getObject()->getId()))) ?>
</div>
<?php use_stylesheet("fileuploader.css") ?>
<table>
    <tr>
        <td>
            <div id="upload" style="width: 200px;margin: 30px 150px;">
                <?php echo 'Agregar archivos' ?>
            </div>
        Extenciones disponibles:   "jpeg","png","gif","jpg"
        </td>
        <td>
            <div style="margin: 30px 150px;font-weight: bold;font-size: 1.3em;font-family: Arial, Helvetica, sans-serif;text-align: center;background: #F2F2F2;color: #36C;border: 1px solid #CCC;width: 250px;cursor: pointer !important;-moz-border-radius: 5px;-webkit-border-radius: 5px;height: 40px;"> 
            <a href="javascript:showFormularioVideo();" >  
                Videos desde Youtube o Vimeo
            </a>
            </div>    
        </td>
    </tr>
    
</table>
<script type="text/javascript">
 function showFormularioVideo(){
    $("#formulario-video").dialog( "open" );
 }   
$(document).ready(function(){
  $("#formulario-video").dialog({
        autoOpen: false,
        height: 200,
        width: 350,
        modal: true,
        buttons: {
            "Agregar": function() {
                var bValid = true;
                var fieldFile=$("#form-link-video-archivo");
                bValid=(fieldFile.val().length>0 && fieldFile.val()!="Link del video")?true:false;
                if ( bValid ) {
                    $('#image-loader').show();
                    $.get("<?php echo url_for("@backstage_galeria_upload") ?>", 
                    { 
                        publicacion_id: "<?php echo $form->getObject()->getId(); ?>", 
                        archivo: fieldFile.val(),
                        tipo_archivo: "2" 
                    },function(data) {
                            $("#pictures_list").html(data);
                    });
                    fieldFile.val("");
                    $( this ).dialog( "close" );
                }
            },
            "Cancelar": function() {
                $( this ).dialog( "close" );
            }
        }
    });
});
  </script>
<div id="formulario-video" class="editable" title="Agregar video Youtube o Vimeo">
   <p>Agregar la direccion del video</p>
   <div class="sf_admin_form_row sf_admin_text sf_admin_form_field_titulo">
	<div>
		<label for="form-link-video-archivo">Link del Video</label>
		<div class="content">
			<input type="text" name="form-link-video-archivo" id="form-link-video-archivo" value="" width="300px"/>
		</div>
	</div>
    </div>
   
  
</div>

<!--List Files-->
<ul id="files" ></ul>
<div class="clear"></div>
<?php use_javascript("fileuploader.js") ?>
<script>
    function createUploader(){
    var uploader = new qq.FileUploader({
            element: document.getElementById('upload'),
            template: '<?php include_partial("templateUploader") ?>',
            action: '<?php echo url_for(@backstage_galeria_upload) ?>',
            params:
                { publicacion_id: <?php echo $form->getObject()->getId(); ?>},
            onComplete: function(id, file, responseJson){
                    $.post("<?php echo url_for(@backstage_galeria_ajax_registro_liste,$form->getObject()) ?>",
                    {
                        publicacion_id: <?php echo $form->getObject()->getId(); ?>
                    },

                    function(data)
                    {
                        $("#pictures_list").html(data);
                        $('#status').removeClass("loading");
                        $('#status').addClass("success");
                    });

                },
            onSubmit: function(id, fileName){
                },
            onProgress: function(id, fileName){
                    $('#status').addClass("success");
                    $('#status').addClass("loading");
                }
            });

    }
    window.onload = createUploader;
</script>
