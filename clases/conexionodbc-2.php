<?php
// Se define la cadena de conexión
$dsn = "VICENCIOSAP"; 
//$dsn2 = "dsnrhlocal";
//debe ser de sistema no de usuario
$usuario = "sa";
$clave="V1c3nc10.!";

//realizamos la conexion mediante odbc
$conn=odbc_connect($dsn, $usuario, $clave);
if (!$conn)
{
	exit( "Error al establecer la conexion: ".$conn);
}


?>