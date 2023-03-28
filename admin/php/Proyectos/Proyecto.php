<?php

include '../Utilities/Model.php';
include '../Utilities/Hash.php';
include '../Utilities/Response.php';

class Proyecto extends Model{

    protected $table = 'proyectos';

    public function index()
    {

        $proyectos = $this->select()
        ->get();
        
        return json(
            [
                'status' => 'success',
                'data' => $proyectos,
                'message' => '',
            ]
        , 200);

    }

    public function create($nombre_proyecto, $categoria_id)
    {

        try{

            if($this->exists('nombre_proyecto', $nombre_proyecto))
            {
                return json(
                    [
                        'status' => 'error',
                        'data' => null,
                        'message' => "El proyecto $nombre_proyecto ya fue registrada",
                    ]
                , 400);
            }
            else{

                $this->insert([
                    'nombre_proyecto' => $nombre_proyecto,
                    'categoria_id' => $categoria_id 
                ])->exec();

                return json(
                    [
                        'status' => 'success',
                        'data' => null,
                        'message' => 'El proyecto se registro correctamente',
                    ]
                , 201);
            }


        } catch(Exception $e) {

            return $e->getMessage();
            die();

        }

    }

    public function edit($nombre_proyecto, $categoria_id, $id)
    {

        if($this->exists('nombre_proyecto', $nombre_proyecto, $id))
        {
             return json(
                 [
                     'status' => 'error',
                     'data' => null,
                     'message' => "El proyecto $nombre_proyecto ya fue registrado ",
                 ]
             , 400);
        }
        else{
 
            $this->update([
                'nombre_proyecto' => $nombre_proyecto,
                'categoria_id' => $categoria_id 
            ])
            ->where('id','=',$id)
            ->exec();
 
            return json(
                [
                    'status' => 'success',
                    'data' => null,
                    'message' => 'El proyecto se edito correctamente',
                ]
            , 200);
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
                'message' => 'El proyecto se activo correctamente',
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
                'message' => "El proyecto se desactivo correctamente",
            ]
        , 200);

    }

}