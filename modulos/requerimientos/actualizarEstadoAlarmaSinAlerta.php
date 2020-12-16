<?php 
require_once("../../clases/conexionocdb.php");
$idReq = $_POST['idReq'];
$sql="
	UPDATE  SISAP.dbo.SI_Requerimiento
	SET     estadoAlerta = 1
	WHERE   idRequerimiento = ".$idReq;

$rs = odbc_exec( $conn, $sql );
							
			if ( !$rs )
			{
				exit( "Error en la consulta SQL" );
			}
odbc_close( $conn );
?>