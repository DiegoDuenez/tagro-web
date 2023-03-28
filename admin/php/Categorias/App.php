<?php

require 'Categoria.php';

$func = input('func');

$Categoria = new Categoria;

switch($func){

    case 'index':

        echo $Categoria->index();

        break;

    case 'create':

        $nombre_categoria = input('nombre_categoria');

        echo $Categoria->create($nombre_categoria);

        break;

    case 'edit':

        $id = input('id');
        $nombre_categoria = input('nombre_categoria');

        echo $Categoria->edit($nombre_categoria, $contrasenia, $id);

        break;

    case 'activar':

        $id = input('id');
        echo $Categoria->activar($id);
    
        break;
    
    case 'desactivar':
    
        $id = input('id');
        echo $Categoria->desactivar($id);
    
        break;
    
    default:

        echo notDefine();
    
        break; 
}