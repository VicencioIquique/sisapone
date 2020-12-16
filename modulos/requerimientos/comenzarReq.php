<?php 
require_once("../../clases/conexionocdb.php");

$datos = $_POST['datos'];



echo $sql="
	UPDATE  SISAP.dbo.SI_Requerimiento
	SET     startDate = GETDATE() 
			,FK_idEstado = 3
	WHERE   idRequerimiento = ".$datos['idReq'];

$rs = odbc_exec( $conn, $sql );
							
			if ( !$rs )
			{
				exit( "Error en la consulta SQL" );
			}



odbc_close( $conn );

?>