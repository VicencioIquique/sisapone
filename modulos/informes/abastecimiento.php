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
$proveedor = $_GET['proveedor'];
$ffin = $_GET['fin'];
$codbarra = $_GET['codbarra'];
$consultar = $_GET['agregar'];

$cont = $_GET['cont'];
$tipoProducto = $_GET['tipoProducto'];
$areaNegocio = $_GET['areaNegocio'];
$tipoReporte = $_GET['tipoReporte'];

/*SQL SEGMENTO*/
$sqlSegmento = "SELECT DISTINCT Segmento FROM [SBO_Imp_Eximben_SAC].dbo.VIC_VW_ItemsVenta WHERE Proveedor = '".$proveedor."' and Segmento <> 'No Aplica'";
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
$sqlSegmento = "SELECT DISTINCT Status FROM [SBO_Imp_Eximben_SAC].dbo.VIC_VW_ItemsVenta WHERE Proveedor = '".$proveedor."' and Segmento <> 'No Aplica'";
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

$sqlTipoCambio = "SELECT AddID FROM SBO_Imp_Eximben_SAC.dbo.OCRD WHERE CardFName =  '".$proveedor."'";
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
/*if($tipoReporte == 'ReporteUno'){
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
}*/
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
				<legend>Ingresar Fechas</legend>
					<input name="opc" type="hidden" id="opc" size="40" class="required" value="abastecimiento" />
                        <label for="fecha1">
				            Periodo
							<input name="inicio" type="text" id="inicio" size="40" class="required" />
                        </label>
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
							Tipo de producto
							<select id="tipoProducto" name="tipoProducto" class="styled" >
								<option value=""></option>
								<option value="R">Producto Regular</option>
								<option value="S">Sin valor Comercial</option>
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
				<tr></tr>
              	<tr>
					<th align="left" style="border-top: 1px solid #689DED; border-left: 1px solid #689DED;">Proveedor: <?php echo $proveedor;?></th>
                	<th colspan="12" align="center" style="font-size:34px; border-top: 1px solid #689DED; border-right: 1px solid #689DED; "><?php echo $proveedor.' '.$finicio;?></th>
                </tr>
              </thead>
              <thead>
              	<tr>
					<th align="left" style="border-left: 1px solid #689DED;">Segmento: <?php echo $segmento;?></th>
                	<th colspan="12" align="center" style="font-size:12px; border-right: 1px solid #689DED; "><?php echo 'Fecha emisión: '. date("m/d/Y"); ?> &nbsp;&nbsp;  - &nbsp;&nbsp;  Tipo de Producto: <?php if($tipoProducto == "R"){ echo "Producto Regular"; } elseif($tipoProducto == "S"){ echo "Sin valor comercial"; } else { echo "TODOS"; } ?></th>
                </tr>
              </thead>
              <thead>
              	<tr>
					<th align="left" style="border-left: 1px solid #689DED;">Status: <?php echo $status;?></th>
                	<th colspan="12" align="center" style="font-size:24px;border-right: 1px solid #689DED; ">(4) Reporte de Abastecimiento</th>
                </tr>
              </thead>
			   <thead>
              	<tr>
					<th colspan="13" align="left" style="border-right:1px solid #689DED; border-left: 1px solid #689DED;">Tipo de cambio acordado: <?php echo $tipoCambioAcordado;?></th>
                </tr>
              </thead>
			   <thead>
              	<tr>
					<th colspan="13" align="left" style="border-bottom:1px solid #689DED; border-right:1px solid #689DED; border-left: 1px solid #689DED;">Periodo de informe: <?php echo date("Y");?></th>
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
            <thead>
				<tr>
                    <th style="border-top: 1px solid #689DED;">Numero SAP</th>
					<th style="border-top: 1px solid #689DED;">Correlativo ZETA</th>
					<th style="border-top: 1px solid #689DED;">Numero de ZETA</th>
					<th style="border-top: 1px solid #689DED;">Numero Interno</th>
					<th style="border-top: 1px solid #689DED;">Proveedor</th>
					<th style="border-top: 1px solid #689DED;">Producto</th>
					<th style="border-top: 1px solid #689DED;">Monto Pedido</th>
					<th style="border-top: 1px solid #689DED;">Fecha Ingreso</th>
					<th style="border-top: 1px solid #689DED;">Valor Ingreso</th>
                    <th style="border-top: 1px solid #689DED;">Cantidad</th>
					<th style="border-top: 1px solid #689DED;">N° Factura Proveedor</th>
					<th style="border-top: 1px solid #689DED;">Monto CIF</th>
					<th style="border-top: 1px solid #689DED;">Fecha Factura</th>
				</tr>
			</head>
                <tbody>
                 <?php

