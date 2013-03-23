<?php use_helper('Escaping')?>
<?php use_javascript('modernizr.js') ?>
<?php use_javascript('jquery.nicescroll.min.js') ?>
<?php //use_javascript('jquery.easing.1.3.js') ?>
<?php //use_javascript('jquery.mousewheel.min.js') ?>

<!--style type="text/css">
.mcs_container .customScrollBox{position:relative; height:100%; overflow:hidden;}
.mcs_container .customScrollBox .container{position:relative; width:240px; top:0; float:left;}
.mcs_container .customScrollBox .content{clear:both;}
.mcs_container .customScrollBox .content p{padding:0 5px; margin:10px 0; color:#fff; font-family:Verdana, Geneva, sans-serif; font-size:13px; line-height:20px;}
.mcs_container .customScrollBox .content p.alt{padding:10px 5px; margin:10px 0; color:#fff; font-family:Georgia, "Times New Roman", Times, serif; font-size:17px; line-height:19px; color:#999;}
.mcs_container .customScrollBox img{border:5px solid #fff;}
.mcs_container .dragger_container{position:relative; width:2px; height:525px; float:left; margin:40px 0 0 10px; background:#000; cursor:pointer -moz-border-radius:2px; -khtml-border-radius:2px; -webkit-border-radius:2px; border-radius:2px; cursor:s-resize;}
.mcs_container .dragger{position:absolute; width:2px; height:60px; background:#999; text-align:center; line-height:60px; color:#666; overflow:hidden; cursor:pointer; -moz-border-radius:2px; -khtml-border-radius:2px; -webkit-border-radius:2px; border-radius:2px;}
.mcs_container .dragger_pressed{position:absolute; width:4px; margin-left:-1px; height:60px; background:#999; text-align:center; line-height:60px; color:#666; overflow:hidden; -moz-border-radius:4px; -khtml-border-radius:4px; -webkit-border-radius:4px; border-radius:4px; cursor:s-resize;}
.mcs_container .scrollUpBtn,.mcs_container .scrollDownBtn{position:absolute; display:inline-block; width:14px; height:15px; margin-right:12px; text-decoration:none; right:0; filter:alpha(opacity=20); -moz-opacity:0.20; -khtml-opacity:0.20; opacity:0.20;}
.mcs_container .scrollUpBtn{top:16px; background:url(/images/mcs_btnUp.png) center center no-repeat;}
.mcs_container .scrollDownBtn{bottom:12px; background:url(/images/mcs_btnDown.png) center center no-repeat;}
.mcs_container .scrollUpBtn:hover,.mcs_container .scrollDownBtn:hover{filter:alpha(opacity=60); -moz-opacity:0.60; -khtml-opacity:0.60; opacity:0.60;}    
    

</style-->
<h1 class="titulo-pagina-h1">
    <span class="titulo-pagina-span">
        talento/<a href="<?php echo url_for('categoria_talento',$categoria_actual)?>" style="text-decoration: none;" ><?php echo $categoria_actual->getCategoria()?></a>
    </span>
</h1>
<section class="categoria-talento container-card">
    <?php foreach($list_registros as $publicacion):?>
    <article class="categoria-talento-item card publicacion-<?php echo $publicacion->getId()?>">
      <figure class="front">
            <span class="flip_front" onclick="$.showCardBackend('.publicacion-<?php echo $publicacion->getId()?>')"></span>
            <div class="categoria-talento-item-imagen" onclick="$.irAPagina('<?php echo url_for('talento_perfil',array('categoria_slug'=>$categoria_actual->getSlug(),'slug'=>$publicacion->getSlug()))?>')" style="cursor:pointer;">
                <img src="<?php echo $publicacion->getRenderGrayscaleImagen(193,193)?>"/>
            </div>
            <div class="control" onclick="$.irAPagina('<?php echo url_for('talento_perfil',array('categoria_slug'=>$categoria_actual->getSlug(),'slug'=>$publicacion->getSlug()))?>')" style="cursor:pointer;">
                <a href="#" class="control-opciones">
                    <?php echo $publicacion->getTitulo()?>
                    <!--span class="flecha">
                        &nbsp;
                    </span--> 
                </a>
            </div>
      </figure>
      <figure class="back">
          <span class="flip_back" onclick="$.showCardFrontend('.publicacion-<?php echo $publicacion->getId()?>')"></span>
          <div class="categoria-talento-item-opciones">
                <div class="opciones-disponible-para">
                    disponible para:
                </div>
                <div class="opciones-texto mcs_container">
                    <?php echo $publicacion->getDisponiblePara(ESC_RAW)?>
                </div>
                <div class="opciones-ver-perfil">
                    <a style="text-decoration: none;" href="<?php echo url_for('talento_perfil',array('categoria_slug'=>$categoria_actual->getSlug(),'slug'=>$publicacion->getSlug()))?>">
                    ver perfil
                    </a>
                </div>
            </div>
      </figure>
    </article>
    <?php endforeach;?>
</section>
<script>
    $(document).ready(function(){
        
        if (!Modernizr.csstransforms3d) {
            $(".categoria-talento-item").removeClass("card");
            $(".categoria-talento-item .back").fadeOut('fast');
        }
       $(".back").each(function(){
          $(this).hover(function(){
              $(".flip_back",this).fadeIn('fast'); 
          },function(){
             $(".flip_back",this).fadeOut('fast'); 
          }); 
       });
       
       //$(".opciones-texto").niceScroll({cursorcolor:"#0084B4"});
       
      
       
       /*$(".back").each(function(){
          $(this).hover(function(){
              $(".flip_back",this).fadeIn('fast'); 
          },function(){
             $(".flip_back",this).fadeOut('fast'); 
          }); 
       });
       
       $(".front").each(function(){
          $(this).hover(function(){
              $(".flip_front",this).fadeIn('fast'); 
          },function(){
             $(".flip_front",this).fadeOut('fast'); 
          }); 
       });*/
       
       /*$(".front").hover(function(){
             $(".flip_front",this).fadeIn('fast');
       },function(){
             $(".flip_front",this).fadeOut('fast');
       });*/
    });
jQuery.showCardBackend=function(clase){
    if (Modernizr.csstransforms3d) {
      $(clase).addClass('flipped').find('.opciones-texto').niceScroll({cursorcolor:"#0084B4"});
      /*setTimeout(function(){
          $(clase + ' .opciones-texto').niceScroll({cursorcolor:"#0084B4"});
      },500);*/
    }else{
      $(clase + ' .front').fadeOut('fast',function(){
          $(clase + ' .back').fadeIn('fast',function(){
              $(clase + ' .opciones-texto').niceScroll({cursorcolor:"#0084B4"});
          });
      });
    }
}
jQuery.showCardFrontend=function(clase){
    if (Modernizr.csstransforms3d) {
      $(clase).removeClass('flipped').find(".opciones-texto").getNiceScroll().hide();
      /*setTimeout(function(){
          $(clase + ' .opciones-texto').getNiceScroll().hide();
      },500);*/
    }else{
      $(clase + ' .back').fadeOut('fast',function(){
          $(clase + ' .front').fadeIn('fast',function(){
              $(clase + ' .opciones-texto').getNiceScroll().hide();
          });
      });
    }
}

jQuery.irAPagina=function(pagina){
    location.href=pagina;
}


</script>

<?php slot('nCustomScrollbar')?>
<!--script>
$(window).load(function() {
    $(".mcs_container").mCustomScrollbar("vertical",400,"easeOutCirc",1.05,"auto","yes","yes",10);
});

/* function to fix the -10000 pixel limit of jquery.animate */
$.fx.prototype.cur = function(){
    if ( this.elem[this.prop] != null && (!this.elem.style || this.elem.style[this.prop] == null) ) {
      return this.elem[ this.prop ];
    }
    var r = parseFloat( jQuery.css( this.elem, this.prop ) );
    return typeof r == 'undefined' ? 0 : r;
}

/* function to load new content dynamically */
function LoadNewContent(id,file){
	$("#"+id+" .customScrollBox .content").load(file,function(){
		mCustomScrollbars();
	});
}

</script>
<script src="/js/jquery.mCustomScrollbar.js" type="text/javascript"></script-->

<?php end_slot();?>