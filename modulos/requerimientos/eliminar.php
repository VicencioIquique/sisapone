<?php 
require_once("../../clases/conexionocdb.php");

$id =$_POST['id_sol'];

$sql="DELETE FROM  SISAP.dbo.SI_Requerimiento WHERE idRequerimiento = ".$id."";

$rs = odbc_exec( $conn, $sql );
							
							if ( !$rs )
							{
							exit( "Error en la consulta SQL" );
							}

odbc_execute($rs);
odbc_close( $conn );

?>