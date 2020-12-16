<?php
session_start();
require_once("../../clases/conexionocdb.php");
$idarticulo = $_GET['sku'];
$numeroguia =$_GET['idsol'];

$sql="SELECT  [ItemCode]
      ,[ItemName]
      ,[Name]
      ,[Cantidad]
      ,[Bodega]
  FROM [RP_VICENCIO].[dbo].[StockPorCodigoAunqueNoTenga]
  
  WHERE [ItemCode] LIKE '".$idarticulo."' AND [Bodega] = ".$_SESSION["usuario_modulo"]." ";

//echo $sql;

$rs = odbc_exec( $conn, $sql );
							
							if ( !$rs )
							{
							exit( "Error en la consulta SQL" );
							}

							  while($resultado = odbc_fetch_array($rs)){ 
							 	 $cantidad=(INT)$resultado['Cantidad'];
								 $name=$resultado['ItemName'];
								 
							 
								}	
								//hay que definir el vector con los campos de descripción 
								if($cantidad == null)
								{
									
									$vectorProd =   array ( //Datos del producto
												"cantidad" => 0,
												"name" =>  $name,
												);
								}
								else 
								{
									$vectorProd =   array ( //Datos del producto
												"cantidad" => $cantidad,
												"name" =>  $name,
												);
								   
								}
								
							
							 echo json_encode($vectorProd);		
								
	odbc_close( $conn );
?>