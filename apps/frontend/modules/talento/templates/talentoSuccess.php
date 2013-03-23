<?php use_stylesheet('prettyPhoto.css') ?>
<?php use_stylesheet('galeria.css') ?>
<?php use_javascript('jquery.prettyPhoto.js') ?>
<?php use_javascript('sfrichpolis.js') ?>
<?php use_helper('Escaping') ?>
<?php use_javascript('widget.js') ?>

<?php if(!$publicacion_actual==null): ?>
<?php slot('metas-galeria') ?>
<meta property="og:title" content="<?php echo (strlen($publicacion_actual->getTitulo())>0?$publicacion_actual->getTitulo():'Imagen de la pagina de JerryML.com');?>" />
<meta property="og:type" content="album" />
<meta property="og:url" content="<?php echo url_for('talento_perfil',array('categoria_slug'=>$publicacion_actual->getCategoriasTalento()->getSlug(),'slug'=>$publicacion_actual->getSlug()))?>" />
<meta property="og:image" content="<?php echo $publicacion_actual->getThumbnailValid()?>" />
<meta property="og:site_name" content="JerryML.com" />
<!--meta property="fb:admins" content="USER_ID1,USER_ID2"/-->
<meta property="og:description" content="<?php echo $publicacion_actual->getContenidoCorto(50)?>" />
<?php end_slot()?>
<?php endif;?>

<h1 class="titulo-pagina-h1">
    <span class="titulo-pagina-span">
        <a href="<?php echo url_for('categoria_talento',$publicacion_actual->getCategoriasTalento())?>" style="text-decoration: none;"><?php echo $publicacion_actual->getCategoriasTalento()->getCategoria()?></a> / <?php echo $publicacion_actual->getTitulo()?>
    </span>
</h1>

<section class="talento-perfil">
    <article class="article-talento-perfil">
        <div class="talento-perfil-imagen">
            <img src="<?php echo (!$publicacion_actual==null?$publicacion_actual->getArchivoValid():'/images/jerryml/contenedor_fotoprincipal.jpg')?>"/>
        </div>
        <div class="talento-perfil-biografia">
            <h6>biografia</h6>
            <?php if(!$publicacion_actual==null):?>
                <?php echo $publicacion_actual->getContenido(ESC_RAW)?>
            <?php else:?>
                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
            <?php endif;?>
        </div>
        <!--div class="talento-perfil-ventas">
            <h6>disponible para</h6>
            <?php if(!$publicacion_actual==null):?>
                <?php //echo $publicacion_actual->getDisponiblePara(ESC_RAW)?>
            <?php else:?>
                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
            <?php endif;?>
        </div-->
        <div class="talento-perfil-actualmente">
            <h6>actualmente</h6>
            <?php if(!$publicacion_actual==null):?>
                <?php echo $publicacion_actual->getActualmente(ESC_RAW)?>
            <?php else:?>
                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
            <?php endif;?>
        </div>
        
    </article>
    
    <aside class="aside-talento-perfil">
        <div class="talento-perfil-galeria">
            <?php include_partial('galeria_talento', array('publicacion_actual' => $publicacion_actual,'galeria'=>$list_galeria));?> 
        </div>
        <?php if(strlen($publicacion_actual->getPaginaWeb())>0):?>
        <div class="talento-perfil-pagina-web" style="heigth: 50px; width:100%;text-align:center; font-size: large; ">
           <a style="text-decoration: none;" href="<?php echo $publicacion_actual->getPaginaWeb(ESC_RAW)?>" target="_blank">
              <?php echo $publicacion_actual->getPaginaWebSinHttp(ESC_RAW)?>
           </a>
        </div>
        <?php endif;?>
        <div class="talento-perfil-twitter">
            <img src="/images/jerryml/talento/publicacion/twitter_logo_mini.jpg"/> <span style="color: rgb(0,133,189);">@ <?php echo $publicacion_actual->getTwitter()?></span>
        <div id="twitter-feed"> 
	<!--script src="http://widgets.twimg.com/j/2/widget.js"></script-->
	<script>
	new TWTR.Widget({
	  version: 2,
	  type: 'search',
	  search: '<?php echo $publicacion_actual->getTwitter()?>',
	  interval: 3000,
	  title: 'Twitter Feed',
	  subject: '<?php echo $publicacion_actual->getTitulo()?>',
	  width: 'auto',
	  height: 300,
	  theme: {
	    shell: {
	      background: '#ffffff',
	      color: '#fafafa'
	    },
	    tweets: {
	      background: '#ffffff',
	      color: '#444444',
	      links: '#1985b5'
	    }
	  },
	  features: {
	    scrollbar: false,
	    loop: true,
	    live: true,
	    hashtags: true,
	    timestamp: true,
	    avatars: true,
	    toptweets: true,
	    behavior: 'default'
	  }
	}).render().start();
	</script>	
        </div>
        </div>
        <?php $conDocumentos=false?>
        <?php foreach($list_galeria as $registro):?>
        <?php if($registro->getTipoArchivo()==3):?>
            <?php $conDocumentos=true?>
             <?php break;?>
        <?php endif;?>
        <?php endforeach; ?>
        <?php if($conDocumentos):?>
        <div class="talento-perfil-documentos">
         <ul class="talento-perfil-documentos-lista">
            <?php foreach($list_galeria as $registro):?>
            
                <?php if($registro->getTipoArchivo()==3):?>
                <li class="talento-perfil-documentos-lista-item">
                    <div class="talento-perfil-documentos-lista-imagen">
                         <img src="/images/jerryml/talento/publicacion/pdf_icon.png"/>
                    </div>
                    <div class="talento-perfil-documentos-lista-info">
                        <h3><?php echo $registro->getTitulo()?></h3>
                        <?php echo $registro->getContenido(ESC_RAW)?>
                        
                    </div>
                    <div class="talento-perfil-documentos-lista-control">
                        <a href="<?php echo $registro->getArchivoValid()?>" target="_blank">
                            Descargar
                        </a>
                    </div>
                </li>
                <?php endif;?>
            
         <?php endforeach; ?>  
         </ul>       
        </div>
        <?php endif;?>
        <div class="talento-perfil-contacto">
            <a href="<?php echo url_for('contacto')?>">
                <img src="/images/jerryml/talento/publicacion/contacto_btn.png"/>
            </a>
        </div>
    </aside>
</section>

