<?php use_helper('I18N', 'Date') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Upload Lista de Correos', array(), 'messages') ?></h1>

  <?php include_partial('flashes') ?>

  <div id="sf_admin_header">
    <?php //include_partial('publicaciones_newsletters/form_header', array('publicaciones_newsletters' => $publicaciones_newsletters, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <!--form id="upload_form" action="<?php echo url_for('upload_lista_correos') ?>" method="post" enctype="multipart/form-data">
        <?php //echo $helper->getExcelUploadForm(); ?> 
    <p><input type="submit" value="upload"> </p>
    
    </form-->
    <?php include_partial('fileUpload') ?>  
      
  </div>

  <div id="sf_admin_footer">
    <?php //include_partial('publicaciones_newsletters/form_footer', array('publicaciones_newsletters' => $publicaciones_newsletters, 'form' => $form, 'configuration' => $configuration)) ?>
      
  </div>
</div>
