<?php

function generaLogs($usuario,$accion,$origen){
	date_default_timezone_set('America/Santiago');  
    $hora=str_pad(date("H:i:s"),10," "); //hhmmss;
    //Definimos el contenido de cada registro de accion por usuario.
    $usuario=strtoupper(str_pad($usuario,30," "));
    $accion=strtoupper(str_pad($accion,50," "));
    $cadena=$hora.$usuario.$accion.$origen;
    //Creamos dinamicamente el nombre del archivo por dia
    $pre="log";
    $date=date("dmY");
    $fileName=$pre.$date;
    //echo "$fileName";
    $f = fopen("logs/$fileName.TXT","a");
        fputs($f,$cadena."\r\n") or die("no se pudo crear o insertar el fichero");
    fclose($f);  
}
?>