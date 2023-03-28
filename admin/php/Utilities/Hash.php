<?php


class Hash{

    public static function make($string){

        $hashString = password_hash($string, PASSWORD_DEFAULT);

        return $hashString;

    }

    public static function verify($password, $hash){

        return password_verify($password, $hash);

    }

}