if($proveedor!= ""){
	$where_query = " AND B.CardName LIKE '%".$proveedor."%'";
}
if($tipoProducto == "R"){
	$where_query = $where_query . " AND C.U_ZF_TIPITM <> 'S'";
}
if($tipoProducto == "S"){
	$where_query = $where_query . " AND C.U_ZF_TIPITM = 'S'";
}
$sql="
SELECT A.DocEntry 
      ,B.U_VIC_Correlativo AS [Correlativo]
      ,B.NumAtCard AS [Zeta]
      ,B.U_VIC_NumInterno AS [Numero]
      ,B.CardName AS [Proveedor]
      ,D.Name AS [Producto]
      ,B.U_VIC_MontoPedido AS [Pedido]
      ,REPLACE(STR(DAY(B.TaxDate),2,0),' ',0)+'/'+REPLACE(STR(MONTH(B.TaxDate),2,0),' ',0)+'/'+STR(YEAR(B.TaxDate),4,0)  AS [Fecha]
      ,SUM(A.TotalFrgn) AS [Valor]
	  ,SUM(A.Quantity) AS [Cantidad]
      ,B.U_VIC_NumeroFactura AS [Factura]
      ,SUM(A.TotalFrgn) AS [Monto]
      ,REPLACE(STR(DAY(B.U_VIC_FechaFactura),2,0),' ',0)+'/'+REPLACE(STR(MONTH(B.U_VIC_FechaFactura),2,0),' ',0)+'/'+STR(YEAR(B.U_VIC_FechaFactura),4,0)  AS [FechaFactura]
FROM [SBO_Imp_Eximben_SAC].[dbo].[PDN1] AS A
LEFT JOIN [SBO_Imp_Eximben_SAC].[dbo].[OPDN] AS B ON A.DocEntry = B.DocEntry
LEFT JOIN [SBO_Imp_Eximben_SAC].[dbo].[OITM] AS C ON A.ItemCode = C.ItemCode
LEFT JOIN [SBO_Imp_Eximben_SAC].[dbo].[@VK_OMAR] AS D ON C.U_VK_Marca = D.Code
WHERE B.U_VIC_TipoDoc IN ('01','06') AND A.TrgetEntry IS NULL AND B.TaxDate LIKE '%".$finicio."%' ". $where_query. "
GROUP BY A.DocEntry, D.Name, A.Currency, B.Comments, B.CardName, B.TaxDate, B.NumAtCard, B.U_VIC_Correlativo, B.U_VIC_NumInterno, B.U_VIC_MontoPedido, B.U_VIC_NumeroFactura, B.U_VIC_FechaFactura
ORDER BY B.TaxDate ASC
";
	$acumPedido = 0;
	$acumValor = 0;
    $acumMonto = 0;
