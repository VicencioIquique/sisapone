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


//echo $sql;			
	echo'  <script src="graficos/amcharts3/amcharts.js" type="text/javascript"></script>
            <script src="graficos/amcharts3/gauge.js" type="text/javascript"></script> ';//incluyo la librería para generar graficos	
	include("graficos/dsmNoAtendidos.php");// DSM No Validados
	include("graficos/ga_cantidadPorVenta.php");// DSM No Validados
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
      
      <div class="items">
        <div id="one"> 
      
         </div> <!-- fin div two-->
      </div> <!-- fin items -->
    </div> <!-- fin idTabs -->
      
      
<div id="usual1" class="usual" > 
  <ul> 
	<li ><a id="tabdua" href="#tab1"class="selected" > Modulo 1132 </a></li> 
    <li ><a id="tabdua" href="#tab2"  >Gráfico Venta Diaria en el Mes</a></li> 
	<li ><a id="tabdua" href="http://localhost//sisap/modulos/impresiones/inf_ventasMensual.php" >Imprimir Resumen</a></li> 
    
  </ul> 
  <div id="caja2" style="padding-top:30px;">
	
		<div  id="dsmNoAtendidos" style="float:left; width:40%; height: 250px;"></div>
		<div  id="cantidadPorVenta" style="float:left;width:40%; height: 250px;"></div>
  </div> <!-- fin de grafico de marcas -->
  <div id="tab2">

   
		
  </div> <!-- fin de grafico de marcas -->
  
<script type="text/javascript"> 
  $("#usual1 ul").idTabs(); 
</script>
 <?php odbc_close( $conn );?>