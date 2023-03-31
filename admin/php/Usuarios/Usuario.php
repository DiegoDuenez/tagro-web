<?php

include '../Utilities/Model.php';
include '../Utilities/Hash.php';
include '../Utilities/Response.php';

class Usuario extends Model{

    protected $table = 'usuarios';

    public function index()
    {

        $usuarios = $this->select(["usuarios.id", "usuarios.usuario", "usuarios.status"])
        ->orderBy("id", "DESC")
        ->get();
        
        return json(
            [
                'status' => 'success',
                'data' => $usuarios,
                'message' => '',
            ]
        , 200);

    }

    public function create($usuario, $contrasenia)
    {

        try{

            if($this->exists('usuario', $usuario))
            {
                return json(
                    [
                        'status' => 'error',
                        'data' => null,
                        'message' => "El usuario $usuario ya fue registrado",
                    ]
                , 400);
            }
            else{

                $this->insert([
                    'usuario' => $usuario,
                    'contrasenia' => Hash::make($contrasenia)
                ])->exec();

                return json(
                    [
                        'status' => 'success',
                        'data' => null,
                        'message' => 'El usuario se registro correctamente',
                    ]
                , 201);
            }


        } catch(Exception $e) {

            return $e->getMessage();
            die();

        }

    }

    public function edit($usuario, $contrasenia = false, $id)
    {

        if($this->exists('usuario', $usuario, $id))
        {
             return json(
                 [
                     'status' => 'error',
                     'data' => null,
                     'message' => "El usuario $usuario ya fue registrado " . $id,
                 ]
             , 400);
        }
        else{
 
            if($contrasenia){
                
                $this->update([
                    'usuario' => $usuario,
                    'contrasenia' => Hash::make($contrasenia)
                ])
                ->where('id','=',$id)
                ->exec();

            }
            else{

                $this->update([
                    'usuario' => $usuario,
                ])
                ->where('id','=',$id)
                ->exec();

            }
           
 
            return json(
                [
                    'status' => 'success',
                    'data' => null,
                    'message' => 'El usuario se edito correctamente',
                ]
            , 200);
        }
         

    }

    public function login($usuario, $contrasenia){


        $usuario = $this->select(['*'])
        ->where("usuarios.usuario", "=", $usuario)
        ->where("usuarios.status", "=", 1)
        ->limit(1)
        ->get();

        
       
        if($usuario){
            if(Hash::verify($contrasenia, $usuario[0]['contrasenia'])){

                return json(
                    [
                        'status' => 'success',
                        'data' => $usuario[0],
                        'message' => ''
                    ]
                , 200);

            }
            else{

                return json(
                    [
                        'status' => 'error',
                        'data' => null,
                        'message' => 'Datos incorrectos'
                    ]
                , 404);
                
            }
        }
        else{
            return json(
                [
                    'status' => 'error',
                    'data' => null,
                    'message' => 'No se encontro ningun usuario'
                ]
            , 404);
        }


    }

    public function activar($id){

        $this->update([
            'status' => '1'
        ])
        ->where('id','=',$id)
        ->exec();

        return json(
            [
                'status' => 'success',
                'data' => null,
                'message' => 'El usuario se activo correctamente',
            ]
        , 200);

    }

    public function desactivar($id){

        $this->update([
            'status' => '0'
        ])
        ->where('id','=',$id)
        ->exec();

        return json(
            [
                'status' => 'success',
                'data' => null,
                'message' => 'El usuario se desactivo correctamente',
            ]
        , 200);

    }

}