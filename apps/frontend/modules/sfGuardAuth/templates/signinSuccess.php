<?php use_helper('I18N') ?>
<?php use_stylesheet('login.css') ?>
<div id="login_form" class="col1">
<h1><?php echo __('Signin', null, 'sf_guard') ?></h1>
<h2>Acceso unicamente a administradores</h2>
<?php echo get_partial('sfGuardAuth/signin_form', array('form' => $form)) ?>
</div>
