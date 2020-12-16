<?php
	require_once("../../clases/conexionocdb.php");
	$idReq = $_POST['idReq'];
	
	$sql = "SELECT idSolicitante 
			FROM SISAP.dbo.SI_Requerimiento
			WHERE idRequerimiento = ".$idReq."";
		
	$rs = odbc_exec( $conn, $sql );
	if ( !$rs ){
		exit( "Error en la consulta SQL" );
	}
	$resultado = odbc_fetch_array($rs);
	
			$res = array ( 
				'idSolicitante' => $resultado['idSolicitante']
			);
	echo json_encode($res);
?>