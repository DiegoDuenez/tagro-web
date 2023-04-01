<?php

class FileManager{


    public static function errors($key)
    {
        return $_FILES[$key]['error'];
    }

    public static function get($key, $property = null)
    {
        if($property){
            return $_FILES[$key][$property];
        }
        else{
            return $_FILES[$key];
        }
    }

    public static function moveTo($from, $to)
    {
        move_uploaded_file($from, $to);

    }

    public static function fileExtension($name) {
        $n = strrpos($name, '.');
        return ($n === false) ? '' : substr($name, $n+1);
    }

    public static function createFolder($path){

        if (!is_dir($path)) {
            mkdir($path);
            return true;
        }
        return false;
        
    }

    public static function renameFolder($old, $new){

        if (is_dir($old)) {
            rename($old, $new);
            return true;
        }
        else{
            mkdir($new);
            return true;
        }
    }

    public static function getFiles($path){

        if (is_dir($path)) {
            $files = scandir($path);
            return $files;
        }
        else{
            return false;
        }
       
    }

    public static function dropFiles($path)
    {
        if(is_dir($path)){
            $files = glob("$path/*");
            foreach($files as $file){
                unlink($file); 
            }
        }
            
    }

    public static function dropFile($file){

        return unlink($file);
    }

    public static function folderExist($path){
        if (is_dir($path)) {
            return true;
        }
        else{
            return false;
        }
    }

    public static function optimize($from, $to, $key)
    {
        $imageSize = getimagesize($from);

        //Si las imagenes tienen una resolución y un peso aceptable se suben tal cual
        if($imageSize[0] < 1280 && FileManager::get($key,'size') < 100000){
    
            self::moveTo($from, $to);

        }
        else {

            $max_ancho = 1280;
            $max_alto = 900;
            $nombrearchivo= $to;
            //Redimensionar
            $rtOriginal = $from;

            if(FileManager::get($key,'type') == 'image/jpeg'){
            $original = imagecreatefromjpeg($rtOriginal);
            }
            else if(FileManager::get($key,'type') == 'image/png'){
            $original = imagecreatefrompng($rtOriginal);
            }
            else if(FileManager::get($key,'type') == 'image/gif'){
            $original = imagecreatefromgif($rtOriginal);
            }
            
            
            list($ancho,$alto) = getimagesize($rtOriginal);

            $x_ratio = $max_ancho / $ancho;
            $y_ratio = $max_alto / $alto;

            if( ($ancho <= $max_ancho) && ($alto <= $max_alto) ){
                $ancho_final = $ancho;
                $alto_final = $alto;
            }
            elseif (($x_ratio * $alto) < $max_alto){
                $alto_final = ceil($x_ratio * $alto);
                $ancho_final = $max_ancho;
            }
            else{
                $ancho_final = ceil($y_ratio * $ancho);
                $alto_final = $max_alto;
            }

            $lienzo = imagecreatetruecolor($ancho_final,$alto_final); 

            imagecopyresampled($lienzo,$original,0,0,0,0,$ancho_final, $alto_final,$ancho,$alto);

            if(FileManager::get($key,'type') == 'image/jpeg')
            {
                imagejpeg($lienzo, $to);
            }
            else if(FileManager::get($key,'type') == 'image/png')
            {
                imagepng($lienzo,$to);
            }
            else if(FileManager::get($key,'type') == 'image/gif')
            {
                imagegif($lienzo, $to);
            }
                
        }
    }

    public static function dropDir($dirPath) {
        if (!is_dir($dirPath)) {
            return false;
            //throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::dropDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }


}