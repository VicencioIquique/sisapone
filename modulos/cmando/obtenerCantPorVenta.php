<?php
require_once("../../clases/conexionocdb.php");

$sql="SELECT TOP 1 
	[Bodega]
   ,[Total] AS cant
   
  FROM [RP_VICENCIO].[dbo].[RP_ReceiptsCab_SAP] 
  ORDER BY FechaDocto DESC ";

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