<?php
function formateo_rut($rut_param){
    
    //validaciones varias
    //....
	$cant=strlen($rut_param);
    if($cant==8){
		$parte1 = substr($rut_param, 0,1); //12
		$parte2 = substr($rut_param, 1,3); //345
		$parte3 = substr($rut_param, 4,3); //456
		$parte4 = substr($rut_param, 7);   //todo despues del caracter 8 
		return $parte1.".".$parte2.".".$parte3."-".$parte4;

	}else{
		$parte1 = substr($rut_param, 0,2); //12
		$parte2 = substr($rut_param, 2,3); //345
		$parte3 = substr($rut_param, 5,3); //456
		$parte4 = substr($rut_param, 8);   //todo despues del caracter 8 
		return $parte1.".".$parte2.".".$parte3."-".$parte4;
	}
}
function int_rut($rut_param){
    
    $cant=strlen($rut_param);
	//validaciones varias
	if($cant==11){
		$parte1 = substr($rut_param, 0,1); //12 
		$parte2 = substr($rut_param, 2,3); //345
		$parte3 = substr($rut_param, 6,3); //456
		$parte4 = substr($rut_param, 10);   //todo despues del caracter 8 
		return $parte1."".$parte2."".$parte3."".$parte4;

	}else{
		$parte1 = substr($rut_param, 0,2); //12 
		$parte2 = substr($rut_param, 3,3); //345
		$parte3 = substr($rut_param, 7,3); //456
		$parte4 = substr($rut_param, 11);   //todo despues del caracter 8 
		return $parte1."".$parte2."".$parte3."".$parte4;
	}
}


function getmodulo ($a)
{
	 if( ($a == "000") || ($a == "008") || ($a == "8") )return "Modulo 2077";
	 else if($a == 001)return "Modulo 1010";
	 else if($a == 002)return "Modulo 1132";
	 else if($a == 003)return "Modulo 181";
	 else if($a == 004)return "Modulo 184";
	 else if($a == 005)return "Modulo 2002";
	 else if($a == 006)return "Modulo 6115";
	 else if($a == 007)return "Modulo 6130";
	 //else if($a == 008)return "Modulo 2077 EXB";
}


function getmoduloAir ($a)
{
	 if($a == 001)return "Local 2";
	 else if($a == 002)return "Local 8";
	
}

function getestado ($a)
{
	 if($a == 0)return "Creado";
	 else if($a == 1)return "Espera de Revisión";
	 else if($a == 2)return "En Revisión";
	 else if($a == 3)return "Aceptado";
	 else if($a == 4)return "En SAP";

}

function getusuario ($b)
{
	include("conexionocdb.php");
	

		 	$sql7="	SELECT usuario_nombre FROM  sisap_usuarios WHERE usuario_id = ".$b." ";

		
							//echo $sql7;	
							$rs7 = odbc_exec( $conn, $sql7 );
							if ( !$rs7 )
							{
								exit( "Error en la consulta SQL" );
							}

							  while($row = odbc_fetch_array($rs7)){ 
							  		
									 $nombre = $row['usuario_nombre'];
							  }
							  
							  return $nombre;
		
}
function getusuarioSAir ($b)
{
	include("conexionocdb.php");
	

		 	$sql7="	SELECT usuario_nombre FROM  sisap_usuarios WHERE usuario_id = ".$b." ";

		
							//echo $sql7;	
							$rs7 = odbc_exec( $conn, $sql7 );
							if ( !$rs7 )
							{
								exit( "Error en la consulta SQL" );
							}

							  while($row = odbc_fetch_array($rs7)){ 
							  		
									 $nombre = $row['usuario_nombre'];
							  }
							  
							  return $nombre;
		
}

function getusuarioRP ($b)
{
	include("conexionocdb.php");
	

		 	$sql7="	SELECT     SlpCode, SlpName
FROM         SBO_Imp_Eximben_SAC.dbo.OSLP WHERE SlpCode = ".$b." ";

		
							//echo $sql7;	
							$rs7 = odbc_exec( $conn, $sql7 );
							if ( !$rs7 )
							{
								exit( "Error en la consulta SQL" );
							}

							  while($row = odbc_fetch_array($rs7)){ 
							  		
									 $nombre = $row['SlpName'];
							  }
							  
							  return $nombre;
		
}

