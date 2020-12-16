<?php 
require_once("../../clases/conexionocdb.php");

$datos = $_POST['datos'];



echo $sql="
	UPDATE  SISAP.dbo.SI_Requerimiento
	SET     FK_idEstado = 5
			,VBSolicitante = ".$datos['VBSolicitante']."
			,feedback = '".utf8_encode($datos['feedback'])."'
	WHERE   idRequerimiento = ".$datos['idReq'];
	

$rs = odbc_exec( $conn, $sql );
							
			if ( !$rs )
			{
				exit( "Error en la consulta SQL" );
			}



odbc_close( $conn );

?>