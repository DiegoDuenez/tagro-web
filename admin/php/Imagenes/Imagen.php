<?php

include '../Utilities/Model.php';
include '../Utilities/Hash.php';
include '../Utilities/Response.php';

class Imagen extends Model{

    protected $table = 'imagenes';

    public function index()
    {

        $imagenes = $this->select()
        ->get();
        
        return json(
            [
                'status' => 'success',
                'data' => $imagenes,
                'message' => '',
            ]
        , 200);

    }

    public function imagenesProyecto($proyecto_id)
    {

        $imagenes = $this->select(['imagenes.*', 'ip.proyecto_id', 'proyectos.nombre_proyecto', 'categorias.nombre_categoria'])
        ->join("imagenes_proyectos as ip", "ip.imagen_id", "=", "imagenes.id")
        ->join("proyectos", "ip.proyecto_id", "=", "proyectos.id")
        ->join("categorias", "categorias.id", "=", "proyectos.categoria_id")
        ->where("proyectos.id", "=", $proyecto_id)
        ->orderBy("principal", "DESC")
        ->get();
        
        return json(
            [
                'status' => 'success',
                'data' => $imagenes,
                'message' => '',
            ]
        , 200);

    }

    public function cambiarImagenPrincipal($id, $proyecto_id){

        $this->rawStatment("UPDATE imagenes 
        INNER JOIN imagenes_proyectos as ip on ip.imagen_id = imagenes.id
        SET principal = 0
        WHERE ip.proyecto_id = '$proyecto_id' and principal = 1")->exec();

        $this->rawStatment("UPDATE imagenes SET principal = 1 WHERE id = '$id' ")->exec();

        return json(
            [
                'status' => 'success',
                'data' => null,
                'message' => 'Se actualizo la imagen principal',
            ]
        , 200);


    }

    public function destroy($id){

        $proyecto_id = $this->rawQuery("SELECT * FROM imagenes_proyectos WHERE imagen_id = $id")->get()[0]['proyecto_id'];

        if($this->rawStatment("DELETE FROM imagenes_proyectos WHERE imagen_id = $id")->exec()){

            $this->delete()
            ->where("id", "=", $id)
            ->exec();
    
            return json(
                [
                    'status' => 'success',
                    'data' => ['proyecto_id' => $proyecto_id],
                    'message' => 'Se elimino la imagen',
                ]
            , 200);
    
        }

     

    }


}