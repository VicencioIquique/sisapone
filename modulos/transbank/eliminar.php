<?php 
require_once("../../clases/conexionocdb.php");

$id =$_POST['id_abono'];

$sql="DELETE FROM  [RP_VICENCIO].[dbo].[sisap_abonosTransbank] WHERE abono_id = ".$id."";

$rs = odbc_exec( $conn, $sql );
							
							if ( !$rs )
							{
							exit( "Error en la consulta SQL" );
							}

odbc_execute($rs);
odbc_close( $conn );

?>