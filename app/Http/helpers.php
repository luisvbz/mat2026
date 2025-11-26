<?php

function date_to_datedb($date, $delimiter = "-") {
    list($d, $m, $y) = explode($delimiter, $date);
    if(strlen($y) != 4) {
        throw new \Exception("Formato de fecha inválido.");
    }
    return "$y-$m-$d";
}

function date_from_datedb($date, $delimiter = "-") {
    list($y, $m, $d) = explode($delimiter, $date);
    if(strlen($y) != 4) {
        throw new \Exception("Formato de fecha inválido.");
    }
    return "$d/$m/$y";
}

function getMes($value)
{
    switch ($value) {
        case '01':
            return "Enero";
            break;
        case '02':
            return "Febrero";
            break;
        case '03':
            return "Marzo";
            break;
        case '04':
            return "Abril";
            break;
        case '05':
            return "Mayo";
            break;
        case '06':
            return "Junio";
            break;
        case '07':
            return "Julio";
            break;
        case '08':
            return "Agosto";
            break;
        case '09':
            return "Setiembre";
            break;
        case '10':
            return "Octubre";
            break;
        case '11':
            return "Noviembre";
            break;
        case '12':
            return "Diciembre";
            break;
    }
}
