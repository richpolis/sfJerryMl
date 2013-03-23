<?php if(!$pager==null): ?>
<div class="pagination">
    <?php if ($pager->haveToPaginate() && $pager->getPage()>1): ?>
    <a class="previous" href="<?php echo url_for('backstage_ultimas_notas',array('page'=>$pager->getPreviousPage())); ?>">«Anterior</a>
    <?php endif; ?>
    <?php $paginaInicial=(floor($pager->getPage()/6)*6)+1;?>
    <?php $paginaFinal=$paginaInicial+6;?>
    <?php foreach ($pager->getLinks() as $i=>$page): ?>
         <?php if($i>=($paginaInicial-1) && $i<$paginaFinal):?>
             <?php if ($page == $pager->getPage()): ?>
                 <span class="current-page"><?php echo $page ?></span>
             <?php else: ?>
                <a class="page" href="<?php echo url_for('backstage_ultimas_notas',array('page'=>$page)); ?>"><?php echo $page ?></a>
             <?php endif; ?>
         <?php endif; ?>    
    <?php endforeach; ?> 
    <?php if ($pager->haveToPaginate() && $pager->getPage()<$pager->getLastPage()): ?>
    <a class="next" href="<?php echo url_for('backstage_ultimas_notas',array('page'=>$pager->getNextPage())); ?>">Siguiente »</a>
    <?php endif; ?>
</div>
<?php endif; ?>