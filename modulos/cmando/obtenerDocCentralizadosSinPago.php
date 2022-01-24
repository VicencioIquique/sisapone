<?php
require_once("../../clases/conexionocdb.php");
$mes = $_POST['mes'];
	$sql = "SELECT COUNT(NumeroDocto) AS Cant_Docto, Bodega
			FROM [RP_VICENCIO].[dbo].[RP_ReceiptsCab_SAP]
			WHERE Estado='1'  and YEAR(fechadocto)='2022' AND MONTH(fechadocto)='".$mes."'
			AND TipoDocto <> 3
			GROUP BY Bodega";
			
	$rs = odbc_exec( $conn, $sql );
	if ( !$rs){
		exit( "Error en la consulta SQL" );
	}
	$acum = 0; 
	while($resultado = odbc_fetch_array($rs)){
		$acum = $acum + $resultado['Cant_Docto'];
	}
	$res = array ( 
				'cant' => $acum
			);
	echo json_encode($res); 
?>