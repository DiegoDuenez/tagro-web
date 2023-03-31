<?php

include '../Utilities/Model.php';
include '../Utilities/Hash.php';
include '../Utilities/Response.php';

class Categoria extends Model{

    protected $table = 'categorias';

    public function index()
    {

        $categorias = $this->select()
        ->orderBy("id", "DESC")
        ->get();
        
        return json(
            [
                'status' => 'success',
                'data' => $categorias,
                'message' => '',
            ]
        , 200);

    }

    public function categoriasActivas()
    {

        $categorias = $this->select()
        ->where("status","=","1")
        ->get();
        
        return json(
            [
                'status' => 'success',
                'data' => $categorias,
                'message' => '',
            ]
        , 200);

    }

    public function create($nombre_categoria)
    {

        try{

            if($this->exists('nombre_categoria', $nombre_categoria))
            {
                return json(
                    [
                        'status' => 'error',
                        'data' => null,
                        'message' => "La categoria $nombre_categoria ya fue registrada",
                    ]
                , 400);
            }
            else{

                $this->insert([
                    'nombre_categoria' => $nombre_categoria,
                ])->exec();

                return json(
                    [
                        'status' => 'success',
                        'data' => null,
                        'message' => 'La categoria se registro correctamente',
                    ]
                , 201);
            }


        } catch(Exception $e) {

            return $e->getMessage();
            die();

        }

    }

    public function edit($nombre_categoria, $id)
    {

        if($this->exists('nombre_categoria', $nombre_categoria, $id))
        {
             return json(
                 [
                     'status' => 'error',
                     'data' => null,
                     'message' => "La categoria $nombre_categoria ya fue registrado ",
                 ]
             , 400);
        }
        else{
 
            $this->update([
                'nombre_categoria' => $nombre_categoria,
            ])
            ->where('id','=',$id)
            ->exec();
 
            return json(
                [
                    'status' => 'success',
                    'data' => null,
                    'message' => 'La categoria se edito correctamente',
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
                'message' => 'La categoria se activo correctamente',
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
                'message' => "La categoria se desactivo correctamente",
            ]
        , 200);

    }

}