function getusuarioAir ($b)
{
	include("conexionocdb.php");
	

		 	$sql7="	SELECT     SlpCode, SlpName
FROM         SBO_Eximben_RegGen.dbo.OSLP WHERE SlpCode = ".$b." ";

		
							//echo $sql7;	
							$rs7 = odbc_exec( $conn, $sql7 );
							if ( !$rs7 )
							{
								exit( "Error en la consulta SQL" );
							}

							  while($row = odbc_fetch_array($rs7)){ 
							  		
									 $nombre = $row['SlpName'];
							  }
							  
							  return $nombre;
		
}

function getStock ($cod,$mod)
{
	include("conexionocdb.php");
	
$sql="SELECT  [Bodega]
      ,[RecNum]
      ,[Alu]
      ,CONVERT(INT,[Cantidad]) as cant
  FROM [RP_VICENCIO].[dbo].[VerStockTiendas]
  
  WHERE [Alu] LIKE '".$cod."' AND [Bodega] = ".$mod."";
		
							//echo $sql7;	
							$rs7 = odbc_exec( $conn, $sql );
							if ( !$rs7 )
							{
								exit( "Error en la consulta SQL" );
							}

							  while($row = odbc_fetch_array($rs7)){ 
							  		
									 $cant = $row['cant'];
							  }
							  if($cant >0)
							  return (int)$cant;
							  else
							  return 0;
		
}

function lotesDiponible($cod,$mod)
{
	include("conexionocdb.php");
	
$sql="
SELECT 
		 TABLA.ItemCode  [ItemCode]
		,TABLA.bodega    [bodega]
		,TABLA.Cantidad  [Cantidad]
	
FROM
(

SELECT 
	   BO.[Bodega]
      ,LD.[ItemCode]
      ,SUM(LD.[Cantidad])Cantidad
  FROM [RP_VICENCIO].[dbo].[LotesDisponibles]LD
  LEFT JOIN [RP_VICENCIO].[dbo].[Bodega] BO ON LD.Bodega = BO.Retail
  GROUP BY  BO.Bodega
           ,LD.ItemCode
           
UNION ALL
 
SELECT  
       BO.[Bodega]
      ,LD.[ItemCode]
      ,SUM(LD.[Cantidad])Cantidad
  FROM [RP_REGGEN].[dbo].[LotesDisponibles]LD
  LEFT JOIN [RP_REGGEN].[dbo].[Bodega] BO ON LD.Bodega = BO.Retail
  GROUP BY  BO.Bodega
           ,LD.ItemCode

 )AS TABLA
 
 WHERE TABLA.ItemCode ='".$cod."' AND TABLA.bodega = '".$mod."'
";
		
							//echo $sql7;	
							$rs7 = odbc_exec( $conn, $sql );
							if ( !$rs7 )
							{
								exit( "Error en la consulta SQL" );
							}

							  while($row = odbc_fetch_array($rs7)){ 
							  		
									 $cant = $row['Cantidad'];
							  }
							  if($cant >0)
							  return (int)$cant;
							  else
							  return 0;
		
}

function getStockBodegaRef ($cod)
{
	include("conexionodbc2.php");
	
$sql="SELECT sum(CONVERT(INT,[Quantity])) AS cant
  FROM [SBO_Imp_Eximben_SAC].[dbo].[SI_StockBodegasMarcaReferencia2_ON]
  WHERE ItemCode = '".$cod."' ";
		
							echo $sql;	
							$rs7 = odbc_exec( $conn, $sql );
							if ( !$rs7 )
							{
								exit( "Error en la consulta SQL" );
							}

							  while($row = odbc_fetch_array($rs7)){ 
							  		
									 $cant = $row['cant'];
							  }
							  if($cant >0)
							  return (int)$cant;
							  else
							  return 0;
		
}

