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
				
	$("#b1").click(function(){ // Evento Click boton 'CREDITO'
			$.post('modulos/cmando/popup/detalleSerie.php', {}, function(data) { //función POST para enviar montoPorPagar a efectivo.php
			//var win=window.open('about:blank','',"width=200, height=500");
				var win=window.open('Detalle',"","width=560, height=600");
				with(win.document){
					open();
					write(data);
					close();
				}
			});
	});
	$("#b2").click(function(){ // Evento Click boton 'CREDITO'
			$.post('modulos/cmando/popup/detalleDetalleCabecera.php', {}, function(data) { //función POST para enviar montoPorPagar a efectivo.php
			//var win=window.open('about:blank','',"width=200, height=500");
				var win=window.open('Detalle',"","width=560, height=600");
				with(win.document){
					open();
					write(data);
					close();
				}
			});
	});
	$("#b3").click(function(){ // Evento Click boton 'CREDITO'
			$.post('modulos/cmando/popup/detallePagosCabecera.php', {}, function(data) { //función POST para enviar montoPorPagar a efectivo.php
			//var win=window.open('about:blank','',"width=200, height=500");
				var win=window.open('Detalle',"","width=560, height=600");
				with(win.document){
					open();
					write(data);
					close();
				}
			});
	});
});//fin funciotn principal
</script>
<script type="text/javascript">
var resVal = 0;
var resVal2 = 0;
var resVal3 = 0;
var resValAir = 0;
var resVal2Air = 0;
var resVal3Air = 0;

/*FUNCIONES INDICADORES BOLETAS*/
function seriesErroneas(){
	var d = new Date();
	var m = d.getMonth() +1; 
	$.post('modulos/cmando/posObtenerSeriesIncorrectas.php',{mes:m},function(resPHP){
		var res = $.parseJSON(resPHP);
		resVal = res['cant'];
	});
	
	return resVal;
}
function montoDetalleCabecera(){
	var d = new Date();
	var m = d.getMonth() +1; 
	$.post('modulos/cmando/obtenerMontoDetalleCabecera.php',{mes:m},function(resPHP){
		var res = $.parseJSON(resPHP);
		resVal2 = res['cant'];
	});
	return resVal2;
}
function montoPagosCabecera(){
	var d = new Date();
	var m = d.getMonth() +1; 
	$.post('modulos/cmando/obtenerMontoPagosCabecera.php',{mes:m},function(resPHP){
		var res = $.parseJSON(resPHP);
		resVal3 = res['cant'];
	});
	return resVal3;
}



var g1, g2, g3, g1A, g2A, g3A;
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
        var g1 = new JustGage({
          id: "g1", 
          value: seriesErroneas(), /*PHP RESPONSE*/ 
          min: 0,
          max: 50,
          title: "Serie Erronea",
          label: "Boletas"
        });
		var g2 = new JustGage({
          id: "g2", 
          value: montoDetalleCabecera(), /*PHP RESPONSE*/ 
          min: 0,
          max: 50,
          title: "Monto Distinto Cabecera VS Detalle",
          label: "Boletas"
        });
		
		var g3 = new JustGage({
          id: "g3", 
          value: montoPagosCabecera(), /*PHP RESPONSE*/ 
          min: 0,
          max: 50,
          title: "Monto Distinto Cabecera VS Pago",
          label: "Boletas"
        });
		setInterval(function() {
			g1.refresh(seriesErroneas()); /*PHP RESPONSE*/
			g2.refresh(montoDetalleCabecera()); /*PHP RESPONSE*/
			g3.refresh(montoPagosCabecera()); /*PHP RESPONSE*/
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
		
		$.post('modulos/cmando/tipoCambio.php', {mes:m}, function(resPHP){
			var res = $.parseJSON(resPHP);
			for(var i=0;i<res.length;i++){
				valor[i] = res[i]['valor'].substring(0,6);	
			}			
		
		var data = {
			labels: arr,
			datasets:[
				{
					label: "Mes",
					fillColor: "rgba(91,144,191,0.5)",
					strokeColor: "rgba(220,220,220,0.8)",
					highlightFill: "rgba(220,220,220,0.75)",
					highlightStroke: "rgba(220,220,220,1)",
					data: valor
				}
			]
	}
		var ultCambio = res[res.length-1]['valor'];
		$("#cambio").text(ultCambio.substring(0,6));
		var ctx = $("#myChart").get(0).getContext("2d");
		var myBarChart = new Chart(ctx).Line(data, {
						barShowStroke: true
		});
	});
			
		$.post('modulos/cmando/tipoCambioAir.php', {mes:m}, function(resPHPAir){
			var resAir = $.parseJSON(resPHPAir);
			for(var i=0;i<resAir.length;i++){
				valorAir[i] = resAir[i]['valor'].substring(0,6);
			}
			
			var data = {
			labels: arr,
			datasets:[
						{
							label: "Mes",
							fillColor: "rgba(91,144,191,0.5)",
							strokeColor: "rgba(220,220,220,0.8)",
							highlightFill: "rgba(220,220,220,0.75)",
							highlightStroke: "rgba(220,220,220,1)",
							legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
							data: valorAir
						}
					]	
			}
			var ultCambioAir = resAir[resAir.length-1]['valor'];
			$("#cambioAir").text(ultCambioAir.substring(0,6));
			var ctx = $("#myChartAir").get(0).getContext("2d");
				var myBarChart = new Chart(ctx).Line(data, {
								barShowStroke: true
			});
		});
		
		
	
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
  <div style="padding-left:15px; font-size:20px; color:#BB9999;"><center>INDICADORES DE CENTRALIZACIÓN</center></div>
  <div id="caja2" style="padding-top:20px;">
	
		<div  style="float:left; width:33.3%; height: 250px;">
			<div id="g1" class="indicador"></div>
			<center><button id="b1">Ver Detalle</button></center>
		</div>
		<div style="float:left;width:30%; height: 250px;">
			<div id="g2"></div>
			<center><button id="b2">Ver Detalle</button></center>

		</div>
		<div  style="float:left;width:30%; height: 250px;">
			<div id="g3"></div>
			<center><button id="b3">Ver Detalle</button></center>
			
		</div>
		
  </div> <!-- fin de grafico de marcas -->
   
   
		
  </div> <!-- fin de grafico de marcas -->
  
 <?php odbc_close( $conn );?>