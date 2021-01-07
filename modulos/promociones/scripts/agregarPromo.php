<?php
require_once("../../../clases/conexionocdb.php");
$sql = "INSERT INTO [RP_VICENCIO].[dbo].[RP_Descuento_Navidad2]
VALUES ('".$_POST['codigo']."', '".$_POST['precio']."', '1');";

$rsSql = odbc_exec( $conn, $sql);
	if (!$rsSql){  
		exit( "Error en la consulta SQL" );
	}	
echo 1;
odbc_close( $conn );
?>