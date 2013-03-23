<?php use_helper('I18N') ?>
<?php use_stylesheet('temp_sc.css') ?>
<div id="login_form" class="col1">
    <h2><?php echo __('Forgot your password?', null, 'sf_guard') ?></h2>

    <p>
        <?php echo __('No se preocupe acontinuacion lo ayudamos a accesar a su cuenta,') ?>
        <?php echo __('llene el formulario que se presenta a continuacion y recibira un mail de como reactivar su cuenta.') ?>
    </p>

    <form action="<?php echo url_for('@sf_guard_forgot_password') ?>" method="post">
        <div><?php echo $form['email_address'] ?>
        <?php echo $form['email_address']->renderLabel() ?>
        <?php echo $form['_csrf_token'] ?>
        </div>
        <input class="submit" type="submit" name="change" value="<?php echo __('Solicitar', null, 'sf_guard') ?>" />
    </form>
</div>