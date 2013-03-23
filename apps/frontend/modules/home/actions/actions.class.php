<?php
/**
 * home actions.
 *
 * @package    JerryML
 * @subpackage home
 * @author     Dioner911
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class homeActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->categoria_actual=new CategoriasPublicaciones();
    $this->categoria_actual->setCategoria("Ultimas notas");
    $q=  Doctrine_Core::getTable('Publicaciones')->getCriteriaUltimasPublicaciones();   
    $this->pager = new sfDoctrinePager('Publicaciones',4);
    $this->pager->setQuery($q);
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
    $this->list_registros=$this->pager->getResults();
  
    $this->home=Doctrine_Core::getTable('Configuracion')->getSeccion('home');
  
    //$this->twitters=sfRichSys::getUrlsTwitters(twitterOAuthPlugin::getMisTwitters('jerryml'));
    //$this->twitters=twitterOAuthPlugin::getMisTwitters('jerryml1');
  }
  
  public function executeTwitters(sfWebRequest $request)
  {
    
    //$this->twitters=sfRichSys::getUrlsTwitters(twitterOAuthPlugin::getMisTwitters('jerryml'));  
    $this->twitters=twitterOAuthPlugin::getMisTwitters('jerryml1');  
      if ($request->isXmlHttpRequest()){
       try{
           return $this->renderPartial('home/twitters', array('twitters' => $this->twitters));
       } catch(Exception $e){
           throw $e->getMessage();
       }
    }
  }
  
  public function executeNewsletter(sfWebRequest $request)
  {
      $registro=Doctrine_Core::getTable('Newsletter')->getUsuarioPorEmail($request->getParameter('email'));
      if($registro==null){
         $registro=new Newsletter();
         $registro->setNombre($request->getParameter('nombre'));
         $registro->setEmail($request->getParameter('email'));
         $registro->save();
         $this->mensaje_newsletter="Gracias por unirte a nuestro Newsletter.";
      }else{
         if($request->getParameter('nombre')=="BAJA"){ 
            $registro->delete();
            $this->mensaje_newsletter="Registro eliminado";
         }else{
            $registro->setNombre($request->getParameter('nombre'));
            $registro->save();
            $this->mensaje_newsletter="Registro actualizado";
         }
         
      }
      
    if ($request->isXmlHttpRequest()){
       try{
           return $this->renderPartial('home/form_newsletter',array('mensaje_newsletter'=>$this->mensaje_newsletter,'create_user'=>true));
       } catch(Exception $e){
           throw $e->getMessage();
       }
    }
  }
  
  public function executeContacto(sfWebRequest $request)
  {
    $this->form = new ContactForm();
    $this->mensaje_ok="";

    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('contact'));
      if ($this->form->isValid())
      {
        $mailer = Swift_Mailer::newInstance(Swift_MailTransport::newInstance());
        $this->Datos=$this->getArregloMensaje($request->getParameter('contact'));
        $asunto=$this->Datos[2]['value'];
        //Creamos el mensaje
        $message = Swift_Message::newInstance($asunto)
                ->setFrom(array($this->Datos[0]['value'] =>$this->Datos[1]['value']))
                //->setTo(array('richpolis@gmail.com'))
                ->setTo(array('lizzy@jerryml.com','cancinolizzy@yahoo.com','ventas@jerryml.com'))
                ->setBody("Mensaje desde JerryML.com")
                ->addPart($this->getMensajeFormateado($this->Datos), 'text/html');

        try{
        //Enviamos el email
           $mailer->send($message);
        }catch(Exception $e){
           echo "Error al enviar mensaje ". $e->getMessage();
        }

        $this->form=new ContactForm();
        $this->mensaje_ok="Gracias, nos comunicaremos a la brevedad posible";
      }
    }
    //$this->list_contactos=SfroxcasConfigPeer::retrieveByPK(1);
    if ($request->isXmlHttpRequest())
    {
       //return $this->renderText('ok');
        return $this->renderPartial('home/form_contacto', array('form' => $this->form,"mensaje_ok"=>$this->mensaje_ok));
    }
    
    $this->contactos=Doctrine_Core::getTable('Configuracion')->getSeccion('contactos');
  }

  public function executeRenderImagen(sfWebRequest $request){
    $imagen=  $request->getParameter('imagen').'.'.$request->getParameter('sf_format');
    $fileImagen = sfConfig::get('sf_upload_dir').'/'.$request->getParameter('path').'/'.$imagen;
    
    //chmod($fileImagen, 0666);
    $img = new sfImage($fileImagen,sfRichSys::getTipoMime($imagen));
    
    $response = $this->getResponse();

    $response->setContentType($img->getMIMEType());    
    
    if($img->getWidth()<$request->getParameter('width')){
        $img->resize(1000,null);
    }
    
    $img->thumbnail($request->getParameter('width'),$request->getParameter('height'),'center');
    
    $response->setContent($img); 

    return sfView::NONE;
  }
  
  public function executeRenderGrayscaleImagen(sfWebRequest $request){
    $imagen=  $request->getParameter('imagen').'.'.$request->getParameter('sf_format');
    $fileImagen = sfConfig::get('sf_upload_dir').'/'.$request->getParameter('path').'/'.$imagen;
    
    //chmod($fileImagen, 0666);
    $img = new sfImage($fileImagen,sfRichSys::getTipoMime($imagen));
    
    $response = $this->getResponse();

    $response->setContentType($img->getMIMEType());    
    
    if($img->getWidth()<$request->getParameter('width')){
        $img->resize(1000,null);
    }
    
    $img->thumbnail($request->getParameter('width'),$request->getParameter('height'),'center');
    
    $grayscale= new sfImageGreyscaleGD();
          
    $img=$grayscale->execute($img);
    
    $response->setContent($img); 

    return sfView::NONE;
  }
  
  /*
   * background-color: #ffcc00;
    color: white;
   *
   */
  protected function getMensajeFormateado($fields){
      $msg = '<font face="Lucida Grande,Corbel,Arial,sans-serif" color="#565656"><table border=0 cellpadding="4" cellspacing="5" width="500">
		<tr>
                    <td colspan="2" bgcolor="#181818" valign="middle" align="center">
                        <h2 style="margin:0;padding:8px;color:white;font-size: 24px;">
                            JerryML.com
                        </h2>
                    </td>
		</tr>
		<tr>
                    <td colspan="2">&nbsp;</td>
		</tr>';

		for($i=0;$i<count($fields);$i++){

			if(isset($fields[$i]['field']) && mb_strlen(trim($fields[$i]['field']),"utf-8") > 0){

				$fields[$i]['field'] = htmlspecialchars($fields[$i]['field']);

				$msg.= '<tr><td valign="top" bgcolor="#eeeeee"><small>'.$fields[$i]['label'].':&nbsp;&nbsp;&nbsp;</small></td><td>';

				if($fields[$i]['type'] == 'textArea'){
					$msg.=nl2br($fields[$i]['value']);
				}
				else if($fields[$i]['type'] == 'checkBox'){
					$msg.='Yes';
				/*}
				else if($fields[$i]['items']){
					$msg.= $fields[$i]['items']['field'];*/
                                }else $msg.= $fields[$i]['value'];

				$msg.='</td></tr>';
			}
		}

		$msg .= '</table></font>';
          return $msg;
  }
  protected function getArregloMensaje($Datos){
       $arreglo=array();

       $arreglo[0]['type']='Email';
       $arreglo[1]['type']='Text';
       $arreglo[2]['type']='Text';
       $arreglo[3]['type']='Text';
       $arreglo[4]['type']='Text';
       $arreglo[5]['type']='textArea';

       $arreglo[0]['field']='Email';
       $arreglo[1]['field']='Nombre';
       $arreglo[2]['field']='Asunto';
       $arreglo[3]['field']='Telefono';
       $arreglo[4]['field']='País';
       $arreglo[5]['field']='Mensaje';

       $arreglo[0]['label']='Email';
       $arreglo[1]['label']='Nombre';
       $arreglo[2]['label']='Asunto';
       $arreglo[3]['label']='Telefono';
       $arreglo[4]['label']='País';
       $arreglo[5]['label']='Mensaje';

       $arreglo[0]['items']='Email';
       $arreglo[1]['items']='Nombre';
       $arreglo[2]['items']='Asunto';
       $arreglo[3]['items']='Telefono';
       $arreglo[4]['items']='País';
       $arreglo[5]['items']='Mensaje';

       $arreglo[0]['value']=$Datos['email'];
       $arreglo[1]['value']=$Datos['name'];
       $arreglo[2]['value']=$Datos['subject'];
       $arreglo[3]['value']=$Datos['telefon'];
       $arreglo[4]['value']=$Datos['pais'];
       $arreglo[5]['value']=$Datos['message'];

       return $arreglo;
  }
  
  public function executeViewNewsletter(sfWebRequest $request)
  {
      $this->list_registros=Doctrine_Core::getTable('Newsletter')->getBaseDeDatos(true);
      $this->template=Doctrine_Core::getTable('TemplatesNewsletters')->getTemplateConPubliacionesForSlug($request->getParameter('slug'));
      $this->setLayout(false);
      $this->vista_previa=true;
      
  }
  public function executeEnviarNewsletter(sfWebRequest $request)
  {
      $this->list_registros=Doctrine_Core::getTable('Newsletter')->getBaseDeDatos(true);
      $this->template=Doctrine_Core::getTable('TemplatesNewsletters')->getTemplateConPubliacionesForSlug($request->getParameter('slug'));
      $this->setLayout(false);
      $this->vista_previa=false;
      if ($request->isMethod('post'))
      {
        // Create the Transport
        //$transport = Swift_SmtpTransport::newInstance('smtp.com', 25)
        //->setUsername('newsletter@jerryml.com')
        //->setPassword('jerryml36') 
        //;
        
        //$transport = Swift_SmtpTransport::newInstance('smtp.jerrymlhost.com', 25);

        $mailer = Swift_Mailer::newInstance(Swift_MailTransport::newInstance());
        //$mailer = Swift_Mailer::newInstance($transport);

        $asunto='Newsletter Jerry ML';
        //Creamos el mensaje
        $html=$this->getPartial('home/viewNewsletter', array('list_registros'=>$this->list_registros,'template'=>$this->template,'vista_previa'=>$this->vista_previa));
        $cuantos=0;
        foreach($this->list_registros as $registro){
            //$mailer = Swift_Mailer::newInstance(Swift_MailTransport::newInstance());
            
            //if($registro->getEmail()=="richpolis@gmail.com" || $registro->getEmail()=="richpolis@hotmail.com" || $registro->getEmail()=="phrenesis@gmail.com"){
	            $message = Swift_Message::newInstance($asunto)
                        ->setFrom(array('newsletter@jerryml.com'=>'Newsletter Jerry ML' ))
                        ->setTo(array($registro->getEmail()=>$registro->getNombre()))
                        //->setTo(array('lizzy@jerryml.com','cancinolizzy@yahoo.com','ventas@jerryml.com'))
                        ->setBody('Mensaje de Newsletter Jerry ML')
                        ->addPart($html, 'text/html');
                        //->addPart('<table><tr><td style="color: white; background-color: black;">hola, esto es una prueba</td></tr></table>', 'text/html');    
	            try{
	                //Enviamos el email
	                $status=$mailer->send($message);
	            }catch(Exception $e){
	                echo "Error al enviar mensaje ". $e->getMessage();
	            }
               if($status)
                   $cuantos++;
            //}
        }
        if($cuantos>0){
            $enviados=new MovimientosNewsletters();
            $enviados->setCuantosEnviados($cuantos);
            $enviados->setFechaEnviados(date('y-m-d',time()));
            $enviados->save();
        }
        if ($request->isXmlHttpRequest())
        {
            return $this->renderText('Se enviaron '.$cuantos.' correos');
        }
    }else{
        if ($request->isXmlHttpRequest())
        {
            return $this->renderText('Accion desconocida');
        }
    }
    $this->setTemplate('viewNewsletter');

  }
  
  
}
