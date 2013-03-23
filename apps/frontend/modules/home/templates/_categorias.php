<div class="block_categorias">
    <h3>
        Categorias
    </h3>
    <br />
    <ul id="block_categorias_navigator">
        <li><?php echo link_to(ucwords("Ultimas Notas"),'categorias_publicaciones_ultimas_notas',array()) ?></li>
        <?php foreach($categorias as $i => $category): ?>
        <li><?php echo link_to(ucwords($category->getCategoria()),'categorias_publicaciones',$category) ?></li>
        <?php endforeach ?>
    </ul>
</div>