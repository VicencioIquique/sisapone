<?php
require_once("../../clases/conexionocdb.php");
$mes = $_POST['mes'];
//echo $mes['n']."as";
	$sql = "Select Count(CAB.ID)  Cant_Docto FROM [RP_VICENCIO].[dbo].[RP_ReceiptsCab_SAP] cab
LEFT JOIN (SELECT ID,SUM (PrecioExtendido) total FROM [RP_VICENCIO].[dbo].[RP_ReceiptsDet_SAP]
group by id) det on cab.id=det.ID
WHERE cab.total <>det.total  and FechaDocto >'2018' and cab.estado<2";
			
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