<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of components
 *
 * @author dioner911
 */
class publicacionesComponents extends sfComponents {
    public function executeCategorias(sfWebRequest $request)
    {

        $this->categorias = Doctrine_Core::getTable('CategoriasPublicaciones')->getCategoriasActivas();
        $this->ventas4=Doctrine_Core::getTable('Ventas')->getVentas(4);
        
        /*$this->widgetPorFecha = new sfWidgetFormChoice(array(
            'choices' => array('Enero'=>1, 
                                'Febrero'=>2,
                                'Marzo'=>3,
                                'Abril'=>4,
                                'Mayo'=>5,
                                'Junio'=>6,
                                'Julio'=>7,
                                'Agosto'=>8,
                                'Septiembre'=>9,
                                'Octubre'=>10,
                                'Noviembre'=>11,
                                'Diciembre'=>12,
                                ),
                        ));*/
        
    }



}
?>

