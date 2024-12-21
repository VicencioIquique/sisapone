<script type="text/javascript" src="modulos/vendedor/js/jquery.base64.js"></script>
<script type="text/javascript" src="modulos/vendedor/js/jquery.btechco.excelexport.js"></script>

<script type="text/javascript" src="modulos/caja/js/jspdf.js"></script>
<!--<script type="text/javascript" src="modulos/caja/js/jspdf.plugin.table.js"></script>
<script type="text/javascript" src="modulos/caja/js/jspdf.plugin.cell.js"></script>-->
<script type="text/javascript" src="modulos/caja/js/FileSaver.js"></script>

<style>
	
</style>
<?php
session_start();
require_once("clases/conexionocdb.php");
ini_set('max_execution_time', 600); //300 seconds = 5 minutes
$vendedor = $_GET['id'];
$vendedorSelect = $_GET['id'];

//$vendedor = str_pad($vendedor, 3, '0', 'STR_PAD_LEFT');
$fecha = $_GET['datepicker'];
$ffin = $_GET['fin'];
$codbarra = $_GET['codbarra'];
$consultar = $_GET['agregar'];
$marca = '';

$workstation = $_GET['caja'];
$bodega = $_GET['modulo'];

$cont = $_GET['cont'];
$tipoProducto = $_GET['tipoProducto'];
$areaNegocio = $_GET['areaNegocio'];
$tipoReporte = $_GET['tipoReporte'];


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
			
				/*$("#descargarExcel").click(function(){
					alert("gola");
					var doc = new jsPDF();
					var specialElementHandlers = {
						
					};
									
					doc.fromHTML($('#dv').html(), 15, 15, {
						'width': 800,
							'elementHandlers': specialElementHandlers
					})
					doc.save('sample-file.pdf');
				});*/

            });
			
			
