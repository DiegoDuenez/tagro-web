<?php

include '../Utilities/Model.php';
include '../Utilities/Hash.php';
include '../Utilities/Response.php';
require '../Utilities/FileManager.php';

class Proyecto extends Model{

    protected $table = 'proyectos';

    public function index()
    {

        $proyectos = $this->select(["proyectos.*", "categorias.nombre_categoria"])
        ->join("categorias", "categorias.id", "=", "proyectos.categoria_id")
        ->orderBy("id", "DESC")
        ->get();
        
        return json(
            [
                'status' => 'success',
                'data' => $proyectos,
                'message' => '',
            ]
        , 200);

    }

    public function proyectosCategoria($categoria_id = null){

        if($categoria_id){
            $proyectos = $this->select(["proyectos.id",
            "proyectos.nombre_proyecto", "categorias.nombre_categoria",
            "imagenes.nombre_imagen"])
            ->join("categorias", "categorias.id", "=", "proyectos.categoria_id")
            ->join("imagenes_proyectos as ip", "ip.proyecto_id", '=', "proyectos.id")
            ->join("imagenes", "imagenes.id", '=', "ip.imagen_id")
            ->where("proyectos.categoria_id", "=", $categoria_id)
            ->where("imagenes.principal", "=", "1")
            ->where("proyectos.status", "=", "1")
            ->get();
        }
        else{
            $proyectos = $this->select(["proyectos.id",
            "proyectos.nombre_proyecto", "categorias.nombre_categoria",
            "imagenes.nombre_imagen"])
            ->join("categorias", "categorias.id", "=", "proyectos.categoria_id")
            ->join("imagenes_proyectos as ip", "ip.proyecto_id", '=', "proyectos.id")
            ->join("imagenes", "imagenes.id", '=', "ip.imagen_id")
            ->where("imagenes.principal", "=", "1")
            ->where("proyectos.status", "=", "1")
            ->get();
        }
        
        
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

            /*if($this->exists('nombre_proyecto', $nombre_proyecto))
            {
                return json(
                    [
                        'status' => 'error',
                        'data' => null,
                        'message' => "El proyecto $nombre_proyecto ya fue registrado",
                    ]
                , 400);
            }
            else{*/

                
                if($this->insert([
                    'nombre_proyecto' => $nombre_proyecto,
                    'categoria_id' => $categoria_id 
                ])->exec()){

                    return json(
                        [
                            'status' => 'success',
                            'data' => null,
                            'message' => 'El proyecto se registro correctamente',
                        ]
                    , 201);

                }
               
            //}


        } catch(Exception $e) {

            return $e->getMessage();
            die();

        }

    }

    public function subirImagenesProyecto($imagenes, $proyecto_id){

        for($i = 0; $i < count($imagenes['name']); $i++){

            $nombre = $imagenes['name'][$i];
            $ruta = "../../../resources/proyectos/".$nombre;

            if($this->rawStatment("INSERT INTO imagenes (nombre_imagen) VALUES ('$nombre')")->exec()){

                $imagen_id = $this->lastIdIn("imagenes");

                $this->rawStatment("INSERT INTO imagenes_proyectos (proyecto_id, imagen_id) VALUES ($proyecto_id, $imagen_id)")->exec();

                FileManager::moveTo($imagenes['tmp_name'][$i],$ruta);

            }

        }

        return json(
            [
                'status' => 'success',
                'data' => ['proyecto_id' => $proyecto_id],
                'message' => 'Se subieron las imagenes correctamente',
            ]
        , 201);

    }

    public function edit($nombre_proyecto, $categoria_id, $id)
    {

        /*if($this->exists('nombre_proyecto', $nombre_proyecto, $id))
        {
             return json(
                 [
                     'status' => 'error',
                     'data' => null,
                     'message' => "El proyecto $nombre_proyecto ya fue registrado ",
                 ]
             , 400);
        }
        else{*/
 
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
       // }
         
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