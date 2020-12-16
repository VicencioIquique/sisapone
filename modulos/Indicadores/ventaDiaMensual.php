<?php 
require_once("clases/conexionocdb.php");//incluimos archivo de conexión

ini_set('max_execution_time', 300); //300 seconds = 5 minutes

$vendedor = $_GET['id'];
$vendedor = str_pad($vendedor, 3, '0', 'STR_PAD_LEFT');
$modulo = $_GET['modulo'];
$marca = $_GET['marca'];
$fecha = $_GET['fecha'];
if (!$fecha)
{
	 $fecha = date("m-Y");
}
$mes = substr($fecha,0, 2);
$anio = substr($fecha,3, 4);


// Consulta para llamar las marcas de los productos
$sql2= "SELECT   [Code]
      ,[Name]
      ,[U_Marca]
  FROM [RP_VICENCIO].[dbo].[View_OMAR]
";
		$rs2 = odbc_exec( $conn, $sql2 );
		if ( !$rs2 )
		{
		exit( "Error en la consulta SQL" );
		}

if($modulo == '009' || $modulo =='010')
{
	$modulo = $_GET['modulo'];
			if($modulo == '009')
			$modulo = '001';
			else if ($modulo =='010')
			$modulo = '002';
			
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

			/************************************************************ PARA LAS VENTAS EXIMBEN ********************************************************************************/


			$sql=" SELECT     SUM(RP_REGGEN.dbo.RP_ReceiptsDet_SAP.PrecioExtendido) AS total, 
								  SUM(RP_REGGEN.dbo.RP_ReceiptsDet_SAP.PrecioExtendido / RP_REGGEN.dbo.RP_ReceiptsCab_SAP.TipoCambio) AS USD, SUM(RP_REGGEN.dbo.RP_ReceiptsDet_SAP.Cantidad) AS Cantidad, 
								  CONVERT(char(10), FechaDocto, 103) AS DIA, SUM(RP_REGGEN.dbo.RP_ReceiptsDet_SAP.CIF) AS CIFTOTAL
			FROM         RP_REGGEN.dbo.RP_ReceiptsDet_SAP INNER JOIN
								  RP_REGGEN.dbo.RP_ReceiptsCab_SAP ON RP_REGGEN.dbo.RP_ReceiptsDet_SAP.ID = RP_REGGEN.dbo.RP_ReceiptsCab_SAP.ID
			WHERE     (RP_REGGEN.dbo.RP_ReceiptsCab_SAP.FechaDocto >= '01/01/2014 00:00:00.000') AND (RP_REGGEN.dbo.RP_ReceiptsDet_SAP.TipoDocto = 1 OR
								  RP_REGGEN.dbo.RP_ReceiptsDet_SAP.TipoDocto = 4) AND MONTH(RP_REGGEN.dbo.RP_ReceiptsCab_SAP.FechaDocto) = ".$mes." ".$conModulo."  ".$conMarca." 
			GROUP BY CONVERT(char(10), FechaDocto, 103) ".$conModuloGroup."
			UNION
			SELECT     -SUM(RP_REGGEN.dbo.RP_ReceiptsDet_SAP.PrecioExtendido) AS total, 
								  -SUM(RP_REGGEN.dbo.RP_ReceiptsDet_SAP.PrecioExtendido / RP_REGGEN.dbo.RP_ReceiptsCab_SAP.TipoCambio) AS USD, -SUM(RP_REGGEN.dbo.RP_ReceiptsDet_SAP.Cantidad) AS Cantidad, 
								  CONVERT(char(10), FechaDocto, 103) AS DIA, -SUM(RP_REGGEN.dbo.RP_ReceiptsDet_SAP.CIF) AS CIFTOTAL
			FROM         RP_REGGEN.dbo.RP_ReceiptsDet_SAP INNER JOIN
								  RP_REGGEN.dbo.RP_ReceiptsCab_SAP ON RP_REGGEN.dbo.RP_ReceiptsDet_SAP.ID = RP_REGGEN.dbo.RP_ReceiptsCab_SAP.ID
			WHERE     (RP_REGGEN.dbo.RP_ReceiptsCab_SAP.FechaDocto >= '01/01/2014 00:00:00.000') AND (RP_REGGEN.dbo.RP_ReceiptsDet_SAP.TipoDocto = 3) AND 
								  MONTH(RP_REGGEN.dbo.RP_ReceiptsCab_SAP.FechaDocto) = ".$mes." ".$conModulo."  ".$conMarca." 
			GROUP BY CONVERT(char(10), FechaDocto, 103) ".$conModuloGroup."
			ORDER BY DIA, total";

}//FIn Aeropuerto
else
{
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

			/************************************************************ PARA LAS VENTAS EXIMBEN ********************************************************************************/


			$sql=" SELECT     SUM(dbo.RP_ReceiptsDet_SAP.PrecioExtendido) AS total, 
								  SUM(dbo.RP_ReceiptsDet_SAP.PrecioExtendido / dbo.RP_ReceiptsCab_SAP.TipoCambio) AS USD, SUM(dbo.RP_ReceiptsDet_SAP.Cantidad) AS Cantidad, 
								  CONVERT(char(10), FechaDocto, 103) AS DIA, SUM(dbo.RP_ReceiptsDet_SAP.CIF) AS CIFTOTAL
			FROM         dbo.RP_ReceiptsDet_SAP INNER JOIN
								  dbo.RP_ReceiptsCab_SAP ON dbo.RP_ReceiptsDet_SAP.ID = dbo.RP_ReceiptsCab_SAP.ID
			WHERE     (dbo.RP_ReceiptsCab_SAP.FechaDocto >= '01/01/2014 00:00:00.000') AND (dbo.RP_ReceiptsDet_SAP.TipoDocto = 1 OR
								  dbo.RP_ReceiptsDet_SAP.TipoDocto = 4) AND MONTH(dbo.RP_ReceiptsCab_SAP.FechaDocto) = ".$mes." ".$conModulo."  ".$conMarca." 
			GROUP BY CONVERT(char(10), FechaDocto, 103) ".$conModuloGroup."
			UNION
			SELECT      -SUM(dbo.RP_ReceiptsDet_SAP.PrecioExtendido) AS total, 
								  -SUM(dbo.RP_ReceiptsDet_SAP.PrecioExtendido / dbo.RP_ReceiptsCab_SAP.TipoCambio) AS USD, -SUM(dbo.RP_ReceiptsDet_SAP.Cantidad) AS Cantidad, 
								  CONVERT(char(10), FechaDocto, 103) AS DIA, -SUM(dbo.RP_ReceiptsDet_SAP.CIF) AS CIFTOTAL
			FROM         dbo.RP_ReceiptsDet_SAP INNER JOIN
								  dbo.RP_ReceiptsCab_SAP ON dbo.RP_ReceiptsDet_SAP.ID = dbo.RP_ReceiptsCab_SAP.ID
			WHERE     (dbo.RP_ReceiptsCab_SAP.FechaDocto >= '01/01/2014 00:00:00.000') AND (dbo.RP_ReceiptsDet_SAP.TipoDocto = 3) AND 
								  MONTH(dbo.RP_ReceiptsCab_SAP.FechaDocto) = ".$mes." ".$conModulo."  ".$conMarca." 
			GROUP BY CONVERT(char(10), FechaDocto, 103) ".$conModuloGroup."
			ORDER BY DIA, total";
}//FIN IF DE EXIMBEN
//echo $sql;
		 
	$rs = odbc_exec( $conn, $sql );
		if ( !$rs )
		{
			exit( "Error en la consulta SQL" );
		}
			
