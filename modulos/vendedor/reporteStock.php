<script type="text/javascript" src="modulos/vendedor/js/jquery.base64.js"></script>
<script type="text/javascript" src="modulos/vendedor/js/jquery.btechco.excelexport.js"></script>
<style>
	#ssptable2{
		background-color:red;
	}
</style>
<?php
require_once("clases/conexionocdb.php");
ini_set('max_execution_time', 600); //300 seconds = 5 minutes
$vendedor = $_GET['id'];
$vendedorSelect = $_GET['id'];

$vendedor = str_pad($vendedor, 3, '0', 'STR_PAD_LEFT');
$finicio = $_GET['inicio'];
$ffin = $_GET['fin'];
$codbarra = $_GET['codbarra'];
$consultar = $_GET['agregar'];
$marca = '';

$cont = $_GET['cont'];
$tipoProducto = $_GET['tipoProducto'];
$areaNegocio = $_GET['areaNegocio'];
$tipoReporte = $_GET['tipoReporte'];

if(!$finicio)
{
	 $finicio = date("m/01/Y");
	 $ffin= date("m/d/Y");
}
if($tipoReporte == 'ReporteUno'){
	$segmento = "'Selectivo'";
	$status = "'Vigente','Nueva Marca','Potenciar'";
}else if($tipoReporte == 'ReporteDos'){
	$segmento = "'Semiselectivo'";
	$status = "'Vigente','Nueva Marca','Potenciar'";
}else if($tipoReporte == 'ReporteTres'){
	$segmento = "'Masivo'";
	$status = "'Vigente','Nueva Marca','Potenciar'";
}else if($tipoReporte == 'ReporteCuatro'){
	$segmento = "'Semiselectivo','Descontinuado','Selectivo','No Aplica','Masivo'";
	$status = "'Liquidacion','Descontinuado','Museo'";
}else if($tipoReporte == 'ReporteCinco'){
		$marca = "'CARTOON NETWORK','CLAYEUX','KOKESHI','KALOO','DISNEY PARFUM INFANTIL'";
}
if(!$finicio){
	 $finicio = date("Y-m");

}
function cambiarFecha($fecha) {
					  return implode("-", array_reverse(explode("-", $fecha)));
					}
					$finicio2 = cambiarFecha($finicio);
					$ffin2 = cambiarFecha($ffin);


			if ($tipoProducto)
					{
						$WtipoProducto = "  AND (TipoProducto LIKE '".$tipoProducto."') ";

					}

?>
<script type="text/javascript">
  $(document).ready(function(){
				//comienza focus en modulo
				$('#moduloid').focus();
				// calendarios en text de fecha inicio fin
				$( "#inicio" ).datepicker({
					dateFormat: 'yy-mm',
					changeMonth: true,
					changeYear: true,

					showButtonPanel: true,

					onClose: function(dateText, inst) {
						var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
						var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
						$(this).val($.datepicker.formatDate('yy-mm', new Date(year, month, 1)));
					}
				} );
				$("#inicio").focus(function () {
					$(".ui-datepicker-calendar").hide();
					$("#ui-datepicker-div").position({
						my: "center top",
						at: "center bottom",
						of: $(this)
					});
				});
				//formatos de las fechas

				$( "#fin" ).datepicker(  );
				//$('#fin').datepicker('option', {dateFormat: 'dd-mm-yy'});


            });
</script>
<script language="javascript">
$(document).ready(function() {
     $("#descargarExcel").click(function(){
		$("#ssptable2").btechco_excelexport({
			containerid: "ssptable2"
		   , datatype: $datatype.Table
		});
	});


	$("#dialogDescarga").dialog({
					autoOpen: false,
					title: 'a',
					resizable: false,
					width: 200,
					height: 205
				}).dialog("widget").find(".ui-dialog-title").hide();
				//$("#dialogDescarga").dialog("widget").find(".ui-dialog-titlebar-close").hide();


				$("#dialogDescarga:eq(0)")
				.dialog("widget")
				.find(".ui-dialog-titlebar").css({
					"float": "right",
					border: 0,
					padding: 0
				})
				.find(".ui-dialog-title").css({
					display: "none"
				}).end()
				.find(".ui-dialog-titlebar-close").css({
					top: 0,
					right: 0,
					margin: 0,
					"z-index": 999
				});
	//$("#dialogDescarga .ui-dialog-titlebar "){ display:none; }

});
</script>
<script type="text/javascript">
	//<![CDATA[

		$(window).load(function() { // makes sure the whole site is loaded
			$('#status').fadeOut(); // will first fade out the loading animation
			$('#preloader').delay(350).fadeOut('slow'); // will fade out the white DIV that covers the website.
			$("#dialogDescarga").dialog("close");

			var control = <?php if($cont==1){echo 1;}else{echo 0;}?>;

			if(control == 1){
				$("#dialogDescarga").dialog("open");
			}else if(control == 0){
				$('body').delay(350).css({'overflow':'visible'});
			}
		});


	//]]>
</script>
<div id="preloader">
	<div id="status">&nbsp;<?php if($cont == 1){echo 'Un momento por favor, estamos generando su reporte.';}?></div>
</div>



<!-- Formulario de descarga -->
<div id="dialogDescarga" title="Revisión y Asignación de Requerimientos">
	<form action="" method="post" id="">
		<img src="images/export_excel.png" id="descargarExcel" style="display: block; margin-left: auto; margin-right: auto;"/>
		<p style="text-align:center;">Click en la imagen <br>para descargar</p>
		<!--<input type="button" id="descargarExcel" class="submit" value="Descargar" style="width:100%; height:150px; background-image: url(images/export_excel.png); background-repeat: none;"/>-->
	</form>
