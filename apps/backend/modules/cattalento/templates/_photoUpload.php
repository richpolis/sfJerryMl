<div id="pictures_list" class="sf_admin_form_row">
  <?php include_partial('photoListe', array('list_registros' => Doctrine_Core::getTable('Talento')->getPublicacionesPorCategoria($form->getObject()->getId()))) ?>
</div>
<?php use_stylesheet("fileuploader.css") ?>
<div id="upload">
    <a href="<?php echo url_for('@talento_new?categoria_id='.$form->getObject()->getId())?>">  
    <?php echo 'Agregar Publicación' ?>
    </a>    
</div>
<!--List Files-->