while($resultado = odbc_fetch_array($rs))
		{ 
			$dia = substr($resultado["DIA"],0, 2);
			//echo $dia;
						if($dia=='01')
						{
							$d1[] = $resultado["total"];
							$d1CIF[] = $resultado["CIFTOTAL"];
							$d1Cant[] = $resultado["Cantidad"];
							$d1USD[] = $resultado["USD"];
						}
						
						if($dia=='02')
						{
							$d2[] = $resultado["total"];
							$d2CIF[] = $resultado["CIFTOTAL"];
							$d2Cant[] = $resultado["Cantidad"];
							$d2USD[] = $resultado["USD"];
						}
						
						if($dia=='03')
						{
							$d3[] = $resultado["total"];
							$d3CIF[] = $resultado["CIFTOTAL"];
							$d3Cant[] = $resultado["Cantidad"];
							$d3USD[] = $resultado["USD"];
						}
						
						if($dia=='04')
						{
							$d4[] = $resultado["total"];
							$d4CIF[] = $resultado["CIFTOTAL"];
							$d4Cant[] = $resultado["Cantidad"];
							$d4USD[] = $resultado["USD"];
						}
						
						if($dia=='05')
						{
							$d5[] = $resultado["total"];
							$d5CIF[] = $resultado["CIFTOTAL"];
							$d5Cant[] = $resultado["Cantidad"];
							$d5USD[] = $resultado["USD"];
						}
						
						if($dia=='06')
						{
							$d6[] = $resultado["total"];
							$d6CIF[] = $resultado["CIFTOTAL"];
							$d6Cant[] = $resultado["Cantidad"];
							$d6USD[] = $resultado["USD"];
						}
						
						if($dia=='07')
						{
							$d7[] = $resultado["total"];
							$d7CIF[] = $resultado["CIFTOTAL"];
							$d7Cant[] = $resultado["Cantidad"];
							$d7USD[] = $resultado["USD"];
						}
						
						if($dia=='08')
						{
							$d8[] = $resultado["total"];
							$d8CIF[] = $resultado["CIFTOTAL"];
							$d8Cant[] = $resultado["Cantidad"];
							$d8USD[] = $resultado["USD"];
						}
						
						if($dia=='09')
						{
							$d9[] = $resultado["total"];
							$d9CIF[] = $resultado["CIFTOTAL"];
							$d9Cant[] = $resultado["Cantidad"];
							$d9USD[] = $resultado["USD"];
						}
						
						if($dia=='010')
						{
							$d10[] = $resultado["total"];
							$d10CIF[] = $resultado["CIFTOTAL"];
							$d10Cant[] = $resultado["Cantidad"];
							$d10USD[] = $resultado["USD"];
						}
						
						if($dia=='011')
						{
							$d11[] = $resultado["total"];
							$d11CIF[] = $resultado["CIFTOTAL"];
							$d11Cant[] = $resultado["Cantidad"];
							$d11USD[] = $resultado["USD"];
						}
						
						if($dia=='012')
						{
							$d12[] = $resultado["total"];
							$d12CIF[] = $resultado["CIFTOTAL"];
							$d12Cant[] = $resultado["Cantidad"];
							$d12USD[] = $resultado["USD"];
						}
						
						if($dia=='013')
						{
							$d13[] = $resultado["total"];
							$d13CIF[] = $resultado["CIFTOTAL"];
							$d13Cant[] = $resultado["Cantidad"];
							$d13USD[] = $resultado["USD"];
						}
						
						if($dia=='014')
						{
							$d14[] = $resultado["total"];
							$d14CIF[] = $resultado["CIFTOTAL"];
							$d14Cant[] = $resultado["Cantidad"];
							$d14USD[] = $resultado["USD"];
						}
						
						if($dia=='015')
						{
							$d15[] = $resultado["total"];
							$d15CIF[] = $resultado["CIFTOTAL"];
							$d15Cant[] = $resultado["Cantidad"];
							$d15USD[] = $resultado["USD"];
						}
						
						if($dia=='016')
						{
							$d16[] = $resultado["total"];
							$d16CIF[] = $resultado["CIFTOTAL"];
							$d16Cant[] = $resultado["Cantidad"];
							$d16USD[] = $resultado["USD"];
						}
						
						if($dia=='017')
						{
							$d17[] = $resultado["total"];
							$d17CIF[] = $resultado["CIFTOTAL"];
							$d17Cant[] = $resultado["Cantidad"];
							$d17USD[] = $resultado["USD"];
						}
						
						if($dia=='018')
						{
							$d18[] = $resultado["total"];
							$d18CIF[] = $resultado["CIFTOTAL"];
							$d18Cant[] = $resultado["Cantidad"];
							$d18USD[] = $resultado["USD"];
						}
						
						if($dia=='019')
						{
							$d19[] = $resultado["total"];
							$d19CIF[] = $resultado["CIFTOTAL"];
							$d19Cant[] = $resultado["Cantidad"];
							$d19USD[] = $resultado["USD"];
						}
						
						if($dia=='020')
						{
							$d20[] = $resultado["total"];
							$d20CIF[] = $resultado["CIFTOTAL"];
							$d20Cant[] = $resultado["Cantidad"];
							$d20USD[] = $resultado["USD"];
						}
						
						if($dia=='021')
						{
							$d21[] = $resultado["total"];
							$d21CIF[] = $resultado["CIFTOTAL"];
							$d21Cant[] = $resultado["Cantidad"];
							$d21USD[] = $resultado["USD"];
						}
						
						if($dia=='022')
						{
							$d22[] = $resultado["total"];
							$d22CIF[] = $resultado["CIFTOTAL"];
							$d22Cant[] = $resultado["Cantidad"];
							$d22USD[] = $resultado["USD"];
						}
						
						if($dia=='023')
						{
							$d23[] = $resultado["total"];
							$d23CIF[] = $resultado["CIFTOTAL"];
							$d23Cant[] = $resultado["Cantidad"];
							$d23USD[] = $resultado["USD"];
						}
						
						if($dia=='024')
						{
							$d24[] = $resultado["total"];
							$d24CIF[] = $resultado["CIFTOTAL"];
							$d24Cant[] = $resultado["Cantidad"];
							$d24USD[] = $resultado["USD"];
						}
						
						if($dia=='025')
						{
							$d25[] = $resultado["total"];
							$d25CIF[] = $resultado["CIFTOTAL"];
							$d25Cant[] = $resultado["Cantidad"];
							$d25USD[] = $resultado["USD"];
						}
						
						if($dia=='026')
						{
							$d26[] = $resultado["total"];
							$d26CIF[] = $resultado["CIFTOTAL"];
							$d26Cant[] = $resultado["Cantidad"];
							$d26USD[] = $resultado["USD"];
						}
						
						if($dia=='027')
						{
							$d27[] = $resultado["total"];
							$d27CIF[] = $resultado["CIFTOTAL"];
							$d27Cant[] = $resultado["Cantidad"];
							$d27USD[] = $resultado["USD"];
						}
						
						if($dia=='028')
						{
							$d28[] = $resultado["total"];
							$d28CIF[] = $resultado["CIFTOTAL"];
							$d28Cant[] = $resultado["Cantidad"];
							$d28USD[] = $resultado["USD"];
						}
						
						if($dia=='029')
						{
							$d29[] = $resultado["total"];
							$d29CIF[] = $resultado["CIFTOTAL"];
							$d29Cant[] = $resultado["Cantidad"];
							$d29USD[] = $resultado["USD"];
						}
						
						if($dia=='030')
						{
							$d30[] = $resultado["total"];
							$d30CIF[] = $resultado["CIFTOTAL"];
							$d30Cant[] = $resultado["Cantidad"];
							$d30USD[] = $resultado["USD"];
						}
						
						if($dia=='031')
						{
							$d31[] = $resultado["total"];
							$d31CIF[] = $resultado["CIFTOTAL"];
							$d31Cant[] = $resultado["Cantidad"];
							$d31USD[] = $resultado["USD"];
						}

			
			
		  //echo $lunes[0];
		}

