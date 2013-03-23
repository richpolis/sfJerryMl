<?php use_helper('I18N') ?>
<?php echo __('Hola %first_name%', array('%first_name%' => $user->getFirstName()), 'sf_guard') ?>,<br/><br/>
<?php echo __('Esta e-mail está siendo enviado porque usted solicitó información acerca de cómo reiniciar tu contraseña.', null, 'sf_guard') ?><br/><br/>
<?php echo __('Usted puede cambiar su contraseña haciendo clic en el link de abajo, que sólo es válido durante 24 horas:', null, 'sf_guard') ?><br/><br/>
<?php echo link_to(__('Click para cambiar su password', null, 'sf_guard'), '@sf_guard_forgot_password_change?unique_key='.$forgot_password->unique_key, 'absolute=true') ?>