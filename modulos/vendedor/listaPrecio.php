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
$fcorteStock = $_GET['corteStock'];
$fmarca = $_GET['linea'];
$fproveedor = $_GET['proveedor'];
$ffin = $_GET['fin'];
$codbarra = $_GET['codbarra'];
$consultar = $_GET['agregar'];
$marca = '';

$cont = $_GET['cont'];
$tipoProducto = $_GET['tipoProducto'];
$areaNegocio = $_GET['areaNegocio'];
$tipoReporte = $_GET['tipoReporte'];

/*SQL SEGMENTO*/
$sqlSegmento = "SELECT DISTINCT Segmento FROM [SBO_Imp_Eximben_SAC].dbo.VIC_VW_ItemsVenta WHERE Marca = '".$fmarca."' and Segmento <> 'No Aplica'";
$rsseg = odbc_exec( $conn, $sqlSegmento );
if ( !$rsseg){
	exit( "Error en la consulta SQL" );
}
$segmento = '';
while($resultadoseg = odbc_fetch_array($rsseg)){
	if($segmento == ''){
		$segmento = $resultadoseg['Segmento'];
	}else{
		$segmento = $segmento.', '.$resultadoseg['Segmento'];
	}
}

/*SQL STATUS*/
$sqlSegmento = "SELECT DISTINCT Status FROM [SBO_Imp_Eximben_SAC].dbo.VIC_VW_ItemsVenta WHERE Marca = '".$fmarca."' and Segmento <> 'No Aplica'";
$rssta = odbc_exec( $conn, $sqlSegmento );
if ( !$rssta){
	exit( "Error en la consulta SQL" );
}
$status = '';
while($resultadosta = odbc_fetch_array($rssta)){
	if($status == ''){
		$status = $resultadosta['Status'];
	}else{
		$status = $status.', '.$resultadosta['Status'];
	}
}

/*SQL TIPO CAMBIO ACORDADO*/

$sqlTipoCambio = "SELECT AddID FROM SBO_Imp_Eximben_SAC.dbo.OCRD WHERE CardFName =  '".$fproveedor."'";
$rsTipo = odbc_exec( $conn, $sqlTipoCambio );
if ( !$rsTipo){
	exit( "Error en la consulta SQL" );
}
$resultadoTipo = odbc_fetch_array($rsTipo);
$tipoCambioAcordado = $resultadoTipo['AddID'];

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


			/*if ($tipoProducto)
					{
						$WtipoProducto = "  AND (TipoProducto LIKE '".$tipoProducto."') ";

					}*/

