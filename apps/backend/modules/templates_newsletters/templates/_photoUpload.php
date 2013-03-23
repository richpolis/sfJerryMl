<?php
    $app_frontend = 'index';//$sf_context->getConfiguration()->getApplication();
    if(strcmp($sf_context->getConfiguration()->getEnvironment(),'prod') != 0)
    {$app_frontend .= '_'.$sf_context->getConfiguration()->getEnvironment();}
?>
<div id="pictures_list" class="sf_admin_form_row">
  <?php include_partial('photoListe', array('list_registros' => Doctrine_Core::getTable('PublicacionesNewsletters')->getPublicacionesPorTemplate($form->getObject()->getId()))) ?>
</div>
<?php use_stylesheet("fileuploader.css") ?>
<table>
    <tr>
        <td>
            <div id="upload" style="width: 250px;">
                <a href="<?php echo url_for('@publicaciones_newsletters_new?template_id='.$form->getObject()->getId())?>">  
                <?php echo 'Agregar Publicación' ?>
                </a>    
            </div>
        </td>
        <td>
            <div style="margin: 30px 150px;font-weight: bold;font-size: 1.3em;font-family: Arial, Helvetica, sans-serif;text-align: center;background: #F2F2F2;color: #36C;border: 1px solid #CCC;width: 250px;cursor: pointer !important;-moz-border-radius: 5px;-webkit-border-radius: 5px;height: 40px;"> 
            <a href="/<?php echo $app_frontend.'.php'?>/view/newsletter/<?php echo $form->getObject()->getSlug()?>" target="_blank" >  
                Vista Previa
            </a>
            </div>    
        </td>
    </tr>
</table>
<!--List Files-->

