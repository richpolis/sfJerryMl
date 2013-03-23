
<?php
$list_categorias=  Doctrine_Core::getTable('CategoriasPublicaciones')->findAll();
$categoria_actual= $list_categorias[0];
?>

<div id="menu_categorias-backend">
<ul class="menu-categorias-drag">
<li>Categorias:</li>
<?php if(!$list_categorias==null): ?>
<?php foreach ($list_categorias as $categoria): ?>
<?php if($categoria_actual==$categoria->getId()):?>
<li id="categoria-<?php echo $categoria->getId() ?>" class="ui-corner-all menu-categorias-drag-li-active">
<?php echo $categoria->getCategoria();?>
    
</li>
<?php else:?>
<li id="categoria-<?php echo $categoria->getId() ?>" class="ui-state-default ui-corner-all menu-categorias-drag-li">
    <a href="javascript:FiltrarForCategory('<?php echo $categoria->getId() ?>')">
        <?php echo $categoria->getCategoria(); ?>
    </a>
</li>
<?php endif; ?>
<?php endforeach; ?>
<script type="text/javascript">
/* <![CDATA[ */
function FiltrarForCategory(id)
{
  var $categorias=$("#publicaciones_filters_categoria_id option");
  for(cont=0;cont<$categorias.length;cont++){
      if($categorias.eq(cont).val()==id){
          $categorias.eq(cont).attr('selected', 'selected');
          $categorias.css({color: 'blue',textTransfor:'uppercase'});
          cont=$categorias.length+1;
      }
  }
  /*var $status=$("#publicaciones_filters_is_active option");
  for(cont=0;cont<$status.length;cont++){
      if($status.eq(cont).val()=='1'){
          $status.eq(cont).attr('selected', 'selected');
          cont=$status.length+1;
      }
  }*/
  
  var formularios=$("form");
  formularios.eq(0).submit();
}
function FiltrarPapeleraReciclaje(id){
  
  var $status=$("#publicaciones_filters_is_active option");
  for(cont=0;cont<$status.length;cont++){
      if($status.eq(cont).val()=='0'){
          $status.eq(cont).attr('selected', 'selected');
          cont=$status.length+1;
      }
  }
  
  var formularios=$("form");
  formularios.eq(0).submit();
}

$(document).ready(function(){
    $("#menu_categorias-backend li a").index(0).click();    
});
        
 /*]]> */
</script>
<?php endif; ?>
</ul>
</div>