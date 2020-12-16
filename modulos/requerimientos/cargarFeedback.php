<?php
	require_once("../../clases/conexionocdb.php");
	$datos = $_POST['datos'];
	$idReq = $datos['idReq'];
	$sql = "SELECT feedback
			FROM SISAP.dbo.SI_Requerimiento
			WHERE idRequerimiento = ".$idReq."";
	$rs = odbc_exec( $conn, $sql );
	if ( !$rs ){
		exit( "Error en la consulta SQL" );
	}
	$resultado = odbc_fetch_array($rs);
			$res = array ( 
								'feedback' => utf8_decode($resultado['feedback'])
							);
	echo json_encode($res);
?>