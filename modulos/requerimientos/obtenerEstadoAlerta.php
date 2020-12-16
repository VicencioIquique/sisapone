<?php
	require_once("../../clases/conexionocdb.php");
	$idReq = $_POST['idReq'];
	$sql = "SELECT idRequerimiento, estadoAlerta
		  FROM [SISAP].[dbo].[SI_Requerimiento]
		  WHERE idRequerimiento = '".$idReq."'";
	$rs = odbc_exec( $conn, $sql );
	if ( !$rs ){
		exit( "Error en la consulta SQL" );
	}
	while($resultado = odbc_fetch_array($rs)){
		$res[] = array ( 
			'estadoAlerta'=>$resultado['estadoAlerta'],
			'idRequerimiento' => $idReq
		);
	}
	echo json_encode($res); 
	odbc_close( $conn );
?>