?>
<script type="text/javascript">
  $(document).ready(function(){
				//comienza focus en modulo
				$('#moduloid').focus();
				// calendarios en text de fecha inicio fin
				$( "#inicio" ).datepicker({
					dateFormat: 'yy-mm',
					//changeMonth: true,
					changeYear: true,

					showButtonPanel: true,

					onClose: function(dateText, inst) {
						//var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
						var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
						$(this).val($.datepicker.formatDate('yy', new Date(year, 1)));
					}
				} );
				$("#inicio").focus(function () {
					$(".ui-datepicker-calendar").hide();
					$(".ui-datepicker-month").hide();
					$("#ui-datepicker-div").position({
						my: "center top",
						at: "center bottom",
						of: $(this)
					});
				});
				//formatos de las fechas

				$( "#corteStock" ).datepicker({
					dateFormat: 'yy-mm',
					changeMonth: true,
					changeYear: true,

					showButtonPanel: true,

					onClose: function(dateText, inst) {
						var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
						var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
						$(this).val($.datepicker.formatDate('yy-mm', new Date(year,month, 1)));
					}
				} );
				$("#corteStock").focus(function () {
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
				
				$("#proveedor").change(function(){
					$("#cargaLinea").css('display','');
					$("#linea").css('display','none');
					var prov = $("#proveedor").val();
					var jsonProveedor = {
						proveedor : prov
					};
					$.post('modulos/vendedor/script/obtenerLinea.php',{jsonProveedor:jsonProveedor},function(resPHP){
						var res = $.parseJSON(resPHP);
							$("#linea").empty();
							$("#linea").append('<option value=""></option>');
						for(i=0;i<res.length;i++){
							$("#linea").append('<option value="'+res[i]['marca']+'">'+res[i]['marca']+'</option>');
						}
						$("#cargaLinea").css('display','none');
						$("#linea").css('display','');
					});
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

		echo'<form action="/sisap/clases/ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion">
			<center><img src="images/excel.png" width="30px" height="30px" class="botonExcel"  /> </center>
			<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
			</form> ';


		?>
		     <!-- <li><a href="../SISAP/modulos/vendedor/ventasproexcel.php?id=<?php //echo $vendedor; ?>&modulo=<?php // echo $modulo; ?>&inicio=<?php //echo $finicio2; ?>&fin=<?php // echo $ffin2; ?>&marca=<?php //echo $marca; ?>&codbarra=<?php //echo $codbarra; ?>"><img src="images/excel.png" width="30px" height="30px" /></a></li>-->
		<?php }?>
	 </ul>
      <div class="items">
        <div id="one"> <form action="" method="GET" id="horizontalForm">
	
			<!-- FORMULARIO PARA GENERACIÓN DE REPORTE -->
            <fieldset>
				<legend>Ingresar proveedor</legend>
					<input name="opc" type="hidden" id="opc" size="40" class="required" value="listaPrecio" />
						<label class="first" for="title1">
							Proveedor
							<select id="proveedor" name="proveedor" class="styled" >
								<option value=""></option>
								<?php
									$sql="SELECT DISTINCT Proveedor FROM SBO_Imp_Eximben_SAC.dbo.VIC_VW_ItemsVenta ORDER  BY Proveedor ASC";
									$rs = odbc_exec( $conn, $sql );
									if ( !$rs){
										exit( "Error en la consulta SQL" );
									}
									while($resultado = odbc_fetch_array($rs)){
										echo'
											<option value="'.$resultado['Proveedor'].'">'.$resultado['Proveedor'].'</option>
										';
									}
								?>
							</select>
				        </label>
						
						<label class="first" for="title1">
							Línea 
							<select id="linea" name="linea"  class="styled" width="30">
								<!--<option value=""></option>-->
							</select><br>
							<img id="cargaLinea" src="modulos/vendedor/images/loading3.gif" width="20" style="display:none;"/>
				        </label>
						
							   <!--<label class="first" for="title1">
									Tipo de reporte
									<select id="tipoReporte" name="tipoReporte"  class="styled" width="30">
										<option value=""></option>
										<option value="ReporteUno">Segmento: Selectivo - Status: Vigente, Nueva Marca, Potenciar</option>
										<option value="ReporteDos">Segmento: Semiselectivo - Status: Vigente, Nueva Marca, Potenciar</option>
										<option value="ReporteTres">Segmento: Masivo - Status: Vigente, Nueva Marca, Potenciar</option>
                                        <option value="ReporteCuatro">Segmento: Semiselectivo, Descontinuado, Selectivo, No Aplica, Masivo - Status : Liquidacion, Descontinuado, Museo</option>
										<option value="ReporteCinco">Infantil</option>
									</select>
				               </label>-->
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
				<tr></tr>
              	<tr>
					<th align="left" style="border-top: 1px solid #689DED; border-left: 1px solid #689DED;">Proveedor: <?php echo $fproveedor;?></th>
                	<th colspan="10" align="center" style="font-size:34px; border-top: 1px solid #689DED; border-right: 1px solid #689DED; "><?php echo $fmarca.' '.substr($finicio,6,9);?></th>
                </tr>
              </thead>
              <thead>
              	<tr>
					<th align="left" style="border-left: 1px solid #689DED;">Segmento: <?php echo $segmento;?></th>
                	<th colspan="10" align="center" style="font-size:14px; border-right: 1px solid #689DED;"><?php echo 'REPORTE COMERCIAL'; ?></th>
                </tr>
              </thead>
              <thead>
              	<tr>
					<th align="left" style="border-left: 1px solid #689DED;">Status: <?php echo $status;?></th>
                	<th colspan="10" align="center" style="font-size:24px;border-right: 1px solid #689DED; ">(3) Lista de precios - Area Comercial / Comité Ejecutivo</th>
                </tr>
              </thead>
			  <thead>
              	<tr>
					<th colspan="11" align="left" style="border-right:1px solid #689DED; border-left: 1px solid #689DED;">Tipo de cambio acordado: <?php echo $tipoCambioAcordado;?></th>
                </tr>
              </thead>
			   <thead>
              	<tr>
					<th colspan="11" align="left" style="border-bottom:1px solid #689DED; border-right:1px solid #689DED; border-left: 1px solid #689DED;">Periodo de informe: <?php echo date("Y");?></th>
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
					</tr>
			  </head>
			  
			<!--<thead>
				<tr>
                    <th style="border-top: 1px solid #689DED;"></th>
					<th style="border-top: 1px solid #689DED;"></th>
					<th style="border-top: 1px solid #689DED;"></th>
					<th style="border-top: 1px solid #689DED;"></th>
					<th style="border-top: 1px solid #689DED;"></th>
					<th style="border-top: 1px solid #689DED;"></th>
					<th style="border-top: 1px solid #689DED;"></th>
					<th style="border-top: 1px solid #689DED;"></th>
					<th colspan="3" style="border: 1px solid #689DED;">Unidades Vendidas Periodo <?php echo $finicio; ?></th>
					<th style="border-top: 1px solid #689DED;"></th>
					<th style="border-top: 1px solid #689DED;"></th>
					<th style="border-top: 1px solid #689DED;"></th>
					<th style="border-top: 1px solid #689DED;"></th>
					<th style="border-top: 1px solid #689DED;"></th>
					<!-- VALORES DE VENTA 2015 -->
					<!--<th colspan="3" style="border: 1px solid #689DED;">Valores de venta <?php echo $finicio; ?></th>
					
					<!-- STOCK EXIMBEN CIERRE 2015 -->
					<!--<th colspan="2" style="border: 1px solid #689DED;">Stock Eximben cierre <?php echo $finicio; ?></th>
					<th style="border-top: 1px solid #689DED;"></th>
					<th style="border-top: 1px solid #689DED;"></th>
					<th style="border-top: 1px solid #689DED;"></th>
					<th style="border-top: 1px solid #689DED;"></th>
					<th style="border-top: 1px solid #689DED;"></th>
					
				</tr>
			</head>  -->
			  
            <thead>
				<tr>
                    <th style="border-top: 1px solid #689DED;">LINEA</th>
					<th style="border-top: 1px solid #689DED;">REFERENCE</th>
					<th style="border-top: 1px solid #689DED;">DESCRIPTION</th>
					<th style="border-top: 1px solid #689DED;">SKU / EAN</th>
					<th style="border-top: 1px solid #689DED;">Tamaño ml</th>
					<th style="border-top: 1px solid #689DED;">Género</th>
					<th style="border-top: 1px solid #689DED;">Unidades por caja</th>
					<th style="border-top: 1px solid #689DED;">Precio Compra USD</th>
					<th style="border-top: 1px solid #689DED;">Precio DFS USD</th>
					<th style="border-top: 1px solid #689DED;">Precio Venta CLP Zofri</th>
					<th style="border-top: 1px solid #689DED;">Precio Venta CLP Aero</th>
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
	SELECT Linea as LINEA, Referencia, FrgnName as DESCRIPTION, ItemCode as SKU, [CapVolu], Status,
	CASE
		WHEN Genero = 'W'
			THEN 'Mujer'
		WHEN Genero = 'M'
			THEN 'Hombre'
		ELSE 'No Aplica'
	END AS Genero, [PrePacks], LPC_Precio, DFS_Precio, LPV_Precio, ((DFS_Precio * 1.1) * 520) AS LPV_Aero
	FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_VW_ItemsVenta]
	WHERE Proveedor = '".$fproveedor."' AND Marca = '".$fmarca."' AND TipoProducto = 'Producto Regular'
	ORDER BY Status DESC, PurFactor1, Linea, DFS_Precio DESC
";
	
	//$acumCIF = 0;
//echo $sql;
if($consultar!= ""){
	$rs = odbc_exec( $conn, $sql );
		if ( !$rs){
			exit( "Error en la consulta SQL" );
		}
		if($consultar){
			$repiteLinea = "";
			while($resultado = odbc_fetch_array($rs)){
				if("Descontinuado" == utf8_encode($resultado['Status'])){
					echo '<tr style="color:#F30;" >';
				}else{
					echo '<tr>';
				}
				if($repiteLinea == utf8_encode($resultado['LINEA'])){
					echo '<td></td>';
					echo '<td>'.utf8_encode($resultado['Referencia'])."&nbsp;".'</td>';
					echo '<td style="width:780px;">'.utf8_encode($resultado['DESCRIPTION']).'</td>';
					echo '<td style="text-align:center;">'.utf8_encode($resultado['SKU'])."&nbsp;".'</td>';
					echo '<td style="text-align:center;">'.number_format($resultado['CapVolu'],'0',',','.').'</td>';					
					echo '<td style="text-align:center;">'.utf8_encode($resultado['Genero']).'</td>';
					echo '<td>'.number_format($resultado['PrePacks'],'0',',','.').'</td>';
					echo '<td>'.number_format($resultado['LPC_Precio'],'2',',','.').'</td>';
					echo '<td>'.number_format($resultado['DFS_Precio'],'2',',','.').'</td>';
					echo '<td>'.number_format($resultado['LPV_Precio'],'0',',','.').'</td>';
					echo '<td>'.number_format($resultado['LPV_Aero'],'0',',','.').'</td>';
				}else{
					echo '<td style="border-top: 1px solid #689DED; text-align:center; font-weight:bold; font-size:16px;">'.utf8_encode($resultado['LINEA']).'</td>';
					echo '<td style="border-top: 1px solid #689DED;">'.utf8_encode($resultado['Referencia'])."&nbsp;".'</td>';
					echo '<td style="width:780px; border-top: 1px solid #689DED;">'.utf8_encode($resultado['DESCRIPTION']).'</td>';
					echo '<td style="border-top: 1px solid #689DED; text-align:center;">'.utf8_encode($resultado['SKU'])."&nbsp;".'</td>';
					echo '<td style="border-top: 1px solid #689DED; text-align:center;">'.number_format($resultado['CapVolu'],'0',',','.').'</td>';				
					echo '<td style="border-top: 1px solid #689DED; text-align:center;">'.utf8_encode($resultado['Genero']).'</td>';
					echo '<td style="border-top: 1px solid #689DED;">'.number_format($resultado['PrePacks'],'0',',','.').'</td>';
					echo '<td style="border-top: 1px solid #689DED;">'.number_format($resultado['LPC_Precio'],'2',',','.').'</td>';
					echo '<td style="border-top: 1px solid #689DED;">'.number_format($resultado['DFS_Precio'],'2',',','.').'</td>';
					echo '<td style="border-top: 1px solid #689DED;">'.number_format($resultado['LPV_Precio'],'0',',','.').'</td>';
					echo '<td style="border-top: 1px solid #689DED;">'.number_format($resultado['LPV_Aero'],'0',',','.').'</td>';
					$repiteLinea = utf8_encode($resultado['LINEA']);
				}
				echo '</tr>';
			}
		}
	?>
                </tbody>


            </table>
			</div>
			<?php  }
			?>

	<?php odbc_close( $conn );?>
