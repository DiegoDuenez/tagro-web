<?php


class Date {

    public static function dayName($date){

        $dia = date('l', strtotime($date));

        $dias = [
            "Monday" => "Lunes",
            "Tuesday" => "Martes",
            "Wednesday" => "Miercoles",
            "Thursday" => "Jueves",
            "Friday" => "Viernes",
            "Saturday" => "Sabado",
            "Sunday" => "Domingo"
        ];

        return $dias[$dia];

    }

    public static function now(){
        return date('Y-m-d');
    }

}