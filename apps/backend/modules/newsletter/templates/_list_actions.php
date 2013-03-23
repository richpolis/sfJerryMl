<?php echo $helper->linkToNew(array('params' => array(), 'class_suffix' => 'new', 'label' => 'New',)) ?>
<?php if (file_exists(sfConfig::get('sf_upload_dir') . '/newsletters/downloads/listadecorreos.xlsx')): ?>
    <li class="sf_admin_action_limpiar">
        <?php echo link_to(__('Limpiar generado', array(), 'messages'), 'newsletter/ListLimpiar', array()) ?>
    </li>
    <li class="sf_admin_action_download">
        <a href="/uploads/newsletters/downloads/listadecorreos.xlsx">Descargar</a>
    </li>
<?php else: ?>
    <li class="sf_admin_action_exportar">
        <?php echo link_to(__('Generar', array(), 'messages'), 'newsletter/ListExportar', array()) ?>
    </li>
<?php endif; ?>
<!-- _upload_form.php -->
<li class="sf_admin_action_upload">
    <a id="upload_form" href="<?php echo url_for('upload_lista_correos') ?>">
        Upload 
    </a>
</li> 
