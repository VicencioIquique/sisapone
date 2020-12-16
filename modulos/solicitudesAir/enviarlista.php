<?php 
require_once("../../clases/conexionocdb.php");

echo $idsol = $_POST['idsol'];


echo $sql=" UPDATE  [RP_REGGEN].[dbo].[sisap_solicitudes]
    	SET     fecha_estado = GETDATE(),estado = 1 
    	WHERE   solicitud_id = ".$idsol;

$rs = odbc_exec( $conn, $sql );
							
			if ( !$rs )
			{
				exit( "Error en la consulta SQL" );
			}


odbc_execute($rs);
odbc_close( $conn );
?>

?>