<?php

/**
 * CategoriasVentas form.
 *
 * @package    JerryML
 * @subpackage form
 * @author     Dioner911
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CategoriasVentasForm extends BaseCategoriasVentasForm
{
  public function configure()
  {
      unset($this['created_at'], $this['updated_at']);
      $this->widgetSchema['bloque'] = new sfWidgetFormInputHidden();
      $this->widgetSchema['slug'] = new sfWidgetFormInputHidden();
  }
}
