<?php
require_once("../../clases/conexionocdb.php");
	$sql = "SELECT (COUNT(NumeroDocto)*100)/100000 [porcent]
                   ,COUNT(NumeroDocto)             [Cant]
              FROM [RP_VICENCIO].[dbo].[NumeroDoctoPrueba] ";
			
	$rs = odbc_exec( $conn, $sql );
	if ( !$rs){
		exit( "Error en la consulta SQL" );
	}
	$porcent = 0; 
	$cant = 0; 
	while($resultado = odbc_fetch_array($rs)){
		$porcent = $porcent + $resultado['porcent'];
		$cant = $cant + $resultado['Cant'];
	}
	$res = array ( 
				 'porcent' => $porcent
				,'cant' => $cant
			);
	echo json_encode($res); 
?>