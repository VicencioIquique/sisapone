<?php
	require_once("../../../clases/conexionocdb.php");
	$jsonProveedor = $jsonProveedor['proveedor'];
	
	$sql = "SELECT Marca
				FROM SBO_Imp_Eximben_SAC.dbo.VIC_VW_ItemsVenta 
				WHERE Proveedor = '".$jsonProveedor."'
				GROUP BY Marca
				ORDER BY Marca ASC";
	
	$rs = odbc_exec( $conn, $sql );
	if (!$rs){
		exit( "Error en la consulta SQL" );
	}
	
	while($resultado = odbc_fetch_array($rs)){
		$res[] = array(
			"marca"=>$resultado['Marca']
		);
	}
	echo json_encode($res);
?>