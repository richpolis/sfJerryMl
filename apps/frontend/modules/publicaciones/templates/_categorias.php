<article class="categorias-publicaciones">
    <div class="categorias-publicaciones-titulo">
        <h3>Categorias</h3>
    </div>
    <ul class="categorias-publicaciones-lista">
        <?php if($categoria_actual->getCategoria()=="Ultimas notas"):?>
        <li class="categorias-publicaciones-lista-item current-lista-item"><?php echo link_to(ucwords("Ultimas Notas"),'publicaciones_ultimas_notas',array()) ?></li>
        <?php else:?>
        <li class="categorias-publicaciones-lista-item"><?php echo link_to(ucwords("Ultimas Notas"),'publicaciones_ultimas_notas',array()) ?></li>
        <?php endif;?>
        <?php foreach($categorias as $i => $categoria): ?>
        
        <li class="categorias-publicaciones-lista-item <?php echo ($categoria_actual->getCategoria()==$categoria->getCategoria()?"current-lista-item":"")?>">
            <?php echo link_to(ucwords($categoria->getCategoria()),'categorias_publicaciones',$categoria) ?>
        </li>
        <?php endforeach ?>
    </ul>
</article>
