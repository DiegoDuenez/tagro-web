<?php

class Log{

    public static function save($error){
        date_default_timezone_set('America/Monterrey');
        $ddf = fopen('../Log/error.log','a'); 
        fwrite($ddf,"[".date("d/m/y H:i:s")."] Error: $error\r\n"); 
        fclose($ddf); 
    }

}