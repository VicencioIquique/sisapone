<?php
require_once("../../../clases/conexionocdb.php");
$sql = "Delete from [RP_VICENCIO].[dbo].[RP_Descuento_Navidad2] where upc ='".$_POST['codigo']."'";
$rsSql = odbc_exec( $conn, $sql);
	if (!$rsSql){  
		exit( "Error en la consulta SQL" );
	}
	echo 1;
odbc_close( $conn );

?>