function getLastDSM($mod,$repo)
{

include("conexionocdb.php");
 //$sql="SELECT NroDEM FROM  [".$repo."].[dbo].[RP_DEM] WHERE FechaIngreso LIKE (SELECT MAX(FechaIngreso) FROM [".$repo."].[dbo].[RP_DEM] WHERE [CodModulo] = ".$mod.") ";

$sql="SELECT TOP 1 NroDEM FROM [".$repo."].[dbo].[RP_DEM] WHERE [CodModulo] = ".$mod." ORDER BY FechaIngreso DESC  ";



		
							//echo $sql7;	
							$rs7 = odbc_exec( $conn, $sql );
							if ( !$rs7 )
							{
								exit( "Error en la consulta SQL" );
							}

							  while($row = odbc_fetch_array($rs7)){ 
							  		
									 $NroDEM = $row['NroDEM'];
							  }
							
							  return $NroDEM;
		
}

function getLastBoleta($mod,$repo)
{

include("conexionocdb.php");
 //$sql="SELECT NroDEM FROM  [".$repo."].[dbo].[RP_DEM] WHERE FechaIngreso LIKE (SELECT MAX(FechaIngreso) FROM [".$repo."].[dbo].[RP_DEM] WHERE [CodModulo] = ".$mod.") ";

$sql="SELECT TOP 1 NumeroDocto FROM [".$repo."].[dbo].[RP_ReceiptsCab_SAP] WHERE [Bodega] = ".$mod." ORDER BY FechaCreacion DESC  ";



		
							//echo $sql7;	
							$rs7 = odbc_exec( $conn, $sql );
							if ( !$rs7 )
							{
								exit( "Error en la consulta SQL" );
							}

							  while($row = odbc_fetch_array($rs7)){ 
							  		
									 $NroDocto = $row['NumeroDocto'];
							  }
							
							  return $NroDocto;
		
}

function promedioVenta ($sku)
{
	include("conexionocdb.php");
	

  
  $sql7=" SELECT  AVG([PromCant]) AS PROMEDIO
     
  FROM [RP_VICENCIO].[dbo].[SI_UnidadesPorMes]
  WHERE Sku = '".$sku."' ";

		
							//echo $sql7;	
							$rs7 = odbc_exec( $conn, $sql7 );
							if ( !$rs7 )
							{
								exit( "Error en la consulta SQL" );
							}

							  while($row = odbc_fetch_array($rs7)){ 
							  		
									 $prom = $row['PROMEDIO'];
							  }
							  
							  return $prom;		
}


function getMarca ($m)
{
	include("conexionocdb.php");
	

		 	$sql7="SELECT  [Code]
      ,[Name]
  FROM [RP_VICENCIO].[dbo].[View_OMAR] WHERE [Code] = '".$m."' ";

		
							//echo $sql7;	
							$rs7 = odbc_exec( $conn, $sql7 );
							if ( !$rs7 )
							{
								exit( "Error en la consulta SQL" );
							}

							  while($row = odbc_fetch_array($rs7)){ 
							  		
									 $nombre = $row['Name'];
							  }
							  
							  return $nombre;
		
}

function verSiNulo ($tipoDoc,$caja,$bodega,$nroDoc)// comprobar si un documento esta  anulada
{
	include("conexionocdb.php");

	
$numeroref = $tipoDoc.$caja.$bodega.$nroDoc;
	
$sql7="SELECT    Count(*) AS counter
FROM         dbo.RP_ReceiptsCab_SAP
WHERE     (TipoDocto = 3) AND (NumeroDoctoRef = '".$numeroref."') ";

		
							//echo $sql7;	
							$rs7 = odbc_exec( $conn, $sql7 );
							if ( !$rs7 )
							{
								exit( "Error en la consulta SQL" );
							}
							
							$arr = odbc_fetch_array($rs7);
								//echo $arr['counter'];
								
								$cuenta = $arr['counter'];
							if($cuenta == 0)
							{
									return (int)0;
							}
							else
							{
									return (int)1;
							}
		
}

function traerNulo ($tipoDoc,$caja,$bodega,$nroDoc,$sku)// comprobar si un documento esta  anulada
{
	include("conexionocdb.php");

	

$sql7="SELECT     dbo.RP_ReceiptsDet_SAP.PrecioExtendido, dbo.RP_ReceiptsDet_SAP.NumeroDocto, dbo.RP_ReceiptsDet_SAP.Sku, CONVERT(varchar, 
                      dbo.RP_ReceiptsCab_SAP.FechaDocto, 103) AS Fecha, dbo.RP_ReceiptsDet_SAP.Vendedor, dbo.RP_ReceiptsDet_SAP.TipoDocto, 
                      dbo.RP_ReceiptsCab_SAP.Workstation
