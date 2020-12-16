<?php
require_once("../../clases/conexionocdb.php");
$mes = $_POST['mes'];
//echo $mes['n']."as";
	$sql = "SELECT COUNT(NumeroDocto) as Cant_Docto
		FROM [RP_VICENCIO].[dbo].[RP_ReceiptsCab_SAP] cab
		left join [RP_VICENCIO].[dbo].[Bodega] bod on cab.bodega=bod.retail
		left join [RP_VICENCIO].[dbo].[Serie] serie on bod.bodega = serie.Bodega 
		and cab.Workstation=serie.caja 
		and cab.TipoDocto=serie.Documento
		where estado ='0'
		and YEAR(FechaDocto) ='2018'
		and cab.serie<>serie.serie";
			
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