//echo $sql;			
	echo'  <script src="graficos/amcharts/amcharts.js" type="text/javascript"></script> ';//incluyo la librería para generar graficos	
	include("graficos/ventaDiaMes.php");// grafico 
?>
<script type="text/javascript">
  $(document).ready(function(){
				//comienza focus en modulo
				$('#moduloid').focus();
				// calendarios en text de fecha inicio fin
				$(".fecha").datepicker({
				dateFormat: 'mm-yy',
				changeMonth: true,
				changeYear: true,
				showButtonPanel: true,

				onClose: function(dateText, inst) {
					var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
					var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
					$(this).val($.datepicker.formatDate('mm-yy', new Date(year, month, 1)));
				}
			});
			
			
			
			$(".fecha").focus(function () {
				$(".ui-datepicker-calendar").hide();
				$("#ui-datepicker-div").position({
					my: "center top",
					at: "center bottom",
					of: $(this)
				});
			});
				
				
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
					<input name="opc" type="hidden" id="opc" size="40" class="required" value="ventaDiaMensual" />
					
						<label for="fecha1">
					            Mes
                            <input name="fecha" type="text" id="fecha" size="40" class="fecha" value="<?php echo $fecha;?>"  />
                            </label>
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
							
							<?php /*// para cargar un list con las marcas
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
				            </label>';*/
					        ?>
                    
                        <input name="agregar" type="submit" id="agregar" class="submit" value="Consultar" />
						   		
				</fieldset>
            </form>
         </div> <!-- fin div two-->
      </div> <!-- fin items -->
    </div> <!-- fin idTabs -->
      
      
<div id="usual1" class="usual" > 
  <ul> 
	<li ><a id="tabdua" href="#tab1" >Venta Diaria </a></li> 
    <li ><a id="tabdua" href="#tab2" class="selected" >Gráfico Venta Diaria en el Mes</a></li> 
	<li ><a id="tabdua" href="http://localhost//sisap/modulos/impresiones/inf_ventasMensual.php" >Imprimir Resumen</a></li> 
    
  </ul> 
  <div id="tab1">
		<table  id="ssptable2" class="lista">
              <thead>
                    <tr>
						<th>Día</th>
						<th>Un.</th>
						<th>Total Venta</th> 
						<th>USD</th> 
						<th>CIF</th> 
                    </tr>
                </thead>
                <tbody >
				<?php 
				$j = 1;
				/*while($j<=31)
				{
						echo'<tr>
							<td style="background-color:#6C6B6B;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" >'.$j.'</td> 
							<td >\'.abs($d'.$j.'Cant[1]+$d'.$j.'Cant[0]+$d'.$j.'Cant[2]+$d'.$j.'Cant[3]).\'</td> 
							<td ><strong>\'.abs($d'.$j.'[1]+$d'.$j.'[0]+$d'.$j.'[2]+$d'.$j.'[3]).\'</strong></td>
							<td >\'.abs($d'.$j.'USD[1]+$d'.$j.'USD[0]+$d'.$j.'USD[2]+$d'.$j.'USD[3]).\'</td> 
							<td >\'.abs($d'.$j.'CIF[1]+$d'.$j.'CIF[0]+$d'.$j.'CIF[2]+$d'.$j.'CIF[3]).\'</td> 
						</tr>';
						
						echo'
						if($dia==\'0'.$j.'\')
						{
							$d'.$j.'[] = $resultado["total"];
							$d'.$j.'CIF[] = $resultado["CIFTOTAL"];
							$d'.$j.'Cant[] = $resultado["Cantidad"];
							$d'.$j.'USD[] = $resultado["USD"];
						}
						';
						
						echo '
							{ country: "'.$j.'",
							visits: \'.abs($d'.$j.'[1]+$d'.$j.'[0]+$d'.$j.'[2]+$d'.$j.'[3]).\',
							cif: \'.abs($d'.$j.'CIF[1]+$d'.$j.'CIF[0]+$d'.$j.'CIF[2]+$d'.$j.'CIF[3]).\',
							cant: \'.abs($d'.$j.'Cant[1]+$d'.$j.'Cant[0]+$d'.$j.'Cant[2]+$d'.$j.'Cant[3]).\',
							USD: \'.abs($d'.$j.'USD[1]+$d'.$j.'USD[0]+$d'.$j.'USD[2]+$d'.$j.'USD[3]).\',
							color: "#0489B1"
						},'; 
				$j++;
				}*/
				echo'
						<tr>
							<td style="background-color:#6C6B6B;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" >1</td> 
							<td >'. number_format(abs($d1Cant[1]+$d1Cant[0]+$d1Cant[2]+$d1Cant[3]), 0, '', '.').'</td> 
							<td ><strong>'. number_format(abs($d1[1]+$d1[0]+$d1[2]+$d1[3]), 0, '', '.').'</strong></td>
							<td >'. number_format(abs($d1USD[1]+$d1USD[0]+$d1USD[2]+$d1USD[3]), 2, '', '.').'</td> 
							<td >'. number_format(abs($d1CIF[1]+$d1CIF[0]+$d1CIF[2]+$d1CIF[3]), 2, '', '.').'</td> 
						</tr><tr>
							<td style="background-color:#6C6B6B;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" >2</td> 
							<td >'. number_format(abs($d2Cant[1]+$d2Cant[0]+$d2Cant[2]+$d2Cant[3]), 0, '', '.').'</td> 
							<td ><strong>'. number_format(abs($d2[1]+$d2[0]+$d2[2]+$d2[3]), 0, '', '.').'</strong></td>
							<td >'. number_format(abs($d2USD[1]+$d2USD[0]+$d2USD[2]+$d2USD[3]), 2, '', '.').'</td> 
							<td >'. number_format(abs($d2CIF[1]+$d2CIF[0]+$d2CIF[2]+$d2CIF[3]), 2, '', '.').'</td> 
						</tr><tr>
							<td style="background-color:#6C6B6B;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" >3</td> 
							<td >'. number_format(abs($d3Cant[1]+$d3Cant[0]+$d3Cant[2]+$d3Cant[3]), 0, '', '.').'</td> 
							<td ><strong>'. number_format(abs($d3[1]+$d3[0]+$d3[2]+$d3[3]), 0, '', '.').'</strong></td>
							<td >'. number_format(abs($d3USD[1]+$d3USD[0]+$d3USD[2]+$d3USD[3]), 2, '', '.').'</td> 
							<td >'. number_format(abs($d3CIF[1]+$d3CIF[0]+$d3CIF[2]+$d3CIF[3]), 2, '', '.').'</td> 
						</tr><tr>
							<td style="background-color:#6C6B6B;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" >4</td> 
							<td >'. number_format(abs($d4Cant[1]+$d4Cant[0]+$d4Cant[2]+$d4Cant[3]), 0, '', '.').'</td> 
							<td ><strong>'. number_format(abs($d4[1]+$d4[0]+$d4[2]+$d4[3]), 0, '', '.').'</strong></td>
							<td >'. number_format(abs($d4USD[1]+$d4USD[0]+$d4USD[2]+$d4USD[3]), 2, '', '.').'</td> 
							<td >'. number_format(abs($d4CIF[1]+$d4CIF[0]+$d4CIF[2]+$d4CIF[3]), 2, '', '.').'</td> 
						</tr><tr>
							<td style="background-color:#6C6B6B;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" >5</td> 
							<td >'. number_format(abs($d5Cant[1]+$d5Cant[0]+$d5Cant[2]+$d5Cant[3]), 0, '', '.').'</td> 
							<td ><strong>'. number_format(abs($d5[1]+$d5[0]+$d5[2]+$d5[3]), 0, '', '.').'</strong></td>
							<td >'. number_format(abs($d5USD[1]+$d5USD[0]+$d5USD[2]+$d5USD[3]), 2, '', '.').'</td> 
							<td >'. number_format(abs($d5CIF[1]+$d5CIF[0]+$d5CIF[2]+$d5CIF[3]), 2, '', '.').'</td> 
						</tr><tr>
							<td style="background-color:#6C6B6B;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" >6</td> 
							<td >'. number_format(abs($d6Cant[1]+$d6Cant[0]+$d6Cant[2]+$d6Cant[3]), 0, '', '.').'</td> 
							<td ><strong>'. number_format(abs($d6[1]+$d6[0]+$d6[2]+$d6[3]), 0, '', '.').'</strong></td>
							<td >'. number_format(abs($d6USD[1]+$d6USD[0]+$d6USD[2]+$d6USD[3]), 2, '', '.').'</td> 
							<td >'. number_format(abs($d6CIF[1]+$d6CIF[0]+$d6CIF[2]+$d6CIF[3]), 2, '', '.').'</td> 
						</tr><tr>
							<td style="background-color:#6C6B6B;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" >7</td> 
							<td >'. number_format(abs($d7Cant[1]+$d7Cant[0]+$d7Cant[2]+$d7Cant[3]), 0, '', '.').'</td> 
							<td ><strong>'. number_format(abs($d7[1]+$d7[0]+$d7[2]+$d7[3]), 0, '', '.').'</strong></td>
							<td >'. number_format(abs($d7USD[1]+$d7USD[0]+$d7USD[2]+$d7USD[3]), 2, '', '.').'</td> 
							<td >'. number_format(abs($d7CIF[1]+$d7CIF[0]+$d7CIF[2]+$d7CIF[3]), 2, '', '.').'</td> 
						</tr><tr>
							<td style="background-color:#6C6B6B;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" >8</td> 
							<td >'. number_format(abs($d8Cant[1]+$d8Cant[0]+$d8Cant[2]+$d8Cant[3]), 0, '', '.').'</td> 
							<td ><strong>'. number_format(abs($d8[1]+$d8[0]+$d8[2]+$d8[3]), 0, '', '.').'</strong></td>
							<td >'. number_format(abs($d8USD[1]+$d8USD[0]+$d8USD[2]+$d8USD[3]), 2, '', '.').'</td> 
							<td >'. number_format(abs($d8CIF[1]+$d8CIF[0]+$d8CIF[2]+$d8CIF[3]), 2, '', '.').'</td> 
						</tr><tr>
							<td style="background-color:#6C6B6B;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" >9</td> 
							<td >'. number_format(abs($d9Cant[1]+$d9Cant[0]+$d9Cant[2]+$d9Cant[3]), 0, '', '.').'</td> 
							<td ><strong>'. number_format(abs($d9[1]+$d9[0]+$d9[2]+$d9[3]), 0, '', '.').'</strong></td>
							<td >'. number_format(abs($d9USD[1]+$d9USD[0]+$d9USD[2]+$d9USD[3]), 2, '', '.').'</td> 
							<td >'. number_format(abs($d9CIF[1]+$d9CIF[0]+$d9CIF[2]+$d9CIF[3]), 2, '', '.').'</td> 
						</tr><tr>
							<td style="background-color:#6C6B6B;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" >10</td> 
							<td >'. number_format(abs($d10Cant[1]+$d10Cant[0]+$d10Cant[2]+$d10Cant[3]), 0, '', '.').'</td> 
							<td ><strong>'. number_format(abs($d10[1]+$d10[0]+$d10[2]+$d10[3]), 0, '', '.').'</strong></td>
							<td >'. number_format(abs($d10USD[1]+$d10USD[0]+$d10USD[2]+$d10USD[3]), 2, '', '.').'</td> 
							<td >'. number_format(abs($d10CIF[1]+$d10CIF[0]+$d10CIF[2]+$d10CIF[3]), 2, '', '.').'</td> 
						</tr><tr>
							<td style="background-color:#6C6B6B;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" >11</td> 
							<td >'. number_format(abs($d11Cant[1]+$d11Cant[0]+$d11Cant[2]+$d11Cant[3]), 0, '', '.').'</td> 
							<td ><strong>'. number_format(abs($d11[1]+$d11[0]+$d11[2]+$d11[3]), 0, '', '.').'</strong></td>
							<td >'. number_format(abs($d11USD[1]+$d11USD[0]+$d11USD[2]+$d11USD[3]), 2, '', '.').'</td> 
							<td >'. number_format(abs($d11CIF[1]+$d11CIF[0]+$d11CIF[2]+$d11CIF[3]), 2, '', '.').'</td> 
						</tr><tr>
							<td style="background-color:#6C6B6B;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" >12</td> 
							<td >'. number_format(abs($d12Cant[1]+$d12Cant[0]+$d12Cant[2]+$d12Cant[3]), 0, '', '.').'</td> 
							<td ><strong>'. number_format(abs($d12[1]+$d12[0]+$d12[2]+$d12[3]), 0, '', '.').'</strong></td>
							<td >'. number_format(abs($d12USD[1]+$d12USD[0]+$d12USD[2]+$d12USD[3]), 2, '', '.').'</td> 
							<td >'. number_format(abs($d12CIF[1]+$d12CIF[0]+$d12CIF[2]+$d12CIF[3]), 2, '', '.').'</td> 
						</tr><tr>
							<td style="background-color:#6C6B6B;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" >13</td> 
							<td >'. number_format(abs($d13Cant[1]+$d13Cant[0]+$d13Cant[2]+$d13Cant[3]), 0, '', '.').'</td> 
							<td ><strong>'. number_format(abs($d13[1]+$d13[0]+$d13[2]+$d13[3]), 0, '', '.').'</strong></td>
							<td >'. number_format(abs($d13USD[1]+$d13USD[0]+$d13USD[2]+$d13USD[3]), 2, '', '.').'</td> 
							<td >'. number_format(abs($d13CIF[1]+$d13CIF[0]+$d13CIF[2]+$d13CIF[3]), 2, '', '.').'</td> 
						</tr><tr>
							<td style="background-color:#6C6B6B;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" >14</td> 
							<td >'. number_format(abs($d14Cant[1]+$d14Cant[0]+$d14Cant[2]+$d14Cant[3]), 0, '', '.').'</td> 
							<td ><strong>'. number_format(abs($d14[1]+$d14[0]+$d14[2]+$d14[3]), 0, '', '.').'</strong></td>
							<td >'. number_format(abs($d14USD[1]+$d14USD[0]+$d14USD[2]+$d14USD[3]), 2, '', '.').'</td> 
							<td >'. number_format(abs($d14CIF[1]+$d14CIF[0]+$d14CIF[2]+$d14CIF[3]), 2, '', '.').'</td> 
						</tr><tr>
							<td style="background-color:#6C6B6B;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" >15</td> 
							<td >'. number_format(abs($d15Cant[1]+$d15Cant[0]+$d15Cant[2]+$d15Cant[3]), 0, '', '.').'</td> 
							<td ><strong>'. number_format(abs($d15[1]+$d15[0]+$d15[2]+$d15[3]), 0, '', '.').'</strong></td>
							<td >'. number_format(abs($d15USD[1]+$d15USD[0]+$d15USD[2]+$d15USD[3]), 2, '', '.').'</td> 
							<td >'. number_format(abs($d15CIF[1]+$d15CIF[0]+$d15CIF[2]+$d15CIF[3]), 2, '', '.').'</td> 
						</tr><tr>
							<td style="background-color:#6C6B6B;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" >16</td> 
							<td >'. number_format(abs($d16Cant[1]+$d16Cant[0]+$d16Cant[2]+$d16Cant[3]), 0, '', '.').'</td> 
							<td ><strong>'. number_format(abs($d16[1]+$d16[0]+$d16[2]+$d16[3]), 0, '', '.').'</strong></td>
							<td >'. number_format(abs($d16USD[1]+$d16USD[0]+$d16USD[2]+$d16USD[3]), 2, '', '.').'</td> 
							<td >'. number_format(abs($d16CIF[1]+$d16CIF[0]+$d16CIF[2]+$d16CIF[3]), 2, '', '.').'</td> 
						</tr><tr>
							<td style="background-color:#6C6B6B;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" >17</td> 
							<td >'. number_format(abs($d17Cant[1]+$d17Cant[0]+$d17Cant[2]+$d17Cant[3]), 0, '', '.').'</td> 
							<td ><strong>'. number_format(abs($d17[1]+$d17[0]+$d17[2]+$d17[3]), 0, '', '.').'</strong></td>
							<td >'. number_format(abs($d17USD[1]+$d17USD[0]+$d17USD[2]+$d17USD[3]), 2, '', '.').'</td> 
							<td >'. number_format(abs($d17CIF[1]+$d17CIF[0]+$d17CIF[2]+$d17CIF[3]), 2, '', '.').'</td> 
						</tr><tr>
							<td style="background-color:#6C6B6B;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" >18</td> 
							<td >'. number_format(abs($d18Cant[1]+$d18Cant[0]+$d18Cant[2]+$d18Cant[3]), 0, '', '.').'</td> 
							<td ><strong>'. number_format(abs($d18[1]+$d18[0]+$d18[2]+$d18[3]), 0, '', '.').'</strong></td>
							<td >'. number_format(abs($d18USD[1]+$d18USD[0]+$d18USD[2]+$d18USD[3]), 2, '', '.').'</td> 
							<td >'. number_format(abs($d18CIF[1]+$d18CIF[0]+$d18CIF[2]+$d18CIF[3]), 2, '', '.').'</td> 
						</tr><tr>
							<td style="background-color:#6C6B6B;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" >19</td> 
							<td >'. number_format(abs($d19Cant[1]+$d19Cant[0]+$d19Cant[2]+$d19Cant[3]), 0, '', '.').'</td> 
							<td ><strong>'. number_format(abs($d19[1]+$d19[0]+$d19[2]+$d19[3]), 0, '', '.').'</strong></td>
							<td >'. number_format(abs($d19USD[1]+$d19USD[0]+$d19USD[2]+$d19USD[3]), 2, '', '.').'</td> 
							<td >'. number_format(abs($d19CIF[1]+$d19CIF[0]+$d19CIF[2]+$d19CIF[3]), 2, '', '.').'</td> 
						</tr><tr>
							<td style="background-color:#6C6B6B;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" >20</td> 
							<td >'. number_format(abs($d20Cant[1]+$d20Cant[0]+$d20Cant[2]+$d20Cant[3]), 0, '', '.').'</td> 
							<td ><strong>'. number_format(abs($d20[1]+$d20[0]+$d20[2]+$d20[3]), 0, '', '.').'</strong></td>
							<td >'. number_format(abs($d20USD[1]+$d20USD[0]+$d20USD[2]+$d20USD[3]), 2, '', '.').'</td> 
							<td >'. number_format(abs($d20CIF[1]+$d20CIF[0]+$d20CIF[2]+$d20CIF[3]), 2, '', '.').'</td> 
						</tr><tr>
							<td style="background-color:#6C6B6B;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" >21</td> 
							<td >'. number_format(abs($d21Cant[1]+$d21Cant[0]+$d21Cant[2]+$d21Cant[3]), 0, '', '.').'</td> 
							<td ><strong>'. number_format(abs($d21[1]+$d21[0]+$d21[2]+$d21[3]), 0, '', '.').'</strong></td>
							<td >'. number_format(abs($d21USD[1]+$d21USD[0]+$d21USD[2]+$d21USD[3]), 2, '', '.').'</td> 
							<td >'. number_format(abs($d21CIF[1]+$d21CIF[0]+$d21CIF[2]+$d21CIF[3]), 2, '', '.').'</td> 
						</tr><tr>
							<td style="background-color:#6C6B6B;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" >22</td> 
							<td >'. number_format(abs($d22Cant[1]+$d22Cant[0]+$d22Cant[2]+$d22Cant[3]), 0, '', '.').'</td> 
							<td ><strong>'. number_format(abs($d22[1]+$d22[0]+$d22[2]+$d22[3]), 0, '', '.').'</strong></td>
							<td >'. number_format(abs($d22USD[1]+$d22USD[0]+$d22USD[2]+$d22USD[3]), 2, '', '.').'</td> 
							<td >'. number_format(abs($d22CIF[1]+$d22CIF[0]+$d22CIF[2]+$d22CIF[3]), 2, '', '.').'</td> 
						</tr><tr>
							<td style="background-color:#6C6B6B;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" >23</td> 
							<td >'. number_format(abs($d23Cant[1]+$d23Cant[0]+$d23Cant[2]+$d23Cant[3]), 0, '', '.').'</td> 
							<td ><strong>'. number_format(abs($d23[1]+$d23[0]+$d23[2]+$d23[3]), 0, '', '.').'</strong></td>
							<td >'. number_format(abs($d23USD[1]+$d23USD[0]+$d23USD[2]+$d23USD[3]), 2, '', '.').'</td> 
							<td >'. number_format(abs($d23CIF[1]+$d23CIF[0]+$d23CIF[2]+$d23CIF[3]), 2, '', '.').'</td> 
						</tr><tr>
							<td style="background-color:#6C6B6B;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" >24</td> 
							<td >'. number_format(abs($d24Cant[1]+$d24Cant[0]+$d24Cant[2]+$d24Cant[3]), 0, '', '.').'</td> 
							<td ><strong>'. number_format(abs($d24[1]+$d24[0]+$d24[2]+$d24[3]), 0, '', '.').'</strong></td>
							<td >'. number_format(abs($d24USD[1]+$d24USD[0]+$d24USD[2]+$d24USD[3]), 2, '', '.').'</td> 
							<td >'. number_format(abs($d24CIF[1]+$d24CIF[0]+$d24CIF[2]+$d24CIF[3]), 2, '', '.').'</td> 
						</tr><tr>
							<td style="background-color:#6C6B6B;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" >25</td> 
							<td >'. number_format(abs($d25Cant[1]+$d25Cant[0]+$d25Cant[2]+$d25Cant[3]), 0, '', '.').'</td> 
							<td ><strong>'. number_format(abs($d25[1]+$d25[0]+$d25[2]+$d25[3]), 0, '', '.').'</strong></td>
							<td >'. number_format(abs($d25USD[1]+$d25USD[0]+$d25USD[2]+$d25USD[3]), 2, '', '.').'</td> 
							<td >'. number_format(abs($d25CIF[1]+$d25CIF[0]+$d25CIF[2]+$d25CIF[3]), 2, '', '.').'</td> 
						</tr><tr>
							<td style="background-color:#6C6B6B;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" >26</td> 
							<td >'. number_format(abs($d26Cant[1]+$d26Cant[0]+$d26Cant[2]+$d26Cant[3]), 0, '', '.').'</td> 
							<td ><strong>'. number_format(abs($d26[1]+$d26[0]+$d26[2]+$d26[3]), 0, '', '.').'</strong></td>
							<td >'. number_format(abs($d26USD[1]+$d26USD[0]+$d26USD[2]+$d26USD[3]), 2, '', '.').'</td> 
							<td >'. number_format(abs($d26CIF[1]+$d26CIF[0]+$d26CIF[2]+$d26CIF[3]), 2, '', '.').'</td> 
						</tr><tr>
							<td style="background-color:#6C6B6B;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" >27</td> 
							<td >'. number_format(abs($d27Cant[1]+$d27Cant[0]+$d27Cant[2]+$d27Cant[3]), 0, '', '.').'</td> 
							<td ><strong>'. number_format(abs($d27[1]+$d27[0]+$d27[2]+$d27[3]), 0, '', '.').'</strong></td>
							<td >'. number_format(abs($d27USD[1]+$d27USD[0]+$d27USD[2]+$d27USD[3]), 2, '', '.').'</td> 
							<td >'. number_format(abs($d27CIF[1]+$d27CIF[0]+$d27CIF[2]+$d27CIF[3]), 2, '', '.').'</td> 
						</tr><tr>
							<td style="background-color:#6C6B6B;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" >28</td> 
							<td >'. number_format(abs($d28Cant[1]+$d28Cant[0]+$d28Cant[2]+$d28Cant[3]), 0, '', '.').'</td> 
							<td ><strong>'. number_format(abs($d28[1]+$d28[0]+$d28[2]+$d28[3]), 0, '', '.').'</strong></td>
							<td >'. number_format(abs($d28USD[1]+$d28USD[0]+$d28USD[2]+$d28USD[3]), 2, '', '.').'</td> 
							<td >'. number_format(abs($d28CIF[1]+$d28CIF[0]+$d28CIF[2]+$d28CIF[3]), 2, '', '.').'</td> 
						</tr><tr>
							<td style="background-color:#6C6B6B;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" >29</td> 
							<td >'. number_format(abs($d29Cant[1]+$d29Cant[0]+$d29Cant[2]+$d29Cant[3]), 0, '', '.').'</td> 
							<td ><strong>'. number_format(abs($d29[1]+$d29[0]+$d29[2]+$d29[3]), 0, '', '.').'</strong></td>
							<td >'. number_format(abs($d29USD[1]+$d29USD[0]+$d29USD[2]+$d29USD[3]), 2, '', '.').'</td> 
							<td >'. number_format(abs($d29CIF[1]+$d29CIF[0]+$d29CIF[2]+$d29CIF[3]), 2, '', '.').'</td> 
						</tr><tr>
							<td style="background-color:#6C6B6B;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" >30</td> 
							<td >'. number_format(abs($d30Cant[1]+$d30Cant[0]+$d30Cant[2]+$d30Cant[3]), 0, '', '.').'</td> 
							<td ><strong>'. number_format(abs($d30[1]+$d30[0]+$d30[2]+$d30[3]), 0, '', '.').'</strong></td>
							<td >'. number_format(abs($d30USD[1]+$d30USD[0]+$d30USD[2]+$d30USD[3]), 2, '', '.').'</td> 
							<td >'. number_format(abs($d30CIF[1]+$d30CIF[0]+$d30CIF[2]+$d30CIF[3]), 2, '', '.').'</td> 
						</tr><tr>
							<td style="background-color:#6C6B6B;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" >31</td> 
							<td >'. number_format(abs($d31Cant[1]+$d31Cant[0]+$d31Cant[2]+$d31Cant[3]), 0, '', '.').'</td> 
							<td ><strong>'. number_format(abs($d31[1]+$d31[0]+$d31[2]+$d31[3]), 0, '', '.').'</strong></td>
							<td >'. number_format(abs($d31USD[1]+$d31USD[0]+$d31USD[2]+$d31USD[3]), 2, '', '.').'</td> 
							<td >'. number_format(abs($d31CIF[1]+$d31CIF[0]+$d31CIF[2]+$d31CIF[3]), 2, '', '.').'</td> 
						</tr>

';
				
				$totalCantidad= abs($d1Cant[1]+$d1Cant[0]+$d1Cant[2]+$d1Cant[3])+abs($d2Cant[1]+$d2Cant[0]+$d2Cant[2]+$d2Cant[3])+abs($d3Cant[1]+$d3Cant[0]+$d3Cant[2]+$d3Cant[3])+abs($d4Cant[1]+$d4Cant[0]+$d4Cant[2]+$d4Cant[3])+abs($d5Cant[1]+$d5Cant[0]+$d5Cant[2]+$d5Cant[3])+
								abs($d6Cant[1]+$d6Cant[0]+$d6Cant[2]+$d6Cant[3])+abs($d7Cant[1]+$d7Cant[0]+$d7Cant[2]+$d7Cant[3])+abs($d8Cant[1]+$d8Cant[0]+$d8Cant[2]+$d8Cant[3])+abs($d9Cant[1]+$d9Cant[0]+$d9Cant[2]+$d9Cant[3])+abs($d10Cant[1]+$d10Cant[0]+$d10Cant[2]+$d10Cant[3])+
								abs($d11Cant[1]+$d11Cant[0]+$d11Cant[2]+$d11Cant[3])+abs($d12Cant[1]+$d12Cant[0]+$d12Cant[2]+$d12Cant[3])+abs($d13Cant[1]+$d13Cant[0]+$d13Cant[2]+$d13Cant[3])+abs($d14Cant[1]+$d14Cant[0]+$d14Cant[2]+$d14Cant[3])+abs($d15Cant[1]+$d15Cant[0]+$d15Cant[2]+$d15Cant[3])+
								abs($d16Cant[1]+$d16Cant[0]+$d16Cant[2]+$d16Cant[3])+abs($d17Cant[1]+$d17Cant[0]+$d17Cant[2]+$d17Cant[3])+abs($d18Cant[1]+$d18Cant[0]+$d18Cant[2]+$d18Cant[3])+abs($d19Cant[1]+$d19Cant[0]+$d19Cant[2]+$d19Cant[3])+abs($d20Cant[1]+$d20Cant[0]+$d20Cant[2]+$d20Cant[3])+
								abs($d21Cant[1]+$d21Cant[0]+$d21Cant[2]+$d21Cant[3])+abs($d22Cant[1]+$d22Cant[0]+$d22Cant[2]+$d22Cant[3])+abs($d23Cant[1]+$d23Cant[0]+$d23Cant[2]+$d23Cant[3])+abs($d24Cant[1]+$d24Cant[0]+$d24Cant[2]+$d24Cant[3])+abs($d25Cant[1]+$d25Cant[0]+$d25Cant[2]+$d25Cant[3])+
								abs($d26Cant[1]+$d26Cant[0]+$d26Cant[2]+$d26Cant[3])+abs($d27Cant[1]+$d27Cant[0]+$d27Cant[2]+$d27Cant[3])+abs($d28Cant[1]+$d28Cant[0]+$d28Cant[2]+$d28Cant[3])+abs($d29Cant[1]+$d29Cant[0]+$d29Cant[2]+$d29Cant[3])+abs($d30Cant[1]+$d30Cant[0]+$d30Cant[2]+$d30Cant[3])+
								abs($d31Cant[1]+$d31Cant[0]+$d30Cant[2]+$d30Cant[3]);
								
				$TOTAL= abs($d1[1]+$d1[0]+$d1[2]+$d1[3])+abs($d2[1]+$d2[0]+$d2[2]+$d2[3])+abs($d3[1]+$d3[0]+$d3[2]+$d3[3])+abs($d4[1]+$d4[0]+$d4[2]+$d4[3])+abs($d5[1]+$d5[0]+$d5[2]+$d5[3])+
								abs($d6[1]+$d6[0]+$d6[2]+$d6[3])+abs($d7[1]+$d7[0]+$d7[2]+$d7[3])+abs($d8[1]+$d8[0]+$d8[2]+$d8[3])+abs($d9[1]+$d9[0]+$d9[2]+$d9[3])+abs($d10[1]+$d10[0]+$d10[2]+$d10[3])+
								abs($d11[1]+$d11[0]+$d11[2]+$d11[3])+abs($d12[1]+$d12[0]+$d12[2]+$d12[3])+abs($d13[1]+$d13[0]+$d13[2]+$d13[3])+abs($d14[1]+$d14[0]+$d14[2]+$d14[3])+abs($d15[1]+$d15[0]+$d15[2]+$d15[3])+
								abs($d16[1]+$d16[0]+$d16[2]+$d16[3])+abs($d17[1]+$d17[0]+$d17[2]+$d17[3])+abs($d18[1]+$d18[0]+$d18[2]+$d18[3])+abs($d19[1]+$d19[0]+$d19[2]+$d19[3])+abs($d20[1]+$d20[0]+$d20[2]+$d20[3])+
								abs($d21[1]+$d21[0]+$d21[2]+$d21[3])+abs($d22[1]+$d22[0]+$d22[2]+$d22[3])+abs($d23[1]+$d23[0]+$d23[2]+$d23[3])+abs($d24[1]+$d24[0]+$d24[2]+$d24[3])+abs($d25[1]+$d25[0]+$d25[2]+$d25[3])+
								abs($d26[1]+$d26[0]+$d26[2]+$d26[3])+abs($d27[1]+$d27[0]+$d27[2]+$d27[3])+abs($d28[1]+$d28[0]+$d28[2]+$d28[3])+abs($d29[1]+$d29[0]+$d29[2]+$d29[3])+abs($d30[1]+$d30[0]+$d30[2]+$d30[3])+
								abs($d31[1]+$d31[0]+$d31[2]+$d31[3]);
								
				$TOTALUSD=	abs($d1USD[1]+$d1USD[0]+$d1USD[2]+$d1USD[3])+abs($d2USD[1]+$d2USD[0]+$d2USD[2]+$d2USD[3])+abs($d3USD[1]+$d3USD[0]+$d3USD[2]+$d3USD[3])+abs($d4USD[1]+$d4USD[0]+$d4USD[2]+$d4USD[3])+abs($d5USD[1]+$d5USD[0]+$d5USD[2]+$d5USD[3])+
								abs($d6USD[1]+$d6USD[0]+$d6USD[2]+$d6USD[3])+abs($d7USD[1]+$d7USD[0]+$d7USD[2]+$d7USD[3])+abs($d8USD[1]+$d8USD[0]+$d8USD[2]+$d8USD[3])+abs($d9USD[1]+$d9USD[0]+$d9USD[2]+$d9USD[3])+abs($d10USD[1]+$d10USD[0]+$d10USD[2]+$d10USD[3])+
								abs($d11USD[1]+$d11USD[0]+$d11USD[2]+$d11USD[3])+abs($d12USD[1]+$d12USD[0]+$d12USD[2]+$d12USD[3])+abs($d13USD[1]+$d13USD[0]+$d13USD[2]+$d13USD[3])+abs($d14USD[1]+$d14USD[0]+$d14USD[2]+$d14USD[3])+abs($d15USD[1]+$d15USD[0]+$d15USD[2]+$d15USD[3])+
								abs($d16USD[1]+$d16USD[0]+$d16USD[2]+$d16USD[3])+abs($d17USD[1]+$d17USD[0]+$d17USD[2]+$d17USD[3])+abs($d18USD[1]+$d18USD[0]+$d18USD[2]+$d18USD[3])+abs($d19USD[1]+$d19USD[0]+$d19USD[2]+$d19USD[3])+abs($d20USD[1]+$d20USD[0]+$d20USD[2]+$d20USD[3])+
								abs($d21USD[1]+$d21USD[0]+$d21USD[2]+$d21USD[3])+abs($d22USD[1]+$d22USD[0]+$d22USD[2]+$d22USD[3])+abs($d23USD[1]+$d23USD[0]+$d23USD[2]+$d23USD[3])+abs($d24USD[1]+$d24USD[0]+$d24USD[2]+$d24USD[3])+abs($d25USD[1]+$d25USD[0]+$d25USD[2]+$d25USD[3])+
								abs($d26USD[1]+$d26USD[0]+$d26USD[2]+$d26USD[3])+abs($d27USD[1]+$d27USD[0]+$d27USD[2]+$d27USD[3])+abs($d28USD[1]+$d28USD[0]+$d28USD[2]+$d28USD[3])+abs($d29USD[1]+$d29USD[0]+$d29USD[2]+$d29USD[3])+abs($d30USD[1]+$d30USD[0]+$d30USD[2]+$d30USD[3])+
								abs($d31USD[1]+$d31USD[0]+$d30USD[2]+$d30USD[3]);
								
								
			$TOTALCIF=			abs($d1CIF[1]+$d1CIF[0]+$d1CIF[2]+$d1CIF[3])+abs($d2CIF[1]+$d2CIF[0]+$d2CIF[2]+$d2CIF[3])+abs($d3CIF[1]+$d3CIF[0]+$d3CIF[2]+$d3CIF[3])+abs($d4CIF[1]+$d4CIF[0]+$d4CIF[2]+$d4CIF[3])+abs($d5CIF[1]+$d5CIF[0]+$d5CIF[2]+$d5CIF[3])+
								abs($d6CIF[1]+$d6CIF[0]+$d6CIF[2]+$d6CIF[3])+abs($d7CIF[1]+$d7CIF[0]+$d7CIF[2]+$d7CIF[3])+abs($d8CIF[1]+$d8CIF[0]+$d8CIF[2]+$d8CIF[3])+abs($d9CIF[1]+$d9CIF[0]+$d9CIF[2]+$d9CIF[3])+abs($d10CIF[1]+$d10CIF[0]+$d10CIF[2]+$d10CIF[3])+
								abs($d11CIF[1]+$d11CIF[0]+$d11CIF[2]+$d11CIF[3])+abs($d12CIF[1]+$d12CIF[0]+$d12CIF[2]+$d12CIF[3])+abs($d13CIF[1]+$d13CIF[0]+$d13CIF[2]+$d13CIF[3])+abs($d14CIF[1]+$d14CIF[0]+$d14CIF[2]+$d14CIF[3])+abs($d15CIF[1]+$d15CIF[0]+$d15CIF[2]+$d15CIF[3])+
								abs($d16CIF[1]+$d16CIF[0]+$d16CIF[2]+$d16CIF[3])+abs($d17CIF[1]+$d17CIF[0]+$d17CIF[2]+$d17CIF[3])+abs($d18CIF[1]+$d18CIF[0]+$d18CIF[2]+$d18CIF[3])+abs($d19CIF[1]+$d19CIF[0]+$d19CIF[2]+$d19CIF[3])+abs($d20CIF[1]+$d20CIF[0]+$d20CIF[2]+$d20CIF[3])+
								abs($d21CIF[1]+$d21CIF[0]+$d21CIF[2]+$d21CIF[3])+abs($d22CIF[1]+$d22CIF[0]+$d22CIF[2]+$d22CIF[3])+abs($d23CIF[1]+$d23CIF[0]+$d23CIF[2]+$d23CIF[3])+abs($d24CIF[1]+$d24CIF[0]+$d24CIF[2]+$d24CIF[3])+abs($d25CIF[1]+$d25CIF[0]+$d25CIF[2]+$d25CIF[3])+
								abs($d26CIF[1]+$d26CIF[0]+$d26CIF[2]+$d26CIF[3])+abs($d27CIF[1]+$d27CIF[0]+$d27CIF[2]+$d27CIF[3])+abs($d28CIF[1]+$d28CIF[0]+$d28CIF[2]+$d28CIF[3])+abs($d29CIF[1]+$d29CIF[0]+$d29CIF[2]+$d29CIF[3])+abs($d30CIF[1]+$d30CIF[0]+$d30CIF[2]+$d30CIF[3])+
								abs($d31CIF[1]+$d31CIF[0]+$d30CIF[2]+$d30CIF[3]);
				
				
				
				
				?>	
			
				</tbody>
				
				 <tfoot>
                	<tr >
                    	<td style="font-size:14px;"  colspan="11">Cantidad: <strong> <?php echo $totalCantidad; ?></strong> Productos. --- TOTAL de: <strong>$<?php echo number_format($TOTAL, 0, '', '.'); ?></strong> --- USD: <strong><?php echo number_format($TOTALUSD, 2, ',', '.'); ?></strong> --- CIF: <strong><?php echo number_format($TOTALCIF, 2, ',', '.'); ?></strong></td>
                    </tr>
                </tfoot>
		</table>		
			
  </div> <!-- fin de grafico de marcas -->
  <div id="tab2">

      <table>
			<tfoot>
                	<tr >
                    	<td style="font-size:13px; margin-left:15px; float:right; color:#2C2C2C;"  colspan="11">Cantidad: <strong> <?php echo number_format($totalCantidad, 0, '', '.'); ?></strong> Productos. --- TOTAL de: <strong>$<?php echo number_format($TOTAL, 0, '', '.'); ?></strong> --- USD: <strong><?php echo number_format($TOTALUSD, 2, ',', '.'); ?></strong> --- CIF: <strong><?php echo number_format($TOTALCIF, 2, ',', '.'); ?></strong></td>
                    </tr>
                </tfoot>
		</table>
		<div id="ventaDiaMes" style="width:100%; height: 400px;"></div>
  </div> <!-- fin de grafico de marcas -->
  
<script type="text/javascript"> 
  $("#usual1 ul").idTabs(); 
</script>
 <?php odbc_close( $conn );?>