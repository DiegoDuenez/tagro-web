<?php

require 'Imagen.php';

$func = input('func');

$Imagen = new Imagen;

switch($func){

    case 'index':

        echo $Imagen->index();

        break;

    case 'imagenesProyecto':

        $proyecto_id = input('proyecto_id');

        echo $Imagen->imagenesProyecto($proyecto_id);

        break;

    case 'cambiarImagenPrincipal':

        $id = input('id');
        $proyecto_id = input('proyecto_id');

        echo $Imagen->cambiarImagenPrincipal($id, $proyecto_id);

        break;

    case 'delete':

        $id = input('id');

        echo $Imagen->destroy($id);
        
        break;

    default:

        echo notDefine();
    
        break; 
}