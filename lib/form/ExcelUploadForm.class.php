<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ContactForm
 *
 * @author Richpolis
 */
class ExcelUploadForm extends sfForm
{
    public function configure()
    {
    //$this->useFields(array('file_excel'));
    $this->widgetSchema['file_excel'] = new sfWidgetFormInputFile();
    $this->widgetSchema['file_excel']->setLabel('Lista Correos');
    $this->validatorSchema['file_excel'] = new sfValidatorFile(
        array('required'=>true,
                'mime_type_guessers' => array(), 
                'mime_types'=>array(
                    'application/excel', 
                    'application/vnd.ms-excel', 
                    'application/x-msexcel', 
                    'application/vnd.oasis.opendocument.spreadsheet')), 
            array('required'=>'Please fill with the file you want to upload', 
                'mime_types'=>'The uploaded file should be an excel file'));
    }

  
}
