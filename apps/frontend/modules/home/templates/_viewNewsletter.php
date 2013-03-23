<?php 
if(!isset($vista_previa))$vista_previa=false;
?>
 <?php use_helper('Escaping')?>
            <style type="text/css">
            div.controles-newsletter{
                position: static;
                width: 100%;
                right: 0px;
                bottom: 100px;
                z-index: 1000;
            }
            div.controles-newsletter ul{
              list-style: none;
              padding: 0px;
            }
            div.controles-newsletter ul li{
              display: inline;
              list-style: none;
              margin-left: 20px;
            }
            
            
            
            

            .section-ventas h3,.section-ventas h6{
                color: #0084B4;
            }
            .section-ventas h6{
                position: relative;
            }
            footer {
                
            }
            #overlay{
                width:100%;
                height:100%;
                position:fixed;
                top:0;
                left:0;
                background-color:#000;
                opacity:0.4;
                filter:alpha(opacity=0.4);
                z-index:200;
            }

            #preloader{
                background: url("http://jerryml.phrenesis.net/images/preloader.gif") no-repeat 12px 10px #000000;
                font-size: 11px;
                height: 20px;
                left: 50%;
                line-height: 20px;
                margin: -20px 0 0 -45px;
                padding: 10px;
                position: fixed;
                text-align: left;
                text-indent: 36px;
                top: 50%;
                width: 120px;
                z-index: 201;
                color:white;
                opacity:0.8;
                filter:alpha(opacity=0.8);
                -moz-border-radius: 12px;
                -webkit-border-radius: 12px;
                border-radius: 12px;
            }
            

        </style>
      <?php if($vista_previa):?>
        <div class="controles-newsletter">
            <ul>
                <li>
                    <a id="boton_enviar"  href="javascript:void(0);" pagina="<?php echo url_for('enviar_newsletter',$template)?>">
                        Enviar a <?php echo $list_registros->count();?> emails
                    </a>
                </li>
                <li>
                    <div style="display:none;" id="mensaje_enviados" ></div>
                </li>
                <li>
                    <a href="javascript:void(0);" onclick="javascript:window.close();">
                        Cerrar
                    </a>
                </li>
            </ul>
        </div>
        <script type="text/javascript" src="http://jerryml.phrenesis.net/js/jquery-1.4.4.min.js"></script>
        <script>
         $(document).ready(function(){
          var overlay = {
                show    : function(){
                    $('body').append('<div id="overlay"></div><div id="preloader">Enviando...</div>');
                },
                hide    : function(){
                    $('#overlay,#preloader').remove();
                }
            }

            $("#boton_enviar").click(function(){
             overlay.show();
                $.post($(this).attr('pagina'),function(data){
                  $("#boton_enviar").fadeOut('fast',function(){
                      $("#mensaje_enviados").text(data).fadeIn("fast",function(){
                          overlay.hide();
                      });
                  });  
                });


            });
                
         });
            
            
        </script>
        <?php endif;?>    
          
      <div class="bg" style="font-family: Arial,Helvetica,sans-serif;font-size: 13px;color: rgb(87, 87, 87); line-height: 1.7; width: 100%; margin: 0 auto; padding: 0;">
            <table  cellspacing="0" width="700">
             <thead>
              <tr>
                <th height="150" width="10"></th>
                <!-- background-image: url(http://jerryml.phrenesis.net/images/jerryml/Header_background.jpg) -->
                <th valign="middle" align="top" style=" background-color:  #0084B4;height: 153px;background-repeat: repeat-x;" height="150" width="600" style="font-size: 34px; color: white;">
                    <table>
                        <tr>
                            <td>
                                <img src="http://jerryml.phrenesis.net/images/jerryml/Logojerryml.png" alt="logo" width="150" />
                            </td>
                            <td style="font-size: 24px; color: white;" valign="middle" align="left" width="400">
                                <?php echo $template->getTitulo(); ?>
                            </td>
                            <td style="font-size: 12px; color: white;"  valign="middle" align="top" width="150">
                                <?php echo $template->getDateNewsletter("d/m/y"); ?>
                            </td>
                        </tr>    
                    </table>
                </th>
                <th height="150" width="10"></th>
               </tr>
               <!--tr>
                   <th colspan="3" align="center" style="color: #0084B4; text-align: left; padding-left: 100px;font-size: 14px;">Newsletter Jerry ML</th>
               </tr-->
            </thead>
            <tfoot style="position: relative;height: 60px;clear: both;width: 100%; background-image: url(http://jerryml.phrenesis.net/images/jerryml/footer_background.jpg);background-position: left top;background-repeat: repeat-x;margin-bottom: 18px;background-color: black;">
                    <tr class="container">
                        <td></td>
                        <td height="60" COLSPAN=2 id="FooterTree" style=" padding: 0;text-align: center; width: 100%; color: white;">JERRY ML © 2012   Tel. (52 55) 5256 4484 • (52 55) 5212 1283 • <a href="http://www.jerryml.com" target="_blank">www.jerryml.com</a></td> 
                    </tr>
            </tfoot>
            <tbody style="padding-top: 30px; width: 100%;">
                <?php foreach($template->getPublicacionesNewsletters() as $registro):?>
                    <tr >
                     <td width="10" style="border-bottom: 1px solid #0084B4;"></td>
                     <!-- background-image: url(http://jerryml.phrenesis.net/images/jerryml/contenedor_ventas.png); -->
                     <td style="padding: 0px; background-color:white;background-position: center;background-repeat: no-repeat;height: 264px;width: 100%; border-bottom: 1px solid #0084B4;">
                         <table>
                             <tr>
                                 <td>
                                     <img src="<?php echo $registro->getThumbnailValid()?>" width="220px" height="220px" style="border: 3px solid #0084B4;" />
                                 </td>
                                 <td class="ventas-item-descripcion" style="margin-right: 10px;width:470px;padding-left: 10px;">
                                     <table height="100%" width="100%">
                                         <tr height="10" width="100%" >
                                             <td align="left" valign="top">
                                                 <h3 style="color: #0084B4;"><?php echo $registro->getTitulo()?></h3>
                                             </td>
                                         </tr>
                                         <tr height="200" width="100%">
                                             <td align="left" valign="top">
                                                 <?php echo $registro->getContenido(ESC_RAW)?>
                                             </td>
                                         </tr>
                                     </table>
                                </td>
                             </tr>
                             <tr>
                                 <td align="left" valign="middle">
                                     <a href="<?php echo $registro->getArchivoValid()?>" target="_blank" style="font-size: x-small;">
                                         Ver Imagen
                                     </a>
                                 </td>
                                 <td></td>
                             </tr>
                             
                         </table>
                     </td>
                     <td width="10" style="border-bottom: 1px solid #0084B4;" ></td> 
                    </tr>
                <?php endforeach;?>
            </tbody>   
            
      </table>  
</div>
