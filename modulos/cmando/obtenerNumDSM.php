<?php
require_once("../../clases/conexionocdb.php");

$sql="SELECT  COUNT(DISTINCT (NroDEM)) as cant
  FROM [RP_VICENCIO].[dbo].[RP_DEM]
  WHERE Estado = 0 ";

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