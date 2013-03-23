<table width="100%" class="table-galeria">
    <tr height="200px">
        <td width="30px">
            <img class="control-pagina control-pagina-atras" src="/images/jerryml/talento/publicacion/left_arrow.jpg"/>  
        </td>
        <td>
            <div style="width: 552px;height: 210px;">
                <?php foreach($galeria as $registro):?>
                <?php if($registro->getTipoArchivo()<=1):?>
                <div class="galeria-item">
                    <a href="<?php echo $registro->getArchivoValid(); ?>" title="<?php echo $registro->getTitulo(); ?>" rel="prettyPhoto[pp_gal]" class="image-wrap">
                        <?php if($registro->getTipoArchivo()==1):?>
                            <img class="galeria-imagen" src="<?php echo $registro->getRenderImagen(128,95)?>" alt=""/>
                            <span class="zoom-icon"></span>
                        <?php elseif($registro->getTipoArchivo()==0):?>
                            <img class="galeria-imagen" src="<?php echo $registro->getThumbnailValid()?>" alt=""/>
                            <span class="video-icon"></span>
                        <?php endif;?>
                    </a>
                </div>
                <?php endif;?>
                <?php endforeach;?>
            </div>
        </td>
        <td width="30px">
            <img class="control-pagina control-pagina-delante" src="/images/jerryml/talento/publicacion/right_arrow.jpg"/>  
        </td>
    </tr>
</table>
<script>
    $(document).ready(function(){
       var $listGaleriaItem=$("div.galeria-item"),
          largoListGaleriaItem=Math.ceil($listGaleriaItem.length/8)-1,
          indiceListGaleriaItem=0,
          $controlAnterior=$("img.control-pagina-atras"),
          $controlSiguiente=$("img.control-pagina-delante");
          

          if($listGaleriaItem.length>8){
              $.mostrarListGaleriaItem(indiceListGaleriaItem,$listGaleriaItem);
          }else{
              $listGaleriaItem.show("slow",function(){
                  $controlAnterior.hide();
                  $controlSiguiente.hide();
              });
          }

        $controlAnterior.click(function(){
            if(indiceListGaleriaItem>=1){
                indiceListGaleriaItem--;
            }
            $.mostrarListGaleriaItem(indiceListGaleriaItem,$listGaleriaItem);
        });
        $controlSiguiente.click(function(){
            if(indiceListGaleriaItem<largoListGaleriaItem){
                indiceListGaleriaItem++;
            }
            $.mostrarListGaleriaItem(indiceListGaleriaItem,$listGaleriaItem);
        });
        
        $.configPrettyPhoto();
    });
    jQuery.mostrarListGaleriaItem=function(indice,$list){
            var min=indice*8;
            var max=min+8;
            $list.fadeOut('fast',function(){
                setTimeout(function(){
                    while(min<$list.length && (min<max)){
                        $list.eq(min).fadeIn('slow');
                        min++;
                    }
                },500);
            });
     }
</script>