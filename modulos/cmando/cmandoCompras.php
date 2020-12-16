<head>
	<script src="js/raphael.2.1.0.min.js"></script>
    <script src="js/justgage.1.0.1.min.js"></script>
</head>
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
	echo'  	<link href="css/cmando.css" rel="stylesheet" type="text/css" />
			';
			//incluyo la librería para generar graficos	
	
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
<script type="text/javascript">

var resVal4 = 0;
var resVal5 = 0;




function indicadorPreventas(){
	//var d = new Date();
	//var m = d.getMonth() +1; 
	$.post('modulos/cmando/indicadorPreventas.php',function(resPHP){
		var res = $.parseJSON(resPHP);
		resVal4 = res['porcent'];
		
	});
	return resVal4;
}

function indicadorPreventasCant(){
	//var d = new Date();
	//var m = d.getMonth() +1; 
	$.post('modulos/cmando/indicadorPreventas.php',function(resPHP){
		var res = $.parseJSON(resPHP);
		resVal5 = res['cant'];
		
	});
	return resVal5;
}



var g1, g2, g3, g1A, g2A, g3A, g4,g5;
	window.onload = function(){
	/*$.post('modulos/cmando/obtenerCajaExiSinCentralizar.php',{},function(res){
				$("#cajaExiSinCentralizar").html(res);
			});
			$.post('modulos/cmando/obtenerCajaExiSinPago.php',{},function(res){
				$("#cajaExiSinPago").html(res);
			});
			$.post('modulos/cmando/obtenerCajaExiConPago.php',{},function(res){
				$("#cajaExiConPago").html(res);
			});
			$.post('modulos/cmando/obtenerCajaExiSinCentralizarAir.php',{},function(res){
				$("#cajaExiSinCentralizarAir").html(res);
			});
			$.post('modulos/cmando/obtenerCajaExiSinPagoAir.php',{},function(res){
				$("#cajaExiSinPagoAir").html(res);
			});
			$.post('modulos/cmando/obtenerCajaExiConPagoAir.php',{},function(res){
				$("#cajaExiConPagoAir").html(res);
			});*/
   
		 var g4 = new JustGage({
          id: "g4", 
          value: indicadorPreventas(), /*PHP RESPONSE*/ 
          min: 0,
          max: 100,
          title: "Porcentaje de Preventas",
          label: "%"
        });
		
		 var g5 = new JustGage({
          id: "g5", 
          value: indicadorPreventasCant(), /*PHP RESPONSE*/ 
          min: 0,
          max: 100000,
          title: "Cantidad de Preventas",
          label: "Und."
        });
		
	
		setInterval(function() {
	
			g4.refresh(indicadorPreventas()); /*PHP RESPONSE*/
			g5.refresh(indicadorPreventasCant()); /*PHP RESPONSE*/
	
        }, 4000);
      };
</script>
<script type="text/javascript">
	$(function(){
		var d = new Date();
		var n = d.getDate();
		var m = d.getMonth()+1;
		
		var arr = new Array();
		var valor = new Array();
		//var valorSub = new Array();
		var valorAir = new Array();
		for(var i=0; i<n; i++){
			arr[i] = "Día " + (i+1);
		}
		
		
		
		
	
});
		
</script>
<script>
	
	
</script>
<div class="idTabs">
      
      <div class="items">
        <div id="one"> 
      
         </div> <!-- fin div two-->
      </div> <!-- fin items -->
    </div> <!-- fin idTabs -->
      
      

  <!--<ul> 
	<li ><a id="tabdua" href="#tab1"class="selected" > Modulo 1132 </a></li> 
    <li ><a id="tabdua" href="#tab2"  >Gráfico Venta Diaria en el Mes</a></li> 
	<li ><a id="tabdua" href="http://localhost//sisap/modulos/impresiones/inf_ventasMensual.php" >Imprimir Resumen</a></li> 
    
  </ul> -->
  <div style="padding-left:15px; font-size:20px; color:#BB9999;">INDICADORES DE COMPRAS</div>
  <div id="caja2" style="padding-top:20px;">
	
	
		
		
		<div  style="float:left; width:33.3%; height: 250px;">
			<div id="g4"> </div>
			<!--<div>
				<center>
					<label style="margin-top:px;">Valor CLP efectivo<br><label id="cajaExiSinCentralizar"></label></label>
				</center>
			</div>-->
		</div>
		<div  style="float:left; width:33.3%; height: 250px;">
			<div id="g5"> </div>
			<!--<div>
				<center>
					<label style="margin-top:px;">Valor CLP efectivo<br><label id="cajaExiSinCentralizar"></label></label>
				</center>
			</div>-->
		</div>
		
		
  </div> <!-- fin de grafico de marcas -->
  

  
 <?php odbc_close( $conn );?>