</div>
<div class="idTabs">
      <ul>
        <li><a href="#one"><img src="images/agregar.png" width="30px" height="30px" /></a></li>
		<?php // pregunta si ha ingresado una fecha para que se muestre el imagen link de generar Excel

		if($finicio2){

		echo'<form action="/sisapone/clases/ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion">
			<center><img src="images/excel.png" width="30px" height="30px" class="botonExcel"  /> </center>
			<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
			</form> ';


		?>
		     <!-- <li><a href="../SISAP/modulos/vendedor/ventasproexcel.php?id=<?php //echo $vendedor; ?>&modulo=<?php // echo $modulo; ?>&inicio=<?php //echo $finicio2; ?>&fin=<?php // echo $ffin2; ?>&marca=<?php //echo $marca; ?>&codbarra=<?php //echo $codbarra; ?>"><img src="images/excel.png" width="30px" height="30px" /></a></li>-->
		<?php }?>
	 </ul>
      <div class="items">
        <div id="one"> <form action="" method="GET" id="horizontalForm">

            <fieldset>
				<legend>Ingresar Fechas</legend>



							  <input name="opc" type="hidden" id="opc" size="40" class="required" value="reporteStock" />

                             <label for="fecha1">
					            Periodo
                            <input name="inicio" type="text" id="inicio" size="40" class="required" />
                            </label>

							   <label class="first" for="title1">
									Tipo de Producto
									<select id="tipoProducto" name="tipoProducto"    class="styled" >
									<option value="Producto Regular" selected>Producto Regular</option>
									<option value="Sin valor Comercial">Sin valor comercial</option>
									</select>
				               </label>


							    <label class="first" for="title1">
									Area de Negocio
									<select id="areaNegocio" name="areaNegocio"  class="styled" width="30">
										<option value=""></option>
										<option value="Accesorios">Accesorios</option>
										<option value="Articulos">Artículos</option>
										<option value="Confiteria">Confiteria</option>
										<option value="Cosmeticos">Cosmeticos</option>
										<option value="Perfumes">Perfumeria</option>
										<option value="Ropa">Ropa</option>
									</select>
				               </label>

							   <label class="first" for="title1">
									Tipo de reporte
									<select id="tipoReporte" name="tipoReporte"  class="styled" width="30">
										<option value=""></option>
										<option value="ReporteUno">Segmento: Selectivo - Status: Vigente, Nueva Marca, Potenciar</option>
										<option value="ReporteDos">Segmento: Semiselectivo - Status: Vigente, Nueva Marca, Potenciar</option>
										<option value="ReporteTres">Segmento: Masivo - Status: Vigente, Nueva Marca, Potenciar</option>
                                        <option value="ReporteCuatro">Segmento: Semiselectivo, Descontinuado, Selectivo, No Aplica, Masivo - Status : Liquidacion, Descontinuado, Museo</option>
										<option value="ReporteCinco">Infantil</option>
									</select>
				               </label>
								 <input name="cont" type="hidden" id="cont" size="40" class="required" value="1" />
                             <input style="clear:initial;" name="agregar" type="submit" id="agregar" class="submit" value="Consultar" />

			</fieldset>
            </form>
         </div> <!-- fin div two-->
      </div> <!-- fin items -->
    </div> <!-- fin idTabs -->


			 <div id="dv">
            <table  id="ssptable2" class="lista" style="display:none;">
			<thead>

			  </head>
              <thead>
              	<tr>
                	<th colspan="42" align="center" style="font-size:17px">INFORME DE STOCK Y VENTAS POR BODEGAS</th>
                </tr>
              </thead>
              <thead>
              	<tr>
                	<th colspan="42" align="center" style="font-size:17px"><?php if($tipoReporte == "ReporteCinco"){ echo "MARCAS :" . strtoupper($marca); }else if($status != "") { echo "STATUS: " . strtoupper($status); } ?></th>
                </tr>
              </thead>
              <thead>
              	<tr>
                	<th colspan="42" align="center" style="font-size:17px"><?php if($segmento != "") { echo "SEGMENTO: " . strtoupper($segmento); } ?></th>
                </tr>
              </thead>
			 <thead>
					<tr>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th style="background-color:#DCE6F1; border-left: 2px solid black; border-top: 2px solid black;">Stock Cierre</th>
						<th style="background-color:#DCE6F1; border-top: 2px solid black; border-right: 2px solid black;">Periodo: <?php echo $finicio; ?></th>

					</tr>
			  </head>
              <thead>

                    <tr>
                    <th ></th>
					<th ></th>
					<th ></th>
					<th ></th>
					<th style="background-color:#DCE6F1; border-left: 2px solid black; border-top: 2px solid black;"></th>
					<th style="background-color:#DCE6F1; border-top: 2px solid black;"></th>
					<th style="background-color:#DCE6F1; border-top: 2px solid black;"></th>
					<th style="background-color:#DCE6F1; border-top: 2px solid black;"></th>
					<th style="background-color:#DCE6F1; border-top: 2px solid black;"></th>
					<th style="background-color:#DCE6F1; border-top: 2px solid black;"></th>
					<th style="background-color:#DCE6F1; border-top: 2px solid black;"></th>
					<th style="font-size:10px; height:15px;background-color:#DCE6F1; border-top: 2px solid black;">Galpón</th>
					<th style="background-color:#DCE6F1; border-top: 2px solid black;"></th>
					<th style="background-color:#DCE6F1; border-top: 2px solid black; "></th>
					<th style="background-color:#DCE6F1; border-top: 2px solid black;"></th>
					<th style="background-color:#DCE6F1; border-top: 2px solid black;"></th>
					<th style="background-color:#DCE6F1; border-top: 2px solid black;"></th>
					<th style="background-color:#DCE6F1; border-top: 2px solid black;"></th>
					<th style="background-color:#DCE6F1; border-top: 2px solid black; border-right:2px solid black;"></th>
					<!-- MODULOS -->
					<th style="background-color:#DCE6F1; border-top: 2px solid black;"></th>
					<th style="background-color:#DCE6F1; border-top: 2px solid black;"></th>
					<th style="background-color:#DCE6F1; border-top: 2px solid black;"></th>
					<th style="background-color:#DCE6F1; border-top: 2px solid black;"></th>
					<th style="background-color:#DCE6F1; border-top: 2px solid black;"></th>
					<th style="background-color:#DCE6F1; border-top: 2px solid black;"></th>
					<th style="background-color:#DCE6F1; border-top: 2px solid black;"></th>
					<th style="background-color:#DCE6F1; border-top: 2px solid black;"></th>
					<th style="font-size:10px; height:15px; background-color:#DCE6F1; border-top: 2px solid black;">Mall Zofri	</th>
					<th style="background-color:#DCE6F1; border-top: 2px solid black;"></th>
					<th style="background-color:#DCE6F1; border-top: 2px solid black;"></th>
					<th style="background-color:#DCE6F1; border-top: 2px solid black;"></th>
					<th style="background-color:#DCE6F1; border-top: 2px solid black;"></th>
					<th style="background-color:#DCE6F1; border-top: 2px solid black;"></th>
					<th style="background-color:#DCE6F1; border-top: 2px solid black;"></th>
					<th style="background-color:#DCE6F1; border-top: 2px solid black;"></th>
					<th style="background-color:#DCE6F1; border-top: 2px solid black;"></th>
					<th style="background-color:#DCE6F1; border-right:2px solid black; border-top: 2px solid black;"></th>
					<th style="background-color:#DCE6F1; border-top: 2px solid black;"></th>
					<th style="background-color:#DCE6F1; border-top: 2px solid black;"></th>
					<th style="font-size:10px; height:15px; background-color:#DCE6F1; border-top: 2px solid black;">Aeropuerto</th>
					<th style="font-size:10px; height:15px; background-color:#DCE6F1; border-top: 2px solid black;">puerto</th>
					<th style="background-color:#DCE6F1; border-top: 2px solid black;"></th>
					<th style="background-color:#DCE6F1; border-top: 2px solid black;"></th>
					<th style="background-color:#DCE6F1; border-top: 2px solid black; border-left: 2px solid black;"></th>
					<th style="background-color:#DCE6F1; border-top: 2px solid black; border-right: 2px solid black;" ></th>

				</tr>
				</head>
				<thead>
					<tr style="">
                    	<th  ></th>
                    	<th  ></th>
					    <th  ></th>
						<th  ></th>
						<th	 style="font-size:10px; border-left: 2px solid black; background-color:#DCE6F1"></th>
						<th  style="font-size:10px; background-color:#DCE6F1">ZFI.13-1</th>
						<th  style="background-color:#DCE6F1;"></th>
						<th	 style="font-size:10px; background-color:#DCE6F1"></th>
						<th  style="font-size:10px; background-color:#DCE6F1">ZFI.13-2</th>
						<th  style="background-color:#DCE6F1;"></th>
						<th	 style="font-size:10px; background-color:#DCE6F1"></th>
						<th  style="font-size:10px; background-color:#DCE6F1">ZFI.13-6</th>
						<th  style="background-color:#DCE6F1;"></th>
						<th	 style="font-size:10px; background-color:#DCE6F1"></th>
						<th  style="font-size:10px; background-color:#DCE6F1">ZFI.1623</th>
						<th  style="background-color:#DCE6F1;"></th>
						<th	 style="font-size:10px; background-color:#DCE6F1"></th>
						<th  style="font-size:10px; background-color:#DCE6F1">ZFI.17SZ</th>
						<th  style="background-color:#DCE6F1;"></th>
						<!-- MODULOS -->
						<th	 style="font-size:10px; border-left: 2px solid black; background-color:#DCE6F1"></th>
						<th  style="font-size:10px; background-color:#DCE6F1;">ZFI.1010</th>
						<th  style="background-color:#DCE6F1;"></th>
						<th  style="background-color:#DCE6F1;"></th>
						<th  style="font-size:10px; background-color:#DCE6F1;">ZFI.1132</th>
						<th  style="background-color:#DCE6F1;"></th>
						<th  style="background-color:#DCE6F1;"></th>
						<th  style="font-size:10px; background-color:#DCE6F1;">ZFI.181</th>
						<th  style="background-color:#DCE6F1;"></th>
						<th  style="background-color:#DCE6F1;"></th>
						<th  style="font-size:10px; background-color:#DCE6F1;">ZFI.184</th>
						<th  style="background-color:#DCE6F1;"></th>
						<th  style="background-color:#DCE6F1;"></th>
						<th  style="font-size:10px; background-color:#DCE6F1;">ZFI.2002</th>
						<th  style="background-color:#DCE6F1;"></th>
						<th  style="background-color:#DCE6F1;"></th>
						<th  style="font-size:10px; background-color:#DCE6F1;">ZFI.2077</th>
						<th  style="background-color:#DCE6F1;"></th>
						<!-- AEROPUERTO -->
						<th	 style="font-size:10px; border-left: 2px solid black; background-color:#DCE6F1"></th>
						<th  style="font-size:10px; background-color:#DCE6F1;">LOCAL.2</th>
						<th  style="background-color:#DCE6F1;"></th>
						<th  style="background-color:#DCE6F1;"></th>
						<th  style="font-size:10px; background-color:#DCE6F1;">LOCAL.8</th>
						<th  style="background-color:#DCE6F1;"></th>

						<th  style="font-size:10px;  border-left: 2px solid black; background-color:#DCE6F1;">Total Un.</th>
						<th  style="font-size:10px;  border-right: 2px solid black; background-color:#DCE6F1;">Total CIF</th>

          </tr>
					<tr>
            			<th  style="font-size:10px; border-bottom: 1px solid #689DED; background-color:#DCE6F1;">Segmento</th>
            			<th  style="font-size:10px; border-bottom: 1px solid #689DED; background-color:#DCE6F1;">Status</th>
						<th  style="font-size:10px; border-bottom: 1px solid #689DED; background-color:#DCE6F1; width: 30px;"></th>
						<th  style="font-size:10px; border-bottom: 1px solid #689DED; background-color:#DCE6F1;">Marca</th>
						<th  style="font-size:10px;  border-left: 2px solid black; border-bottom: 1px solid black; background-color:#DCE6F1;">Un.</th>
						<th  style="font-size:10px;  border-bottom: 1px solid black; background-color:#DCE6F1;">CIF</th>
						<th  style="font-size:10px;  border-bottom: 1px solid black; background-color:#DCE6F1;">Ventas.</th>
						<th  style="font-size:10px;  border-bottom: 1px solid black; background-color:#DCE6F1;">Un.</th>
						<th  style="font-size:10px;  border-bottom: 1px solid black; background-color:#DCE6F1;">CIF</th>
						<th  style="font-size:10px;  border-bottom: 1px solid black; background-color:#DCE6F1;">Ventas.</th>
						<th  style="font-size:10px;  border-bottom: 1px solid black; background-color:#DCE6F1;">Un.</th>
						<th  style="font-size:10px;  border-bottom: 1px solid black; background-color:#DCE6F1;">CIF</th>
						<th  style="font-size:10px;  border-bottom: 1px solid black; background-color:#DCE6F1;">Ventas.</th>
						<th  style="font-size:10px;  border-bottom: 1px solid black; background-color:#DCE6F1;">Un.</th>
						<th  style="font-size:10px;  border-bottom: 1px solid black; background-color:#DCE6F1;">CIF</th>
						<th  style="font-size:10px;  border-bottom: 1px solid black; background-color:#DCE6F1;">Ventas.</th>
						<th  style="font-size:10px;  border-bottom: 1px solid black; background-color:#DCE6F1;">Un.</th>
						<th  style="font-size:10px;  border-bottom: 1px solid black; background-color:#DCE6F1;">CIF</th>
						<th  style="font-size:10px;  border-right: 2px solid black; border-bottom: 1px solid black; background-color:#DCE6F1;">Ventas.</th>
						<th  style="font-size:10px;  border-bottom: 1px solid black; background-color:#DCE6F1;">Un.</th>
						<th  style="font-size:10px;  border-bottom: 1px solid black; background-color:#DCE6F1;">CIF</th>
						<th  style="font-size:10px;  border-bottom: 1px solid black; background-color:#DCE6F1;">Ventas.</th>
						<th  style="font-size:10px;  border-bottom: 1px solid black; background-color:#DCE6F1;">Un.</th>
						<th  style="font-size:10px;  border-bottom: 1px solid black; background-color:#DCE6F1;">CIF</th>
						<th  style="font-size:10px;  border-bottom: 1px solid black; background-color:#DCE6F1;">Ventas.</th>
						<th  style="font-size:10px;  border-bottom: 1px solid black; background-color:#DCE6F1;">Un.</th>
						<th  style="font-size:10px;  border-bottom: 1px solid black; background-color:#DCE6F1;">CIF</th>
						<th  style="font-size:10px;  border-bottom: 1px solid black; background-color:#DCE6F1;">Ventas.</th>
						<th  style="font-size:10px;  border-bottom: 1px solid black; background-color:#DCE6F1;">Un.</th>
						<th  style="font-size:10px;  border-bottom: 1px solid black; background-color:#DCE6F1;">CIF</th>
						<th  style="font-size:10px;  border-bottom: 1px solid black; background-color:#DCE6F1;">Ventas.</th>
						<th  style="font-size:10px;  border-bottom: 1px solid black; background-color:#DCE6F1;">Un.</th>
						<th  style="font-size:10px;  border-bottom: 1px solid black; background-color:#DCE6F1;">CIF</th>
						<th  style="font-size:10px;  border-bottom: 1px solid black; background-color:#DCE6F1;">Ventas.</th>
						<th  style="font-size:10px;  border-bottom: 1px solid black; background-color:#DCE6F1;">Un.</th>
						<th  style="font-size:10px;  border-bottom: 1px solid black; background-color:#DCE6F1;">CIF</th>
						<th  style="font-size:10px;  border-right: 2px solid black; border-bottom: 1px solid black; background-color:#DCE6F1;">Ventas.</th>
						<th  style="font-size:10px;  border-bottom: 1px solid black; background-color:#DCE6F1;">Un.</th>
						<th  style="font-size:10px;  border-bottom: 1px solid black; background-color:#DCE6F1;">CIF</th>
						<th  style="font-size:10px;  border-bottom: 1px solid black; background-color:#DCE6F1;">Ventas.</th>
						<th  style="font-size:10px;  border-bottom: 1px solid black; background-color:#DCE6F1;">Un.</th>
						<th  style="font-size:10px;  border-bottom: 1px solid black; background-color:#DCE6F1;">CIF</th>
						<th  style="font-size:10px;  border-right: 2px solid black; border-bottom: 1px solid black; background-color:#DCE6F1;">Ventas.</th>
						<th  style="font-size:10px;  border-bottom: 1px solid black; background-color:#DCE6F1;"></th>
						<th  style="font-size:10px;  border-right: 2px solid black; border-bottom: 1px solid black; background-color:#DCE6F1;"></th>
					</tr>
				</head>
                <tbody>
                 <?php

