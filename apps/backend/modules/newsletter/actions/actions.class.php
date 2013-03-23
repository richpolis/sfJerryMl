<?php

require_once dirname(__FILE__).'/../lib/newsletterGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/newsletterGeneratorHelper.class.php';

/**
 * newsletter actions.
 *
 * @package    JerryML
 * @subpackage newsletter
 * @author     Ricardo Alcantara <richpolis@gmail.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class newsletterActions extends autoNewsletterActions
{
  
  public function executeIndex(sfWebRequest $request)
  {
    // sorting
    if ($request->getParameter('sort') && $this->isValidSortColumn($request->getParameter('sort')))
    {
      $this->setSort(array($request->getParameter('sort'), $request->getParameter('sort_type')));
    }

    // pager
    if ($request->getParameter('page'))
    {
      $this->setPage($request->getParameter('page'));
    }

    $this->pager = $this->getPager();
    $this->sort = $this->getSort();

  }  
    
  public function executeListExportar(sfWebRequest $request)
  {
    $objPHPExcel = new sfPhpExcel();
    $registros=Doctrine_Core::getTable('Newsletter')->getBaseDeDatos(true);
    
    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Nombre');
    $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Email');
        
    $cont=2;
    foreach($registros as $registro){
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$cont, $registro->getNombre());
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$cont, $registro->getEmail());
        $cont++;
    }
    
    $objPHPExcel->getActiveSheet()->setTitle('Lista de correos');
 
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    
    $objWriter->save(sfConfig::get('sf_upload_dir').'/newsletters/downloads/listadecorreos.xlsx');
    
    $this->getUser()->setFlash('notice', 'El archivo fue generado.');
 
    $this->redirect('@newsletter');
       
  }
  
  public function executeListLimpiar(sfWebRequest $request)
  {
      if(file_exists(sfConfig::get('sf_upload_dir').'/newsletters/downloads/listadecorreos.xlsx')){
          unlink(sfConfig::get('sf_upload_dir').'/newsletters/downloads/listadecorreos.xlsx');
      }
      if(file_exists(sfConfig::get('sf_upload_dir').'/newsletters/downloads/listadecorreos.xls')){
          unlink(sfConfig::get('sf_upload_dir').'/newsletters/downloads/listadecorreos.xls');
      }
      
      $this->getUser()->setFlash('notice', 'El archivo de lista de correos actual, fue limpiado.');
 
      $this->redirect('@newsletter');
  }

  public function executeUpload(sfWebRequest $request) {
        
      if($request->hasParameter('upload_file')){
            // list of valid extensions, ex. array("jpeg", "xml", "bmp")
            if(file_exists(sfConfig::get("sf_upload_dir")."/newsletters/uploads/listadecorreos.xlsx")){
                unlink(sfConfig::get("sf_upload_dir")."/newsletters/uploads/listadecorreos.xlsx");
            }
          
            if(file_exists(sfConfig::get("sf_upload_dir")."/newsletters/uploads/listadecorreos.xls")){
                unlink(sfConfig::get("sf_upload_dir")."/newsletters/uploads/listadecorreos.xls");
            }
            
            $allowedExtensions = array("xls","xlsx");
            // max file size in bytes
            $sizeLimit = 6 * 1024 * 1024;
            $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
            $result = $uploader->handleUpload(sfConfig::get("sf_upload_dir")."/newsletters/uploads/");
            // to pass data through iframe you will need to encode all html tags
            /*****************************************************************/
            //$file = $request->getParameter("qqfile");
            if(isset($result["success"])){
                //chmod(sfConfig::get('sf_upload_dir').'/newsletters/'.$result["filename"], 666);
                $cuantosRegistros=$this->loadArchivoExcel($result["filename"]);
                unset($result['original'],$result['titulo'],$result['contenido']);
                $result["success"]=true;
                $ok="success";
            }
            // echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
            return $this->renderText(htmlspecialchars(json_encode($result), ENT_NOQUOTES));
        }
  }
  
  public function executeUpload2(sfWebRequest $request)
  {
   
    if ($request->hasParameter('upload_file'))
    {
      // list of valid extensions, ex. array("jpeg", "xml", "bmp")
      $allowedExtensions = array("xls","xlsx");
      // max file size in bytes
      $sizeLimit = 6 * 1024 * 1024;
      $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
      $result = $uploader->handleUpload(sfConfig::get("sf_upload_dir")."/newsletters/uploads/");
      // to pass data through iframe you will need to encode all html tags
      /*****************************************************************/
      //$file = $request->getParameter("qqfile");
      if(isset($result["success"])){
            
            //$file = $this->form->getValue('file_excel');
            //$filename = 'uploaded_'.sha1($file->getOriginalName());
            //$extension = $file->getExtension($file->getOriginalExtension());
            //$filename="lista_correos.xls";
            //$file->save(sfConfig::get('sf_upload_dir').'/newsletters/'.$filename);
           //chmod(sfConfig::get('sf_upload_dir').'/newsletters/'.$result["filename"], 666);
           $cuantosRegistros=$this->loadArchivoExcel($result["filename"]);
           unset($result["filename"],$result['original'],$result['titulo'],$result['contenido']);
           $result["success"]=true;
           return $this->renderText(htmlspecialchars(json_encode($result), ENT_NOQUOTES)); 
      }
    }
    
  }
  private function loadArchivoExcel($filename){
      /*if($this->getTipoArchivo($filename)=="Excel2007"){
        $objPHPExcel=new PHPExcel_Reader_Excel2007();
      }else{
        $objPHPExcel=new PHPExcel_Reader_Excel5();  
      }*/
      $objPHPExcel = PHPExcel_IOFactory::load(sfConfig::get('sf_upload_dir').'/newsletters/uploads/'.$filename);
      //$objPHPExcel->load(sfConfig::get('sf_upload_dir').'/newsletters/uploads/'.$filename);
      /*try{
          $objPHPExcel->setActiveSheetIndex(0);
      }catch(Exception $e){
         throw $e->getMessage();
      }*/
      $i=2; 
      
     Doctrine::getTable('Newsletter')
        ->createQuery()
        ->delete()
        ->execute();
     
      ////Si existiera una fila con los títulos inicial $i=2
      //Recorremos las filas del excel
      while($objPHPExcel->getActiveSheet()->getCell("A".$i)->getValue() != '')
      {	
        $nombre = $objPHPExcel->getActiveSheet()->getCell("A".$i)->getValue();
        $email = $objPHPExcel->getActiveSheet()->getCell("B".$i)->getValue();
        //inserto los datos en la table usuarios:
        $registro=new Newsletter();
        $registro->setNombre($nombre);
        $registro->setEmail($email);
        $registro->setIsActive(true);
        $registro->save();
        $i++;
      }
      return $i-2;
  }
  public function getTipoArchivo($archivo){
        $archivo=explode(".", $archivo);
        $resp="Excel2003";
        switch ($archivo[1]){
            case "xlsx":
                $resp="Excel2007";
                break;
            case "xls":
                $resp="Excel2003";
                break;
        }
        return $resp;
    }
}
