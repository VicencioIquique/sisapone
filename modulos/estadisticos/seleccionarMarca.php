<?php
	require_once("../../clases/conexionocdb.php");
	$idReq = $_POST['idReq'];
	$sql = "SELECT Code, Name FROM [SBO_Imp_Eximben_SAC].[dbo].[@VK_OMAR]";
	$rs = odbc_exec( $conn, $sql );
	if ( !$rs ){
		exit( "Error en la consulta SQL" );
	}
	$resultado = odbc_fetch_array($rs);
			$res = array ( 
								'Code' => $resultado['Code'],
								'Name' => $resultado['Name']
							);
	echo json_encode($res);
?>