<?php 
require_once("clases/conexionocdb.php");//incluimos archivo de conexión

ini_set('max_execution_time', 300); //300 seconds = 5 minutes

$vendedor = $_GET['id'];
$vendedor = str_pad($vendedor, 3, '0', 'STR_PAD_LEFT');
$modulo = $_GET['modulo'];
$marca = $_GET['marca'];
$uNegocio = $_GET['grupo'];

IF ($modulo)
{
		if($modulo == '009' || $modulo =='010')
		{
			$modulo = $_GET['modulo'];
			if($modulo == '009')
			$modulo = '001';
			else if ($modulo =='010')
			$modulo = '002';
			
			//echo "debo usar air";
			
				 // Consulta para llamar las marcas de los productos
					$sql2= "SELECT   [Code]
						  ,[Name]
						  ,[U_Marca]
					  FROM [RP_REGGEN].[dbo].[View_OMAR] ORDER BY U_Marca ASC
					";
							$rs2 = odbc_exec( $conn, $sql2 );
							if ( !$rs2 )
							{
							exit( "Error en la consulta SQL" );
							}

					if ($modulo)// si selecciono modulo, se genera la consulta
					{
						$conModulo = "  AND (RP_REGGEN.dbo.RP_ReceiptsDet_SAP.Bodega LIKE '".$modulo."') ";
						$conModuloGroup = " , RP_REGGEN.dbo.RP_ReceiptsDet_SAP.Bodega";
					}

					if ($marca)
					{
						$conMarca = " AND (RP_REGGEN.dbo.oITM_From_SBO.U_VK_Marca LIKE '".$marca."')  ";
						$fromMarca = " INNER JOIN
									  RP_REGGEN.dbo.oITM_From_SBO ON RP_REGGEN.dbo.oITM_From_SBO.ItemCode COLLATE SQL_Latin1_General_CP1_CI_AS = RP_REGGEN.dbo.RP_ReceiptsDet_SAP.Sku LEFT OUTER JOIN
									  RP_REGGEN.dbo.View_OMAR ON RP_REGGEN.dbo.View_OMAR.Code = RP_REGGEN.dbo.oITM_From_SBO.U_VK_Marca ";
					}

					/************************************************************ Aeropuerto ********************************************************************************/

					$sql="   SELECT SUM(RP_REGGEN.dbo.RP_ReceiptsDet_SAP.PrecioExtendido) AS total,SUM(RP_REGGEN.dbo.RP_ReceiptsDet_SAP.PrecioExtendido / RP_REGGEN.dbo.RP_ReceiptsCab_SAP.TipoCambio) AS USD,  SUM(RP_REGGEN.dbo.RP_ReceiptsDet_SAP.Cantidad) AS Cantidad, CONVERT(char(7), FechaDocto, 102) AS MES,SUM(RP_REGGEN.dbo.RP_ReceiptsDet_SAP.CIF) as CIFTOTAL 
							 FROM  RP_REGGEN.dbo.RP_ReceiptsDet_SAP  
							 INNER JOIN RP_REGGEN.dbo.RP_ReceiptsCab_SAP ON RP_REGGEN.dbo.RP_ReceiptsDet_SAP.ID = RP_REGGEN.dbo.RP_ReceiptsCab_SAP.ID ".$fromMarca."
							 WHERE (FechaDocto >= '01/01/2014 00:00:00.000') AND (RP_REGGEN.dbo.RP_ReceiptsDet_SAP.TipoDocto = 1 OR RP_REGGEN.dbo.RP_ReceiptsDet_SAP.TipoDocto=4) ".$conModulo."  ".$conMarca."
							 GROUP BY CONVERT(char(7), FechaDocto, 102) ".$conModuloGroup." 
							 UNION 
							 SELECT -SUM(RP_REGGEN.dbo.RP_ReceiptsDet_SAP.PrecioExtendido) AS total, -SUM(RP_REGGEN.dbo.RP_ReceiptsDet_SAP.PrecioExtendido / RP_REGGEN.dbo.RP_ReceiptsCab_SAP.TipoCambio) AS USD,  -SUM(RP_REGGEN.dbo.RP_ReceiptsDet_SAP.Cantidad) AS Cantidad, CONVERT(char(7), FechaDocto, 102) AS MES,-SUM(RP_REGGEN.dbo.RP_ReceiptsDet_SAP.CIF) as CIFTOTAL 
							 FROM  RP_REGGEN.dbo.RP_ReceiptsDet_SAP  
							 INNER JOIN RP_REGGEN.dbo.RP_ReceiptsCab_SAP ON RP_REGGEN.dbo.RP_ReceiptsDet_SAP.ID = RP_REGGEN.dbo.RP_ReceiptsCab_SAP.ID  ".$fromMarca."
							 WHERE (FechaDocto >= '01/01/2014 00:00:00.000') AND RP_REGGEN.dbo.RP_ReceiptsDet_SAP.TipoDocto = 3  ".$conModulo."  ".$conMarca." 
							 GROUP BY CONVERT(char(7), FechaDocto, 102) ".$conModuloGroup."
							 ORDER BY MES,total  ";
				 
		}//FIN IF AEROPUERTO

		Else
		{
					// CONSULTA PARA EXIMBEN
					$sql2= "SELECT   [Code]
						  ,[Name]
						  ,[U_Marca]
					  FROM [RP_VICENCIO].[dbo].[View_OMAR] ORDER BY U_Marca ASC
					";
							$rs2 = odbc_exec( $conn, $sql2 );
							if ( !$rs2 )
							{
							exit( "Error en la consulta SQL" );
							}


					if ($modulo)// si selecciono modulo, se genera la consulta
					{
						$conModulo = "  AND (dbo.RP_ReceiptsDet_SAP.Bodega LIKE '".$modulo."') ";
						$conModuloGroup = " , dbo.RP_ReceiptsDet_SAP.Bodega";
					}

					if ($marca)
					{
						$conMarca = " AND (dbo.oITM_From_SBO.U_VK_Marca LIKE '".$marca."')  ";
						$fromMarca = " INNER JOIN
									  dbo.oITM_From_SBO ON dbo.oITM_From_SBO.ItemCode COLLATE SQL_Latin1_General_CP1_CI_AS = dbo.RP_ReceiptsDet_SAP.Sku LEFT OUTER JOIN
									  dbo.View_OMAR ON dbo.View_OMAR.Code = dbo.oITM_From_SBO.U_VK_Marca ";
					}


					/************************************************************ EXIMBEN ********************************************************************************/

					$sql="   SELECT SUM(dbo.RP_ReceiptsDet_SAP.PrecioExtendido) AS total,SUM(dbo.RP_ReceiptsDet_SAP.PrecioExtendido / dbo.RP_ReceiptsCab_SAP.TipoCambio) AS USD,  SUM(dbo.RP_ReceiptsDet_SAP.Cantidad) AS Cantidad, CONVERT(char(7), FechaDocto, 102) AS MES,SUM(dbo.RP_ReceiptsDet_SAP.CIF) as CIFTOTAL 
							 FROM  dbo.RP_ReceiptsDet_SAP  
							 INNER JOIN dbo.RP_ReceiptsCab_SAP ON dbo.RP_ReceiptsDet_SAP.ID = dbo.RP_ReceiptsCab_SAP.ID ".$fromMarca."
							 WHERE (FechaDocto >= '01/01/2014 00:00:00.000') AND (dbo.RP_ReceiptsDet_SAP.TipoDocto = 1 OR dbo.RP_ReceiptsDet_SAP.TipoDocto=4) ".$conModulo."  ".$conMarca."
							 GROUP BY CONVERT(char(7), FechaDocto, 102) ".$conModuloGroup." 
							 UNION 
							 SELECT -SUM(dbo.RP_ReceiptsDet_SAP.PrecioExtendido) AS total, -SUM(dbo.RP_ReceiptsDet_SAP.PrecioExtendido / dbo.RP_ReceiptsCab_SAP.TipoCambio) AS USD,  -SUM(dbo.RP_ReceiptsDet_SAP.Cantidad) AS Cantidad, CONVERT(char(7), FechaDocto, 102) AS MES,-SUM(dbo.RP_ReceiptsDet_SAP.CIF) as CIFTOTAL 
							 FROM  dbo.RP_ReceiptsDet_SAP  
							 INNER JOIN dbo.RP_ReceiptsCab_SAP ON dbo.RP_ReceiptsDet_SAP.ID = dbo.RP_ReceiptsCab_SAP.ID  ".$fromMarca."
							 WHERE (FechaDocto >= '01/01/2014 00:00:00.000') AND dbo.RP_ReceiptsDet_SAP.TipoDocto = 3  ".$conModulo."  ".$conMarca." 
							 GROUP BY CONVERT(char(7), FechaDocto, 102) ".$conModuloGroup."
							 ORDER BY MES,total  ";
							 
							 
				 
		}//FIN IF EXIMBEN
}//fin if si selecciona modulo
ELSE
{

	// CONSULTA PARA EXIMBEN y AEROPUERTO JUNTOS
					$sql2= "SELECT   [Code]
						  ,[Name]
						  ,[U_Marca]
					  FROM [RP_VICENCIO].[dbo].[View_OMAR] ORDER BY U_Marca ASC
					";
							$rs2 = odbc_exec( $conn, $sql2 );
							if ( !$rs2 )
							{
							exit( "Error en la consulta SQL" );
							}
					if ($marca)
					{
						$conMarca = " AND (dbo.oITM_From_SBO.U_VK_Marca LIKE '".$marca."')  ";
						$fromMarca = " INNER JOIN
									  dbo.oITM_From_SBO ON dbo.oITM_From_SBO.ItemCode COLLATE SQL_Latin1_General_CP1_CI_AS = dbo.RP_ReceiptsDet_SAP.Sku LEFT OUTER JOIN
									  dbo.View_OMAR ON dbo.View_OMAR.Code = dbo.oITM_From_SBO.U_VK_Marca ";
					}
					
					if ($uNegocio)
					{
						$conuNegocio = " AND (dbo.oITM_From_SBO.ItmsGrpCod = ".$uNegocio.")  ";
						$fromuNegocio = " INNER JOIN
									  dbo.oITM_From_SBO ON dbo.oITM_From_SBO.ItemCode COLLATE SQL_Latin1_General_CP1_CI_AS = dbo.RP_ReceiptsDet_SAP.Sku";
					}
					
					if ($marca)
					{
						$conMarcaAir = " AND (RP_REGGEN.dbo.oITM_From_SBO.U_VK_Marca LIKE '".$marca."')  ";
						$fromMarcaAir = " INNER JOIN
									  RP_REGGEN.dbo.oITM_From_SBO ON RP_REGGEN.dbo.oITM_From_SBO.ItemCode COLLATE SQL_Latin1_General_CP1_CI_AS = RP_REGGEN.dbo.RP_ReceiptsDet_SAP.Sku LEFT OUTER JOIN
									  RP_REGGEN.dbo.View_OMAR ON RP_REGGEN.dbo.View_OMAR.Code = RP_REGGEN.dbo.oITM_From_SBO.U_VK_Marca ";
					}
					
					if ($uNegocio)
					{
						$conuNegocioAir = " AND (RP_REGGEN.dbo.oITM_From_SBO.ItmsGrpCod = ".$uNegocio.")  ";
						$fromconuNegocioAir = " INNER JOIN  RP_REGGEN.dbo.oITM_From_SBO ON RP_REGGEN.dbo.oITM_From_SBO.ItemCode COLLATE SQL_Latin1_General_CP1_CI_AS = RP_REGGEN.dbo.RP_ReceiptsDet_SAP.Sku ";
					}

							
	$sql="
			SELECT SUM(dbo.RP_ReceiptsDet_SAP.PrecioExtendido) AS total,SUM(dbo.RP_ReceiptsDet_SAP.PrecioExtendido / dbo.RP_ReceiptsCab_SAP.TipoCambio) AS USD, SUM(dbo.RP_ReceiptsDet_SAP.Cantidad) AS Cantidad, CONVERT(char(7), FechaDocto, 102) AS MES,SUM(dbo.RP_ReceiptsDet_SAP.CIF) as CIFTOTAL 
			FROM dbo.RP_ReceiptsDet_SAP 
			INNER JOIN dbo.RP_ReceiptsCab_SAP ON dbo.RP_ReceiptsDet_SAP.ID = dbo.RP_ReceiptsCab_SAP.ID  ".$fromMarca."  ".$fromuNegocio."
			WHERE (FechaDocto >= '01/01/2014 00:00:00.000') AND (dbo.RP_ReceiptsDet_SAP.TipoDocto = 1 OR dbo.RP_ReceiptsDet_SAP.TipoDocto=4) ".$conMarca." ".$conuNegocio." 
			GROUP BY CONVERT(char(7), FechaDocto, 102) 

			UNION 

			SELECT -SUM(dbo.RP_ReceiptsDet_SAP.PrecioExtendido) AS total, -SUM(dbo.RP_ReceiptsDet_SAP.PrecioExtendido / dbo.RP_ReceiptsCab_SAP.TipoCambio) AS USD, -SUM(dbo.RP_ReceiptsDet_SAP.Cantidad) AS Cantidad, CONVERT(char(7), FechaDocto, 102) AS MES,-SUM(dbo.RP_ReceiptsDet_SAP.CIF) as CIFTOTAL 
			FROM dbo.RP_ReceiptsDet_SAP 
			INNER JOIN dbo.RP_ReceiptsCab_SAP ON dbo.RP_ReceiptsDet_SAP.ID = dbo.RP_ReceiptsCab_SAP.ID  ".$fromMarca." ".$fromuNegocio."
			WHERE (FechaDocto >= '01/01/2014 00:00:00.000') AND dbo.RP_ReceiptsDet_SAP.TipoDocto = 3 ".$conMarca." ".$conuNegocio." 
			 GROUP BY CONVERT(char(7), FechaDocto, 102)  

UNION

SELECT SUM(RP_REGGEN.dbo.RP_ReceiptsDet_SAP.PrecioExtendido) AS total,SUM(RP_REGGEN.dbo.RP_ReceiptsDet_SAP.PrecioExtendido / RP_REGGEN.dbo.RP_ReceiptsCab_SAP.TipoCambio) AS USD,  SUM(RP_REGGEN.dbo.RP_ReceiptsDet_SAP.Cantidad) AS Cantidad, CONVERT(char(7), FechaDocto, 102) AS MES,SUM(RP_REGGEN.dbo.RP_ReceiptsDet_SAP.CIF) as CIFTOTAL 
					 FROM  RP_REGGEN.dbo.RP_ReceiptsDet_SAP  
					 INNER JOIN RP_REGGEN.dbo.RP_ReceiptsCab_SAP ON RP_REGGEN.dbo.RP_ReceiptsDet_SAP.ID = RP_REGGEN.dbo.RP_ReceiptsCab_SAP.ID ".$fromMarcaAir." ".$fromconuNegocioAir."
					 WHERE (FechaDocto >= '01/01/2014 00:00:00.000') AND (RP_REGGEN.dbo.RP_ReceiptsDet_SAP.TipoDocto = 1 OR RP_REGGEN.dbo.RP_ReceiptsDet_SAP.TipoDocto=4) ".$conMarcaAir."     ".$conuNegocioAir." 
					 GROUP BY CONVERT(char(7), FechaDocto, 102) 
UNION 
					 
SELECT -SUM(RP_REGGEN.dbo.RP_ReceiptsDet_SAP.PrecioExtendido) AS total, -SUM(RP_REGGEN.dbo.RP_ReceiptsDet_SAP.PrecioExtendido / RP_REGGEN.dbo.RP_ReceiptsCab_SAP.TipoCambio) AS USD,  -SUM(RP_REGGEN.dbo.RP_ReceiptsDet_SAP.Cantidad) AS Cantidad, CONVERT(char(7), FechaDocto, 102) AS MES,-SUM(RP_REGGEN.dbo.RP_ReceiptsDet_SAP.CIF) as CIFTOTAL 
					 FROM  RP_REGGEN.dbo.RP_ReceiptsDet_SAP  
					 INNER JOIN RP_REGGEN.dbo.RP_ReceiptsCab_SAP ON RP_REGGEN.dbo.RP_ReceiptsDet_SAP.ID = RP_REGGEN.dbo.RP_ReceiptsCab_SAP.ID ".$fromMarcaAir."  ".$fromconuNegocioAir."
					 WHERE (FechaDocto >= '01/01/2014 00:00:00.000') AND RP_REGGEN.dbo.RP_ReceiptsDet_SAP.TipoDocto = 3  ".$conMarcaAir." ".$conuNegocioAir." 
					 GROUP BY CONVERT(char(7), FechaDocto, 102) 
					 ORDER BY MES,total  ";
					 //echo $sql;

}

