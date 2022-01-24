<?php
require_once("../../clases/conexionocdb.php");
$mes = $_POST['mes'];
	$sql = "SELECT Monto
  FROM [RP_VICENCIO].[dbo].[RP_MONEDA]
  WHERE YEAR(FechaModificacion) = '2022' AND MONTH(FechaModificacion)='".$mes."'";
	$rows = array();
	$rs = odbc_exec( $conn, $sql );
	if ( !$rs){
		exit( "Error en la consulta SQL" );
	}
	while($resultado = odbc_fetch_array($rs)){
		$rows[] = array ( 
				'valor' => $resultado['Monto']
			);
	}
	
	echo json_encode($rows); 
?>