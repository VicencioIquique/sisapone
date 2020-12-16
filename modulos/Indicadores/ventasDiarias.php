<?php 
require_once("clases/conexionocdb.php");//incluimos archivo de conexión

ini_set('max_execution_time', 300); //300 seconds = 5 minutes

$vendedor = $_GET['id'];
$vendedor = str_pad($vendedor, 3, '0', 'STR_PAD_LEFT');
$modulo = $_GET['modulo'];
$marca = $_GET['marca'];

// Consulta para llamar las marcas de los productos
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


/************************************************************ PARA LAS VENTAS ********************************************************************************/
$sql = "
SELECT     TOP (100) PERCENT SUM(dbo.RP_ReceiptsDet_SAP.PrecioExtendido) AS total, 
                      SUM(dbo.RP_ReceiptsDet_SAP.PrecioExtendido / dbo.RP_ReceiptsCab_SAP.TipoCambio) AS USD, SUM(dbo.RP_ReceiptsDet_SAP.Cantidad) AS Cantidad, 
                      DATENAME(dw, dbo.RP_ReceiptsCab_SAP.FechaDocto) AS DIA, SUM(dbo.RP_ReceiptsDet_SAP.CIF) AS CIFTOTAL
FROM         dbo.RP_ReceiptsDet_SAP INNER JOIN
                      dbo.RP_ReceiptsCab_SAP ON dbo.RP_ReceiptsDet_SAP.ID = dbo.RP_ReceiptsCab_SAP.ID ".$fromMarca."
WHERE     (dbo.RP_ReceiptsCab_SAP.FechaDocto >= '01/01/2014 00:00:00.000') AND (dbo.RP_ReceiptsDet_SAP.TipoDocto = 1 OR dbo.RP_ReceiptsDet_SAP.TipoDocto=4) ".$conModulo." ".$conMarca." 
GROUP BY DATENAME(dw, dbo.RP_ReceiptsCab_SAP.FechaDocto) ".$conModuloGroup."
UNION
SELECT     TOP (100) PERCENT SUM(dbo.RP_ReceiptsDet_SAP.PrecioExtendido) AS total, 
                      SUM(dbo.RP_ReceiptsDet_SAP.PrecioExtendido / dbo.RP_ReceiptsCab_SAP.TipoCambio) AS USD, SUM(dbo.RP_ReceiptsDet_SAP.Cantidad) AS Cantidad, 
                      DATENAME(dw, dbo.RP_ReceiptsCab_SAP.FechaDocto) AS DIA, SUM(dbo.RP_ReceiptsDet_SAP.CIF) AS CIFTOTAL
FROM         dbo.RP_ReceiptsDet_SAP INNER JOIN
                      dbo.RP_ReceiptsCab_SAP ON dbo.RP_ReceiptsDet_SAP.ID = dbo.RP_ReceiptsCab_SAP.ID ".$fromMarca."
WHERE     (dbo.RP_ReceiptsCab_SAP.FechaDocto >= '01/01/2014 00:00:00.000') AND (dbo.RP_ReceiptsDet_SAP.TipoDocto = 3) ".$conModulo." ".$conMarca." 
GROUP BY DATENAME(dw, dbo.RP_ReceiptsCab_SAP.FechaDocto) ".$conModuloGroup."
ORDER BY DIA,total";




//echo $sql;			
	echo'  <script src="graficos/amcharts/amcharts.js" type="text/javascript"></script> ';//incluyo la librería para generar graficos	
	include("graficos/ventaDiaSemana.php");// grafico que mustra las ventas por marcas en peso 
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
					<input name="opc" type="hidden" id="opc" size="40" class="required" value="ventaDiaria" />
					    <?php
							 	if($_SESSION["usuario_modulo"] == -1)
								{
									
									echo '<label class="first" for="title1">
									Retail
									<select id="moduloid" name="modulo"    class="styled" >
									<option ></option>';
									if($modulo)
									{
										echo'<option value="'.$modulo.'" selected>'.getmodulo($modulo).'</option>';
									}
									echo'
									<option value="000">Modulo 2077</option>
									<option value="001">Modulo 1010</option>
									<option value="002">Modulo 1132</option>
									<option value="003">Modulo 181</option>
									<option value="004">Modulo 184</option>
									<option value="005">Modulo 2002</option>
									<option value="006">Modulo 6115</option>
									<option value="007">Modulo 6130</option>
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
					        ?>
                    
                        <input name="agregar" type="submit" id="agregar" class="submit" value="Consultar" />
						   		
				</fieldset>
            </form>
         </div> <!-- fin div two-->
      </div> <!-- fin items -->
    </div> <!-- fin idTabs -->
      
      
<div id="usual1" class="usual" > 
  <ul> 
    <li ><a id="tabdua" href="#tab1" class="selected">Gráfico Ventas Por Día de la Semana</a></li> 
    <!--<li ><a id="tabdua" href="#tab3">Detalle</a></li> -->
  </ul> 
  <div id="tab1"><?php 
		//echo' <div id="ventaDiaSemana" style="width:100%; height:200px;"></div>';
		echo'<div id="ventaDiaSemana" style="width:100%; height: 400px;"></div>';
	?>
  </div> <!-- fin de grafico de marcas -->
  
<script type="text/javascript"> 
  $("#usual1 ul").idTabs(); 
</script>
 <?php odbc_close( $conn );?>