if($finicio!= ""){
	$where_query = $where_query . " AND Periodo='". $finicio ."'";
}
if($areaNegocio != ""){
	$where_query = $where_query . " AND AreaNegocio='". $areaNegocio ."'";
}
if($status != ""){
	$where_query = $where_query . " AND Status IN (". $status .")";
}
if($segmento != ""){
	$where_query = $where_query . " AND Segmento IN (". $segmento .")";
}
if($marca != ""){
	$where_query = $where_query . " AND Marca IN (". $marca . ")";
}

$sql="

SELECT
	TABLAPV.[Segmento]
	,TABLAPV.[Marca]
	,TABLAPV.[Status]
	,CASE WHEN (GROUPING(TABLAPV.Status) = 1)
		THEN 'ALL' ELSE ISNULL(TABLAPV.Status,'Sub total')
	END AS TotalStatus 
	,ISNULL(TABLAPV.Marca,'SUB TOTAL '+UPPER(TABLAPV.Status)) AS [Marca2]

	,SUM(ISNULL(TABLAPV.[ZFI.13-1],0))      AS   [ZFI.13-1]
	,SUM(ISNULL(TABLAPV.[CIF-ZFI.13-1],0))  AS   [CIF-ZFI.13-1]
	,SUM(ISNULL(TABLAPV.[UVT-ZFI.13-1],0))  AS   [UVT-ZFI.13-1]
	,SUM(ISNULL(TABLAPV.[ZFI.13-2],0))      AS   [ZFI.13-2]
	,SUM(ISNULL(TABLAPV.[CIF-ZFI.13-2],0))  AS   [CIF-ZFI.13-2]
	,SUM(ISNULL(TABLAPV.[UVT-ZFI.13-2],0))  AS   [UVT-ZFI.13-2]
	,SUM(ISNULL(TABLAPV.[ZFI.14-6],0))      AS   [ZFI.14-6]
	,SUM(ISNULL(TABLAPV.[CIF-ZFI.14-6],0))  AS   [CIF-ZFI.14-6]
	,SUM(ISNULL(TABLAPV.[UVT-ZFI.14-6],0))  AS   [UVT-ZFI.14-6]
	,SUM(ISNULL(TABLAPV.[ZFI.17SZ],0))      AS   [ZFI.17SZ]
	,SUM(ISNULL(TABLAPV.[CIF-ZFI.17SZ],0))  AS   [CIF-ZFI.17SZ]
	,SUM(ISNULL(TABLAPV.[UVT-ZFI.17SZ],0))  AS   [UVT-ZFI.17SZ]
	,SUM(ISNULL(TABLAPV.[ZFI.13-6],0))      AS   [ZFI.13-6]
	,SUM(ISNULL(TABLAPV.[CIF-ZFI.13-6],0))  AS   [CIF-ZFI.13-6]
	,SUM(ISNULL(TABLAPV.[UVT-ZFI.13-6],0))  AS   [UVT-ZFI.13-6]
	,SUM(ISNULL(TABLAPV.[ZFI.1623],0))      AS   [ZFI.1623]
	,SUM(ISNULL(TABLAPV.[CIF-ZFI.1623],0))  AS   [CIF-ZFI.1623]
	,SUM(ISNULL(TABLAPV.[UVT-ZFI.1623],0))  AS   [UVT-ZFI.1623]
	,SUM(ISNULL(TABLAPV.[ZFI.1010],0))      AS   [ZFI.1010]
	,SUM(ISNULL(TABLAPV.[CIF-ZFI.1010],0))  AS   [CIF-ZFI.1010]
	,SUM(ISNULL(TABLAPV.[UVT-ZFI.1010],0))  AS   [UVT-ZFI.1010]
	,SUM(ISNULL(TABLAPV.[ZFI.1132],0))      AS   [ZFI.1132]
	,SUM(ISNULL(TABLAPV.[CIF-ZFI.1132],0))  AS   [CIF-ZFI.1132]
	,SUM(ISNULL(TABLAPV.[UVT-ZFI.1132],0))  AS   [UVT-ZFI.1132]
	,SUM(ISNULL(TABLAPV.[ZFI.181],0))       AS   [ZFI.181]
	,SUM(ISNULL(TABLAPV.[CIF-ZFI.181],0))   AS   [CIF-ZFI.181]
	,SUM(ISNULL(TABLAPV.[UVT-ZFI.181],0))   AS   [UVT-ZFI.181]
	,SUM(ISNULL(TABLAPV.[ZFI.184],0))       AS   [ZFI.184]
	,SUM(ISNULL(TABLAPV.[CIF-ZFI.184],0))   AS   [CIF-ZFI.184]
	,SUM(ISNULL(TABLAPV.[UVT-ZFI.184],0))   AS   [UVT-ZFI.184]
	,SUM(ISNULL(TABLAPV.[ZFI.2002],0))      AS   [ZFI.2002]
	,SUM(ISNULL(TABLAPV.[CIF-ZFI.2002],0))  AS   [CIF-ZFI.2002]
	,SUM(ISNULL(TABLAPV.[UVT-ZFI.2002],0))  AS   [UVT-ZFI.2002]
	,SUM(ISNULL(TABLAPV.[ZFI.6115],0))      AS   [ZFI.6115]
	,SUM(ISNULL(TABLAPV.[CIF-ZFI.6115],0))  AS   [CIF-ZFI.6115]
	,SUM(ISNULL(TABLAPV.[UVT-ZFI.6115],0))  AS   [UVT-ZFI.6115]
	,SUM(ISNULL(TABLAPV.[ZFI.6130],0))      AS   [ZFI.6130]
	,SUM(ISNULL(TABLAPV.[CIF-ZFI.6130],0))  AS   [CIF-ZFI.6130]
	,SUM(ISNULL(TABLAPV.[UVT-ZFI.6130],0))  AS   [UVT-ZFI.6130]
	,SUM(ISNULL(TABLAPV.[ZFI.2077],0))      AS   [ZFI.2077]
	,SUM(ISNULL(TABLAPV.[CIF-ZFI.2077],0))  AS   [CIF-ZFI.2077]
	,SUM(ISNULL(TABLAPV.[UVT-ZFI.2077],0))  AS   [UVT-ZFI.2077]
	,SUM(ISNULL(TABLAPV.[LOCAL.2],0))       AS   [LOCAL.2]
	,SUM(ISNULL(TABLAPV.[CIF-LOCAL.2],0))   AS   [CIF-LOCAL.2]
	,SUM(ISNULL(TABLAPV.[UVT-LOCAL.2],0))   AS   [UVT-LOCAL.2]
	,SUM(ISNULL(TABLAPV.[LOCAL.8],0))       AS   [LOCAL.8]
	,SUM(ISNULL(TABLAPV.[CIF-LOCAL.8],0))   AS   [CIF-LOCAL.8]
	,SUM(ISNULL(TABLAPV.[UVT-LOCAL.8],0))   AS   [UVT-LOCAL.8]
