<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
    <head>
        <title>
            <?php if (!include_slot('title')): ?>
                <?php echo $sf_response->getTitle() ?>
            <?php endif; ?>
        </title>
        <!--link rel="shortcut icon" href="/favicon.ico" /-->
        <?php include_stylesheets() ?>
    </head>
    <body>
        <div class="bg">
        <header>
            <div class="container">
                <table>
                    <tr>
                        <td>
                            <a href="#" id="logo">
                                <img src="/images/jerryml/Logojerryml.png" alt="logo"/>
                            </a>
                        </td>
                        <td>
                            <?php if (!include_slot('titulo-newsletter')): ?>
                                <?php echo $sf_response->getTitle() ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!include_slot('fecha-newsletter')): ?>
                                <?php echo date ( "d/m/y" , time()); ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </div>
        </header>
        <div id="container">    
             <?php echo $sf_content ?>
        </div>
        <footer>
            <div class="container">
                <div id="FooterTree" style=" padding: 0;text-align: center; width: 100%;">JERRY ML © 2012   Tel. (52 55) 5256 4484 • (52 55) 5212 1283 • <a href="<?php echo url_for('contacto')?>">Contacto</a></div> 
            </div>
        </footer>
       </div>     
    </body>
</html>
