<?php

require 'Usuario.php';

$func = input('func');

$Usuario = new Usuario;

switch($func){

    case 'index':

        echo $Usuario->index();

        break;

    case 'create':

        $usuario = input('usuario');
        $contrasenia = input('contrasenia');

        echo $Usuario->create($usuario, $contrasenia);

        break;

    case 'edit':

        $id = input('id');
        $usuario = input('usuario');
        $contrasenia = input('contrasenia', true);

        echo $Usuario->edit($usuario, $contrasenia, $id);

        break;

    case 'login':

        $usuario = input('usuario');
        $contrasenia = input('contrasenia');

        echo $Usuario->login($usuario, $contrasenia);

        break;

    case 'activar':

        $id = input('id');
        echo $Usuario->activar($id);
    
        break;
    
    case 'desactivar':
    
        $id = input('id');
        echo $Usuario->desactivar($id);
    
        break;
    
    default:

        echo notDefine();
    
        break; 
}