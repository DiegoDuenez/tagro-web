<?php

header('Content-Type: application/json; charset=utf-8');

/**
 * Sanitiza los datos de entrada para evitar injecciones de html
 * @param mixed $input
 * @return string
 */
function sanitize($input){
    return trim(htmlspecialchars($input));
}


/**
 * Retorna una respuesta en formato json
 * @param mixed $data
 * @param int $status_code
 * @return string 
 */
function json($data, $status_code = 200){

    http_response_code($status_code);
    return json_encode($data);

}

function stringJSONToArray($string){

    $obj = str_replace("\r\n", " ", str_replace("'", '"',str_replace('"', "'", $string)));
    $array = json_decode($obj, true);
    return $array;

}


/**
 * Recoje el valor de una entrada de datos
 * @param mixed $key
 * @param int $optional
 * @return string 
 */
function input($key, $optional = false, $default = false, $sanitize = true){

    $data= json_decode(file_get_contents('php://input'), true);

    try{

        if($sanitize){

            if($optional){

                if($default){
                    return isset($data[$key]) ? sanitize($data[$key]) : $default;
                }
                else{
                    return isset($data[$key]) ? sanitize($data[$key]) : false;
                }
    
            }
            else{
    
                if($default){
                    return isset($data[$key]) ? sanitize($data[$key]) : $default;
                }
                else{
                    return isset($data[$key]) ? sanitize($data[$key]) : throwException("Undefined $key key in data");
                }
    
                return isset($data[$key]) ? sanitize($data[$key]) : throwException("Undefined $key key in data");
            }
    

        }
        else{

            if($optional){

                if($default){
                    return isset($data[$key]) ? $data[$key] : $default;
                }
                else{
                    return isset($data[$key]) ? $data[$key] : false;
                }
    
            }
            else{
    
                if($default){
                    return isset($data[$key]) ? $data[$key] : $default;
                }
                else{
                    return isset($data[$key]) ? $data[$key] : throwException("Undefined $key key in data");
                }
    
                return isset($data[$key]) ? $data[$key] : throwException("Undefined $key key in data");
            }

        }
    

    }
    catch (Exception $e){

        echo json([
            'status' => 'error',
            'data'=> null,
            'message' => $e->getMessage()
        ], 404);

        die();
    }

}

function throwException($message){
    throw new Exception($message);
}


/**
 * Recoje el valor de una entrada de datos de formdata
 * @param mixed $key
 * @return string 
 */
function formdata($key, $optional = false)
{

    try{

        if($optional){
            return isset($_POST[$key]) ? sanitize($_POST[$key]) : false;

        }
        else{
            return isset($_POST[$key]) ? sanitize($_POST[$key]) : throwException("Undefined $key key in formdata");
        }
    }
    catch (Exception $e){

        echo json([
            'status' => 'error',
            'data'=> null,
            'message' => $e->getMessage()
        ], 404);

        die();
    }

}



function notDefine(){
    $_DATA = json_decode(file_get_contents('php://input'), true);
    /**
     * Datos enviados con formato json en javascript
     */
    if(isset($_DATA['func'])){
        $func = $_DATA['func'];
    }
    /**
     * Datos enviados con formato form en javascript
     */
    if(isset($_POST['func'])){
        $func = $_POST['func'];
    }
    http_response_code(404);
    $data = [
        "status"=>"error",
        "data"=>$_DATA,
        "message"=> "La funcion $func no esta definida"
    ];
    return json_encode($data);
}



function abort($status_code, $message){
    if($status_code >= 400 && $status_code >= 599){
        http_response_code($status_code);
        return json_encode(['status'=>'abort', 'message'=>$message]);
        die();
    }
    else{
        http_response_code(400);
        return json_encode(['status'=>'abort', 'message'=>$message]);
        die();
    }
    
}


function create_time_range($start, $end, $interval = '60 mins', $format = '') {
    $startTime = strtotime($start); 
    $endTime   = strtotime($end);
    $returnTimeFormat = ($format == '12')?'g:i:s A':'G:i';

    $current   = time(); 
    $addTime   = strtotime('+'.$interval, $current); 
    $diff      = $addTime - $current;

    $times = array(); 
    while ($startTime < $endTime) { 
        $times[] = date($returnTimeFormat, $startTime); 
        $startTime += $diff; 
    } 
    $times[] = date($returnTimeFormat, $startTime); 
    return $times; 
}

