<?php
$dsn = "VICENCIOSAP"; 

$usuario = "sa";
$clave="V1c3nc10.!";

$conn2=odbc_connect($dsn, $usuario, $clave);
if (!$conn2)
{
	exit( "Error al establecer la conexion2: ".$conn2);
}


?>