FROM         dbo.RP_ReceiptsDet_SAP INNER JOIN
                      dbo.RP_ReceiptsCab_SAP ON dbo.RP_ReceiptsDet_SAP.ID = dbo.RP_ReceiptsCab_SAP.ID INNER JOIN
                      dbo.oITM_From_SBO ON dbo.oITM_From_SBO.ItemCode COLLATE SQL_Latin1_General_CP1_CI_AS = dbo.RP_ReceiptsDet_SAP.Sku LEFT OUTER JOIN
                      dbo.View_OMAR ON dbo.View_OMAR.Code = dbo.oITM_From_SBO.U_VK_Marca
WHERE     (dbo.RP_ReceiptsDet_SAP.Bodega = ".$bodega.") AND (dbo.RP_ReceiptsDet_SAP.TipoDocto = ".$tipoDoc.") AND (dbo.RP_ReceiptsDet_SAP.NumeroDocto = '".$nroDoc."') AND 
                      (dbo.RP_ReceiptsDet_SAP.WorkStation = ".$caja.") AND (dbo.RP_ReceiptsDet_SAP.Sku = '".$sku."') ";

		
							//echo $sql7;	
							$rs7 = odbc_exec( $conn, $sql7 );
							if ( !$rs7 )
							{
								exit( "Error en la consulta SQL" );
							}
						
							  while($row = odbc_fetch_array($rs7)){ 
							  		
									 $nombre = "<td >".$row['Fecha']."</td>
												<td >".$row['NumeroDocto']."</td>
												<td >".$row['TipoDocto']."</td>
												<td >Caja ".$row['Workstation']."</td>
												<td >".$row['Vendedor']."</td>
												<td >".(int)$row['PrecioExtendido']."</td>"
													;
							  }
							  
							  return $nombre;
		
}


function getBodegaStock($codigo)
{


	include("conexionodbc-2.php");
	

  $sql9="SELECT  [ItemCode]
      ,[WhsCode]
      ,CONVERT(int,[OnHand]) AS Cantidad
     
  FROM [SBO_Imp_Eximben_SAC].[dbo].[OITW]
  WHERE  (WhsCode NOT IN ('ZFI.1010', 'ZFI.181', 'ZFI.184', 'ZFI.2002', 'ZFI.1132', 'ZFI.6130', 'ZFI.33', 'ZFI.66', 'NA', 'ZFI.6115')) 
  AND ItemCode = '".$codigo."' AND OnHand >0  ";

							$cantidad1=$cantidad2=$cantidad6=$cantidad17=$cantidad17=$cantidad8=$cantidad9=0;
							//echo $sql9;	
							$rs9 = odbc_exec( $conn2, $sql9 );
							if ( !$rs9 )
							{
								exit( "Error en la consulta SQL" );
							}

							  while($row7 = odbc_fetch_array($rs9)){ 
							  		
									
									 if($row7['WhsCode'] == 'ZFI.13-1')
									 {
										  $cantidad1=$row7['Cantidad'];
										 
									 }
									
									 
									 if($row7['WhsCode'] == 'ZFI.14-6')
									 {
										  $cantidad2=$row7['Cantidad'];
									 }
									
									 
									 if($row7['WhsCode'] == 'ZFI.13-6')
									 {
										 $cantidad6=$row7['Cantidad'];
									 }
									
									 if($row7['WhsCode'] == 'ZFI.17SZ')
									 {
										 $cantidad17=$row7['Cantidad'];
									 }
									 
									
									if($row7['WhsCode'] == 'ZFI.1623')
									 {
										 $cantidad8=$row7['Cantidad'];
									 }
									 
									 if($row7['WhsCode'] == 'ZFI.13-2')
									 {
										 $cantidad9=$row7['Cantidad'];
									 }
									
									
							  }
							 
							  
							   return $cantidad1."-".$cantidad9."-".$cantidad2."-".$cantidad6."-".$cantidad17."-".$cantidad8;
		
}


