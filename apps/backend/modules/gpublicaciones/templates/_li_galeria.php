<li id="registro-<?php echo $registro->getId()?>" class="ui-widget-content ui-corner-tr picture">
  <h5 class="ui-widget-header"><?php echo $registro->getTituloCortoBackend(13); ?></h5>
  <div id="image_<?php echo $registro->getId(); ?>">
  <a href="<?php echo $registro->getArchivoValid()?>" title="<?php echo $registro->getContenido(ESC_RAW)?>" rel="prettyPhoto[pp_gal]" style="padding: 0px; margin:0px;">
  <img class="basic" src="<?php echo $registro->getThumbnailValid(); ?>"  title="<?php echo $registro->getTitulo(); ?>" description="<?php echo $registro->getContenido(ESC_RAW); ?>" url="<?php echo url_for('publicaciones_galeria_edit',$registro)?>" />
  </a>
  </div>
  <a href="#" onclick="titularizar('<?php echo $registro->getId() ?>')" title="Editar registro" class="ui-icon ui-icon-pencil">Editar registro</a>
  <a href="#" onclick="eliminar('<?php echo $registro->getId() ?>','<?php echo url_for('publicaciones_galeria_ajax_registro_delete', $registro) ?>')" title="Eliminar registro" class="ui-icon ui-icon-trash">Eliminar registro</a>
</li>
