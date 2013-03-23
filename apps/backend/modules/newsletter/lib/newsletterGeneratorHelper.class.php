<?php

/**
 * newsletter module helper.
 *
 * @package    JerryML
 * @subpackage newsletter
 * @author     Ricardo Alcantara <richpolis@gmail.com>
 * @version    SVN: $Id: helper.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class newsletterGeneratorHelper extends BaseNewsletterGeneratorHelper
{
  public function getExcelUploadForm()
  {
    return new ExcelUploadForm();
  }
}
