<?php 
require_once("../../clases/conexionocdb.php");


$idsol = $_POST['idsol'];

 $sql="
	UPDATE  [RP_REGGEN].[dbo].[sisap_solicitudes]
	SET   estado = 4
    	WHERE   solicitud_id = ".$idsol;

$rs = odbc_exec( $conn, $sql );
							
			if ( !$rs )
			{
				exit( "Error en la consulta SQL" );
			}



odbc_close( $conn );

?>