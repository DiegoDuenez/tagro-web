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

    case 'proyectosCategoria':

        $categoria_id = input("categoria_id", true);
        echo $Proyecto->proyectosCategoria($categoria_id);

        break;

    case 'create':

        $nombre_proyecto = input("nombre_proyecto");
        $categoria_id = input("categoria_id");

        echo $Proyecto->create($nombre_proyecto, $categoria_id);

        break;

    case 'edit':

        $id = input("id");
        $nombre_proyecto = input("nombre_proyecto");
        $categoria_id = input("categoria_id");

        echo $Proyecto->edit($nombre_proyecto, $categoria_id, $id);

        break;

    case 'subirImagenesProyecto':

        $proyecto_id = formdata("proyecto_id");
        $imagenes = FileManager::get("imagenes");

        echo $Proyecto->subirImagenesProyecto($imagenes, $proyecto_id);

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