<?php
// auto-generated by sfViewConfigHandler
// date: 2013/03/23 09:51:58
$response = $this->context->getResponse();


  $templateName = sfConfig::get('symfony.view.'.$this->moduleName.'_'.$this->actionName.'_template', $this->actionName);
  $this->setTemplate($templateName.$this->viewName.$this->getExtension());



  if (null !== $layout = sfConfig::get('symfony.view.'.$this->moduleName.'_'.$this->actionName.'_layout'))
  {
    $this->setDecoratorTemplate(false === $layout ? false : $layout.$this->getExtension());
  }
  else if (null === $this->getDecoratorTemplate() && !$this->context->getRequest()->isXmlHttpRequest())
  {
    $this->setDecoratorTemplate('' == 'layout' ? false : 'layout'.$this->getExtension());
  }
  $response->addHttpMeta('content-type', 'text/html', false);
  $response->addMeta('title', 'Jerry ML', false, false);
  $response->addMeta('description', 'Jerry ML Management', false, false);
  $response->addMeta('keywords', 'Montserrat Oliver,Galilea Montijo,Ana Brenda,Vanessa Huppenkothen,Celebridades,Celebrities,Agencia de representación,Artistas,Manager,Managers,Relaciones Públicas', false, false);
  $response->addMeta('language', 'es', false, false);

  $response->addStylesheet('main.css', '', array ());
  $response->addJavascript('jquery-1.4.4.min.js', '', array ());


