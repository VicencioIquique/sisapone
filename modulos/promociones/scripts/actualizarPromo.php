<?php
require_once("../../../clases/conexionocdb.php");
$sql = "update [RP_VICENCIO].[dbo].[RP_Descuento_Navidad2] set descuento ='".$_POST['precio']."'
where upc ='".$_POST['codigo']."'";
$rsSql = odbc_exec( $conn, $sql);
	if (!$rsSql){  
		exit( "Error en la consulta SQL" );
	}
	echo 1;
odbc_close( $conn );

?>