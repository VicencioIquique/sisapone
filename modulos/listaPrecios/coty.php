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
		 <div id="dv">
            <table  id="ssptable2" class="lista" style="display:none;">
			<thead >

			  </head>
              <thead >
				<tr></tr>
              	<tr>
                	<th colspan="13" align="left" style="color:#FFF;font-size:18px; border-top: 1px solid #676767; border-right: 1px solid #676767; border-left: 1px solid #676767; background-color:#96b4d8; "><?php echo 'Lista de Precios COTY BEAUTY - Importaciones Eximben S.A.C.- Área Comercial / Comité Ejecutivo';?></th>
                </tr>
              </thead>
              <thead>
              	<tr>
                	<th colspan="13" align="left" style="color:#1f497d;font-size:14px; border-right: 1px solid #676767; border-left: 1px solid #676767; background-color:#96b4d8;"><?php echo 'Vigencia '.date("Y"); ?></th>
                </tr>
              </thead>
              <thead>
              	<tr>
                	<th colspan="13" align="left" style="color:#1f497d;font-size:12px; border-bottom:1px solid #676767; border-right: 1px solid #676767; border-left: 1px solid #FFF; background-color:#96b4d8;"><?php echo 'Marca : ' .$fmarca.' - Brand Manager: '.$vendedorSelect; ?></th>
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
                    <th style="border-top: 1px solid #676767;"></th>
					<th style="border-top: 1px solid #676767;"></th>
					<th style="border-top: 1px solid #676767;"></th>
					<th style="border-top: 1px solid #676767;"></th>
					<th style="border-top: 1px solid #676767;"></th>
					<th style="border-top: 1px solid #676767;"></th>
					<th style="border-top: 1px solid #676767;"></th>
					<th style="border-top: 1px solid #676767;"></th>
					<th colspan="3" style="border: 1px solid #676767;">Unidades Vendidas Periodo <?php echo $finicio; ?></th>
					<th style="border-top: 1px solid #676767;"></th>
					<th style="border-top: 1px solid #676767;"></th>
					<th style="border-top: 1px solid #676767;"></th>
					<th style="border-top: 1px solid #676767;"></th>
					<th style="border-top: 1px solid #676767;"></th>
					<!-- VALORES DE VENTA 2015 -->
					<!--<th colspan="3" style="border: 1px solid #676767;">Valores de venta <?php echo $finicio; ?></th>
					
					<!-- STOCK EXIMBEN CIERRE 2015 -->
					<!--<th colspan="2" style="border: 1px solid #676767;">Stock Eximben cierre <?php echo $finicio; ?></th>
					<th style="border-top: 1px solid #676767;"></th>
					<th style="border-top: 1px solid #676767;"></th>
					<th style="border-top: 1px solid #676767;"></th>
					<th style="border-top: 1px solid #676767;"></th>
					<th style="border-top: 1px solid #676767;"></th>
					
				</tr>
			</head>  -->
			  
            <thead>
				<tr style="color:#1f497d;">
                    <th style="border-top: 1px solid #676767; background-color:#dce6f1;">LINEA</th>
					<th style="border-top: 1px solid #676767;background-color:#dce6f1;">REFERENCE</th>
					<th style="border-top: 1px solid #676767;background-color:#dce6f1;">DESCRIPTION</th>
					<th style="border-top: 1px solid #676767;background-color:#dce6f1;">SKU / EAN</th>
					<th style="border-top: 1px solid #676767;background-color:#dce6f1;">Tamaño ml</th>
					<th style="border-top: 1px solid #676767;background-color:#dce6f1;">Segmento</th>
					<th style="border-top: 1px solid #676767;background-color:#dce6f1;">Género</th>
					<th style="border-top: 1px solid #676767;background-color:#dce6f1;">Estatus</th>
					<th style="border-top: 1px solid #676767;background-color:#dce6f1;">Unidades por caja</th>
					<th style="border-top: 1px solid #676767;background-color:#dce6f1;">Precio Compra USD</th>
					<th style="border-top: 1px solid #676767;background-color:#dce6f1;">Precio DFS USD</th>
					<th style="border-top: 1px solid #676767;background-color:#dce6f1;">Precio Venta CLP Zofri</th>
					<th style="border-top: 1px solid #676767;background-color:#dce6f1;">Precio Venta CLP Aero</th>
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
	SELECT Linea as LINEA, Referencia, ItemName as DESCRIPTION, ItemCode as SKU, [CapVolu], Segmento, 
	CASE
		WHEN Genero = 'W'
			THEN 'Mujer'
		WHEN Genero = 'M'
			THEN 'Hombre'
		ELSE 'No Aplica'
	END AS Genero, [Status], [PrePacks], LPC_Precio, DFS_Precio, LPV_Precio, ((DFS_Precio * 1.1) * 520) AS LPV_Aero
	FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_VW_ItemsVenta]
	WHERE Proveedor = '".$fproveedor."' AND Marca = '".$fmarca."' AND TipoProducto = 'Producto Regular'
	ORDER BY Linea, DFS_Precio DESC
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
				echo '<tr>';
				if($repiteLinea == utf8_encode($resultado['LINEA'])){
					echo '<td  ></td>';
					echo '<td>'.utf8_encode($resultado['Referencia'])."&nbsp;".'</td>';
					echo '<td style="width:780px;">'.utf8_encode($resultado['DESCRIPTION']).'</td>';
					echo '<td style="text-align:center;">'.utf8_encode($resultado['SKU'])."&nbsp;".'</td>';
					echo '<td style="text-align:center;">'.number_format($resultado['CapVolu'],'0',',','.').'</td>';
					echo '<td style="text-align:center;">'.utf8_encode($resultado['Segmento']).'</td>';
					echo '<td style="text-align:center;">'.utf8_encode($resultado['Genero']).'</td>';
					echo '<td style="text-align:center;">'.utf8_encode($resultado['Status']).'</td>';
					echo '<td>'.number_format($resultado['PrePacks'],'0',',','.').'</td>';
					echo '<td>'.number_format($resultado['LPC_Precio'],'2',',','.').'</td>';
					echo '<td>'.number_format($resultado['DFS_Precio'],'2',',','.').'</td>';
					echo '<td>'.number_format($resultado['LPV_Precio'],'0',',','.').'</td>';
					echo '<td>'.number_format($resultado['LPV_Aero'],'0',',','.').'</td>';
				}else{
					echo '<td style="border-top: 1px solid #676767; text-align:center; font-weight:bold; font-size:16px; background-color:#ffff99;">'.utf8_encode($resultado['LINEA']).'</td>';
					echo '<td style="border-top: 1px solid #676767;">'.utf8_encode($resultado['Referencia'])."&nbsp;".'</td>';
					echo '<td style="width:780px; border-top: 1px solid #676767;">'.utf8_encode($resultado['DESCRIPTION']).'</td>';
					echo '<td style="border-top: 1px solid #676767; text-align:center;">'.utf8_encode($resultado['SKU'])."&nbsp;".'</td>';
					echo '<td style="border-top: 1px solid #676767; text-align:center;">'.number_format($resultado['CapVolu'],'0',',','.').'</td>';
					echo '<td style="border-top: 1px solid #676767; text-align:center;">'.utf8_encode($resultado['Segmento']).'</td>';
					echo '<td style="border-top: 1px solid #676767; text-align:center;">'.utf8_encode($resultado['Genero']).'</td>';
					echo '<td style="border-top: 1px solid #676767; text-align:center;">'.utf8_encode($resultado['Status']).'</td>';
					echo '<td style="border-top: 1px solid #676767;">'.number_format($resultado['PrePacks'],'0',',','.').'</td>';
					echo '<td style="border-top: 1px solid #676767;">'.number_format($resultado['LPC_Precio'],'2',',','.').'</td>';
					echo '<td style="border-top: 1px solid #676767;">'.number_format($resultado['DFS_Precio'],'2',',','.').'</td>';
					echo '<td style="border-top: 1px solid #676767;">'.number_format($resultado['LPV_Precio'],'0',',','.').'</td>';
					echo '<td style="border-top: 1px solid #676767;">'.number_format($resultado['LPV_Aero'],'0',',','.').'</td>';
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
