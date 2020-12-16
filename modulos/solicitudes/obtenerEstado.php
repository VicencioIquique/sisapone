<?php
require_once("../../clases/conexionocdb.php");

$sql="SELECT  Count(solicitud_id) AS cant
  FROM [RP_VICENCIO].[dbo].[sisap_solicitudes]
  WHERE estado= 1 ";

//echo $sql;

$rs = odbc_exec( $conn, $sql );
							
							if ( !$rs )
							{
							exit( "Error en la consulta SQL" );
							}

							  while($resultado = odbc_fetch_array($rs)){ 
							 	 $cantidad=(INT)$resultado['cant'];
							 
								}	
								
								if($cantidad == null)
								{
									echo json_encode(0);
								}
								else 
								echo json_encode($cantidad);
	odbc_close( $conn );
?>