<?php
	require_once("../../clases/conexionocdb.php");
	$idArea = $_POST['idArea'];
	$sql = "SELECT usuario_id, usuario_nombre FROM RP_VICENCIO.dbo.sisap_usuarios WHERE FK_idArea = '".$idArea."'";
	$rs = odbc_exec( $conn, $sql );
	if ( !$rs ){
		exit( "Error en la consulta SQL" );
	}
	/*while($resultado = odbc_fetch_array($rs)){
		echo $resultado['usuario_nombre'];
	}*/
	
	while($resultado = odbc_fetch_array($rs)){
			$res[] = array ( 
								'usuario_id' => $resultado['usuario_id'], 
								'usuario_nombre' => $resultado['usuario_nombre'] 
							);
	}
	
	echo json_encode($res);
?>