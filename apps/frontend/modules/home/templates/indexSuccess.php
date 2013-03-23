<?php use_javascript('widget.js') ?>
<?php use_javascript('jquery.featureList-1.0.0.js')?>
<?php use_helper('Escaping') ?>

        <div class="holder_content">
            <!--start intro-->
            <section class="seccion-galeria">
            <!-- .box -->
            <div class="box alt-bg">
              <div class="left-top-corner">
                <div class="right-top-corner">
                  <div class="inner1">

                <!-- slider -->
                    <div id="feature_list">
                      <ul id="output">
                        <?php foreach($list_registros as $key=>$registro):?>
                        <li>
                          <?php $galeria=$registro->getPublicacionesGaleria();?>
                          <?php $arregloGaleria[$key]=$galeria[0]->getRenderImagen(195,95)?>  
                          <img src="<?php echo $galeria[0]->getRenderImagen(706,369);?>" alt="<?php echo $registro->getTitulo()?>" width="706px" height="369px" />
                          <div class="description">
                            <div class="indent">
                              <h2><?php echo $registro->getTitulo()?><span></span></h2>
                              <a href="<?php echo url_for('publicacion',$registro)?>" class="link1"><em><b>ver mas</b></em></a>
                            </div>
                          </div>
                        </li>
                        <?php endforeach;?>
                      </ul>
                      <ul id="tabs">
                        <?php foreach($list_registros as $key=>$registro):?>  
                        <li>
                          <a href="javascript:;">
                            <img src="<?php echo $arregloGaleria[$key];//$registro->getRenderImagen(175,95)?>" alt="<?php echo $registro->getTitulo()?>" width="175px" height="95px"/>
                            <span><?php echo $registro->getTitulo()?><br />
                            </span>
                          </a>
                        </li>
                        <?php endforeach;?>
                      </ul>
                    </div>
                    <!-- slider -->
                    </div>
                </div>
              </div>
            </div>
            <!-- /.box -->

            </section>
            <section class="seccion-inicio">
                <div class="texto-principal">
                <h3><?php echo $home->getSeccion()?></h3>
                <?php echo $home->getContenido(ESC_RAW)?>
                </div>
                <div class="newsletter">
                    <h3>
						suscribirse a newsletter
						<br/> 
						<img src="/images/jerryml/envelope.png"/>
                    </h3>
                    <div id="form_newsletter">
                        <?php include_partial('home/form_newsletter', array('mensaje_newsletter'=>'','create_user'=>false)) ?>  
                    </div>
                </div>   
            </section>
            
            
            <!--end intro-->    
            <div style="clear: both;"></div>
            <section class="section-twitters">
                <div style="width:100%; height: 60px;">
                
                <a href="https://twitter.com/#!/jerryml1" target="_blank"  style="position: absolute; left:5px;top:5px;">
                    <img src="/images/jerryml/twitterlogo.jpg"/>
                </a>
                 <a href="http://www.facebook.com/profile.php?id=100002635078209" target="_blank" style="position: absolute; left:155px;top:5px;">
                    <img src="/images/facebooklogo.jpg"/>
                </a>    
                <a href="https://twitter.com/#!/jerryml1" target="_blank" style="position: absolute; right:5px;top:5px;">
                    <img src="/images/jerryml/twitter_btn.png"/>
                </a>
                </div>    
                <?php include_partial('home/twitters', array('usuario'=>'jerryml1','nombre'=>'Jerry ML')) ?>  
            </section>
      
            
	</div>
<script type="text/javascript">
    $(document).ready(function() {
    	$.featureList(
            $("#tabs li a"),
            $("#output li"), {
		start_item	:	0
		}
	);
	//fade effect for img
	$("ul#output li img").fadeIn();
        	
    });
</script>
