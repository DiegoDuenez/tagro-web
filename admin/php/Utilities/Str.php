<?php


class Str{

    public static function contains($haystack,$needle,$insensitive = true) {

        if ($insensitive) {
    
            return false !== stristr($haystack, $needle);
    
        } else {
    
            return false !== strpos($haystack, $needle);
    
        }
    
    }

    public static function length($string){

        return strlen($string);

    }

}