FROM
		(
		SELECT
		   PV.[Periodo]
		  ,PV.[AreaNegocio]
		  ,PV.[Segmento]
		  ,PV.[Status]
		  ,PV.[Marca]
		  ,ISNULL(PV.[ZFI.13-1],0)      AS   [ZFI.13-1]
		  ,ISNULL(PV.[CIF-ZFI.13-1],0)  AS   [CIF-ZFI.13-1]
		  ,ISNULL(PV.[UVT-ZFI.13-1],0)  AS   [UVT-ZFI.13-1]
		  ,ISNULL(PV.[ZFI.13-2],0)      AS   [ZFI.13-2]
		  ,ISNULL(PV.[CIF-ZFI.13-2],0)  AS   [CIF-ZFI.13-2]
		  ,ISNULL(PV.[UVT-ZFI.13-2],0)  AS   [UVT-ZFI.13-2]
		  ,ISNULL(PV.[ZFI.14-6],0)      AS   [ZFI.14-6]
		  ,ISNULL(PV.[CIF-ZFI.14-6],0)  AS   [CIF-ZFI.14-6]
		  ,ISNULL(PV.[UVT-ZFI.14-6],0)  AS   [UVT-ZFI.14-6]
		  ,ISNULL(PV.[ZFI.17SZ],0)      AS   [ZFI.17SZ]
		  ,ISNULL(PV.[CIF-ZFI.17SZ],0)  AS   [CIF-ZFI.17SZ]
		  ,ISNULL(PV.[UVT-ZFI.17SZ],0)  AS   [UVT-ZFI.17SZ]
		  ,ISNULL(PV.[ZFI.13-6],0)      AS   [ZFI.13-6]
		  ,ISNULL(PV.[CIF-ZFI.13-6],0)  AS   [CIF-ZFI.13-6]
		  ,ISNULL(PV.[UVT-ZFI.13-6],0)  AS   [UVT-ZFI.13-6]
		  ,ISNULL(PV.[ZFI.1623],0)      AS   [ZFI.1623]
		  ,ISNULL(PV.[CIF-ZFI.1623],0)  AS   [CIF-ZFI.1623]
		  ,ISNULL(PV.[UVT-ZFI.1623],0)  AS   [UVT-ZFI.1623]
		  ,ISNULL(PV.[ZFI.1010],0)      AS   [ZFI.1010]
		  ,ISNULL(PV.[CIF-ZFI.1010],0)  AS   [CIF-ZFI.1010]
		  ,ISNULL(PV.[UVT-ZFI.1010],0)  AS   [UVT-ZFI.1010]
		  ,ISNULL(PV.[ZFI.1132],0)      AS   [ZFI.1132]
		  ,ISNULL(PV.[CIF-ZFI.1132],0)  AS   [CIF-ZFI.1132]
		  ,ISNULL(PV.[UVT-ZFI.1132],0)  AS   [UVT-ZFI.1132]
		  ,ISNULL(PV.[ZFI.181],0)       AS   [ZFI.181]
		  ,ISNULL(PV.[CIF-ZFI.181],0)   AS   [CIF-ZFI.181]
		  ,ISNULL(PV.[UVT-ZFI.181],0)   AS   [UVT-ZFI.181]
		  ,ISNULL(PV.[ZFI.184],0)       AS   [ZFI.184]
		  ,ISNULL(PV.[CIF-ZFI.184],0)   AS   [CIF-ZFI.184]
		  ,ISNULL(PV.[UVT-ZFI.184],0)   AS   [UVT-ZFI.184]
		  ,ISNULL(PV.[ZFI.2002],0)      AS   [ZFI.2002]
		  ,ISNULL(PV.[CIF-ZFI.2002],0)  AS   [CIF-ZFI.2002]
		  ,ISNULL(PV.[UVT-ZFI.2002],0)  AS   [UVT-ZFI.2002]
		  ,ISNULL(PV.[ZFI.6115],0)      AS   [ZFI.6115]
		  ,ISNULL(PV.[CIF-ZFI.6115],0)  AS   [CIF-ZFI.6115]
		  ,ISNULL(PV.[UVT-ZFI.6115],0)  AS   [UVT-ZFI.6115]
		  ,ISNULL(PV.[ZFI.6130],0)      AS   [ZFI.6130]
		  ,ISNULL(PV.[CIF-ZFI.6130],0)  AS   [CIF-ZFI.6130]
		  ,ISNULL(PV.[UVT-ZFI.6130],0)  AS   [UVT-ZFI.6130]
		  ,ISNULL(PV.[ZFI.2077],0)      AS   [ZFI.2077]
		  ,ISNULL(PV.[CIF-ZFI.2077],0)  AS   [CIF-ZFI.2077]
		  ,ISNULL(PV.[UVT-ZFI.2077],0)  AS   [UVT-ZFI.2077]
		  ,ISNULL(PV.[LOCAL.2],0)       AS   [LOCAL.2]
		  ,ISNULL(PV.[CIF-LOCAL.2],0)   AS   [CIF-LOCAL.2]
		  ,ISNULL(PV.[UVT-LOCAL.2],0)   AS   [UVT-LOCAL.2]
		  ,ISNULL(PV.[LOCAL.8],0)       AS   [LOCAL.8]
		  ,ISNULL(PV.[CIF-LOCAL.8],0)   AS   [CIF-LOCAL.8]
		  ,ISNULL(PV.[UVT-LOCAL.8],0)   AS   [UVT-LOCAL.8]
		  FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_VW_Vtas_Stock_SegSta]

		          pivot (
							 SUM([Quantity])
							 for [WhsCode] in
							  ([ZFI.13-1]
							  ,[ZFI.13-2]
							  ,[ZFI.14-6]
							  ,[ZFI.17SZ]
							  ,[ZFI.13-6]
							  ,[ZFI.1623]
							  ,[ZFI.1010]
							  ,[ZFI.1132]
							  ,[ZFI.181]
							  ,[ZFI.184]
							  ,[ZFI.2002]
							  ,[ZFI.6115]
							  ,[ZFI.6130]
							  ,[ZFI.2077]
							  ,[LOCAL.2]
							  ,[LOCAL.8]       )) AS PV
				  pivot (
							 SUM([StockVal])
							 for [WhsCodePV2] in
							  ([CIF-ZFI.13-1]
							  ,[CIF-ZFI.13-2]
							  ,[CIF-ZFI.14-6]
							  ,[CIF-ZFI.17SZ]
							  ,[CIF-ZFI.13-6]
							  ,[CIF-ZFI.1623]
							  ,[CIF-ZFI.1010]
							  ,[CIF-ZFI.1132]
							  ,[CIF-ZFI.181]
							  ,[CIF-ZFI.184]
							  ,[CIF-ZFI.2002]
							  ,[CIF-ZFI.6115]
							  ,[CIF-ZFI.6130]
							  ,[CIF-ZFI.2077]
							  ,[CIF-LOCAL.2]
							  ,[CIF-LOCAL.8]   )) AS PV
				 pivot (
							 SUM([UVentas])
							 for [WhsCodePV3] in
							  ([UVT-ZFI.13-1]
							  ,[UVT-ZFI.13-2]
							  ,[UVT-ZFI.14-6]
							  ,[UVT-ZFI.17SZ]
							  ,[UVT-ZFI.13-6]
							  ,[UVT-ZFI.1623]
							  ,[UVT-ZFI.1010]
							  ,[UVT-ZFI.1132]
							  ,[UVT-ZFI.181]
							  ,[UVT-ZFI.184]
							  ,[UVT-ZFI.2002]
							  ,[UVT-ZFI.6115]
							  ,[UVT-ZFI.6130]
							  ,[UVT-ZFI.2077]
							  ,[UVT-LOCAL.2]
							  ,[UVT-LOCAL.8]   )) AS PV

		WHERE 1=1
		  ". $where_query ."
		) AS TABLAPV

