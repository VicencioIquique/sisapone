<?php
	require_once("../../clases/conexionocdb.php");
	$idCategoria = $_POST['idCategoria'];
	$sql = "SELECT idServicio, description
			FROM [SISAP].[dbo].[SI_Servicio] 
			WHERE FK_idCategoria = ".$idCategoria."
			ORDER BY levelPriority ASC";
	$rs = odbc_exec( $conn, $sql );
	if ( !$rs ){
		exit( "Error en la consulta SQL" );
	}
	while($resultado = odbc_fetch_array($rs)){
		$res[] = array ( 
								'idServicio' => $resultado['idServicio'],
								'description' => $resultado['description']
							);
	}
			
	echo json_encode($res);
?>