//echo $sql;
	echo'  <script src="graficos/amcharts/amcharts.js" type="text/javascript"></script> ';//incluyo la librería para generar graficos	
	include("graficos/ventaMensual.php");// grafico que mustra las ventas por marcas en peso 
?>
<script type="text/javascript">
  $(document).ready(function(){
				//comienza focus en modulo
				$('#moduloid').focus();
				// calendarios en text de fecha inicio fin
				
				
				
			});//fin funciotn principal
</script>
<div class="idTabs">
      <ul>
          <li><a href="#one"><img src="images/agregar.png" width="30px" height="30px" /></a></li>
		
	 </ul>
      <div class="items">
        <div id="one"> 
         <form action="" method="GET" id="horizontalForm">
            <fieldset>
				<legend>Seleccionar</legend>
					<input name="opc" type="hidden" id="opc" size="40" class="required" value="ventaMensual" />
					    <?php
							 	if($_SESSION["usuario_modulo"] == -1)
								{
									
									echo '<label class="first" for="title1">
									Retail
									<select id="moduloid" name="modulo"    class="styled" >
									<option ></option>';
									echo'<option value="'.$_GET['modulo'].'" selected>';
									if($modulo)
									{
										
										if( $_GET['modulo']=='009' || $_GET['modulo']=='010')
										{
											echo getmoduloAir($modulo);
										}
										else
										{
											echo getmodulo($modulo);
										}
										
									}
									echo '</option>';
									echo'
									<option value="000">Modulo 2077</option>
									<option value="001">Modulo 1010</option>
									<option value="002">Modulo 1132</option>
									<option value="003">Modulo 181</option>
									<option value="004">Modulo 184</option>
									<option value="005">Modulo 2002</option>
									<option value="006">Modulo 6115</option>
									<option value="007">Modulo 6130</option>
									<option value="009">Local 2</option>
									<option value="010">Local 8</option>
									</select>
									</label>';
								}
					        ?>
							
							<?php // para cargar un list con las marcas
									 echo' <label class="first" for="title1">
									Marca
									<select id="marca" name="marca"    class="styled" >';
											if($marca)
												{
													echo'<option value="'.$marca.'" selected>'.utf8_encode($marca).'</option>';
												}
											 echo'<option value=""></option>';	
											 while($result = odbc_fetch_array($rs2))
											 { 
												
												 echo'<option value="'.$result['Code'].'">'.utf8_encode($result['Name']).'</option>';
												
											 }
										
				
								  echo'</select>
				            </label>';
							
							echo '<label class="first" for="title1">
									Grupo
									<select id="moduloid" name="grupo"    class="styled" >
									<option ></option>';
									echo'<option value="100">Artículos</option>
									<option value="101">Perfumes</option>
									<option value="102">Cosmeticos</option>
									<option value="103">Ropa</option>
									<option value="104">Accesorios</option>
									<option value="105">Confitería</option>
									<option value="106">Óptica</option>
									<option value="107">Servicios</option>
									</select>
				            </label>';
								
					        ?>
                    
                        <input name="agregar" type="submit" id="agregar" class="submit" value="Consultar" />
						   		
				</fieldset>
            </form>
         </div> <!-- fin div two-->
      </div> <!-- fin items -->
    </div> <!-- fin idTabs -->
      
      
<div id="usual1" class="usual" > 
  <ul> 
    <li ><a id="tabdua" href="#tab1" class="selected">Gráfico Venta Mensual</a></li> 
    <!--<li ><a id="tabdua" href="#tab3">Detalle</a></li> -->
  </ul> 
  <div id="tab1"><?php 
		//echo' <div id="ventanual" style="width:100%; height:200px;"></div>';
		echo'<div id="ventaMensual" style="width:100%; height: 400px;"></div>';
	?>
  </div> <!-- fin de grafico de marcas -->
  
<script type="text/javascript"> 
  $("#usual1 ul").idTabs(); 
</script>
 <?php odbc_close( $conn );?>