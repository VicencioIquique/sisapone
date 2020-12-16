<?php 
require_once("../../clases/conexionocdb.php");

$datos = $_POST['datosReq'];

$sql="
	SELECT description 
	FROM SISAP.dbo.SI_Requerimiento
	WHERE   idRequerimiento = ".$datos['idReq'];

$rs = odbc_exec( $conn, $sql );
							
			if ( !$rs )
			{
				exit( "Error en la consulta SQL" );
			}
$resultado = odbc_fetch_array($rs);
	
			$res = array ( 
				'description' => utf8_decode($resultado['description'])
			);
	echo json_encode($res); 


odbc_close( $conn );

?>