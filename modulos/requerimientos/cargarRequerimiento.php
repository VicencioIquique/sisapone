<?php
	require_once("../../clases/conexionocdb.php");
	$idReq = $_POST['idReq'];
	$sql = "SELECT title, description
			FROM SISAP.dbo.SI_Requerimiento
			WHERE idRequerimiento = ".$idReq."";
	$rs = odbc_exec( $conn, $sql );
	if ( !$rs ){
		exit( "Error en la consulta SQL" );
	}
	$resultado = odbc_fetch_array($rs);
			$res = array ( 
								'title' => utf8_decode($resultado['title']),
								'description' => utf8_decode($resultado['description'])
							);
	echo json_encode($res);
?>