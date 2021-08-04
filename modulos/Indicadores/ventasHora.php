<?php 
require_once("clases/conexionocdb.php");//incluimos archivo de conexión

ini_set('max_execution_time', 300); //300 seconds = 5 minutes

$vendedor = $_GET['id'];
$vendedor = str_pad($vendedor, 3, '0', 'STR_PAD_LEFT');
$modulo = $_GET['modulo'];
$marca = $_GET['marca'];
$fecha = $_GET['fecha'];
$nombreDia = $_GET['nombreDia'];

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

if ($nombreDia)// si selecciono modulo, se genera la consulta
{
	$conNombreDia = "  AND DATENAME(WEEKDAY,FECHA) = '".$nombreDia."' ";
	
}

if ($modulo)// si selecciono modulo, se genera la consulta
{
	$conModulo = "  AND (Bodega LIKE '".$modulo."') ";
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
$sql = "SELECT SUM([total])AS TOTAL
      ,SUM([USD])AS  USD
      ,SUM([Cantidad]) AS CANT
      ,CONVERT(char(13), FECHA, 120) AS HORA
      ,SUM([CIFTOTAL]) AS CIF
  FROM [RP_VICENCIO].[dbo].[SI_VENTAShoraPIC]
  WHERE MONTH(FECHA) = ".$mes."  ".$conModulo." ".$conNombreDia." 
  GROUP BY CONVERT(char(13), FECHA, 120)
  ORDER BY HORA ";




echo $sql;			
	echo'  <script src="graficos/amcharts/amcharts.js" type="text/javascript"></script> ';//incluyo la librería para generar graficos	
	include("graficos/ventaHora.php");// grafico que mustra las ventas por marcas en peso 
?>
<script type="text/javascript">
  $(document).ready(function(){
				//comienza focus en modulo
				$('#moduloid').focus();
				// calendarios en text de fecha inicio fin
				
				
				
			});//fin funciotn principal
</script>

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
					<input name="opc" type="hidden" id="opc" size="40" class="required" value="ventasHora" />
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
								
								echo '<label class="first" for="title1">
									Día de la Semana
									<select id="nombreDia" name="nombreDia"    class="styled" >
									<option ></option>
									<option value="Monday">Lunes</option>
									<option value="Tuesday">Martes</option>
									<option value="Wednesday">Miercoles</option>
									<option value="Thursday">Jueves</option>
									<option value="Friday">Vierness</option>
									<option value="Saturday">Sabados</option>
									<option value="Sunday">Domingos</option>
									
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
    <li ><a id="tabdua" href="#tab1" class="selected">Gráfico Ventas Mensual Por Hora</a></li> 
    <!--<li ><a id="tabdua" href="#tab3">Detalle</a></li> -->
  </ul> 
  <div id="tab1"><?php 
		//echo' <div id="ventaDiaSemana" style="width:100%; height:200px;"></div>';
		 echo'<div id="ventaHora" style="width:100%; height: 500px;"></div>';
	?>
  </div> <!-- fin de grafico de marcas -->
  
<script type="text/javascript"> 
  $("#usual1 ul").idTabs(); 
</script>
 <?php odbc_close( $conn );?>