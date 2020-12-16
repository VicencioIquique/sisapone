<?php
	require_once("../../clases/conexionocdb.php");
	$idReq = $_POST['idReq'];
	$sql = "SELECT AR.idArea, AR.description
			FROM SISAP.dbo.SI_Requerimiento RE
			LEFT JOIN SISAP.dbo.SI_Area AR ON RE.FK_idAreaRecepcion = AR.idArea
			WHERE RE.idRequerimiento = ".$idReq."";
	$rs = odbc_exec( $conn, $sql );
	if ( !$rs ){
		exit( "Error en la consulta SQL" );
	}
	$resultado = odbc_fetch_array($rs);
			$res = array ( 
								'idAreaRecepcion' => $resultado['idArea'],
								'areaRecepcion' => $resultado['description']
							);
	echo json_encode($res);
?>