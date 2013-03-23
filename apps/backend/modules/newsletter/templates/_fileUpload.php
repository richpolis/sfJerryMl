<div id="files_list" class="sf_admin_form_row">
    
</div>    
<?php use_stylesheet("fileuploader.css") ?>
<table>
    <tr>
        <td>
            <div id="upload" style="width: 200px;margin: 30px 150px;">
                <?php echo 'Agregar archivos' ?>
            </div>
             Extenciones disponibles:   "xls","xlsx"
        </td>
        <td>
            <div style="margin: 30px 150px;font-weight: bold;font-size: 1.3em;font-family: Arial, Helvetica, sans-serif;text-align: center;background: #F2F2F2;color: #36C;border: 1px solid #CCC;width: 250px;cursor: pointer !important;-moz-border-radius: 5px;-webkit-border-radius: 5px;height: 40px;"> 
            <a href="<?php echo url_for('newsletter') ?>" >  
                Regresar
            </a>
            </div>
        </td>
    </tr>
    
</table>
<!--List Files-->
<ul id="files" ></ul>
<div class="clear"></div>
<?php use_javascript("fileuploader.js") ?>
<script>
    function createUploader(){
    var uploader = new qq.FileUploader({
            element:  document.getElementById('upload'),
            template: '<?php include_partial("templateUploader") ?>',
            action:   '<?php echo url_for(@upload_lista_correos) ?>',
            params:   { upload_file: 1 },
            onComplete: function(id, file, responseJson){
                    $files_list=$("#files_list");
                    $files_list.text('Archivo: ' + file + ' cargado y ejecutado');
                    $('#status').removeClass("loading");
                    $('#status').addClass("success");
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