</script>
<script language="javascript">
$(document).ready(function() {
     $("#descargarExcel").click(function(){
		var doc = new jsPDF('l','pt','letter');
		var fontSize = 8;
		
		doc.setFont("times", "normal");
		doc.setFontSize(fontSize);
		//ENCABEZADO REPORTE//
		doc.text(20, 20, "CAJA: "); // Y ; X -> la wea rara
		var workstation = '<?php if($workstation == '3'){echo '3';}else{echo $workstation;}?>';
		doc.text(45, 20, workstation);
		
		doc.text(20, 30, "MODULO:");
		var bodega = '<?php 
		if($bodega == '000'){
			echo '2077';
		}else if($bodega == '001'){
			echo '1010';
		}else if($bodega == '002'){
			echo '1132';
		}else if($bodega == '003'){
			echo '181';
		}else if($bodega == '004'){
			echo '184';
		}else if($bodega == '005'){
			echo '2002';
		}else if($bodega == '006'){
			echo '6115';
		}else if($bodega == '007'){
			echo '6130';
		}else if($bodega == '008'){
			echo '2077';
		}
		?>';
		doc.text(60, 30, bodega);
		
		doc.text(350, 30, "INFORME DE CAJA - ");
		var usuario = '<?php echo $_SESSION['usuario_nombre'];?>';
		doc.text(430, 30, usuario);
		
		doc.text(20, 40, "DIA DE INFORME:");
		var dia = '<?php echo $fecha;?>';
		doc.text(90, 40, dia);
		//FIN ENCABEZADO REPORTE//
		
		//CABECERA REPORTE//
		doc.setFont("times", "bold");
		doc.text(20, 80, "Tipo de documento");
		doc.text(100, 80, "Numero de documento");
		doc.text(200, 80, "Numero SAP");
		doc.text(265, 80, "Total");
		doc.text(310, 80, "Monto efectivo");
		doc.text(380, 80, "Monto debito");
		doc.text(450, 80, "Monto credito");
		doc.text(520, 80, "Monto cheque");
		doc.text(600, 80, "Monto cheque a fecha");
		doc.text(700, 80, "Monto credito tienda");
		//FIN CABECERA REPORTE//
		
		//VALORES DEL REPORTE//
		doc.setFont("times", "normal");
		var alto = 90;
		var table = $("#ssptable2").get(0);
		var largo = table.rows.length;
		for(var i=5;i<largo;i++){
			if((i != 0) && (i%50 == 0)){
				doc.addPage();
				//CABECERA REPORTE//
				doc.setFont("times", "bold");
				doc.text(20, 20, "Tipo de documento");
				doc.text(100, 20, "Numero de documento");
				doc.text(200, 20, "Numero SAP");
				doc.text(265, 20, "Total");
				doc.text(310, 20, "Monto efectivo");
				doc.text(380, 20, "Monto debito");
				doc.text(450, 20, "Monto credito");
				doc.text(520, 20, "Monto cheque");
				doc.text(600, 20, "Monto cheque a fecha");
				doc.text(700, 20, "Monto credito tienda");
				//FIN CABECERA REPORTE//
				alto = 35;
			}
			var tableRow = table.rows[i];
			if(tableRow.cells[0].innerHTML == 'Sub total'){
				doc.setFont("times", "bold");
			}else if(tableRow.cells[0].innerHTML == 'Totales'){
				doc.setFont("times", "bold");
				doc.setFontSize(10);
			}else{
				doc.setFont("times", "normal");	
			}
			doc.text(20, alto, tableRow.cells[0].innerHTML);
			doc.text(100, alto, tableRow.cells[1].innerHTML);
			doc.text(200, alto, tableRow.cells[2].innerHTML);
			doc.text(265, alto, tableRow.cells[3].innerHTML);
			doc.text(310, alto, tableRow.cells[4].innerHTML);
			doc.text(380, alto, tableRow.cells[5].innerHTML);
			doc.text(450, alto, tableRow.cells[6].innerHTML);
			doc.text(520, alto, tableRow.cells[7].innerHTML);
			doc.text(600, alto, tableRow.cells[8].innerHTML);
			doc.text(700, alto, tableRow.cells[9].innerHTML);
			alto = alto +10;
		}
		//FIN DE VALORES DEL REPORTE//
		doc.save('reporte caja '+'<?php echo $fecha;?>'+'.pdf');
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
				
				$("#modulo").change(function(){
					var modulo = $("#modulo").val();
					if(modulo == '000'){
						$("#caja").empty();
						$("#caja").append('<option value=""> </option>');
						$("#caja").append('<option value="1">1</option>');
					}else if(modulo == '001'){
						$("#caja").empty();
						$("#caja").append('<option value=""> </option>');
						$("#caja").append('<option value="1">1</option>');
						$("#caja").append('<option value="2">2</option>');
					}else if(modulo == '002'){
						$("#caja").empty();
						$("#caja").append('<option value=""> </option>');
						$("#caja").append('<option value="1">1</option>');
						$("#caja").append('<option value="2">2</option>');
						$("#caja").append('<option value="3">3</option>');
						$("#caja").append('<option value="4">4</option>');
						$("#caja").append('<option value="5">5</option>');
						$("#caja").append('<option value="6">6</option>');
						$("#caja").append('<option value="9">9</option>');
					}else if(modulo == '003'){
						$("#caja").empty();
						$("#caja").append('<option value=""> </option>');
						$("#caja").append('<option value="1">1</option>');
					}else if(modulo == '004'){
						$("#caja").empty();
						$("#caja").append('<option value=""> </option>');
						$("#caja").append('<option value="1">1</option>');
						$("#caja").append('<option value="2">2</option>');
					}else if(modulo == '005'){
						$("#caja").empty();
						$("#caja").append('<option value=""> </option>');
						$("#caja").append('<option value="3">3</option>');
						$("#caja").append('<option value="2">2</option>');
					}else if(modulo == '006'){
						$("#caja").empty();
						$("#caja").append('<option value=""> </option>');
						$("#caja").append('<option value="1">1</option>');
						$("#caja").append('<option value="2">2</option>');
					}else if(modulo == '007'){
						$("#caja").empty();
						$("#caja").append('<option value=""> </option>');
						$("#caja").append('<option value="1">1</option>');
						$("#caja").append('<option value="2">2</option>');
					}else if(modulo == '008'){
						$("#caja").empty();
						$("#caja").append('<option value=""> </option>');
						$("#caja").append('<option value="1">1</option>');
						$("#caja").append('<option value="2">2</option>');
						$("#caja").append('<option value="3">3</option>');
					}
				});
				$( "#datepicker" ).datepicker({
					dateFormat: 'yy-mm-dd',
					changeMonth: false,
					changeYear: false,
					showButtonPanel: false
				} );
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
		<img src="images/export_pdf.jpg" id="descargarExcel" style="display: block; margin-left: auto; margin-right: auto;"/>
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
	
			<!-- FORMULARIO PARA GENERACIÓN DE REPORTE -->
            <fieldset>
				<legend>Ingresar fecha</legend>
					<input name="opc" type="hidden" id="opc" size="40" class="required" value="reporteCajaCont" />
						<label class="first" for="title1">
							Fecha cierre de caja 
							<input type="text" id="datepicker" name="datepicker"/>
				        </label>
						<label class="first" for="title1">
							Módulo
							<select id="modulo" style="width:120px;" name="modulo">
								<option value=""></option>
								<option value="003">181</option>
								<option value="004">184</option>
								<option value="001">1010</option>
								<option value="002">1132</option>
								<option value="005">2002</option>
								<!--<option value="000">2077</option>-->
								<option value="008">2077</option>
								<option value="006">6115</option>
								<option value="007">6130</option>
							</select>
				        </label>
						<label class="first" for="title1">
							Caja
							<select id="caja" style="width:90px;" name="caja">
							</select>
				        </label>
						<input name="cont" type="hidden" id="cont" size="40" class="required" value="1" />
                        <input style="clear:initial;" name="agregar" type="submit" id="agregar" class="submit" value="Aceptar" />
						

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
					<th colspan="9" align="left" style="border: 1px solid black;">CAJA: <?php echo $workstation;?></th>
                	<th colspan="8" align="center" style="font-size:34px; border-top: 1px solid #689DED; border-right: 1px solid #689DED;"><?php echo $fmarca.' '.substr($finicio,6,9);?></th>
                </tr>
              </thead>
              <thead>
              	<tr>
					<th align="left" style="border-left: 1px solid #689DED;">MÓDULO: 
					<?php  
						if($bodega=='000'){
							echo '2077';
						}else if($bodega =='001'){
							echo '1010';
						}else if($bodega =='002'){
							echo '1132';
						}else if($bodega =='003'){
							echo '181';
						}else if($bodega =='004'){
							echo '184';
						}else if($bodega =='005'){
							echo '2002';
						}else if($bodega =='006'){
							echo '6115';
						}else if($bodega =='007'){
							echo '6130';
						}
					?>
				</th>
                	<th colspan="8" align="center" style="font-size:14px; border-right: 1px solid #689DED;"><?php echo 'INFORME DE CAJA - ' . $_SESSION['usuario_nombre']; ?></th>
                </tr>
              </thead>
			   <thead>
              	<tr>
					<th colspan="9" align="left" style="border-bottom:1px solid #689DED; border-right:1px solid #689DED; border-left: 1px solid #689DED;">Día de informe: <?php echo $fecha;?></th>
                </tr>
              </thead>
			 <thead>
					<tr>
						<th colspan="9"></th>
					</tr>
			  </head>
			  
			
            <thead>
				<tr>
					<th style="border-top: 1px solid #689DED;">Tipo de documento</th>
                    <th style="border-top: 1px solid #689DED;">Número de documento</th>
					<th style="border-top: 1px solid #689DED;">Total</th>
					<th style="border-top: 1px solid #689DED;">Monto efectivo</th>
					<th style="border-top: 1px solid #689DED;">Monto débito</th>
					<th style="border-top: 1px solid #689DED;">Monto crédito</th>
					<th style="border-top: 1px solid #689DED;">Monto cheque</th>
					<th style="border-top: 1px solid #689DED;">Monto cheque a fecha</th>
					<th style="border-top: 1px solid #689DED;">Monto crédito tienda</th>
				</tr>
			</head>
                <tbody>
                 <?php
				 if($bodega == '000'){
					$sql="
						SELECT Tabla.* FROM 
						(SELECT 
							T1.WorkStation, 
							T1.TipoDocto, 
							T1.NumeroDocto, 
							CASE WHEN T3.DocNum IS NULL THEN 'Pendiente' ELSE CONVERT(CHAR(10),T3.DocNum) END as DocNum,
							T1.Total, 
							ISNULL((SELECT SUM(Monto) FROM RP_VICENCIO.dbo.RP_ReceiptsPagos_SAP as T3 WHERE TipoPago = 'Cash' AND T1.ID = T3.ID GROUP BY TipoPago),'0') as Monto_Cash,
							ISNULL((SELECT SUM(Monto) FROM RP_VICENCIO.dbo.RP_ReceiptsPagos_SAP as T3 WHERE TipoPago = 'DebitCard' AND T1.ID = T3.ID GROUP BY TipoPago),'0') as Monto_DebitCard,
							ISNULL((SELECT SUM(Monto) FROM RP_VICENCIO.dbo.RP_ReceiptsPagos_SAP as T3 WHERE TipoPago = 'CreditCard' AND T1.ID = T3.ID GROUP BY TipoPago),'0') as Monto_CreditCard,
							ISNULL((SELECT SUM(Monto) FROM RP_VICENCIO.dbo.RP_ReceiptsPagos_SAP as T3 WHERE TipoPago = 'Check' AND T1.ID = T3.ID GROUP BY TipoPago),'0') as Monto_Check,
							ISNULL((SELECT SUM(Monto) FROM RP_VICENCIO.dbo.RP_ReceiptsPagos_SAP as T3 WHERE TipoPago = 'Payments' AND T1.ID = T3.ID GROUP BY TipoPago),'0') as Monto_Payments,
							ISNULL((SELECT SUM(Monto) FROM RP_VICENCIO.dbo.RP_ReceiptsPagos_SAP as T3 WHERE TipoPago = 'CreditStore' AND T1.ID = T3.ID GROUP BY TipoPago),'0') as Monto_StoreCredit
							
						FROM RP_VICENCIO.dbo.RP_ReceiptsCab_SAP as T1
						LEFT JOIN RP_VICENCIO.dbo.RP_ReceiptsPagos_SAP as T2 ON T1.ID = T2.ID
						LEFT JOIN SBO_Inv_Servimex.dbo.OINV T3 ON T1.BaseEntry = T3.DocEntry
						WHERE 
							T1.FechaDocto > '".$fecha." 00:00:00' AND 
							T1.FechaDocto < '".$fecha." 23:59:59' AND 
							T1.Bodega = '".$bodega."' AND 
							T1.Workstation = '".$workstation."'AND
							T1.TipoDocto <> '99'
						) as Tabla

						GROUP BY Tabla.Workstation, Tabla.TipoDocto, Tabla.NumeroDocto, Tabla.DocNum, Tabla.Total, Tabla.Monto_Cash, Tabla.Monto_DebitCard, Tabla.Monto_CreditCard, Tabla.Monto_Check, Tabla.Monto_Payments, Tabla.Monto_StoreCredit
						ORDER BY Tabla.TipoDocto, Tabla.NumeroDocto ASC 
					";
				 }else{
					$sql="
						SELECT Tabla.* FROM 
						(SELECT 
							T1.WorkStation, 
							T1.TipoDocto, 
							T1.NumeroDocto, 
							CASE WHEN T3.DocNum IS NULL THEN 'Pendiente' ELSE CONVERT(CHAR(10),T3.DocNum) END as DocNum,
							T1.Total, 
							ISNULL((SELECT SUM(Monto) FROM RP_VICENCIO.dbo.RP_ReceiptsPagos_SAP as T3 WHERE TipoPago = 'Cash' AND T1.ID = T3.ID GROUP BY TipoPago),'0') as Monto_Cash,
							ISNULL((SELECT SUM(Monto) FROM RP_VICENCIO.dbo.RP_ReceiptsPagos_SAP as T3 WHERE TipoPago = 'DebitCard' AND T1.ID = T3.ID GROUP BY TipoPago),'0') as Monto_DebitCard,
							ISNULL((SELECT SUM(Monto) FROM RP_VICENCIO.dbo.RP_ReceiptsPagos_SAP as T3 WHERE TipoPago = 'CreditCard' AND T1.ID = T3.ID GROUP BY TipoPago),'0') as Monto_CreditCard,
							ISNULL((SELECT SUM(Monto) FROM RP_VICENCIO.dbo.RP_ReceiptsPagos_SAP as T3 WHERE TipoPago = 'Check' AND T1.ID = T3.ID GROUP BY TipoPago),'0') as Monto_Check,
							ISNULL((SELECT SUM(Monto) FROM RP_VICENCIO.dbo.RP_ReceiptsPagos_SAP as T3 WHERE TipoPago = 'Payments' AND T1.ID = T3.ID GROUP BY TipoPago),'0') as Monto_Payments,
							ISNULL((SELECT SUM(Monto) FROM RP_VICENCIO.dbo.RP_ReceiptsPagos_SAP as T3 WHERE TipoPago = 'CreditStore' AND T1.ID = T3.ID GROUP BY TipoPago),'0') as Monto_StoreCredit
							
						FROM RP_VICENCIO.dbo.RP_ReceiptsCab_SAP as T1
						LEFT JOIN RP_VICENCIO.dbo.RP_ReceiptsPagos_SAP as T2 ON T1.ID = T2.ID
						LEFT JOIN SBO_Imp_Eximben_SAC.dbo.OINV T3 ON T1.BaseEntry = T3.DocEntry
						WHERE 
							T1.FechaDocto > '".$fecha." 00:00:00' AND 
							T1.FechaDocto < '".$fecha." 23:59:59' AND 
							T1.Bodega = '".$bodega."' AND 
							T1.Workstation = '".$workstation."' AND
							T1.TipoDocto <> '99'
						) as Tabla

						GROUP BY Tabla.Workstation, Tabla.TipoDocto, Tabla.NumeroDocto, Tabla.DocNum, Tabla.Total, Tabla.Monto_Cash, Tabla.Monto_DebitCard, Tabla.Monto_CreditCard, Tabla.Monto_Check, Tabla.Monto_Payments, Tabla.Monto_StoreCredit
						ORDER BY Tabla.TipoDocto, Tabla.NumeroDocto ASC 
					";
				 }
	
	//$acumCIF = 0;
//echo $sql;

	$sql2 = "
		SELECT Tabla.* FROM
		(
			SELECT 
				(SELECT TOP 1 NumeroDocto FROM RP_VICENCIO.dbo.RP_ReceiptsCab_SAP WHERE TipoDocto = '1' AND FechaDocto > DATEADD(day,-1,'".$fecha." 00:00:00') AND FechaDocto < DATEADD(day,-1,'".$fecha." 23:59:59') AND Bodega = '".$bodega."' AND Workstation = '".$workstation."' ORDER BY NumeroDocto DESC) as Tipo1,
				(SELECT TOP 1 NumeroDocto FROM RP_VICENCIO.dbo.RP_ReceiptsCab_SAP WHERE TipoDocto = '2' AND FechaDocto > DATEADD(day,-1,'".$fecha." 00:00:00') AND FechaDocto < DATEADD(day,-1,'".$fecha." 23:59:59') AND Bodega = '".$bodega."' AND Workstation = '".$workstation."' ORDER BY NumeroDocto DESC) as Tipo2,
				(SELECT TOP 1 NumeroDocto FROM RP_VICENCIO.dbo.RP_ReceiptsCab_SAP WHERE TipoDocto = '3' AND FechaDocto > DATEADD(day,-1,'".$fecha." 00:00:00') AND FechaDocto < DATEADD(day,-1,'".$fecha." 23:59:59') AND Bodega = '".$bodega."' AND Workstation = '".$workstation."' ORDER BY NumeroDocto DESC) as Tipo3,
				(SELECT TOP 1 NumeroDocto FROM RP_VICENCIO.dbo.RP_ReceiptsCab_SAP WHERE TipoDocto = '4' AND FechaDocto > DATEADD(day,-1,'".$fecha." 00:00:00') AND FechaDocto < DATEADD(day,-1,'".$fecha." 23:59:59') AND Bodega = '".$bodega."' AND Workstation = '".$workstation."' ORDER BY NumeroDocto DESC) as Tipo4,
				(SELECT TOP 1 NumeroDocto FROM RP_VICENCIO.dbo.RP_ReceiptsCab_SAP WHERE TipoDocto = '5' AND FechaDocto > DATEADD(day,-1,'".$fecha." 00:00:00') AND FechaDocto < DATEADD(day,-1,'".$fecha." 23:59:59') AND Bodega = '".$bodega."' AND Workstation = '".$workstation."' ORDER BY NumeroDocto DESC) as Tipo5,
				(SELECT TOP 1 NumeroDocto FROM RP_VICENCIO.dbo.RP_ReceiptsCab_SAP WHERE TipoDocto = '99' AND FechaDocto > DATEADD(day,-1,'".$fecha." 00:00:00') AND FechaDocto < DATEADD(day,-1,'".$fecha." 23:59:59') AND Bodega = '".$bodega."' AND Workstation = '".$workstation."' ORDER BY NumeroDocto DESC) as Tipo99
			FROM RP_VICENCIO.dbo.RP_ReceiptsCab_SAP
			WHERE FechaDocto > DATEADD(day,-1,'".$fecha." 00:00:00') AND
					FechaDocto < DATEADD(day,-1,'".$fecha." 23:59:59')
		) as Tabla
		GROUP BY Tabla.Tipo1, Tabla.Tipo2, Tabla.Tipo3, Tabla.Tipo4, Tabla.Tipo5, Tabla.Tipo99
	";

	//echo $sql2;

	$rs2 = odbc_exec( $conn, $sql2 );
	if(!$rs2){
		exit( "Error en la consulta SQL" );
	}
	$resultado2 = odbc_fetch_array($rs2);
	
if($consultar!= ""){
	$rs = odbc_exec( $conn, $sql );
		if ( !$rs){
			exit( "Error en la consulta SQL" );
		}
		if($consultar){
			$acumTotal = 0;
			$acumMonto_Cash = 0;
			$acumMonto_DebitCard = 0;
			$acumMonto_CreditCard = 0;
			$acumMonto_Check = 0;
			$acumMonto_Payments = 0;
			$acumMonto_StoreCredit = 0;
			
			$acumMontoCreditCard_StoreCredit=0;
			$acumMontoCheck_Payments=0;
			$numeroDoctoAnt="";
			$tipoDoctoAnt="";
			$contFolioAnterior = 0;
			$tipoDoctoAnte = "";
			
			//ACUMULADORES NOTAS DE CRÉDITO
			$acumNotaCreditoCash = 0;
			$acumNotaCreditoStore = 0;
			$acumNotaCreditoTotal = 0;
			
			//ACUMULADORES SUB Totales
			$acumSubTotal = 0;
			$acumSubMonto_Cash = 0;
			$acumSubMonto_DebitCard = 0;
			$acumSubMonto_CreditCard = 0;
			$acumSubMonto_Check = 0;
			$acumSubMonto_Payments = 0;
			$acumSubMonto_StoreCredit = 0;
			//FIN ACUMULADORES SUB Totales
			while($resultado = odbc_fetch_array($rs)){
				if($tipoDoctoAnt==""){
					
				}else if($tipoDoctoAnt == $resultado['TipoDocto']){
					
				}else{
					$numeroDoctoAnt="";
				}
				//COMPROBAR SI HAY SALTO DE FOLIO CON EL ULTIMO DOCUMENTO DEL DÍA ANTERIOR//
				if($contFolioAnterior == 0){
					if($resultado['TipoDocto'] == '1'){
						if((($resultado['NumeroDocto']-1)!=$resultado2['Tipo1'])&&($resultado2['Tipo1']!=NULL)){
							echo '<tr>';
								echo'<td style="color:#ff0000; text-align:right;">SALTO DE FOLIO</td>';
								echo'<td style="text-align:center;">-</td>';
								echo'<td style="text-align:center;">-</td>';
								echo'<td style="text-align:center;">-</td>';
								echo'<td style="text-align:center;">-</td>';
								echo'<td style="text-align:center;">-</td>';
								echo'<td style="text-align:center;">-</td>';
								echo'<td style="text-align:center;">-</td>';
								echo'<td style="text-align:center;">-</td>';
								echo'<td style="text-align:center;">-</td>';
							echo '</tr>';
						}
					}else if($resultado['TipoDocto'] == '2'){
						if((($resultado['NumeroDocto']-1)!=$resultado2['Tipo2'])&&($resultado2['Tipo2']!=NULL)){
							echo '<tr>';
								echo'<td style="color:#ff0000; text-align:right;">SALTO DE FOLIO</td>';
								echo'<td style="text-align:center;">-</td>';
								echo'<td style="text-align:center;">-</td>';
								echo'<td style="text-align:center;">-</td>';
								echo'<td style="text-align:center;">-</td>';
								echo'<td style="text-align:center;">-</td>';
								echo'<td style="text-align:center;">-</td>';
								echo'<td style="text-align:center;">-</td>';
								echo'<td style="text-align:center;">-</td>';
								echo'<td style="text-align:center;">-</td>';
							echo '</tr>';
						}else if($resultado2['Tipo2'] == 'NULL'){
							
						}
					}else if($resultado['TipoDocto'] == '3'){
						if((($resultado['NumeroDocto']-1)!=$resultado2['Tipo3'])&&($resultado2['Tipo3']!=NULL)){
							echo '<tr>';
								echo'<td style="color:#ff0000; text-align:right;">SALTO DE FOLIO</td>';
								echo'<td style="text-align:center;">-</td>';
								echo'<td style="text-align:center;">-</td>';
								echo'<td style="text-align:center;">-</td>';
								echo'<td style="text-align:center;">-</td>';
								echo'<td style="text-align:center;">-</td>';
								echo'<td style="text-align:center;">-</td>';
								echo'<td style="text-align:center;">-</td>';
								echo'<td style="text-align:center;">-</td>';
								echo'<td style="text-align:center;">-</td>';
							echo '</tr>';
						}
					}else if($resultado['TipoDocto'] == '4'){
						if((($resultado['NumeroDocto']-1)!=$resultado2['Tipo4'])&&($resultado2['Tipo4']!=NULL)){
							echo '<tr>';
								echo'<td style="color:#ff0000; text-align:right;">SALTO DE FOLIO</td>';
								echo'<td style="text-align:center;">-</td>';
								echo'<td style="text-align:center;">-</td>';
								echo'<td style="text-align:center;">-</td>';
								echo'<td style="text-align:center;">-</td>';
								echo'<td style="text-align:center;">-</td>';
								echo'<td style="text-align:center;">-</td>';
								echo'<td style="text-align:center;">-</td>';
								echo'<td style="text-align:center;">-</td>';
								echo'<td style="text-align:center;">-</td>';
							echo '</tr>';
						}
					}else if($resultado['TipoDocto'] == '4'){
						if((($resultado['NumeroDocto']-1)!=$resultado2['Tipo5'])&&($resultado2['Tipo5']!=NULL)){
							echo '<tr>';
								echo'<td style="color:#ff0000; text-align:right;">SALTO DE FOLIO</td>';
								echo'<td style="text-align:center;">-</td>';
								echo'<td style="text-align:center;">-</td>';
								echo'<td style="text-align:center;">-</td>';
								echo'<td style="text-align:center;">-</td>';
								echo'<td style="text-align:center;">-</td>';
								echo'<td style="text-align:center;">-</td>';
								echo'<td style="text-align:center;">-</td>';
								echo'<td style="text-align:center;">-</td>';
								echo'<td style="text-align:center;">-</td>';
							echo '</tr>';
						}
					}else if($resultado['TipoDocto'] == '99'){
						if((($resultado['NumeroDocto']-1)!=$resultado2['Tipo99'])&&($resultado2['Tipo99']!=NULL)){
							echo '<tr>';
								echo'<td style="color:#ff0000; text-align:right;">SALTO DE FOLIO</td>';
								echo'<td style="text-align:center;">-</td>';
								echo'<td style="text-align:center;">-</td>';
								echo'<td style="text-align:center;">-</td>';
								echo'<td style="text-align:center;">-</td>';
								echo'<td style="text-align:center;">-</td>';
								echo'<td style="text-align:center;">-</td>';
								echo'<td style="text-align:center;">-</td>';
								echo'<td style="text-align:center;">-</td>';
								echo'<td style="text-align:center;">-</td>';
							echo '</tr>';
						}
					}
					$contFolioAnterior++;
				}
				//FIN COMPROBACIÓN DE FOLIO CON EL ÚLTIMO DOCUMENTO DEL DÍA ANTERIOR//
				if($tipoDoctoAnte == ""){
					if($numeroDoctoAnt == ""){ // =="" PARA EL INGRESO DEL PRIMER ROW
						echo '<tr>';
							if($resultado['TipoDocto'] == '1'){
								echo '<td>Boleta Fiscal</td>';
							}else if($resultado['TipoDocto'] == '2'){
								echo '<td>Factura</td>';
							}else if($resultado['TipoDocto'] == '3'){
								echo '<td>Nota de crédito</td>';
							}else if($resultado['TipoDocto'] == '4'){
								echo '<td>Boleta manual</td>';
							}
							else if($resultado['TipoDocto'] == '5'){
								echo '<td>Boleta</td>';
							}
							echo '<td>'.$resultado['NumeroDocto'].'</td>';
							if(number_format($resultado['Monto_Cash'],'0',',','.')==0 && number_format($resultado['Monto_DebitCard'],'0',',','.') ==0 && number_format($resultado['Monto_CreditCard'],'0',',','.') == 0 && number_format($resultado['Monto_Check'],'0',',','.') == 0 && number_format($resultado['Monto_Payments'],'0',',','.') == 0 && number_format($resultado['Monto_StoreCredit'],'0',',','.') == 0){
								echo '<td>SIN PAGO</td>';
							}else{
								echo '<td>'.$resultado['DocNum'].'</td>';
							}
							echo '<td>'.number_format($resultado['Total'],'0',',','.').'</td>';
							echo '<td>'.number_format($resultado['Monto_Cash'],'0',',','.').'</td>';
							echo '<td>'.number_format($resultado['Monto_DebitCard'],'0',',','.').'</td>';
							echo '<td>'.number_format($resultado['Monto_CreditCard'],'0',',','.').'</td>';
							echo '<td>'.number_format($resultado['Monto_Check'],'0',',','.').'</td>';
							echo '<td>'.number_format($resultado['Monto_Payments'],'0',',','.').'</td>';
							echo '<td>'.number_format($resultado['Monto_StoreCredit'],'0',',','.').'</td>';
						echo '</tr>';
					}else if(($numeroDoctoAnt+1)!= $resultado['NumeroDocto']){ //COMPROBACIÓN DE NUMERO DE DOCUMENTO ANTERIOR PARA COMPROBACIÓN DE SALTO DE FOLIO
						echo '<tr>';
							echo'<td style="color:#ff0000; text-align:right;">SALTO DE FOLIO</td>';
							echo'<td style="text-align:center;">-</td>';
							echo'<td style="text-align:center;">-</td>';
							echo'<td style="text-align:center;">-</td>';
							echo'<td style="text-align:center;">-</td>';
							echo'<td style="text-align:center;">-</td>';
							echo'<td style="text-align:center;">-</td>';
							echo'<td style="text-align:center;">-</td>';
							echo'<td style="text-align:center;">-</td>';
							echo'<td style="text-align:center;">-</td>';
						echo '</tr>';
						echo '<tr>';
							if($resultado['TipoDocto'] == '1'){
								echo '<td>Boleta Fiscal</td>';
							}else if($resultado['TipoDocto'] == '2'){
								echo '<td>Factura</td>';
							}else if($resultado['TipoDocto'] == '3'){
								echo '<td>Nota de crédito</td>';
							}else if($resultado['TipoDocto'] == '4'){
								echo '<td>Boleta manual</td>';
							}
							else if($resultado['TipoDocto'] == '5'){
								echo '<td>Boleta</td>';
							}
							echo '<td>'.$resultado['NumeroDocto'].'</td>';
							if(number_format($resultado['Monto_Cash'],'0',',','.')==0 && number_format($resultado['Monto_DebitCard'],'0',',','.') ==0 && number_format($resultado['Monto_CreditCard'],'0',',','.') == 0 && number_format($resultado['Monto_Check'],'0',',','.') == 0 && number_format($resultado['Monto_Payments'],'0',',','.') == 0 && number_format($resultado['Monto_StoreCredit'],'0',',','.') == 0){
								echo '<td>SIN PAGO</td>';
							}else{
								echo '<td>'.$resultado['DocNum'].'</td>';
							}
							echo '<td>'.number_format($resultado['Total'],'0',',','.').'</td>';
							echo '<td>'.number_format($resultado['Monto_Cash'],'0',',','.').'</td>';
							echo '<td>'.number_format($resultado['Monto_DebitCard'],'0',',','.').'</td>';
							echo '<td>'.number_format($resultado['Monto_CreditCard'],'0',',','.').'</td>';
							echo '<td>'.number_format($resultado['Monto_Check'],'0',',','.').'</td>';
							echo '<td>'.number_format($resultado['Monto_Payments'],'0',',','.').'</td>';
							echo '<td>'.number_format($resultado['Monto_StoreCredit'],'0',',','.').'</td>';
						echo '</tr>';
					}else{ // CORRELATIVO CORRESPONDIENTE, NO EXISTE SALTO DE FOLIO
						echo '<tr>';
							if($resultado['TipoDocto'] == '1'){
								echo '<td>Boleta Fiscal</td>';
							}else if($resultado['TipoDocto'] == '2'){
								echo '<td>Factura</td>';
							}else if($resultado['TipoDocto'] == '3'){
								echo '<td>Nota de crédito</td>';
							}else if($resultado['TipoDocto'] == '4'){
								echo '<td>Boleta manual</td>';
							}
							else if($resultado['TipoDocto'] == '5'){
								echo '<td>Boleta</td>';
							}
							echo '<td>'.$resultado['NumeroDocto'].'</td>';
							if(number_format($resultado['Monto_Cash'],'0',',','.')==0 && number_format($resultado['Monto_DebitCard'],'0',',','.') ==0 && number_format($resultado['Monto_CreditCard'],'0',',','.') == 0 && number_format($resultado['Monto_Check'],'0',',','.') == 0 && number_format($resultado['Monto_Payments'],'0',',','.') == 0 && number_format($resultado['Monto_StoreCredit'],'0',',','.') == 0){
								echo '<td>SIN PAGO</td>';
							}else{
								echo '<td>'.$resultado['DocNum'].'</td>';
							}
							echo '<td>'.number_format($resultado['Total'],'0',',','.').'</td>';
							echo '<td>'.number_format($resultado['Monto_Cash'],'0',',','.').'</td>';
							echo '<td>'.number_format($resultado['Monto_DebitCard'],'0',',','.').'</td>';
							echo '<td>'.number_format($resultado['Monto_CreditCard'],'0',',','.').'</td>';
							echo '<td>'.number_format($resultado['Monto_Check'],'0',',','.').'</td>';
							echo '<td>'.number_format($resultado['Monto_Payments'],'0',',','.').'</td>';
							echo '<td>'.number_format($resultado['Monto_StoreCredit'],'0',',','.').'</td>';
						echo '</tr>';
					}
					//ACUMULAR SUB TOTALES
					$acumSubTotal = $acumSubTotal + $resultado['Total'];
					$acumSubMonto_Cash = $acumSubMonto_Cash + $resultado['Monto_Cash'];
					$acumSubMonto_DebitCard = $acumSubMonto_DebitCard + $resultado['Monto_DebitCard'];
					$acumSubMonto_CreditCard = $acumSubMonto_CreditCard + $resultado['Monto_CreditCard'];
					$acumSubMonto_Check = $acumSubMonto_Check + $resultado['Monto_Check'];
					$acumSubMonto_Payments = $acumSubMonto_Payments + $resultado['Monto_Payments'];
					$acumSubMonto_StoreCredit = $acumSubMonto_StoreCredit + $resultado['Monto_StoreCredit'];
					//ACUMULAR VALOR NOTAS DE CREDITO
					if($resultado['TipoDocto'] == '3'){
						$acumNotaCreditoTotal = $acumNotaCreditoTotal + $resultado['Total'];
						$acumNotaCreditoCash = $acumNotaCreditoCash + $resultado['Monto_Cash'];
						$acumNotaCreditoStore = $acumNotaCreditoStore + $resultado['Monto_StoreCredit'];
					}
					//FIN ACUMULAR SUB TOTALES
					$tipoDoctoAnte = $resultado['TipoDocto'];
					
				}else if($tipoDoctoAnte == $resultado['TipoDocto']){
					if($numeroDoctoAnt == ""){ // == "" PARA EL INGRESO DEL PRIMER ROW
						echo '<tr>';
							echo '<td></td>';
							echo '<td>'.$resultado['NumeroDocto'].'</td>';
							if(number_format($resultado['Monto_Cash'],'0',',','.')==0 && number_format($resultado['Monto_DebitCard'],'0',',','.') ==0 && number_format($resultado['Monto_CreditCard'],'0',',','.') == 0 && number_format($resultado['Monto_Check'],'0',',','.') == 0 && number_format($resultado['Monto_Payments'],'0',',','.') == 0 && number_format($resultado['Monto_StoreCredit'],'0',',','.') == 0){
								echo '<td>SIN PAGO</td>';
							}else{
								echo '<td>'.$resultado['DocNum'].'</td>';
							}
							echo '<td>'.number_format($resultado['Total'],'0',',','.').'</td>';
							echo '<td>'.number_format($resultado['Monto_Cash'],'0',',','.').'</td>';
							echo '<td>'.number_format($resultado['Monto_DebitCard'],'0',',','.').'</td>';
							echo '<td>'.number_format($resultado['Monto_CreditCard'],'0',',','.').'</td>';
							echo '<td>'.number_format($resultado['Monto_Check'],'0',',','.').'</td>';
							echo '<td>'.number_format($resultado['Monto_Payments'],'0',',','.').'</td>';
							echo '<td>'.number_format($resultado['Monto_StoreCredit'],'0',',','.').'</td>';
						echo '</tr>';
					}else if(($numeroDoctoAnt+1)!= $resultado['NumeroDocto']){ //COMPROBACIÓN DE NUMERO DE DOCUMENTO ANTERIOR PARA COMPROBACIÓN DE SALTO DE FOLIO
						echo '<tr>';
							echo'<td style="color:#ff0000; text-align:right;">SALTO DE FOLIO</td>';
							echo'<td style="text-align:center;">-</td>';
							echo'<td style="text-align:center;">-</td>';
							echo'<td style="text-align:center;">-</td>';
							echo'<td style="text-align:center;">-</td>';
							echo'<td style="text-align:center;">-</td>';
							echo'<td style="text-align:center;">-</td>';
							echo'<td style="text-align:center;">-</td>';
							echo'<td style="text-align:center;">-</td>';
							echo'<td style="text-align:center;">-</td>';
						echo '</tr>';
						echo '<tr>';
							echo '<td></td>';
							echo '<td>'.$resultado['NumeroDocto'].'</td>';
							echo '<td>'.$resultado['DocNum'].'</td>';
							echo '<td>'.number_format($resultado['Total'],'0',',','.').'</td>';
							echo '<td>'.number_format($resultado['Monto_Cash'],'0',',','.').'</td>';
							echo '<td>'.number_format($resultado['Monto_DebitCard'],'0',',','.').'</td>';
							echo '<td>'.number_format($resultado['Monto_CreditCard'],'0',',','.').'</td>';
							echo '<td>'.number_format($resultado['Monto_Check'],'0',',','.').'</td>';
							echo '<td>'.number_format($resultado['Monto_Payments'],'0',',','.').'</td>';
							echo '<td>'.number_format($resultado['Monto_StoreCredit'],'0',',','.').'</td>';
						echo '</tr>';
					}else{ // CORRELATIVO CORRESPONDIENTE, NO EXISTE SALTO DE FOLIO
						echo '<tr>';
							echo '<td></td>';
							echo '<td>'.$resultado['NumeroDocto'].'</td>';
							if(number_format($resultado['Monto_Cash'],'0',',','.')==0 && number_format($resultado['Monto_DebitCard'],'0',',','.') ==0 && number_format($resultado['Monto_CreditCard'],'0',',','.') == 0 && number_format($resultado['Monto_Check'],'0',',','.') == 0 && number_format($resultado['Monto_Payments'],'0',',','.') == 0 && number_format($resultado['Monto_StoreCredit'],'0',',','.') == 0){
								echo '<td>SIN PAGO</td>';
							}else{
								echo '<td>'.$resultado['DocNum'].'</td>';
							}
							
							echo '<td>'.number_format($resultado['Total'],'0',',','.').'</td>';
							echo '<td>'.number_format($resultado['Monto_Cash'],'0',',','.').'</td>';
							echo '<td>'.number_format($resultado['Monto_DebitCard'],'0',',','.').'</td>';
							echo '<td>'.number_format($resultado['Monto_CreditCard'],'0',',','.').'</td>';
							echo '<td>'.number_format($resultado['Monto_Check'],'0',',','.').'</td>';
							echo '<td>'.number_format($resultado['Monto_Payments'],'0',',','.').'</td>';
							echo '<td>'.number_format($resultado['Monto_StoreCredit'],'0',',','.').'</td>';
						echo '</tr>';
					}
					//ACUMULAR SUB TOTALES
					$acumSubTotal = $acumSubTotal + $resultado['Total'];
					$acumSubMonto_Cash = $acumSubMonto_Cash + $resultado['Monto_Cash'];
					$acumSubMonto_DebitCard = $acumSubMonto_DebitCard + $resultado['Monto_DebitCard'];
					$acumSubMonto_CreditCard = $acumSubMonto_CreditCard + $resultado['Monto_CreditCard'];
					$acumSubMonto_Check = $acumSubMonto_Check + $resultado['Monto_Check'];
					$acumSubMonto_Payments = $acumSubMonto_Payments + $resultado['Monto_Payments'];
					$acumSubMonto_StoreCredit = $acumSubMonto_StoreCredit + $resultado['Monto_StoreCredit'];
					//ACUMULAR VALOR NOTAS DE CREDITO
					if($resultado['TipoDocto'] == '3'){
						$acumNotaCreditoTotal = $acumNotaCreditoTotal + $resultado['Total'];
						$acumNotaCreditoCash = $acumNotaCreditoCash + $resultado['Monto_Cash'];
						$acumNotaCreditoStore = $acumNotaCreditoStore + $resultado['Monto_StoreCredit'];
					}
					//FIN ACUMULAR SUB TOTALES
					$tipoDoctoAnte = $resultado['TipoDocto'];
				}else{
					echo '<tr>';
					echo '<td style="font-weight: bold;">Sub total</td>';
					echo '<td></td>';
					echo '<td></td>';
					echo '<td style="font-weight: bold;">'.number_format($acumSubTotal,'0',',','.').'</td>';
					echo '<td style="font-weight: bold;">'.number_format($acumSubMonto_Cash,'0',',','.').'</td>';
					echo '<td style="font-weight: bold;">'.number_format($acumSubMonto_DebitCard,'0',',','.').'</td>';
					echo '<td style="font-weight: bold;">'.number_format($acumSubMonto_CreditCard,'0',',','.').'</td>';
					echo '<td style="font-weight: bold;">'.number_format($acumSubMonto_Check,'0',',','.').'</td>';
					echo '<td style="font-weight: bold;">'.number_format($acumSubMonto_Payments,'0',',','.').'</td>';
					echo '<td style="font-weight: bold;">'.number_format($acumSubMonto_StoreCredit,'0',',','.').'</td>';
					echo '</tr>';
					$acumSubTotal = 0;
					$acumSubMonto_Cash = 0;
					$acumSubMonto_DebitCard = 0;
					$acumSubMonto_CreditCard = 0;
					$acumSubMonto_Check = 0;
					$acumSubMonto_Payments = 0;
					$acumSubMonto_StoreCredit = 0;
					if($numeroDoctoAnt == ""){ // =="" PARA EL INGRESO DEL PRIMER ROW
						echo '<tr>';
							if($resultado['TipoDocto'] == '1'){
								echo '<td>Boleta Fiscal</td>';
							}else if($resultado['TipoDocto'] == '2'){
								echo '<td>Factura</td>';
							}else if($resultado['TipoDocto'] == '3'){
								echo '<td>Nota de credito</td>';
							}else if($resultado['TipoDocto'] == '4'){
								echo '<td>Boleta manual</td>';
							}
							else if($resultado['TipoDocto'] == '5'){
								echo '<td>Boleta</td>';
							}
							echo '<td>'.$resultado['NumeroDocto'].'</td>';
							echo '<td>'.$resultado['DocNum'].'</td>';
							echo '<td>'.number_format($resultado['Total'],'0',',','.').'</td>';
							echo '<td>'.number_format($resultado['Monto_Cash'],'0',',','.').'</td>';
							echo '<td>'.number_format($resultado['Monto_DebitCard'],'0',',','.').'</td>';
							echo '<td>'.number_format($resultado['Monto_CreditCard'],'0',',','.').'</td>';
							echo '<td>'.number_format($resultado['Monto_Check'],'0',',','.').'</td>';
							echo '<td>'.number_format($resultado['Monto_Payments'],'0',',','.').'</td>';
							echo '<td>'.number_format($resultado['Monto_StoreCredit'],'0',',','.').'</td>';
						echo '</tr>';
					}else if(($numeroDoctoAnt+1)!= $resultado['NumeroDocto']){ //COMPROBACIÓN DE NUMERO DE DOCUMENTO ANTERIOR PARA COMPROBACIÓN DE SALTO DE FOLIO
						echo '<tr>';
							echo'<td style="color:#ff0000; text-align:right;">SALTO DE FOLIO</td>';
							echo'<td style="text-align:center;">-</td>';
							echo'<td style="text-align:center;">-</td>';
							echo'<td style="text-align:center;">-</td>';
							echo'<td style="text-align:center;">-</td>';
							echo'<td style="text-align:center;">-</td>';
							echo'<td style="text-align:center;">-</td>';
							echo'<td style="text-align:center;">-</td>';
							echo'<td style="text-align:center;">-</td>';
							echo'<td style="text-align:center;">-</td>';
						echo '</tr>';
						echo '<tr>';
							if($resultado['TipoDocto'] == '1'){
								echo '<td>Boleta Fiscal</td>';
							}else if($resultado['TipoDocto'] == '2'){
								echo '<td>Factura</td>';
							}else if($resultado['TipoDocto'] == '3'){
								echo '<td>Nota de credito</td>';
							}else if($resultado['TipoDocto'] == '4'){
								echo '<td>Boleta manual</td>';
							}
							else if($resultado['TipoDocto'] == '5'){
								echo '<td>Boleta</td>';
							}
							echo '<td>'.$resultado['DocNum'].'</td>';
							echo '<td>'.number_format($resultado['Total'],'0',',','.').'</td>';
							echo '<td>'.number_format($resultado['Monto_Cash'],'0',',','.').'</td>';
							echo '<td>'.number_format($resultado['Monto_DebitCard'],'0',',','.').'</td>';
							echo '<td>'.number_format($resultado['Monto_CreditCard'],'0',',','.').'</td>';
							echo '<td>'.number_format($resultado['Monto_Check'],'0',',','.').'</td>';
							echo '<td>'.number_format($resultado['Monto_Payments'],'0',',','.').'</td>';
							echo '<td>'.number_format($resultado['Monto_StoreCredit'],'0',',','.').'</td>';
						echo '</tr>';
					}else{ // CORRELATIVO CORRESPONDIENTE, NO EXISTE SALTO DE FOLIO
						echo '<tr>';
							if($resultado['TipoDocto'] == '1'){
								echo '<td>Boleta Fiscal</td>';
							}else if($resultado['TipoDocto'] == '2'){
								echo '<td>Factura</td>';
							}else if($resultado['TipoDocto'] == '3'){
								echo '<td>Nota de credito</td>';
							}else if($resultado['TipoDocto'] == '4'){
								echo '<td>Boleta manual</td>';
							}
							else if($resultado['TipoDocto'] == '5'){
								echo '<td>Boleta</td>';
							}
							echo '<td>'.$resultado['NumeroDocto'].'</td>';
							echo '<td>'.$resultado['DocNum'].'</td>';
							echo '<td>'.number_format($resultado['Total'],'0',',','.').'</td>';
							echo '<td>'.number_format($resultado['Monto_Cash'],'0',',','.').'</td>';
							echo '<td>'.number_format($resultado['Monto_DebitCard'],'0',',','.').'</td>';
							echo '<td>'.number_format($resultado['Monto_CreditCard'],'0',',','.').'</td>';
							echo '<td>'.number_format($resultado['Monto_Check'],'0',',','.').'</td>';
							echo '<td>'.number_format($resultado['Monto_Payments'],'0',',','.').'</td>';
							echo '<td>'.number_format($resultado['Monto_StoreCredit'],'0',',','.').'</td>';
						echo '</tr>';
					}
					//ACUMULAR SUB TOTALES
					$acumSubTotal = $acumSubTotal + $resultado['Total'];
					$acumSubMonto_Cash = $acumSubMonto_Cash + $resultado['Monto_Cash'];
					$acumSubMonto_DebitCard = $acumSubMonto_DebitCard + $resultado['Monto_DebitCard'];
					$acumSubMonto_CreditCard = $acumSubMonto_CreditCard + $resultado['Monto_CreditCard'];
					$acumSubMonto_Check = $acumSubMonto_Check + $resultado['Monto_Check'];
					$acumSubMonto_Payments = $acumSubMonto_Payments + $resultado['Monto_Payments'];
					$acumSubMonto_StoreCredit = $acumSubMonto_StoreCredit + $resultado['Monto_StoreCredit'];
					//ACUMULAR VALOR NOTAS DE CREDITO
					if($resultado['TipoDocto'] == '3'){
						$acumNotaCreditoTotal = $acumNotaCreditoTotal + $resultado['Total'];
						$acumNotaCreditoCash = $acumNotaCreditoCash + $resultado['Monto_Cash'];
						$acumNotaCreditoStore = $acumNotaCreditoStore + $resultado['Monto_StoreCredit'];
					}
					//FIN ACUMULAR SUB TOTALES
					$tipoDoctoAnte = $resultado['TipoDocto'];
				}
				
				$acumTotal = $acumTotal + $resultado['Total'];
				$acumMonto_Cash = $acumMonto_Cash + $resultado['Monto_Cash'];
				$acumMonto_DebitCard = $acumMonto_DebitCard + $resultado['Monto_DebitCard'];
				$acumMonto_CreditCard = $acumMonto_CreditCard + $resultado['Monto_CreditCard'];
				$acumMonto_Check = $acumMonto_Check + $resultado['Monto_Check'];
				$acumMonto_Payments = $acumMonto_Payments + $resultado['Monto_Payments'];
				$acumMonto_StoreCredit = $acumMonto_StoreCredit + $resultado['Monto_StoreCredit'];
				$numeroDoctoAnt = $resultado['NumeroDocto'];
				$tipoDoctoAnt = $resultado['TipoDocto'];
				
			}
			echo '<tr>';
				echo '<td style="font-weight: bold;">Sub total</td>';
				echo '<td ></td>';
				echo '<td ></td>';
				echo '<td style="font-weight: bold;">'.number_format($acumSubTotal,'0',',','.').'</td>';
				echo '<td style="font-weight: bold;">'.number_format($acumSubMonto_Cash,'0',',','.').'</td>';
				echo '<td style="font-weight: bold;">'.number_format($acumSubMonto_DebitCard,'0',',','.').'</td>';
				echo '<td style="font-weight: bold;">'.number_format($acumSubMonto_CreditCard,'0',',','.').'</td>';
				echo '<td style="font-weight: bold;">'.number_format($acumSubMonto_Check,'0',',','.').'</td>';
				echo '<td style="font-weight: bold;">'.number_format($acumSubMonto_Payments,'0',',','.').'</td>';
				echo '<td style="font-weight: bold;">'.number_format($acumSubMonto_StoreCredit,'0',',','.').'</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td style="font-weight: bold;">Totales</td>';
			echo '<td></td>';
			echo '<td></td>';
			echo '<td style="font-weight: bold;">'.number_format((($acumTotal-$acumNotaCreditoTotal)-$acumNotaCreditoTotal),'0',',','.').'</td>';
			echo '<td style="font-weight: bold;">'.number_format((($acumMonto_Cash-$acumNotaCreditoCash)-$acumNotaCreditoCash),'0',',','.').'</td>';
			echo '<td style="font-weight: bold;">'.number_format($acumMonto_DebitCard,'0',',','.').'</td>';
			echo '<td style="font-weight: bold;">'.number_format($acumMonto_CreditCard,'0',',','.').'</td>';
			echo '<td style="font-weight: bold;">'.number_format($acumMonto_Check,'0',',','.').'</td>';
			echo '<td style="font-weight: bold;">'.number_format($acumMonto_Payments,'0',',','.').'</td>';
			echo '<td style="font-weight: bold;">'.number_format((($acumMonto_StoreCredit-$acumNotaCreditoStore)-$acumNotaCreditoStore),'0',',','.').'</td>';
			echo '</tr>';
		}
		
	?>
                </tbody>


            </table>
			</div>
			<?php  }
			?>

	<?php odbc_close( $conn );?>
