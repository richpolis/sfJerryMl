<?php use_javascript('jquery.form.js')?>

<form action="<?php echo url_for('newsletter')?>" class="newsletter-form" style="position:relative; top:-10px;">
    <?php if(!$create_user):?>
    <label style="text-align: center;">
        <input type="text" name="nombre" class="text" value="NOMBRE" onfocus="if(this.value=='NOMBRE'){this.value=''}" onblur="if(this.value==''){this.value='NOMBRE'}"/>
    </label>
    <label style="text-align: center;">
        <input type="text" name="email" class="text" value="EMAIL" onfocus="if(this.value=='EMAIL'){this.value=''}" onblur="if(this.value==''){this.value='EMAIL'}"/>
    </label>
    <?php else:?>
    <div style="width: 100%; height: 60px; text-align: center; vertical-align: middle;">
      <?php echo $mensaje_newsletter?>  
    </div>
    <?php endif;?>
    <label style="text-align: center;">
        <?php if(!$create_user):?>
        <input style="margin-left: 58px; margin-top: 10px;" type="image" class="image" src="/images/jerryml/join_btn.png"/>
        <?php else:?>
        <img style="margin-left: 58px; margin-top: 10px;" src="/images/jerryml/join_btn-check.png"/>
        <?php endif;?>
    </label>
</form>
<script type="text/javascript"> 
        // esperamos que el DOM cargue
        $(document).ready(function() { 
            // definimos las opciones del plugin AJAX FORM
            var opciones= {
                target:        '#form_newsletter',   // target element(s) to be updated with server response 
                beforeSubmit: validarFormulario, //funcion que se ejecuta antes de enviar el form
                success: mostrarRespuesta, //funcion que se ejecuta una vez enviado el formulario
							   
            };
             //asignamos el plugin ajaxForm al formulario myForm y le pasamos las opciones
            $('form.newsletter-form').ajaxForm(opciones) ; 
            
            //funciones para controlar el formulario
            function validarFormulario(formData, jqForm, options) { 
             
                //variables del formulario
                var nombreValue = $('input[name=nombre]').fieldValue(); 
                var emailValue = $('input[name=email]').fieldValue(); 

                // validamos los datos
                if (!nombreValue[0] || !emailValue[0]) { 
                    alert('Ingresa los datos correctos'); 
                    return false; 
                } 
                if(nombreValue[0]=='NOMBRE'){
                    alert('Ingresa tu nombre');
                    $('input[name=nombre]').focus(); 
                    return false; 
                }
                if(emailValue[0]=='EMAIL'){
                    alert('Ingresa tu email');
                    $('input[name=email]').focus(); 
                    return false; 
                }
                if(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(emailValue[0])){
                    $('input[type=image]').attr('src', '/images/loader.gif');
                    return true;
                }else{
                    alert('El email no es correcto');
                    $('input[name=email]').focus(); 
                    return false;
                }
                
            }
             function mostrarRespuesta (responseText){
	            $('input[type=image]').attr('src', '/images/jerryml/join_btn-check.png');
             };
   
        }); 
    </script>
