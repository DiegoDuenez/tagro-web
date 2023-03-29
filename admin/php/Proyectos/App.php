<?php

require 'Proyecto.php';

if(input('func', true)){
    $func = input('func');
}
else if(formdata('func', true)){
    $func = formdata('func');
}

$Proyecto = new Proyecto;

switch($func){

    case 'index':

        echo $Proyecto->index();

        break;

    case 'create':

        $nombre_proyecto = formdata("nombre_proyecto");
        $categoria_id = formdata("categoria_id");
        $imagenes = FileManager::get("imagenes");

        echo $Proyecto->create($nombre_proyecto, $categoria_id, $imagenes);

        break;

    case 'activar':

        $id = input('id');
        echo $Proyecto->activar($id);
    
        break;
    
    case 'desactivar':
    
        $id = input('id');
        echo $Proyecto->desactivar($id);
    
        break;
    
    default:

        echo notDefine();
    
        break; 

}