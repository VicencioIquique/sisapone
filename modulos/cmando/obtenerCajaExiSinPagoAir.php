<?php 
	require_once("../../clases/conexionocdb.php");
	$sql = "SELECT SUM(T1.TotNeto) AS Val_CLP, T1.Bodega
		FROM [RP_REGGEN].[dbo].[RP_ReceiptsCab_SAP] AS T1
		LEFT JOIN RP_REGGEN.dbo.RP_ReceiptsPagos_SAP as T2 ON T1.ID = T2.ID 
		WHERE Estado='1' and YEAR(fechadocto)='2016' AND MONTH(fechadocto)='".date('m')."' AND T2.TipoPago = 'Cash'
		AND T1.TipoDocto <> 3
		GROUP BY T1.Bodega";
	$rs = odbc_exec( $conn, $sql );
	if(!$rs ){
		exit( "Error en la consulta SQL" );
	}
	$acum = 0;
	while($resultado = odbc_fetch_array($rs)){
		$acum = $acum + $resultado['Val_CLP'];
	}
	echo "<label style='font-size:14px;'>CLP $".number_format($acum,0,'.',',')."</label>";
?>