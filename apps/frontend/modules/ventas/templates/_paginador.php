<?php if(!$pager==null): ?>
<div class="pagination">
    <?php if ($pager->haveToPaginate() && $pager->getPage()>1): ?>
    <a class="previous" href="<?php echo url_for('ventas',array('page'=>$pager->getPreviousPage())); ?>">«Anterior</a>
    <?php endif; ?>
    <?php foreach ($pager->getLinks() as $i=>$page): ?>
             <?php if ($page == $pager->getPage()): ?>
                 <span class="current-page"><?php echo $page ?></span>
             <?php else: ?>
                <a href="<?php echo url_for('ventas',array('page'=>$page)); ?>"><?php echo $page ?></a>
             <?php endif; ?>
    <?php endforeach; ?> 
    <?php if ($pager->haveToPaginate() && $pager->getPage()<$pager->getLastPage()): ?>
    <a class="next" href="<?php echo url_for('ventas',array('page'=>$pager->getNextPage())); ?>">Siguiente »</a>
    <?php endif; ?>
</div>
<?php endif; ?>