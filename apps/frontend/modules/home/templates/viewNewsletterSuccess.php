<?php 
if(!isset($vista_previa))$vista_previa=false;
?>
 <?php use_helper('Escaping')?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
    <head>
        <title>
            <?php if (!include_slot('title')): ?>
                <?php echo $sf_response->getTitle() ?>
            <?php endif; ?>
        </title>
    </head>
    <body>
        <?php include_partial('viewNewsletter',  array('list_registros'=>$list_registros,'template'=>$template,'vista_previa'=>$vista_previa)); ?>        
    </body>
</html>