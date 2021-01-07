<?php
require_once("../../../clases/conexionocdb.php");
$sql = "SELECT ALU,convert(int,PRICE01) precio,isnull(descuento,'NO')descuento,DESC2 FROM [RP_VICENCIO].[dbo].[RP_Articulos] art
LEFT JOIN [RP_VICENCIO].[dbo].[RP_Descuento_Navidad2] nav ON art.ALU =nav.upc
where alu ='".$_POST['codigo']."'";

$rsSql = odbc_exec( $conn, $sql);
	if (!$rsSql){  
		exit( "Error en la consulta SQL" );
	}	
	$resultado = odbc_fetch_array($rsSql);
	$objeto->precio=$resultado['precio'];
	$objeto->descripcion=$resultado['DESC2'];
	$objeto->oferta=$resultado['descuento'];
	echo json_encode($objeto);

odbc_close( $conn );
?>