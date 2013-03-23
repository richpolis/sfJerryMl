<?php use_helper('I18N') ?>
<form action="<?php echo url_for('@sf_guard_signin') ?>" method="post">

    <div>
        <?php echo $form['username']->renderLabel(); ?>
<?php echo $form['username'] ?>
</div>
    <div>
        <?php echo $form['password']->renderLabel(); ?>
<?php echo $form['password'] ?>
</div>
    <div>
        <?php echo $form['remember']->renderLabel() ?>
        <div class="input">
            <?php echo $form['remember'] ?>
        </div>



        </div>

    <?php  echo $form['_csrf_token']; ?>
            <input class="submit" type="submit" value="<?php echo __('Signin', null, 'sf_guard') ?>" />
    <?php $routes = $sf_context->getRouting()->getRoutes() ?>
    
    <?php if (isset($routes['sf_guard_register'])): ?>
                    &nbsp; <a href="<?php echo url_for('@sf_guard_register') ?>"><?php echo __('Want to register?', null, 'sf_guard') ?></a>
    <?php endif; ?>

