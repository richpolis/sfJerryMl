<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
    <head>
        <?php include_http_metas() ?>
        <?php include_metas() ?>
        <title>
            <?php if (!include_slot('title')): ?>
                <?php echo $sf_response->getTitle() ?>
            <?php endif; ?>
        </title>
        <!--link rel="shortcut icon" href="/favicon.ico" /-->
        <?php include_stylesheets() ?>
        <?php include_javascripts() ?>
         <!--[if lt IE 9]>
            <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <?php if(!include_slot('metas-galeria')):?>
<meta property="og:title" content="Pagina JerryML.com" />
<meta property="og:type" content="album" />
<meta property="og:url" content="Artistas, contrataciones" />
<meta property="og:image" content="/images/jerryml/Logojerryml.png" />
<meta property="og:site_name" content="JerryML.com" />
<!--meta property="fb:admins" content="USER_ID1,USER_ID2"/-->
<meta property="og:description" content="Contrataciones de talento artistico, conductores, etc..." />
<?php endif;?>

    </head>
    <body>
        <div class="bg">
        <header>
            <div class="container">
                <a href="<?php echo url_for('homepage')?>" id="logo">
                    <img src="/images/jerryml/Logojerryml.png" alt="logo"/>
                </a>
                <?php $module=$sf_request->getParameterHolder()->get('module');?>
                <?php $action=$sf_request->getParameterHolder()->get('action');?>
                <nav>
                    <ul>
                        <li><a href="<?php echo url_for('homepage')?>" class="<?php echo ($module=='home' && $action=='index'?'current':'')?>">Home</a></li>
                        <li><a href="<?php echo url_for('categorias_talento')?>" class="<?php echo ($module=='talento'?'current':'')?>">talento</a></li>
                        <li><a href="<?php echo url_for('ventas')?>" class="<?php echo ($module=='ventas' && $action=='index'?'current':'')?>">ventas</a></li>
                        <li><a href="<?php echo url_for('publicaciones_ultimas_notas')?>" class="<?php echo ($module=='publicaciones' && $action?'current':'')?>">prensa/notas</a></li>
                        <li><a href="<?php echo url_for('backstage_ultimas_notas')?>" class="<?php echo ($module=='backstage'?'current':'')?>">backstage</a></li>
                        <li><a href="<?php echo url_for('contacto')?>" class="<?php echo ($module=='home' && $action=='contacto'?'current':'')?>">Contacto</a></li>
                    </ul>
                </nav>
                <div class="icons-redes-sociales" style="position: absolute; top: 0px; right: 20%;">
                    <ul>
                        <li>
                            <a href="https://twitter.com/#!/jerryml1" target="_blank">
                                <img src="/images/jerryml/twitter.jpg"/>
                            </a>
                        </li>
                        <li>
                            <a href="http://www.facebook.com/profile.php?id=100002635078209" target="_blank">
                                <img src="/images/jerryml/facebook.jpg"/>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </header>
        <?php include_slot('categorias-talento-encabezado')?>    
        <div id="container" style="<?php echo ($module=='talento' && $action=='index'?'width:945px;':'')?>">    
             <?php echo $sf_content ?>
        </div>
        <footer>
            <div class="container">
                
                <div id="FooterTree" style=" padding: 0;text-align: center; width: 100%;">JERRY ML © 2012   Tel. (52 55) 5256 4484 • (52 55) 5212 1283 • <a href="<?php echo url_for('contacto')?>">Contacto</a></div> 
            </div>
        </footer>
       </div>     
    <?php include_slot('nCustomScrollbar')?>
    </body>
    
</html>