//echo $sql;
if($consultar!= ""){
	$rs = odbc_exec( $conn, $sql );
		if ( !$rs){
			exit( "Error en la consulta SQL" );
		}
		if($consultar){
			$repiteLinea = "";
			while($resultado = odbc_fetch_array($rs)){
				echo '<tr>';
				if($repiteLinea == $resultado['DocEntry']){
					echo '<td></td>';
					echo '<td></td>';
					echo '<td></td>';
					echo '<td align="center"></td>';
					echo '<td align="center"></td>';
					echo '<td align="center">'.utf8_encode($resultado['Producto']).'</td>';
					echo '<td></td>';
					echo '<td align="center">'.utf8_encode($resultado['Fecha'])."&nbsp;".'</td>';
					echo '<td>'.number_format($resultado['Valor'],'2',',','.').'</td>';
					echo '<td>'.number_format($resultado['Cantidad'],'0',',','.').'</td>';
					echo '<td align="center">'.utf8_encode($resultado['Factura']).'</td>';
					echo '<td>'.number_format($resultado['Monto'],'2',',','.').'</td>';
					echo '<td align="center">'.utf8_encode($resultado['FechaFactura'])."&nbsp;".'</td>';
				}else{
					echo '<td style="border-top: 1px solid #689DED;">'.number_format($resultado['DocEntry'],'0','','').'</td>';
					echo '<td style="border-top: 1px solid #689DED;">'.$resultado['Correlativo'].'</td>';
					echo '<td style="border-top: 1px solid #689DED;">'.$resultado['Zeta'].'</td>';
					echo '<td style="border-top: 1px solid #689DED;" align="center">'.utf8_encode($resultado['Numero'])."&nbsp;".'</td>';
					echo '<td style="border-top: 1px solid #689DED;" align="center">'.utf8_encode($resultado['Proveedor'])."&nbsp;".'</td>';
					echo '<td style="border-top: 1px solid #689DED;" align="center">'.utf8_encode($resultado['Producto']).'</td>';
					echo '<td style="border-top: 1px solid #689DED;">'.number_format($resultado['Pedido'],'2',',','.').'</td>';
					echo '<td style="border-top: 1px solid #689DED;" align="center">'.utf8_encode($resultado['Fecha'])."&nbsp;".'</td>';
					echo '<td style="border-top: 1px solid #689DED;">'.number_format($resultado['Valor'],'2',',','.').'</td>';
					echo '<td style="border-top: 1px solid #689DED;">'.number_format($resultado['Cantidad'],'0',',','.').'</td>';
					echo '<td style="border-top: 1px solid #689DED;" align="center">'.utf8_encode($resultado['Factura']).'</td>';
					echo '<td style="border-top: 1px solid #689DED;">'.number_format($resultado['Monto'],'2',',','.').'</td>';
					echo '<td style="border-top: 1px solid #689DED;" align="center">'.utf8_encode($resultado['FechaFactura'])."&nbsp;".'</td>';

					$repiteLinea = $resultado['DocEntry'];
				}
				echo '</tr>';
				$acumPedido = $acumPedido + $resultado['Pedido'];
				$acumValor = $acumValor + $resultado['Valor'];
				$acumMonto = $acumMonto + $resultado['Monto'];
			}
			echo '<tr>';
				echo '<td style="border-top: 1px solid #689DED;"></td>';
				echo '<td style="border-top: 1px solid #689DED;"></td>';
				echo '<td style="border-top: 1px solid #689DED;"></td>';
				echo '<td style="border-top: 1px solid #689DED;"></td>';
				echo '<td style="border-top: 1px solid #689DED;"></td>';
				echo '<td style="border-top: 1px solid #689DED;"></td>';
				echo '<td style="border: 1px solid #689DED; font-weight: bold;">'.number_format($acumPedido,'2',',','.').'</td>';
				echo '<td style="border-top: 1px solid #689DED;"></td>';
				echo '<td style="border: 1px solid #689DED; font-weight: bold;">'.number_format($acumValor,'2',',','.').'</td>';
				echo '<td style="border-top: 1px solid #689DED;"></td>';
				echo '<td style="border-top: 1px solid #689DED;"></td>';
				echo '<td style="border: 1px solid #689DED; font-weight: bold;">'.number_format($acumMonto,'2',',','.').'</td>';
				echo '<td style="border-top: 1px solid #689DED;"></td>';
			echo '</tr>';
		}
	?>
                </tbody>
            </table>
			</div>
			<?php  }
			?>

	<?php odbc_close( $conn );?>
