<?php 
require_once("clases/conexionocdb.php");//incluimos archivo de conexión

ini_set('max_execution_time', 300); //300 seconds = 5 minutes

$vendedor = $_GET['id'];
$vendedor = str_pad($vendedor, 3, '0', 'STR_PAD_LEFT');
$modulo = $_GET['modulo'];
$marca = $_GET['marca'];
$fecha = $_GET['fecha'];
$finicio = $_GET['fini'];
$ffin = $_GET['ffin'];
if (!$fecha)
{
	 $fecha = date("m-Y");
}
$mes = substr($fecha,0, 2);
$anio = substr($fecha,3, 4);

 function cambiarFecha($fecha) {
					  return implode("-", array_reverse(explode("-", $fecha)));
					}
					$finicio2 = cambiarFecha($finicio);
					$ffin2 = cambiarFecha($ffin);

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


if ($modulo)// si selecciono modulo, se genera la consulta
{
	$conModulo = "  (Bodega LIKE '".$modulo."') ";
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
  WHERE (FECHA >= '".$finicio2." 00:00:00.000')  AND (FECHA <= '".$ffin2." 23:59:59.000')
  GROUP BY CONVERT(char(13), FECHA, 120)
  ORDER BY HORA ";




//echo $sql;			
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
$(function() {
    var startDate;
    var endDate;
    
    var selectCurrentWeek = function() {
        window.setTimeout(function () {
            $('.week-picker').find('.ui-datepicker-current-day a').addClass('ui-state-active')
        }, 1);
    }
    
    $('.week-picker').datepicker( {
        showOtherMonths: true,
        selectOtherMonths: true,
        onSelect: function(dateText, inst) { 
            var date = $(this).datepicker('getDate');
            startDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay());
            endDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay() + 14);
            var dateFormat = inst.settings.dateFormat || $.datepicker._defaults.dateFormat;
            $('#startDate').val($.datepicker.formatDate( dateFormat, startDate, inst.settings ));
            $('#endDate').val($.datepicker.formatDate( dateFormat, endDate, inst.settings ));
            
            selectCurrentWeek();
        },
        beforeShowDay: function(date) {
            var cssClass = '';
            if(date >= startDate && date <= endDate)
                cssClass = 'ui-datepicker-current-day';
            return [true, cssClass];
        },
        onChangeMonthYear: function(year, month, inst) {
            selectCurrentWeek();
        }
    });
    
    $('.week-picker .ui-datepicker-calendar tr').live('mousemove', function() { $(this).find('td a').addClass('ui-state-hover'); });
    $('.week-picker .ui-datepicker-calendar tr').live('mouseleave', function() { $(this).find('td a').removeClass('ui-state-hover'); });
});
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
					<input name="opc" type="hidden" id="opc" size="40" class="required" value="ventaSemanaHora" />
					<label for="fecha1">
					            Mes
                            <input name="fecha" type="text" id="fecha" size="40" class="week-picker" value="<?php echo $fecha;?>"  />
                    </label>
					<input name="fini" type="hidden" id="startDate"  value=""   />		
					<input name="ffin" type="hidden" id="endDate" value=""  />		
					
   <!-- <label>Week :</label> <span id="startDate"></span> - <span id="endDate"></span>-->
					
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