GROUP BY
	TABLAPV.[Segmento]
	,TABLAPV.[Status]
	,TABLAPV.[Marca] WITH ROLLUP
HAVING Segmento IS NOT NULL
";

	$acumUnidades = 0;
	$acumCIF = 0;
//echo $sql;
if($consultar!= ""){
	$rs = odbc_exec( $conn, $sql );
		if ( !$rs){
			exit( "Error en la consulta SQL" );
		}
		if($consultar){
			$ai = 1;
			$repiteSegmento = "";
			$repiteStatus = "";
			while($resultado = odbc_fetch_array($rs)){
				echo '<tr>';
				
				if($resultado["TotalStatus"] == 'ALL'){
					$repiteSegmento = "";
					$repiteStatus = "";
					echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-left: 2px solid #689DED; border-right: 2px solid #689DED; background-color:#DCE6F1;" colspan="4" align="center"><strong>TOTAL</strong></td>';
					$ai = $ai - 1;
				}else{
					$encontrado = strpos($resultado["Marca2"],'SUB TOTAL');
					if($encontrado!== false){
						$repiteSegmento = "";
						$repiteStatus = "";
						echo '<td style="border-top:2px solid #689DED; border-right:2px solid #689DED; border-bottom:2px solid #689DED; background-color:#DCE6F1;" colspan="4" align="center"><strong>'.$resultado["Marca2"].'</strong></td>';
						$ai = $ai - 1;
					}else{
						if($resultado["Segmento"] == $repiteSegmento){
							echo '<td style="border-left:1px solid #689DED; background-color:#DCE6F1;"></td>';
							if($resultado["TotalStatus"] == $repiteStatus){
								echo '<td></td>';
							}else{
								$repiteStatus = $resultado["TotalStatus"];
								echo '<td>'.($resultado["TotalStatus"]).'</td>';
							}
							  echo'<td style="border-top:1px solid #689DED; border-bottom: 1px solid #689DED;"><strong>'.($ai).'</strong></td>
							  <td style="border-top:1px solid #689DED; border-bottom: 1px solid #689DED;">'.$resultado["Marca2"].'</td>';
						}else{
							$repiteSegmento = $resultado["Segmento"];
							echo '<td style="border-left:1px solid #689DED; background-color:#DCE6F1;">'.($resultado["Segmento"]).'</td>';
							 if($resultado["TotalStatus"] == $repiteStatus){
								echo '<td></td>';
							}else{
								$repiteStatus = $resultado["TotalStatus"];
								echo '<td>'.($resultado["TotalStatus"]).'</td>';
							}
							 
							  echo '<td style="border-top:1px solid #689DED; border-bottom: 1px solid #689DED;"><strong>'.($ai).'</strong></td>
							  <td style="border-top:1px solid #689DED; border-bottom: 1px solid #689DED;">'.$resultado["Marca2"].'</td>';
						}
					}
				}
				if($resultado["ZFI.13-1"] == 0){ //UNIDAD
					if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){

						echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
					}else{
						if($resultado["TotalStatus"] == 'ALL'){
							echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
						}else{
							echo '<td style="border-left:2px solid #689DED; border-bottom: 1px dotted #689DED; border-right:1px dotted #689DED;"></td>';
						}
					}
				}else{
					if($resultado["TotalStatus"] == 'ALL'){
						echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["ZFI.13-1"],0,'','.').'</td>';
					}else if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
						echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["ZFI.13-1"],0,'','.').'</td>';
					}else{
						echo '<td style="border-left:2px solid #689DED; border-bottom: 1px dotted #689DED; border-right:1px dotted #689DED;">'.number_format($resultado["ZFI.13-1"],0,'','.').'</td>';
					}
					$acumUnidades = $acumUnidades + $resultado["ZFI.13-1"];
				}
				if($resultado["CIF-ZFI.13-1"] == 0){
					if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
						echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
					}else{
						if($resultado["TotalStatus"] == 'ALL'){
							echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
						}else{
							echo '<td style="border-top: 1px dotted #689DED; border-left:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-right:1px dotted #689DED;"></td>';
						}
					}
				}else{
					if($resultado["TotalStatus"] == 'ALL'){
						echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["CIF-ZFI.13-1"],0,'','.').'</td>';
					}else if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
						echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["CIF-ZFI.13-1"],0,'','.').'</td>';
					}else{
						echo '<td style="border-top: 1px dotted #689DED; border-right:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-left: 1px dotted #689DED;">'.number_format($resultado["CIF-ZFI.13-1"],2,',','.').'</td>';
					}
					$acumCIF = $acumCIF + $resultado["CIF-ZFI.13-1"];
				}
				if($resultado["UVT-ZFI.13-1"] == 0){
					if($resultado["TotalStatus"] == 'ALL'){
						echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
					}else if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
						echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
							}else{
								echo '<td style="border-top: 1px dotted #689DED; border-right:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-left: 1px dotted #689DED;"></td>';
							}
						}else{
							if($resultado["TotalStatus"] == 'ALL'){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["UVT-ZFI.13-1"],0,'','.').'</td>';
							}else if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["UVT-ZFI.13-1"],0,'','.').'</td>';
							}else{
								echo '<td style="border-top: 1px dotted #689DED; border-right:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-left: 1px dotted #689DED;">'.number_format($resultado["UVT-ZFI.13-1"],2,',','.').'</td>';
							}
						}

						if($resultado["ZFI.13-2"] == 0){
							if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
							}else{
								if($resultado["TotalStatus"] == 'ALL'){
							echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
						}else{
							echo '<td style="border-top: 1px dotted #689DED; border-left:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-right:1px dotted #689DED;"></td>';
						}
							}
						}else{
							if($resultado["TotalStatus"] == 'ALL'){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["ZFI.13-2"],0,'','.').'</td>';
							}else if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["ZFI.13-2"],0,'','.').'</td>';
							}else{
								echo '<td style="border-top: 1px dotted #689DED; border-right:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-left: 1px dotted #689DED;">'.number_format($resultado["ZFI.13-2"],2,',','.').'</td>';
							}
							$acumUnidades = $acumUnidades + $resultado["ZFI.13-2"];
						}
						if($resultado["CIF-ZFI.13-2"] == 0){
							if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
							}else{
								if($resultado["TotalStatus"] == 'ALL'){
							echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
						}else{
							echo '<td style="border-top: 1px dotted #689DED; border-left:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-right:1px dotted #689DED;"></td>';
						}
							}
						}else{
							if($resultado["TotalStatus"] == 'ALL'){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["CIF-ZFI.13-2"],0,'','.').'</td>';
							}else if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["CIF-ZFI.13-2"],0,'','.').'</td>';
							}else{
								echo '<td style="border-top: 1px dotted #689DED; border-right:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-left: 1px dotted #689DED;">'.number_format($resultado["CIF-ZFI.13-2"],2,',','.').'</td>';
							}
							$acumCIF = $acumCIF + $resultado["CIF-ZFI.13-2"];
						}
						if($resultado["UVT-ZFI.13-2"] == 0){
							if($resultado["TotalStatus"] == 'ALL'){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
							}else if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
							}else{
								echo '<td style="border-top: 1px dotted #689DED; border-right:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-left: 1px dotted #689DED;"></td>';
							}
						}else{
							if($resultado["TotalStatus"] == 'ALL'){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["UVT-ZFI.13-2"],0,'','.').'</td>';
							}else if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["UVT-ZFI.13-2"],0,'','.').'</td>';
							}else{
								echo '<td style="border-top: 1px dotted #689DED; border-right:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-left: 1px dotted #689DED;">'.number_format($resultado["UVT-ZFI.13-2"],2,',','.').'</td>';
							}
						}

						if($resultado["ZFI.13-6"] == 0){
							if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
							}else{
								if($resultado["TotalStatus"] == 'ALL'){
							echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
						}else{
							echo '<td style="border-top: 1px dotted #689DED; border-left:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-right:1px dotted #689DED;"></td>';
						}
							}
						}else{
							if($resultado["TotalStatus"] == 'ALL'){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["ZFI.13-6"],0,'','.').'</td>';
							}else if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["ZFI.13-6"],0,'','.').'</td>';
							}else{
								echo '<td style="border-top: 1px dotted #689DED; border-right:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-left: 1px dotted #689DED;">'.number_format($resultado["ZFI.13-6"],2,',','.').'</td>';
							}
							$acumUnidades = $acumUnidades + $resultado["ZFI.13-6"];
						}
						if($resultado["CIF-ZFI.13-6"] == 0){
							if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
							}else{
								if($resultado["TotalStatus"] == 'ALL'){
							echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
						}else{
							echo '<td style="border-top: 1px dotted #689DED; border-left:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-right:1px dotted #689DED;"></td>';
						}
							}
						}else{
							if($resultado["TotalStatus"] == 'ALL'){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["CIF-ZFI.13-6"],0,'','.').'</td>';
							}else if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["CIF-ZFI.13-6"],0,'','.').'</td>';
							}else{
								echo '<td style="border-top: 1px dotted #689DED; border-right:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-left: 1px dotted #689DED;">'.number_format($resultado["CIF-ZFI.13-6"],2,',','.').'</td>';
							}
							$acumCIF = $acumCIF + $resultado["CIF-ZFI.13-6"];
						}
						if($resultado["UVT-ZFI.13-6"] == 0){
							if($resultado["TotalStatus"] == 'ALL'){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
							}else if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
							}else{
								echo '<td style="border-top: 1px dotted #689DED; border-right:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-left: 1px dotted #689DED;"></td>';
							}
						}else{
							if($resultado["TotalStatus"] == 'ALL'){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["UVT-ZFI.13-6"],0,'','.').'</td>';
							}else if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["UVT-ZFI.13-6"],0,'','.').'</td>';
							}else{
								echo '<td style="border-top: 1px dotted #689DED; border-right:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-left: 1px dotted #689DED;">'.number_format($resultado["UVT-ZFI.13-6"],2,',','.').'</td>';
							}
						}

						if($resultado["ZFI.1623"] == 0){
							if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
							}else{
								if($resultado["TotalStatus"] == 'ALL'){
							echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
						}else{
							echo '<td style="border-top: 1px dotted #689DED; border-left:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-right:1px dotted #689DED;"></td>';
						}
							}
						}else{
							if($resultado["TotalStatus"] == 'ALL'){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["ZFI.1623"],0,'','.').'</td>';
							}else if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["ZFI.1623"],0,'','.').'</td>';
							}else{
								echo '<td style="border-top: 1px dotted #689DED; border-right:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-left: 1px dotted #689DED;">'.number_format($resultado["ZFI.1623"],2,',','.').'</td>';
							}
							$acumUnidades = $acumUnidades + $resultado["ZFI.1623"];
						}
						if($resultado["CIF-ZFI.1623"] == 0){
							if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
							}else{
								if($resultado["TotalStatus"] == 'ALL'){
							echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
						}else{
							echo '<td style="border-top: 1px dotted #689DED; border-left:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-right:1px dotted #689DED;"></td>';
						}
							}
						}else{
							if($resultado["TotalStatus"] == 'ALL'){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["CIF-ZFI.1623"],0,'','.').'</td>';
							}else if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["CIF-ZFI.1623"],0,'','.').'</td>';
							}else{
								echo '<td style="border-top: 1px dotted #689DED; border-right:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-left: 1px dotted #689DED;">'.number_format($resultado["CIF-ZFI.1623"],2,',','.').'</td>';
							}
							$acumCIF = $acumCIF + $resultado["CIF-ZFI.1623"];
						}
						if($resultado["UVT-ZFI.1623"] == 0){
							if($resultado["TotalStatus"] == 'ALL'){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
							}else if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
							}else{
								echo '<td style="border-top: 1px dotted #689DED; border-right:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-left: 1px dotted #689DED;"></td>';
							}
						}else{
							if($resultado["TotalStatus"] == 'ALL'){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["UVT-ZFI.1623"],0,'','.').'</td>';
							}else if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["UVT-ZFI.1623"],0,'','.').'</td>';
							}else{
								echo '<td style="border-top: 1px dotted #689DED; border-right:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-left: 1px dotted #689DED;">'.number_format($resultado["UVT-ZFI.1623"],2,',','.').'</td>';
							}
						}

						if($resultado["ZFI.17SZ"] == 0){
							if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
							}else{
								if($resultado["TotalStatus"] == 'ALL'){
							echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
						}else{
							echo '<td style="border-top: 1px dotted #689DED; border-left:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-right:1px dotted #689DED;"></td>';
						}
							}
						}else{
							if($resultado["TotalStatus"] == 'ALL'){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["ZFI.17SZ"],0,'','.').'</td>';
							}else if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["ZFI.17SZ"],0,'','.').'</td>';
							}else{
								echo '<td style="border-top: 1px dotted #689DED; border-right:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-left: 1px dotted #689DED;">'.number_format($resultado["ZFI.17SZ"],2,',','.').'</td>';
							}
							$acumUnidades = $acumUnidades + $resultado["ZFI.17SZ"];
						}
						if($resultado["CIF-ZFI.17SZ"] == 0){
							if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
							}else{
								if($resultado["TotalStatus"] == 'ALL'){
							echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
						}else{
							echo '<td style="border-top: 1px dotted #689DED; border-left:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-right:1px dotted #689DED;"></td>';
						}
							}
						}else{
							if($resultado["TotalStatus"] == 'ALL'){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["CIF-ZFI.17SZ"],0,'','.').'</td>';
							}else if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["CIF-ZFI.17SZ"],0,'','.').'</td>';
							}else{
								echo '<td style="border-top: 1px dotted #689DED; border-right:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-left: 1px dotted #689DED;">'.number_format($resultado["CIF-ZFI.17SZ"],2,',','.').'</td>';
							}
							$acumCIF = $acumCIF + $resultado["CIF-ZFI.17SZ"];
						}
						if($resultado["UVT-ZFI.17SZ"] == 0){
							if($resultado["TotalStatus"] == 'ALL'){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:2px solid #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
							}else if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:2px solid #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
							}else{
								echo '<td style="border-top: 1px dotted #689DED; border-right:1px dotted #689DED; border-right:2px solid #689DED; border-left: 1px dotted #689DED;"></td>';
							}
						}else{
							if($resultado["TotalStatus"] == 'ALL'){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:2px solid #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["UVT-ZFI.17SZ"],0,'','.').'</td>';
							}else if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:2px solid #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["UVT-ZFI.17SZ"],0,'','.').'</td>';
							}else{
								echo '<td style="border-top: 1px dotted #689DED; border-right:2px solid #689DED; border-bottom: 1px dotted #689DED; border-left: 1px dotted #689DED;">'.number_format($resultado["UVT-ZFI.17SZ"],2,',','.').'</td>';
							}
						}

						if($resultado["ZFI.1010"] == 0){
							if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
							}else{
								if($resultado["TotalStatus"] == 'ALL'){
							echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
						}else{
							echo '<td style="border-top: 1px dotted #689DED; border-left:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-right:1px dotted #689DED;"></td>';
						}
							}
						}else{
							if($resultado["TotalStatus"] == 'ALL'){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["ZFI.1010"],0,'','.').'</td>';
							}else if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["ZFI.1010"],0,'','.').'</td>';
							}else{
								echo '<td style="border-top: 1px dotted #689DED; border-right:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-left: 1px dotted #689DED;">'.number_format($resultado["ZFI.1010"],2,',','.').'</td>';
							}
							$acumUnidades = $acumUnidades + $resultado["ZFI.1010"];
						}
						if($resultado["CIF-ZFI.1010"] == 0){
							if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
							}else{
								if($resultado["TotalStatus"] == 'ALL'){
							echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
						}else{
							echo '<td style="border-top: 1px dotted #689DED; border-left:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-right:1px dotted #689DED;"></td>';
						}
							}
						}else{
							if($resultado["TotalStatus"] == 'ALL'){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["CIF-ZFI.1010"],0,'','.').'</td>';
							}else if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["CIF-ZFI.1010"],0,'','.').'</td>';
							}else{
								echo '<td style="border-top: 1px dotted #689DED; border-right:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-left: 1px dotted #689DED;">'.number_format($resultado["CIF-ZFI.1010"],2,',','.').'</td>';
							}
							$acumCIF = $acumCIF + $resultado["CIF-ZFI.1010"];
						}
						if($resultado["UVT-ZFI.1010"] == 0){
							if($resultado["TotalStatus"] == 'ALL'){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
							}else if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
							}else{
								echo '<td style="border-top: 1px dotted #689DED; border-right:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-left: 1px dotted #689DED;"></td>';
							}
						}else{
							if($resultado["TotalStatus"] == 'ALL'){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["UVT-ZFI.1010"],0,'','.').'</td>';
							}else if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["UVT-ZFI.1010"],0,'','.').'</td>';
							}else{
								echo '<td style="border-top: 1px dotted #689DED; border-right:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-left: 1px dotted #689DED;">'.number_format($resultado["UVT-ZFI.1010"],2,',','.').'</td>';
							}
						}

						if($resultado["ZFI.1132"] == 0){
							if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
							}else{
								if($resultado["TotalStatus"] == 'ALL'){
							echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
						}else{
							echo '<td style="border-top: 1px dotted #689DED; border-left:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-right:1px dotted #689DED;"></td>';
						}
							}
						}else{
							if($resultado["TotalStatus"] == 'ALL'){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["ZFI.1132"],0,'','.').'</td>';
							}else if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["ZFI.1132"],0,'','.').'</td>';
							}else{
								echo '<td style="border-top: 1px dotted #689DED; border-right:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-left: 1px dotted #689DED;">'.number_format($resultado["ZFI.1132"],2,',','.').'</td>';
							}
							$acumUnidades = $acumUnidades + $resultado["ZFI.1132"];
						}
						if($resultado["CIF-ZFI.1132"] == 0){
							if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
							}else{
								if($resultado["TotalStatus"] == 'ALL'){
							echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
						}else{
							echo '<td style="border-top: 1px dotted #689DED; border-left:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-right:1px dotted #689DED;"></td>';
						}
							}
						}else{
							if($resultado["TotalStatus"] == 'ALL'){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["CIF-ZFI.1132"],0,'','.').'</td>';
							}else if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["CIF-ZFI.1132"],0,'','.').'</td>';
							}else{
								echo '<td style="border-top: 1px dotted #689DED; border-right:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-left: 1px dotted #689DED;">'.number_format($resultado["CIF-ZFI.1132"],2,',','.').'</td>';
							}
							$acumCIF = $acumCIF + $resultado["CIF-ZFI.1132"];
						}
						if($resultado["UVT-ZFI.1132"] == 0){
							if($resultado["TotalStatus"] == 'ALL'){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
							}else if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
							}else{
								echo '<td style="border-top: 1px dotted #689DED; border-right:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-left: 1px dotted #689DED;"></td>';
							}
						}else{
							if($resultado["TotalStatus"] == 'ALL'){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["UVT-ZFI.1132"],0,'','.').'</td>';
							}else if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["UVT-ZFI.1132"],0,'','.').'</td>';
							}else{
								echo '<td style="border-top: 1px dotted #689DED; border-right:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-left: 1px dotted #689DED;">'.number_format($resultado["UVT-ZFI.1132"],2,',','.').'</td>';
							}
						}

						if($resultado["ZFI.181"] == 0){
							if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
							}else{
								if($resultado["TotalStatus"] == 'ALL'){
							echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
						}else{
							echo '<td style="border-top: 1px dotted #689DED; border-left:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-right:1px dotted #689DED;"></td>';
						}
							}
						}else{
							if($resultado["TotalStatus"] == 'ALL'){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["ZFI.181"],0,'','.').'</td>';
							}else if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["ZFI.181"],0,'','.').'</td>';
							}else{
								echo '<td style="border-top: 1px dotted #689DED; border-right:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-left: 1px dotted #689DED;">'.number_format($resultado["ZFI.181"],2,',','.').'</td>';
							}
							$acumUnidades = $acumUnidades + $resultado["ZFI.181"];
						}
						if($resultado["CIF-ZFI.181"] == 0){
							if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
							}else{
								if($resultado["TotalStatus"] == 'ALL'){
							echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
						}else{
							echo '<td style="border-top: 1px dotted #689DED; border-left:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-right:1px dotted #689DED;"></td>';
						}
							}
						}else{
							if($resultado["TotalStatus"] == 'ALL'){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["CIF-ZFI.181"],0,'','.').'</td>';
							}else if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["CIF-ZFI.181"],0,'','.').'</td>';
							}else{
								echo '<td style="border-top: 1px dotted #689DED; border-right:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-left: 1px dotted #689DED;">'.number_format($resultado["CIF-ZFI.181"],2,',','.').'</td>';
							}
							$acumCIF = $acumCIF + $resultado["CIF-ZFI.181"];
						}
						if($resultado["UVT-ZFI.181"] == 0){
							if($resultado["TotalStatus"] == 'ALL'){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
							}else if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
							}else{
								echo '<td style="border-top: 1px dotted #689DED; border-right:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-left: 1px dotted #689DED;"></td>';
							}
						}else{
							if($resultado["TotalStatus"] == 'ALL'){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["UVT-ZFI.181"],0,'','.').'</td>';
							}else if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["UVT-ZFI.181"],0,'','.').'</td>';
							}else{
								echo '<td style="border-top: 1px dotted #689DED; border-right:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-left: 1px dotted #689DED;">'.number_format($resultado["UVT-ZFI.181"],2,',','.').'</td>';
							}
						}

						if($resultado["ZFI.184"] == 0){
							if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
							}else{
								if($resultado["TotalStatus"] == 'ALL'){
							echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
						}else{
							echo '<td style="border-top: 1px dotted #689DED; border-left:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-right:1px dotted #689DED;"></td>';
						}
							}
						}else{
							if($resultado["TotalStatus"] == 'ALL'){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["ZFI.184"],0,'','.').'</td>';
							}else if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["ZFI.184"],0,'','.').'</td>';
							}else{
								echo '<td style="border-top: 1px dotted #689DED; border-right:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-left: 1px dotted #689DED;">'.number_format($resultado["ZFI.184"],2,',','.').'</td>';
							}
							$acumUnidades = $acumUnidades + $resultado["ZFI.184"];
						}
						if($resultado["CIF-ZFI.184"] == 0){
							if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
							}else{
								if($resultado["TotalStatus"] == 'ALL'){
							echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
						}else{
							echo '<td style="border-top: 1px dotted #689DED; border-left:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-right:1px dotted #689DED;"></td>';
						}
							}
						}else{
							if($resultado["TotalStatus"] == 'ALL'){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["CIF-ZFI.184"],0,'','.').'</td>';
							}else if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["CIF-ZFI.184"],0,'','.').'</td>';
							}else{
								echo '<td style="border-top: 1px dotted #689DED; border-right:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-left: 1px dotted #689DED;">'.number_format($resultado["CIF-ZFI.184"],2,',','.').'</td>';
							}
							$acumCIF = $acumCIF + $resultado["CIF-ZFI.184"];
						}
						if($resultado["UVT-ZFI.184"] == 0){
							if($resultado["TotalStatus"] == 'ALL'){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
							}else if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
							}else{
								echo '<td style="border-top: 1px dotted #689DED; border-right:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-left: 1px dotted #689DED;"></td>';
							}
						}else{
							if($resultado["TotalStatus"] == 'ALL'){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["UVT-ZFI.184"],0,'','.').'</td>';
							}else if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["UVT-ZFI.184"],0,'','.').'</td>';
							}else{
								echo '<td style="border-top: 1px dotted #689DED; border-right:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-left: 1px dotted #689DED;">'.number_format($resultado["UVT-ZFI.184"],2,',','.').'</td>';
							}
						}

						if($resultado["ZFI.2002"] == 0){
							if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
							}else{
								if($resultado["TotalStatus"] == 'ALL'){
							echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
						}else{
							echo '<td style="border-top: 1px dotted #689DED; border-left:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-right:1px dotted #689DED;"></td>';
						}
							}
						}else{
							if($resultado["TotalStatus"] == 'ALL'){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["ZFI.2002"],0,'','.').'</td>';
							}else if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["ZFI.2002"],0,'','.').'</td>';
							}else{
								echo '<td style="border-top: 1px dotted #689DED; border-right:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-left: 1px dotted #689DED;">'.number_format($resultado["ZFI.2002"],2,',','.').'</td>';
							}
							$acumUnidades = $acumUnidades + $resultado["ZFI.2002"];
						}
						if($resultado["CIF-ZFI.2002"] == 0){
							if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
							}else{
								if($resultado["TotalStatus"] == 'ALL'){
							echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
						}else{
							echo '<td style="border-top: 1px dotted #689DED; border-left:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-right:1px dotted #689DED;"></td>';
						}
							}
						}else{
							if($resultado["TotalStatus"] == 'ALL'){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["CIF-ZFI.2002"],0,'','.').'</td>';
							}else if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["CIF-ZFI.2002"],0,'','.').'</td>';
							}else{
								echo '<td style="border-top: 1px dotted #689DED; border-right:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-left: 1px dotted #689DED;">'.number_format($resultado["CIF-ZFI.2002"],2,',','.').'</td>';
							}
							$acumCIF = $acumCIF + $resultado["CIF-ZFI.2002"];
						}
						if($resultado["UVT-ZFI.2002"] == 0){
							if($resultado["TotalStatus"] == 'ALL'){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
							}else if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
							}else{
								echo '<td style="border-top: 1px dotted #689DED; border-right:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-left: 1px dotted #689DED;"></td>';
							}
						}else{
							if($resultado["TotalStatus"] == 'ALL'){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["UVT-ZFI.2002"],0,'','.').'</td>';
							}else if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["UVT-ZFI.2002"],0,'','.').'</td>';
							}else{
								echo '<td style="border-top: 1px dotted #689DED; border-right:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-left: 1px dotted #689DED;">'.number_format($resultado["UVT-ZFI.2002"],2,',','.').'</td>';
							}
						}

						if($resultado["ZFI.2077"] == 0){
							if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
							}else{
								if($resultado["TotalStatus"] == 'ALL'){
							echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
						}else{
							echo '<td style="border-top: 1px dotted #689DED; border-left:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-right:1px dotted #689DED;"></td>';
						}
							}
						}else{
							if($resultado["TotalStatus"] == 'ALL'){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["ZFI.2077"],0,'','.').'</td>';
							}else if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["ZFI.2077"],0,'','.').'</td>';
							}else{
								echo '<td style="border-top: 1px dotted #689DED; border-right:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-left: 1px dotted #689DED;">'.number_format($resultado["ZFI.2077"],2,',','.').'</td>';
							}
							$acumUnidades = $acumUnidades + $resultado["ZFI.2077"];
						}
						if($resultado["CIF-ZFI.2077"] == 0){
							if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
							}else{
								if($resultado["TotalStatus"] == 'ALL'){
							echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
						}else{
							echo '<td style="border-top: 1px dotted #689DED; border-left:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-right:1px dotted #689DED;"></td>';
						}
							}
						}else{
							if($resultado["TotalStatus"] == 'ALL'){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["CIF-ZFI.2077"],0,'','.').'</td>';
							}else if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["CIF-ZFI.2077"],0,'','.').'</td>';
							}else{
								echo '<td style="border-top: 1px dotted #689DED; border-right:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-left: 1px dotted #689DED;">'.number_format($resultado["CIF-ZFI.2077"],2,',','.').'</td>';
							}
							$acumCIF = $acumCIF + $resultado["CIF-ZFI.2077"];
						}
						if($resultado["UVT-ZFI.2077"] == 0){
							if($resultado["TotalStatus"] == 'ALL'){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:2px solid #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
							}else if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:2px solid #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
							}else{
								echo '<td style="border-top: 1px dotted #689DED; border-right:1px dotted #689DED; border-right:2px solid #689DED; border-left: 1px dotted #689DED;"></td>';
							}
						}else{
							if($resultado["TotalStatus"] == 'ALL'){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:2px solid #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["UVT-ZFI.2077"],0,'','.').'</td>';
							}else if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:2px solid #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["UVT-ZFI.2077"],0,'','.').'</td>';
							}else{
								echo '<td style="border-top: 1px dotted #689DED; border-right:2px solid #689DED; border-bottom: 1px dotted #689DED; border-left: 1px dotted #689DED;">'.number_format($resultado["UVT-ZFI.2077"],2,',','.').'</td>';
							}
						}

						if($resultado["LOCAL.2"] == 0){
							if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
							}else{
								if($resultado["TotalStatus"] == 'ALL'){
							echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
						}else{
							echo '<td style="border-top: 1px dotted #689DED; border-left:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-right:1px dotted #689DED;"></td>';
						}
							}
						}else{
							if($resultado["TotalStatus"] == 'ALL'){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["LOCAL.2"],0,'','.').'</td>';
							}else if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["LOCAL.2"],0,'','.').'</td>';
							}else{
								echo '<td style="border-top: 1px dotted #689DED; border-right:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-left: 1px dotted #689DED;">'.number_format($resultado["LOCAL.2"],2,',','.').'</td>';
							}
							$acumUnidades = $acumUnidades + $resultado["LOCAL.2"];
						}
						if($resultado["CIF-LOCAL.2"] == 0){
							if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
							}else{
								if($resultado["TotalStatus"] == 'ALL'){
							echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
						}else{
							echo '<td style="border-top: 1px dotted #689DED; border-left:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-right:1px dotted #689DED;"></td>';
						}
							}
						}else{
							if($resultado["TotalStatus"] == 'ALL'){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["CIF-LOCAL.2"],0,'','.').'</td>';
							}else if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["CIF-LOCAL.2"],0,'','.').'</td>';
							}else{
								echo '<td style="border-top: 1px dotted #689DED; border-right:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-left: 1px dotted #689DED;">'.number_format($resultado["CIF-LOCAL.2"],2,',','.').'</td>';
							}
							$acumCIF = $acumCIF + $resultado["CIF-LOCAL.2"];
						}
						if($resultado["UVT-LOCAL.2"] == 0){
							if($resultado["TotalStatus"] == 'ALL'){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
							}else if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
							}else{
								echo '<td style="border-top: 1px dotted #689DED; border-right:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-left: 1px dotted #689DED;"></td>';
							}
						}else{
							if($resultado["TotalStatus"] == 'ALL'){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["UVT-LOCAL.2"],0,'','.').'</td>';
							}else if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["UVT-LOCAL.2"],0,'','.').'</td>';
							}else{
								echo '<td style="border-top: 1px dotted #689DED; border-right:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-left: 1px dotted #689DED;">'.number_format($resultado["UVT-LOCAL.2"],2,',','.').'</td>';
							}
						}

						if($resultado["LOCAL.8"] == 0){
							if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
							}else{
								if($resultado["TotalStatus"] == 'ALL'){
							echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
						}else{
							echo '<td style="border-top: 1px dotted #689DED; border-left:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-right:1px dotted #689DED;"></td>';
						}
							}
						}else{
							if($resultado["TotalStatus"] == 'ALL'){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["LOCAL.8"],0,'','.').'</td>';
							}else if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["LOCAL.8"],0,'','.').'</td>';
							}else{
								echo '<td style="border-top: 1px dotted #689DED; border-right:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-left: 1px dotted #689DED;">'.number_format($resultado["LOCAL.8"],2,',','.').'</td>';
							}
							$acumUnidades = $acumUnidades + $resultado["LOCAL.8"];
						}
						if($resultado["CIF-LOCAL.8"] == 0){
							if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
							}else{
								if($resultado["TotalStatus"] == 'ALL'){
							echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
						}else{
							echo '<td style="border-top: 1px dotted #689DED; border-left:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-right:1px dotted #689DED;"></td>';
						}
							}
						}else{
							if($resultado["TotalStatus"] == 'ALL'){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["CIF-LOCAL.8"],0,'','.').'</td>';
							}else if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["CIF-LOCAL.8"],0,'','.').'</td>';
							}else{
								echo '<td style="border-top: 1px dotted #689DED; border-right:1px dotted #689DED; border-bottom: 1px dotted #689DED; border-left: 1px dotted #689DED;">'.number_format($resultado["CIF-LOCAL.8"],2,',','.').'</td>';
							}
							$acumCIF = $acumCIF + $resultado["CIF-LOCAL.8"];
						}
						if($resultado["UVT-LOCAL.8"] == 0){
							if($resultado["TotalStatus"] == 'ALL'){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:2px solid #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
							}else if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:2px solid #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;"></td>';
							}else{
								echo '<td style="border-top: 1px dotted #689DED; border-right:2px solid #689DED;; border-bottom: 1px dotted #689DED; border-left: 1px dotted #689DED;"></td>';
							}
						}else{
							if($resultado["TotalStatus"] == 'ALL'){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:2px solid #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["UVT-LOCAL.8"],0,'','.').'</td>';
							}else if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
								echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:2px solid #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($resultado["UVT-LOCAL.8"],0,'','.').'</td>';
							}else{
								echo '<td style="border-top: 1px dotted #689DED; border-right:2px solid #689DED; border-bottom: 1px dotted #689DED; border-left: 1px dotted #689DED;">'.number_format($resultado["UVT-LOCAL.8"],2,',','.').'</td>';
							}
						}
						if($resultado["TotalStatus"] == 'ALL'){
							echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($acumUnidades,0,'','.').'</td>';
						}else if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
							echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:1px dotted #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($acumUnidades,0,'','.').'</td>';
						}else{
							echo '<td style="border-top: 1px dotted #689DED; border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED; border-right:1px dotted #689DED;">'.number_format($acumUnidades,0,'','.').'</td>';
						}
						if($resultado["TotalStatus"] == 'ALL'){
							echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-right:2px solid #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($acumCIF,0,'','.').'</td>';
						}else if(strpos($resultado["Marca2"],'SUB TOTAL')!== FALSE){
							echo '<td style="border-top:2px solid #689DED; border-bottom: 2px solid #689DED; border-left:1px dotted #689DED; background-color:#DCE6F1;">'.number_format($acumCIF,2,',','.').'</td>';
						}else{
							echo '<td style="border-top: 1px dotted #689DED; border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED; border-right:2px solid #689DED;">'.number_format($acumCIF,2,',','.').'</td>';
						}
						echo '

					</tr>';

					$ai = $ai + 1;
					$acumUnidades = 0;
					$acumCIF = 0;
			}
		}
	?>
                </tbody>


            </table>
			</div>
			<?php  }?>

	<?php odbc_close( $conn );?>
