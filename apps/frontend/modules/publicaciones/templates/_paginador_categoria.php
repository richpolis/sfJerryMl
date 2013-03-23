<?php if(!$pager==null): ?>
<div class="pagination">
    <?php if ($pager->haveToPaginate() && $pager->getPage()>1): ?>
    <a class="previous" href="<?php echo url_for('categorias_publicaciones',array('slug'=>$categoria_actual->getSlug(),'page'=>$pager->getPreviousPage())); ?>">«</a>
    <?php endif; ?>
    <?php $paginaInicial=(floor($pager->getPage()/6)*6)+1;?>
    <?php $paginaFinal=$paginaInicial+6;?>
    <?php foreach ($pager->getLinks() as $i=>$page): ?>
         <?php if($i>=($paginaInicial-1) && $i<$paginaFinal):?>
             <?php if ($page == $pager->getPage()): ?>
                 <span class="current"><?php echo $page ?></span>
             <?php else: ?>
                <a href="<?php echo url_for('categorias_publicaciones',array('slug'=>$categoria_actual->getSlug(),'page'=>$page)); ?>"><?php echo $page ?></a>
             <?php endif; ?>
         <?php endif; ?>    
    <?php endforeach; ?> 
    <?php if ($pager->haveToPaginate() && $pager->getPage()<$pager->getLastPage()): ?>
    <a class="next" href="<?php echo url_for('categorias_publicaciones',array('slug'=>$categoria_actual->getSlug(),'page'=>$pager->getNextPage())); ?>">»</a>
    <?php endif; ?>
</div>
<?php endif; ?>