function stockAeropuerto($codigo)
{
include("conexionocdb.php");
	

  $sql9="SELECT  [Articulo]
      ,[Bodega]
      ,[Z]
      ,[Cantidad]
      ,[ItemCode]
      ,[Cif]
      ,[Fecha]
  FROM [RP_REGGEN].[dbo].[LotesDisponibles]
   WHERE ItemCode = '".$codigo."' ";

						$cantidad1=$cantidad2=0;
							//echo $sql9;	
							$rs9 = odbc_exec( $conn, $sql9 );
							if ( !$rs9 )
							{
								exit( "Error en la consulta SQL" );
							}

							  while($row7 = odbc_fetch_array($rs9)){ 
							  		
									
									 if($row7['Bodega'] == 1)
									 {
										   $cantidad1= $cantidad1+(int)$row7['Cantidad'];
										 
									 }
									
									 
									 if($row7['Bodega'] == 2)
									 {
										  $cantidad2= $cantidad2+(int)$row7['Cantidad'];
										
									 }
										
							  }
							 
							  
							return $cantidad1."-".$cantidad2;
		
}

/************************* STOCK EN AEROPUERT *********************************/

function stockModulos($codigo)
{
include("conexionocdb.php");
	

  $sql9="SELECT  [Articulo]
      ,[Bodega]
      ,[Z]
      ,[Cantidad]
      ,[ItemCode]
      ,[Cif]
      ,[Fecha]
  FROM [RP_VICENCIO].[dbo].[LotesDisponibles]
   WHERE ItemCode = '".$codigo."' ";

						$cantidad1=$cantidad2=$cantidad3=$cantidad4=$cantidad5=$cantidad6=$cantidad7=$cantidad8=$cantidad9=0;
							echo $sql9;	
							$rs9 = odbc_exec( $conn, $sql9 );
							if ( !$rs9 )
							{
								exit( "Error en la consulta SQL" );
							}

							  while($row7 = odbc_fetch_array($rs9)){ 
							  		
									
									 if($row7['Bodega'] == 1)
									 {
										   $cantidad1= $cantidad1+(int)$row7['Cantidad'];
										 
									 }
									
									 
									 if($row7['Bodega'] == 2)
									 {
										  $cantidad2= $cantidad2+(int)$row7['Cantidad'];
										
									 }
									
									 
									 if($row7['Bodega'] == 3)
									 {
										 $cantidad3= $cantidad3+(int)$row7['Cantidad'];
									 }
									
									 if($row7['Bodega'] == 4)
									 {
										 $cantidad4= $cantidad4+(int)$row7['Cantidad'];
									 }
									
									
									if($row7['Bodega'] == 5)
									 {
										 $cantidad5= $cantidad5+(int)$row7['Cantidad'];
									 }
									 
									 
									 if($row7['Bodega'] == 6)
									 {
										 $cantidad6= $cantidad6+(int)$row7['Cantidad'];
									 }
									 
									 if($row7['Bodega'] == 7)
									 {
										 $cantidad7= $cantidad7+(int)$row7['Cantidad'];
									 }
									 
									 if($row7['Bodega'] == 0)
									 {
										   $cantidad8= $cantidad8+(int)$row7['Cantidad'];
										 
									 }
									 if($row7['Bodega'] == 8)
									 {
										   $cantidad9= $cantidad9+(int)$row7['Cantidad'];
										 
									 }
									
									
									
							  }
							 
							  
							return $cantidad1."-".$cantidad2."-".$cantidad3."-".$cantidad4."-".$cantidad5."-".$cantidad6."-".$cantidad7."-".$cantidad8."-".$cantidad9;
		
}

function precioOferta($codigo) {
	include("conexionocdb.php");
	$sql10 = "
		SELECT [upc]
			,[descuento]
			,[cantidad]
		FROM [RP_VICENCIO].[dbo].[RP_Descuento_Navidad2]
		WHERE upc = '".$codigo."'
	";
	$rs10 = odbc_exec( $conn, $sql10 );
	if (!$rs10){
		exit("Error en la consulta SQL");
	}
	$result = odbc_fetch_array($rs10);
	$precioOferta = $result['descuento'];
	return $precioOferta;
}


?>