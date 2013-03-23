<?php use_javascript('jquery.easing.1.3.js')?>
<?php slot('categorias-talento-encabezado')?>
<div class="categorias-talento-encabezado">
    <div class="categorias-talento-encabezado-control-pagina">
            <img style="cursor:pointer;" class="control-pagina-left" src="/images/jerryml/talento/categorias/left_arrow.png"/>
            <img style="cursor:pointer;" class="control-pagina-right" src="/images/jerryml/talento/categorias/right_arrow.png"/>
    </div>    
</div>
<?php end_slot()?>
<section class="categorias-talento">
    <div class="categorias-talento-container" style="width: <?php echo $categorias->count()*315?>px;">
    <?php foreach($categorias as $key=>$categoria):?>
    <article class="categorias-talento-item">
        <div class="categorias-talento-item-titulo">
            <h3><?php echo $categoria->getCategoria()?></h3>
        </div>
        <div class="categorias-talento-container-ul" style="width: 275px; height: 1030px; overflow: hidden; ">
        <?php $cont=1;?>
        <ul class="ul-<?php echo $categoria->getSlug()?>" style="position:relative;">
            <?php foreach($categoria->getTalento() as $talento):?>
            
            <li id="<?echo $categoria->getSlug().'-'.$cont?>" class="categorias-talento-item-imagen">
                <img style="cursor:pointer;" src="<?php echo $talento->getThumbnailValid()?>" onclick="$.irAPagina('<?php echo url_for('categoria_talento',$categoria)?>');"/>
            </li>
            <?php $cont++;?>
            

            <?php endforeach;?>
    	
        </ul>
        </div>    
        <div class="control">
            <a href="<?php echo url_for('categoria_talento',$categoria)?>">
                <?php echo $categoria->getCategoria()?> <img src="/images/jerryml/talento/categorias/icono_flechita.png"/>
            </a>
	</div>        
    </article>
    <?php endforeach;?>
    </div>
   
</section>
<script>
   
    $(document).ready(function(){
       var $listItem=$(".categorias-talento-item"),
          largolistItem=Math.ceil($listItem.length/1)-1,
          indicelistItem=0,
          $controlAnterior=$("img.control-pagina-left"),
          $controlSiguiente=$("img.control-pagina-right");

        $controlSiguiente.click(function(){
            if(indicelistItem<largolistItem){
                indicelistItem++;
            }
            var posicion=(indicelistItem*315)*1;
            $(".categorias-talento-container").animate({'left':'-'+posicion+'px'},"slow");
			
        });
        $controlAnterior.click(function(){
            if(indicelistItem  >= 1){
                indicelistItem--;
            }
            var posicion=(indicelistItem*315)*1;
            $(".categorias-talento-container").animate({'left':'-'+posicion+'px'},"slow");
        });
        
       
        
        
        /*$('.categorias-talento-item-imagen').hover(function(){
        	$('img', this).stop(true, true).fadeIn(200);
	}, function(){
		$('img', this).stop(true, true).fadeOut(200);
	});*/
    });
    jQuery.irAPagina=function(pagina){
        location.href=pagina;
    }
    <?php foreach($categorias as $key=>$categoria):?>
    <?php if($categoria->getTalento()->count()>0):?>    
        
    jQuery.<?php echo $categoria->getSlug()?>=function(){
        $('.ul-<?php echo $categoria->getSlug()?> li:first-child').slideUp("slow",function(){
            $('.ul-<?php echo $categoria->getSlug()?>').append($(this).slideDown("fast"));
        });
        
        setTimeout(function(){
            $.<?php echo $categoria->getSlug()?>();
        },2000);
    }
    setTimeout(function(){
            $.<?php echo $categoria->getSlug()?>();
    },2000);
    <?php endif;?>
    <?php endforeach;?>
   
</script>
