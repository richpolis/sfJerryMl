<?php use_helper('I18N') ?>
<?php use_stylesheet('temp_sc.css') ?>
<div id="login_form" class="col1">
    <h2><?php echo __('Hola %name%', array('%name%' => $user->getName()), 'sf_guard') ?></h2>
    <h3><?php echo __('Digite su nuevo password a continuación.', null, 'sf_guard') ?></h3>
    <form action="<?php echo url_for('@sf_guard_forgot_password_change?unique_key=' . $sf_request->getParameter('unique_key')) ?>" method="POST">
        <div>
            <?php echo $form['password'] ?>
            <?php echo $form['password']->renderLabel() ?>
        </div>
        <div>
            <?php echo $form['password_again'] ?>
            <?php echo $form['password_again']->renderLabel() ?>
        </div>
        <?php echo $form['_csrf_token'] ?>
        <input class="submit" type="submit" name="change" value="<?php echo __('Cambiar', null, 'sf_guard') ?>" />
    </form>
</div>