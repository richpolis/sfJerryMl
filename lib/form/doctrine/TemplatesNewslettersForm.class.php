<?php

/**
 * TemplatesNewsletters form.
 *
 * @package    JerryML
 * @subpackage form
 * @author     Ricardo Alcantara <richpolis@gmail.com>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TemplatesNewslettersForm extends BaseTemplatesNewslettersForm
{
  public function configure()
  {
      unset($this['created_at'], $this['updated_at']);
      $this->widgetSchema['position'] = new sfWidgetFormInputHidden();
      $this->widgetSchema['slug'] = new sfWidgetFormInputHidden();
      $this->widgetSchema['date_newsletter']=new sfWidgetFormJQueryDate(array(
            'culture' => 'en',
      ));
  }
}
