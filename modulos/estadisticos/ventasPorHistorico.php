<script type="text/javascript" src="js/jquery.base64.js"></script>
<script type="text/javascript" src="js/jquery.btechco.excelexport.js"></script>
<style>
	#ssptable2{
		background-color:red;
	}
</style>
<?php
require_once("clases/conexionocdb.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
$vendedor = $_GET['id'];
$vendedorSelect = $_GET['id'];

$vendedor = str_pad($vendedor, 3, '0', 'STR_PAD_LEFT');
$finicio = $_GET['inicio'];
$codbarra = $_GET['codbarra'];
$consultar = $_GET['agregar'];
$marca = htmlspecialchars(urldecode(($_GET["marca"])));
$segmento = $_GET['segmento'];
$status = $_GET['statuuus'];
$bodega = $_GET['bodega'];
$cont = $_GET['cont'];
$tipoProducto = $_GET['tipoProducto'];
$areaNegocio = $_GET['areaNegocio'];
$tipoReporte = $_GET['tipoReporte'];

if($marca != ''){
	$marca = "'".$marca."'";
}

if($tipoReporte == 'ReporteUno'){
	$segmento = "Selectivo";
	$status = "Vigente','Nueva Marca','Potenciar";
}else if($tipoReporte == 'ReporteDos'){
	$segmento = "Semiselectivo";
	$status = "Vigente','Nueva Marca','Potenciar";
}else if($tipoReporte == 'ReporteTres'){
	$segmento = "Masivo";
	$status = "Vigente','Nueva Marca','Potenciar";
}else if($tipoReporte == 'ReporteCuatro'){
	$segmento = "Semiselectivo','Descontinuado','Selectivo','No Aplica','Masivo";
	$status = "Liquidacion','Descontinuado','Museo";
}else if($tipoReporte == 'ReporteCinco'){
		if($marca == ''){
			$marca = "'CARTOON NETWORK','CLAYEUX','KOKESHI','KALOO','DISNEY PARFUM INFANTIL'";
		}else{
			$marca = $marca.",'CARTOON NETWORK','KOKESHI','KALOO','DISNEY PARFUM INFANTIL'";
		}
}
?>
<script type="text/javascript">
  $(document).ready(function(){
				//comienza focus en modulo
				$('#moduloid').focus();
				// calendarios en text de fecha inicio fin
				$( "#inicio" ).datepicker({
					dateFormat: 'yy',
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
	$("#dialogDescarga:eq(0)")
		.dialog("widget")
		.find(".ui-dialog-titlebar").css({ "float": "right", border: 0, padding: 0 })
		.find(".ui-dialog-title").css({ display: "none" }).end()
		.find(".ui-dialog-titlebar-close").css({ top: 0, right: 0, margin: 0, "z-index": 999
	});
});
</script>
<script type="text/javascript">
	$(window).load(function() {
		$('#status').fadeOut();
		$('#preloader').delay(350).fadeOut('slow');
		$("#dialogDescarga").dialog("close");
		var control = <?php if($cont==1){ echo 1; } elseif($cont==0){ echo 0; } else{ echo 2;} ?>;
		if(control == 1){
			$("#dialogDescarga").dialog("open");
		}else if(control == 2){
			$('#erroConsulta').dialog("open");
		}else if(control == 0){
			$('body').delay(350).css({'overflow':'visible'});
		}
	});
</script>
<div id="preloader">
	<div id="status">&nbsp;<?php if($cont == 1){echo 'Un momento por favor, estamos generando su reporte.';}?></div>
</div>
<!-- Formulario de descarga -->
<div id="dialogDescarga" title="Ventas Historicas por Marca">
		<img src="images/export_excel.png" id="descargarExcel" style="display: block; margin-left: auto; margin-right: auto; cursor:pointer;"/>
		<p style="text-align:center;">Click en la imagen <br>para descargar</p>
</div>
<!-- Formulario de Error
<div id="errorConsulta" title="Ventas Historicas por Marca">
		<img src="images/no_export.png" id="sinResultado" style="display: block; margin-left: auto; margin-right: auto; cursor:pointer;"/>
		<p style="text-align:center;">no se obtuvieron resultados</p>
</div> -->
<div class="idTabs">
	<ul>
		<li><a href="#one"><img src="images/agregar.png" width="30px" height="30px" /></a></li>
	</ul>
	<div class="items">
		<div id="one">
        	<form action="" method="GET" id="horizontalForm">
            	<fieldset>
					<legend>Ventas Por Historico</legend>
						<input name="opc" type="hidden" id="opc" class="required" value="ventasPorHistorico" />
                    	<label class="first" for="inicio"> Periodo <input name="inicio" type="text" id="inicio" class="required" /> </label>
                    	<label class="first" for="bodega"> Bodega
                    		<select id="bodega" name="bodega" class="styled" >
							<?php
								$sql = "SELECT WhsCode FROM [SBO_Imp_Eximben_SAC].[dbo].[OWHS] WHERE U_VK_BdgaVenta = 'Y' AND WhsCode NOT LIKE 'INV'+'%' AND WhsCode NOT LIKE 'ZFI.Zeta'";
								$rs = odbc_exec( $conn, $sql );
								if ( !$rs ){
									exit( "Error en la consulta SQL" );
								}
								echo "<option value = ''> </option>";
								while($resultado = odbc_fetch_array($rs)){
									echo "<option value = ".$resultado['WhsCode']."> ".$resultado['WhsCode']."</option>";
								}
							?>
							</select>
                    	</label>
                    	<label class="first" for="tipoProducto">
							Tipo de Producto
							<select id="tipoProducto" name="tipoProducto" class="styled" >
								<option value="Producto Regular" selected>Producto Regular</option>
								<option value="Sin valor Comercial">Sin valor comercial</option>
							</select>
				    	</label>
						<label class="first" for="areaNegocio">
							Area de Negocio
							<select id="areaNegocio" name="areaNegocio" class="styled">
							<?php
								$sql = "SELECT DISTINCT AreaNegocio FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_VW_itemsVenta]";
								$rs = odbc_exec( $conn, $sql );
								if(!$rs){
									exit( "Error en la consulta SQL" );
								}
								echo "<option value = ''> </option>";
								while($resultado = odbc_fetch_array($rs)){
									echo "<option value = ".utf8_encode($resultado['AreaNegocio'])."> ".utf8_encode($resultado['AreaNegocio'])."</option>";
								}
							?>
							</select>
							<br>
                        </label>
						<label class="first" for="marca">
							Marca
							<select name="marca" id="marca" class="styled">
							<?php
								$sql = "SELECT Name FROM [SBO_Imp_Eximben_SAC].[dbo].[@VK_OMAR]";
								$rs = odbc_exec( $conn, $sql );
								if(!$rs){
									exit( "Error en la consulta SQL" );
								}
								echo "<option value = ''> </option>";
								while($resultado = odbc_fetch_array($rs)){
									echo '<option value = '.urlencode($resultado["Name"]).'> '. utf8_encode($resultado["Name"]).'</option>';
								}
							?>
							</select>
						</label>
						<label class="first" for="segmento">
							Segmento
							<select name="segmento" id="segmento" class="styled">
							<?php
								$sql = "SELECT DISTINCT Segmento FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_VW_itemsVenta]";
								$rs = odbc_exec( $conn, $sql );
								if (!$rs){
									exit( "Error en la consulta SQL" );
								}
								echo "<option value = ''> </option>";
								while($resultado = odbc_fetch_array($rs)){
									echo "<option value = ".$resultado['Segmento']."> ".$resultado['Segmento']."</option>";
								}
							?>
							</select>
						</label>
						<label class="first" for="statuuus">
							Status
							<select name="statuuus" id="statuuus" class="styled">
							<?php
								$sql = "SELECT DISTINCT Status FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_VW_itemsVenta]";
								$rs = odbc_exec( $conn, $sql );
								if (!$rs){
									exit( "Error en la consulta SQL" );
								}
								echo "<option value = ''> </option>";
								while($resultado = odbc_fetch_array($rs)){
									echo "<option value = ".$resultado['Status']."> ".$resultado['Status']."</option>";
								}
							?>
							</select>
						</label>
                        <label class="first" for="tipoReporte">
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
         </div> <!-- fin div one-->
      </div> <!-- fin items -->
    </div> <!-- fin idTabs -->
    <?php
	$where_query = '';
if($tipoProducto != ""){
	$where_query = $where_query . " AND TipoProducto='". $tipoProducto ."'";
}
if($bodega != ""){
	$where_query = $where_query . " AND WhsCode='". $bodega ."'";
}
if($areaNegocio != ""){
	$where_query = $where_query . " AND AreaNegocio='". $areaNegocio ."'";
}
if($status != ""){
	$where_query = $where_query . " AND Status IN ('". $status ."')";
}
if($segmento != ""){
	$where_query = $where_query . " AND Segmento IN ('". $segmento ."')";
}
if($marca != ""){
	$where_query = $where_query . " AND Marca IN (". $marca . ")";
}
if($marca != "" && $tipoReporte != 'ReporteCinco'){
$sql="
SELECT
	TABLA.Segmento
	,CASE WHEN (GROUPING(TABLA.Status) = 1) THEN 'TOTAL SEG' ELSE ISNULL(TABLA.Status,'Sub total') END AS TotalStatus
	,ISNULL(TABLA.ItemCode,'SUB TOTAL') AS [ItemCode]
	,TABLA.ItemName
	,TABLA.Marca [Marcas]
	,SUM(TABLA.Enero) [Enero]
	,SUM(TABLA.Febrero) [Febrero]
	,SUM(TABLA.Marzo) [Marzo]
	,SUM(TABLA.Abril) [Abril]
	,SUM(TABLA.Mayo) [Mayo]
	,SUM(TABLA.Junio) [Junio]
	,SUM(TABLA.Julio) [Julio]
	,SUM(TABLA.Agosto) [Agosto]
	,SUM(TABLA.Septiembre) [Septiembre]
	,SUM(TABLA.Octubre) [Octubre]
	,SUM(TABLA.Noviembre) [Noviembre]
	,SUM(TABLA.Diciembre) [Diciembre]
	,SUM(TABLA.Enero)+SUM(TABLA.Febrero)+SUM(TABLA.Marzo) [1er_Trim]
	,SUM(TABLA.Abril)+SUM(TABLA.Mayo)+SUM(TABLA.Junio) [2do_Trim]
	,SUM(TABLA.Julio)+SUM(TABLA.Agosto)+SUM(TABLA.Septiembre) [3er_Trim]
	,SUM(TABLA.Octubre)+SUM(TABLA.Noviembre)+SUM(TABLA.Diciembre) [4to_Trim]
	,SUM(TABLA.Enero)+SUM(TABLA.Febrero)+SUM(TABLA.Marzo) +SUM(TABLA.Abril)+SUM(TABLA.Mayo)+SUM(TABLA.Junio) +SUM(TABLA.Julio)+SUM(TABLA.Agosto)+SUM(TABLA.Septiembre)+SUM(TABLA.Octubre)+SUM(TABLA.Noviembre)+SUM(TABLA.Diciembre) AS [Total_UNDS]
	,SUM(TABLA.Total_CLP) [Total_CLP]
	,SUM(TABLA.Total_USD) [Total_USD]
	,SUM(TABLA.CtoVtaCIF) [CtoVtaCIF]
FROM (
	SELECT
		Segmento
		,Status
		,Marca
		,ItemCode
		,ItemName
		,ISNULL([".$finicio."-01],0) AS Enero
		,ISNULL([".$finicio."-02],0) AS Febrero
		,ISNULL([".$finicio."-03],0) AS Marzo
		,ISNULL([".$finicio."-04],0) AS Abril
		,ISNULL([".$finicio."-05],0) AS Mayo
		,ISNULL([".$finicio."-06],0) AS Junio
		,ISNULL([".$finicio."-07],0) AS Julio
		,ISNULL([".$finicio."-08],0) AS Agosto
		,ISNULL([".$finicio."-09],0) AS Septiembre
		,ISNULL([".$finicio."-10],0) AS Octubre
		,ISNULL([".$finicio."-11],0) AS Noviembre
		,ISNULL([".$finicio."-12],0) AS Diciembre
		,ISNULL([".$finicio."-01],0) + ISNULL([".$finicio."-02],0) + ISNULL([".$finicio."-03],0) AS [1er_Trim]
		,ISNULL([".$finicio."-04],0) + ISNULL([".$finicio."-05],0) + ISNULL([".$finicio."-06],0) AS [2do_Trim]
		,ISNULL([".$finicio."-07],0) + ISNULL([".$finicio."-08],0) + ISNULL([".$finicio."-09],0) AS [3er_Trim]
		,ISNULL([".$finicio."-10],0) + ISNULL([".$finicio."-11],0) + ISNULL([".$finicio."-12],0) AS [4to_Trim]
		,ISNULL([".$finicio."-01],0) + ISNULL([".$finicio."-02],0) + ISNULL([".$finicio."-03],0) +ISNULL([".$finicio."-04],0) + ISNULL([".$finicio."-05],0) + ISNULL([".$finicio."-06],0) +ISNULL([".$finicio."-07],0) + ISNULL([".$finicio."-08],0) + ISNULL([".$finicio."-09],0) +ISNULL([".$finicio."-10],0) + ISNULL([".$finicio."-11],0) + ISNULL([".$finicio."-12],0) AS [Total_UNDS]
		,Total_CLP
		,Total_USD
		,CtoVtaCIF
	FROM (
		SELECT
			Quantity
			,Periodo
			,AreaNegocio
			,TipoProducto
			,Segmento
			,Status
			,Marca
			,ItemCode
			,ItemName
			,Total_CLP
			,Total_USD
			,CtoVtaCIF
		FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_VW_Ventas]
		WHERE
			Periodo LIKE '".$finicio."'+'%'
			". $where_query ."
		) V
		PIVOT (
			SUM(Quantity)
			FOR Periodo in (
				 [".$finicio."-01]
				,[".$finicio."-02]
				,[".$finicio."-03]
				,[".$finicio."-04]
				,[".$finicio."-05]
				,[".$finicio."-06]
				,[".$finicio."-07]
				,[".$finicio."-08]
				,[".$finicio."-09]
				,[".$finicio."-10]
				,[".$finicio."-11]
				,[".$finicio."-12]
			)
		) AS PV
		) AS TABLA
GROUP BY TABLA.ItemCode, TABLA.Marca ,TABLA.Segmento ,TABLA.Status , TABLA.ItemName";
}else{
$sql="
SELECT
  TABLA.[Segmento]
  ,CASE WHEN (GROUPING(TABLA.Status) = 1)
  THEN 'TOTAL SEG'
  ELSE ISNULL(TABLA.Status,'Sub total')
   END AS TotalStatus
  ,ISNULL(TABLA.Marca,'SUB TOTAL')        AS [Marcas]
  ,SUM(TABLA.Enero)          [Enero]
  ,SUM(TABLA.Febrero)        [Febrero]
  ,SUM(TABLA.Marzo)          [Marzo]
  ,SUM(TABLA.Abril)          [Abril]
  ,SUM(TABLA.Mayo)           [Mayo]
  ,SUM(TABLA.Junio)          [Junio]
  ,SUM(TABLA.Julio)          [Julio]
  ,SUM(TABLA.Agosto)         [Agosto]
  ,SUM(TABLA.Septiembre)     [Septiembre]
  ,SUM(TABLA.Octubre)        [Octubre]
  ,SUM(TABLA.Noviembre)      [Noviembre]
  ,SUM(TABLA.Diciembre)      [Diciembre]
  ,SUM(TABLA.Enero)+SUM(TABLA.Febrero)+SUM(TABLA.Marzo)         [1er_Trim]
  ,SUM(TABLA.Abril)+SUM(TABLA.Mayo)+SUM(TABLA.Junio)            [2do_Trim]
  ,SUM(TABLA.Julio)+SUM(TABLA.Agosto)+SUM(TABLA.Septiembre)     [3er_Trim]
  ,SUM(TABLA.Octubre)+SUM(TABLA.Noviembre)+SUM(TABLA.Diciembre) [4to_Trim]
  ,SUM(TABLA.Enero)+SUM(TABLA.Febrero)+SUM(TABLA.Marzo)
  +SUM(TABLA.Abril)+SUM(TABLA.Mayo)+SUM(TABLA.Junio)
  +SUM(TABLA.Julio)+SUM(TABLA.Agosto)+SUM(TABLA.Septiembre)
  +SUM(TABLA.Octubre)+SUM(TABLA.Noviembre)+SUM(TABLA.Diciembre) AS [Total_UNDS]
  ,SUM(TABLA.Total_CLP)       [Total_CLP]
  ,SUM(TABLA.Total_USD)       [Total_USD]
  ,SUM(TABLA.CtoVtaCIF)       [CtoVtaCIF]
FROM
(

  SELECT
    Segmento
   ,Status
   ,Marca
   ,ISNULL([".$finicio."-01],0) AS Enero
   ,ISNULL([".$finicio."-02],0) AS Febrero
   ,ISNULL([".$finicio."-03],0) AS Marzo
   ,ISNULL([".$finicio."-04],0) AS Abril
   ,ISNULL([".$finicio."-05],0) AS Mayo
   ,ISNULL([".$finicio."-06],0) AS Junio
   ,ISNULL([".$finicio."-07],0) AS Julio
   ,ISNULL([".$finicio."-08],0) AS Agosto
   ,ISNULL([".$finicio."-09],0) AS Septiembre
   ,ISNULL([".$finicio."-10],0) AS Octubre
   ,ISNULL([".$finicio."-11],0) AS Noviembre
   ,ISNULL([".$finicio."-12],0) AS Diciembre
   ,ISNULL([".$finicio."-01],0) + ISNULL([".$finicio."-02],0) + ISNULL([".$finicio."-03],0) AS [1er_Trim]
   ,ISNULL([".$finicio."-04],0) + ISNULL([".$finicio."-05],0) + ISNULL([".$finicio."-06],0) AS [2do_Trim]
   ,ISNULL([".$finicio."-07],0) + ISNULL([".$finicio."-08],0) + ISNULL([".$finicio."-09],0) AS [3er_Trim]
   ,ISNULL([".$finicio."-10],0) + ISNULL([".$finicio."-11],0) + ISNULL([".$finicio."-12],0) AS [4to_Trim]
   ,ISNULL([".$finicio."-01],0) + ISNULL([".$finicio."-02],0) + ISNULL([".$finicio."-03],0)
   +ISNULL([".$finicio."-04],0) + ISNULL([".$finicio."-05],0) + ISNULL([".$finicio."-06],0)
   +ISNULL([".$finicio."-07],0) + ISNULL([".$finicio."-08],0) + ISNULL([".$finicio."-09],0)
   +ISNULL([".$finicio."-10],0) + ISNULL([".$finicio."-11],0) + ISNULL([".$finicio."-12],0) AS [Total_UNDS]
   ,Total_CLP
   ,Total_USD
   ,CtoVtaCIF
   FROM
    (SELECT
      Quantity
     ,Periodo
     ,AreaNegocio
     ,TipoProducto
     ,Segmento
     ,Status
     ,Marca
     ,Total_CLP
     ,Total_USD
     ,CtoVtaCIF
    FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_VW_Ventas]
    WHERE Periodo LIKE '".$finicio."'+'%'
    ". $where_query ."
    ) V
    PIVOT ( SUM(Quantity)
    FOR Periodo in
     ([".$finicio."-01]
     ,[".$finicio."-02]
     ,[".$finicio."-03]
     ,[".$finicio."-04]
     ,[".$finicio."-05]
     ,[".$finicio."-06]
     ,[".$finicio."-07]
     ,[".$finicio."-08]
     ,[".$finicio."-09]
     ,[".$finicio."-10]
     ,[".$finicio."-11]
     ,[".$finicio."-12]
    )) AS PV
) AS TABLA
GROUP BY
      TABLA.Segmento
     ,TABLA.Status
     ,TABLA.Marca WITH ROLLUP
HAVING TABLA.Segmento IS NOT NULL
--ORDER BY Segmento,Status,Total_UNDS";
}
?>
	<div id="dv">
            <table  id="ssptable2" class="lista" style="display:none;">
			<thead>
			  </head>
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
					</tr>
				</head>
			 <thead>
					<tr>
						<th colspan="26" align="center" style="border-top: 1px solid black; font-size:20px;">Informe de Ventas Historicas Periodo <?php echo $finicio; if($bodega  != "") echo ' - Bodega: '. $bodega; ?> </th>
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
					</tr>
				</head>
                <thead>
					<tr>
						<th colspan="26" align="center" style="font-size:20px;">Unidad de Negocios:</th>
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
					</tr>
				</head>
                <thead>
					<tr>
						<th colspan="26" align="center" style="font-size:30px;"><strong><?php echo($areaNegocio != "") ?  strtoupper($areaNegocio) : '"TODAS"'; ?></strong></th>
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
					</tr>
				</head>
                <?php
                    if($marca != ""){
                        echo '
                            <thead>
					           <tr>
						          <th colspan="26" align="center" style="font-size:20px;">Marca:</th>
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
					           </tr>
				            </head>
                    <thead>
					           <tr>
						          <th colspan="26" align="center" style="font-size:30px;"><strong>';
											if($tipoReporte=="ReporteCinco"){
												echo "INFANTIL";
											}else{
												echo strtoupper($marca);
											}
											echo '</strong></th>
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
					           </tr>
				            </head>'
                            ;
                    }
                ?>
                <thead>
					<tr>
						<th colspan="26" align="center" style="font-weight: blond; border-bottom: 2px solid black; font-size:20px;"><?php if($segmento != ""){ echo " Segmento: <strong>". strtoupper($segmento) ."</strong>"; } if($status != ""){ echo " Status: <strong>". strtoupper($status). "</strong>"; } if($bodega != ""){ echo " Bodega: <strong>". strtoupper($bodega) ."</strong>"; } ?></th>
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
					</tr>
				</head>
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
            <th colspan="5" style="font-weight: blond; font-size:10px;"><?php echo 'Fecha Informe: '. date("d-m-Y"); ?></th>
            <th></th>
            <th></th>
            <th></th>
						<th></th>
					</tr>
				</head>
				<thead>
					<tr>
            <th style="font-size:10px; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">SEGMENTO</th>
            <th style="font-size:10px; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">STATUS</th>
            <th height="50" width="50" style="font-size:10px; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"></th>
						<th style="font-size:10px; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">Marca</th>
        <?php
					if($marca != ""){
						echo'<th style="font-size:10px; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">Código</th>
						<th style="font-size:10px; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">Descripció</th>';
					}
				?>
						<th style="font-size:10px; border-top: 2px solid black; border-left: 2px solid black; border-bottom: 1px solid black; background-color:#DCE6F1;">Enero</th>
						<th style="font-size:10px; border-top: 2px solid black; border-bottom: 1px solid black; background-color:#DCE6F1;">Febrero</th>
						<th style="font-size:10px; border-top: 2px solid black; border-bottom: 1px solid black; background-color:#DCE6F1;">Marzo</th>
						<th style="font-size:10px; border-top: 2px solid black; border-bottom: 1px solid black; background-color:#DCE6F1;">Abril</th>
						<th style="font-size:10px; border-top: 2px solid black; border-bottom: 1px solid black; background-color:#DCE6F1;">Mayo</th>
						<th style="font-size:10px; border-top: 2px solid black; border-bottom: 1px solid black; background-color:#DCE6F1;">Junio</th>
						<th style="font-size:10px; border-top: 2px solid black; border-bottom: 1px solid black; background-color:#DCE6F1;">Julio</th>
						<th style="font-size:10px; border-top: 2px solid black; border-bottom: 1px solid black; background-color:#DCE6F1;">Agosto</th>
						<th style="font-size:10px; border-top: 2px solid black; border-bottom: 1px solid black; background-color:#DCE6F1;">Septiembre</th>
						<th style="font-size:10px; border-top: 2px solid black; border-bottom: 1px solid black; background-color:#DCE6F1;">Octubre</th>
						<th style="font-size:10px; border-top: 2px solid black; border-bottom: 1px solid black; background-color:#DCE6F1;">Noviembre</th>
						<th style="font-size:10px; border-top: 2px solid black; border-bottom: 1px solid black; border-right: 2px solid black; background-color:#DCE6F1;">Diciembre</th>
						<th style="font-size:10px; border-top: 2px solid black; border-bottom: 1px solid black; background-color:#DCE6F1;">1er Trim</th>
						<th style="font-size:10px; border-top: 2px solid black; border-bottom: 1px solid black; background-color:#DCE6F1;">2do Trim</th>
						<th style="font-size:10px; border-top: 2px solid black; border-bottom: 1px solid black; background-color:#DCE6F1;">3er Trim</th>
						<th style="font-size:10px; border-top: 2px solid black; border-bottom: 1px solid black; border-right: 2px solid black; background-color:#DCE6F1;">4to Trim</th>
						<th style="font-size:10px; border-top: 2px solid black; border-bottom: 1px solid black; background-color:#DCE6F1;">Total UN.</th>
						<th style="font-size:10px; border-top: 2px solid black; border-bottom: 1px solid black; background-color:#DCE6F1;">Total CLP</th>
						<th style="font-size:10px; border-top: 2px solid black; border-bottom: 1px solid black; background-color:#DCE6F1;">Total USD</th>
						<th style="font-size:10px; border-top: 2px solid black; border-bottom: 1px solid black; background-color:#DCE6F1;">Media Venta</th>
						<th style="font-size:10px; border-top: 2px solid black; border-bottom: 1px solid black; border-right: 2px solid black; background-color:#DCE6F1;">Total CIF</th>
					</tr>
				</head>
      <tbody>
<?php
		if($consultar){
			$rs = odbc_exec( $conn, $sql );
			if ( !$rs){
				exit( "Error en la consulta SQL" );
				$cont = 2;
			}
			$ai = 1;
			$totales = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
			$repiteSegmento = "";
			$repiteStatus = "";
			while($resultado = odbc_fetch_array($rs)){
                if($resultado["Marcas"] == "SUB TOTAL"){
                    $ai = $ai - 1;
					$repiteSegmento = "";
                    echo
                        '<tr>
                            <td '; echo($marca != "") ? 'colspan="6"':'colspan="4"'; echo ' align="center" style="font-weight: bold; border-top: 2px solid #689DED; border-left:2px dotted #689DED; border-bottom: 2px solid #689DED; border-right: 2px solid #689DED; background-color:#DCE6F1;">SUBTOTAL '. $resultado["TotalStatus"] . '</td>';

                }else{

                    $totales[0] += $resultado["Enero"];
					$totales[1] += $resultado["Febrero"];
					$totales[2] += $resultado["Marzo"];
					$totales[3] += $resultado["Abril"];
					$totales[4] += $resultado["Mayo"];
					$totales[5] += $resultado["Junio"];
					$totales[6] += $resultado["Julio"];
					$totales[7] += $resultado["Agosto"];
					$totales[8] += $resultado["Septiembre"];
					$totales[9] += $resultado["Octubre"];
					$totales[10] += $resultado["Noviembre"];
					$totales[11] += $resultado["Diciembre"];
					$totales[12] += $resultado["1er_Trim"];
					$totales[13] += $resultado["2do_Trim"];
					$totales[14] += $resultado["3er_Trim"];
					$totales[15] += $resultado["4to_Trim"];
					$totales[16] += $resultado["Total_UNDS"];
					$totales[17] += $resultado["Total_CLP"];
					$totales[18] += $resultado["Total_USD"];
					$totales[19] += $resultado["CtoVtaCIF"];
					$totales[20] += ($resultado["Total_CLP"]/$resultado["Total_UNDS"]);
                    echo
                        '<tr style="">';
						if($resultado["Segmento"] == $repiteSegmento){
							echo '<td style="background-color:#DCE6F1; border-left:2px solid #689DED;"></td>';
						}else{
							$repiteSegmento = $resultado["Segmento"];
							echo '<td style="background-color:#DCE6F1; border-left:2px solid #689DED;">'. utf8_encode($resultado["Segmento"]) .'</td>';
						}
						if($resultado["TotalStatus"]  == $repiteStatus){
							echo '<td style="border-top: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"></td>';
						}else{
							$repiteStatus = $resultado["TotalStatus"];
							echo '<td style="border-top: 1px dotted #689DED; border-bottom: 1px dotted #689DED;">'. $resultado["TotalStatus"] .'</td>';
						}
                            echo'
                            <td align="center" style="font-weight: bold; border-top: 1px dotted #689DED; border-bottom: 1px dotted #689DED;">'. ($ai).'</td>
                            <td style="border-top: 1px dotted #689DED; border-bottom: 1px dotted #689DED;">'. $resultado["Marcas"] .'</td>';
                    if($marca != ""){

                        $descripcion = str_replace("Marca:", "", utf8_encode($resultado["ItemName"]));
                        $descripcion = str_replace("Tipo:", ",", $descripcion);
                        $descripcion = str_replace($resultado["Marcas"], "", $descripcion);
                        echo
                            '<td style="border-top: 1px dotted #689DED; border-bottom: 1px dotted #689DED;">'. utf8_encode((string)$resultado["ItemCode"]) .'*</td>
                            <td style="border-top: 1px dotted #689DED; border-bottom: 1px dotted #689DED;">'. $descripcion .'</td>';
                    }
                } //Fin else SUB TOTAL ?>

            <td style="border-left:2px solid #689DED; border-right:1px dotted #689DED; <?php echo ($resultado["Marcas"] == "SUB TOTAL") ? 'border-bottom:2px solid #689DED; background-color:#DCE6F1; border-top:2px solid #689DED;':'border-bottom:1px dotted #689DED; border-top:1px dotted #689DED;';?>"><?php echo number_format($resultado["Enero"],0,'','.'); ?></td>
            <td align="center" style="border-left:1px dotted #689DED; border-right:1px dotted #689DED; <?php echo ($resultado["Marcas"] == "SUB TOTAL") ? 'border-bottom:2px solid #689DED; background-color:#DCE6F1; border-top:2px solid #689DED;':'border-bottom:1px dotted #689DED; border-top:1px dotted #689DED;';?>"><?php echo number_format($resultado["Febrero"],0,'','.'); ?></td>
						<td align="center" style="border-left:1px dotted #689DED; border-right:1px dotted #689DED; <?php echo ($resultado["Marcas"] == "SUB TOTAL") ? 'border-bottom:2px solid #689DED; background-color:#DCE6F1; border-top:2px solid #689DED;':'border-bottom:1px dotted #689DED; border-top:2px dotted #689DED;';?>"><?php echo number_format($resultado["Marzo"],0,'','.'); ?></td>
						<td align="center" style="border-left:1px dotted #689DED; border-right:1px dotted #689DED; <?php echo ($resultado["Marcas"] == "SUB TOTAL") ? 'border-bottom:2px solid #689DED; background-color:#DCE6F1; border-top:2px solid #689DED;':'border-bottom:1px dotted #689DED; border-top:2px dotted #689DED;';?>"><?php echo number_format($resultado["Abril"],0,'','.'); ?></td>
						<td align="center" style="border-left:1px dotted #689DED; border-right:1px dotted #689DED; <?php echo ($resultado["Marcas"] == "SUB TOTAL") ? 'border-bottom:2px solid #689DED; background-color:#DCE6F1; border-top:2px solid #689DED;':'border-bottom:1px dotted #689DED; border-top:2px dotted #689DED;';?>"><?php echo number_format($resultado["Mayo"],0,'','.'); ?></td>
						<td align="center" style="border-left:1px dotted #689DED; border-right:1px dotted #689DED; <?php echo ($resultado["Marcas"] == "SUB TOTAL") ? 'border-bottom:2px solid #689DED; background-color:#DCE6F1; border-top:2px solid #689DED;':'border-bottom:1px dotted #689DED; border-top:2px dotted #689DED;';?>"><?php echo number_format($resultado["Junio"],0,'','.'); ?></td>
						<td align="center" style="border-left:1px dotted #689DED; border-right:1px dotted #689DED; <?php echo ($resultado["Marcas"] == "SUB TOTAL") ? 'border-bottom:2px solid #689DED; background-color:#DCE6F1; border-top:2px solid #689DED;':'border-bottom:1px dotted #689DED; border-top:2px dotted #689DED;';?>"><?php echo number_format($resultado["Julio"],0,'','.'); ?></td>
						<td align="center" style="border-left:1px dotted #689DED; border-right:1px dotted #689DED; <?php echo ($resultado["Marcas"] == "SUB TOTAL") ? 'border-bottom:2px solid #689DED; background-color:#DCE6F1; border-top:2px solid #689DED;':'border-bottom:1px dotted #689DED; border-top:2px dotted #689DED;';?>"><?php echo number_format($resultado["Agosto"],0,'','.'); ?></td>
						<td align="center" style="border-left:1px dotted #689DED; border-right:1px dotted #689DED; <?php echo ($resultado["Marcas"] == "SUB TOTAL") ? 'border-bottom:2px solid #689DED; background-color:#DCE6F1; border-top:2px solid #689DED;':'border-bottom:1px dotted #689DED; border-top:2px dotted #689DED;';?>"><?php echo number_format($resultado["Septiembre"],0,'','.'); ?></td>
						<td align="center" style="border-left:1px dotted #689DED; border-right:1px dotted #689DED; <?php echo ($resultado["Marcas"] == "SUB TOTAL") ? 'border-bottom:2px solid #689DED; background-color:#DCE6F1; border-top:2px solid #689DED;':'border-bottom:1px dotted #689DED; border-top:2px dotted #689DED;';?>"><?php echo number_format($resultado["Octubre"],0,'','.'); ?></td>
						<td align="center" style="border-left:1px dotted #689DED; border-right:1px dotted #689DED; <?php echo ($resultado["Marcas"] == "SUB TOTAL") ? 'border-bottom:2px solid #689DED; background-color:#DCE6F1; border-top:2px solid #689DED;':'border-bottom:1px dotted #689DED; border-top:2px dotted #689DED;';?>"><?php echo number_format($resultado["Noviembre"],0,'','.'); ?></td>
						<td align="center" style="border-left:1px dotted #689DED; border-right:2px solid #689DED; <?php echo ($resultado["Marcas"] == "SUB TOTAL") ? 'border-bottom:2px solid #689DED; background-color:#DCE6F1; border-top:2px solid #689DED;':'border-bottom:1px dotted #689DED; border-top:2px dotted #689DED;';?>"><?php echo number_format($resultado["Diciembre"],0,'','.'); ?></td>
						<td align="center" style="border-left:2px solid #689DED; border-right:1px dotted #689DED; <?php echo ($resultado["Marcas"] == "SUB TOTAL") ? 'border-bottom:2px solid #689DED; background-color:#DCE6F1; border-top:2px solid #689DED;':'border-bottom:1px dotted #689DED; border-top:2px dotted #689DED;';?>"><?php echo number_format($resultado["1er_Trim"],0,'','.'); ?></td>
						<td align="center" style="border-left:1px dotted #689DED; border-right:1px dotted #689DED; <?php echo ($resultado["Marcas"] == "SUB TOTAL") ? 'border-bottom:2px solid #689DED; background-color:#DCE6F1; border-top:2px solid #689DED;':'border-bottom:1px dotted #689DED; border-top:2px dotted #689DED;';?>"><?php echo number_format($resultado["2do_Trim"],0,'','.'); ?></td>
						<td align="center" style="border-left:1px dotted #689DED; border-right:1px dotted #689DED; <?php echo ($resultado["Marcas"] == "SUB TOTAL") ? 'border-bottom:2px solid #689DED; background-color:#DCE6F1; border-top:2px solid #689DED;':'border-bottom:1px dotted #689DED; border-top:2px dotted #689DED;';?>"><?php echo number_format($resultado["3er_Trim"],0,'','.'); ?></td>
						<td align="center" style="border-left:1px dotted #689DED; border-right:2px solid #689DED; <?php echo ($resultado["Marcas"] == "SUB TOTAL") ? 'border-bottom:2px solid #689DED; background-color:#DCE6F1; border-top:2px solid #689DED;':'border-bottom:1px dotted #689DED; border-top:2px dotted #689DED;';?>"><?php echo number_format($resultado["4to_Trim"],0,'','.'); ?></td>
						<td align="center" style="border-left:2px solid #689DED; border-right:1px dotted #689DED; <?php echo ($resultado["Marcas"] == "SUB TOTAL") ? 'border-bottom:2px solid #689DED; background-color:#DCE6F1; border-top:2px solid #689DED;':'border-bottom:1px dotted #689DED; border-top:2px dotted #689DED;';?>"><?php echo number_format($resultado["Total_UNDS"],0,'','.'); ?></td>
						<td align="center" style="border-left:1px dotted #689DED; border-right:1px dotted #689DED; <?php echo ($resultado["Marcas"] == "SUB TOTAL") ? 'border-bottom:2px solid #689DED; background-color:#DCE6F1; border-top:2px solid #689DED;':'border-bottom:1px dotted #689DED; border-top:2px dotted #689DED;';?>"><?php echo number_format($resultado["Total_CLP"],0,'','.'); ?></td>
						<td align="center" style="border-left:1px dotted #689DED; border-right:1px dotted #689DED; <?php echo ($resultado["Marcas"] == "SUB TOTAL") ? 'border-bottom:2px solid #689DED; background-color:#DCE6F1; border-top:2px solid #689DED;':'border-bottom:1px dotted #689DED; border-top:2px dotted #689DED;';?>"><?php echo number_format($resultado["Total_USD"],0,'','.'); ?></td>
						<td align="center" style="border-left:1px dotted #689DED; border-right:1px dotted #689DED; <?php echo ($resultado["Marcas"] == "SUB TOTAL") ? 'border-bottom:2px solid #689DED; background-color:#DCE6F1; border-top:2px solid #689DED;':'border-bottom:1px dotted #689DED; border-top:2px dotted #689DED;';?>"><?php echo number_format(($resultado["Total_CLP"]/$resultado["Total_UNDS"]),0,'','.'); ?></td>
						<td align="center" style="border-left:1px dotted #689DED; <?php echo ($resultado["Marcas"] == "SUB TOTAL") ? 'border-bottom:2px solid #689DED; background-color:#DCE6F1; border-top:2px solid #689DED; border-right:1px dotted #689DED;':'border-bottom:1px dotted #689DED; border-top:2px dotted #689DED; border-right:2px solid #689DED;';?>"><?php echo number_format($resultado["CtoVtaCIF"],0,'','.'); ?></td>
					</tr>
                    <?php
					$ai = $ai + 1;
			} // FIN WHILE RESULTADO
			if($ai > 1){ $cont = 2; }
			?>
			<td <?php if($marca != "") { echo 'colspan="6"'; } else { echo 'colspan="4"'; } ?>align="center" style="font-weight: bold; border-top: 2px solid #689DED; border-left:2px solid #689DED; border-bottom: 2px solid #689DED; border-right: 2px solid #689DED; background-color:#DCE6F1;">TOTAL GENERAL</td>
			<td align="center" style="font-weight: bold; border-top: 2px solid #689DED; border-left:2px solid #689DED; border-bottom: 2px solid #689DED; border-right: 1px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($totales[0],0,'','.'); ?></td>
			<td align="center" style=" font-weight: bold; border-top: 2px solid #689DED; border-left:1px solid #689DED; border-bottom: 2px solid #689DED; border-right: 1px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($totales[1],0,'','.'); ?></td>
			<td align="center" style="font-weight: bold; border-top: 2px solid #689DED; border-left:1px solid #689DED; border-bottom: 2px solid #689DED; border-right: 1px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($totales[2],0,'','.'); ?></td>
			<td align="center" style="font-weight: bold; border-top: 2px solid #689DED; border-left:1px solid #689DED; border-bottom: 2px solid #689DED; border-right: 1px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($totales[3],0,'','.'); ?></td>
			<td align="center" style="font-weight: bold; border-top: 2px solid #689DED; border-left:1px solid #689DED; border-bottom: 2px solid #689DED; border-right: 1px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($totales[4],0,'','.'); ?></td>
			<td align="center" style=" font-weight: bold; border-top: 2px solid #689DED; border-left:1px solid #689DED; border-bottom: 2px solid #689DED; border-right: 1px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($totales[5],0,'','.'); ?></td>
			<td align="center" style="font-weight: bold; border-top: 2px solid #689DED; border-left:1px solid #689DED; border-bottom: 2px solid #689DED; border-right: 1px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($totales[6],0,'','.'); ?></td>
			<td align="center" style="font-weight: bold; border-top: 2px solid #689DED; border-left:1px solid #689DED; border-bottom: 2px solid #689DED; border-right: 1px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($totales[7],0,'','.'); ?></td>
			<td align="center" style="font-weight: bold; border-top: 2px solid #689DED; border-left:1px solid #689DED; border-bottom: 2px solid #689DED; border-right: 1px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($totales[8],0,'','.'); ?></td>
			<td align="center" style="font-weight: bold; border-top: 2px solid #689DED; border-left:1px solid #689DED; border-bottom: 2px solid #689DED; border-right: 1px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($totales[9],0,'','.'); ?></td>
			<td align="center" style="font-weight: bold; border-top: 2px solid #689DED; border-left:1px solid #689DED; border-bottom: 2px solid #689DED; border-right: 1px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($totales[10],0,'','.'); ?></td>
			<td align="center" style="font-weight: bold; border-top: 2px solid #689DED; border-left:1px solid #689DED; border-bottom: 2px solid #689DED; border-right: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($totales[11],0,'','.'); ?></td>
			<td align="center" style="font-weight: bold; border-top: 2px solid #689DED; border-left:2px solid #689DED; border-bottom: 2px solid #689DED; border-right: 1px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($totales[12],0,'','.'); ?></td>
			<td align="center" style="font-weight: bold; border-top: 2px solid #689DED; border-left:1px solid #689DED; border-bottom: 2px solid #689DED; border-right: 1px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($totales[13],0,'','.'); ?></td>
			<td align="center" style="font-weight: bold; border-top: 2px solid #689DED; border-left:1px solid #689DED; border-bottom: 2px solid #689DED; border-right: 1px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($totales[14],0,'','.'); ?></td>
			<td align="center" style="font-weight: bold; border-top: 2px solid #689DED; border-left:1px solid #689DED; border-bottom: 2px solid #689DED; border-right: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($totales[15],0,'','.'); ?></td>
			<td align="center" style="font-weight: bold; border-top: 2px solid #689DED; border-left:2px solid #689DED; border-bottom: 2px solid #689DED; border-right: 1px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($totales[16],0,'','.'); ?></td>
			<td align="center" style="font-weight: bold; border-top: 2px solid #689DED; border-left:1px solid #689DED; border-bottom: 2px solid #689DED; border-right: 1px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($totales[17],0,'','.'); ?></td>
			<td align="center" style="font-weight: bold; border-top: 2px solid #689DED; border-left:1px solid #689DED; border-bottom: 2px solid #689DED; border-right: 1px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($totales[18],0,'','.'); ?></td>
			<td align="center" style="font-weight: bold; border-top: 2px solid #689DED; border-left:1px solid #689DED; border-bottom: 2px solid #689DED; border-right: 1px solid #689DED; background-color:#DCE6F1;"><?php echo number_format(($totales[17]/$totales[16]),0,'','.'); ?></td>
			<td align="center" style="font-weight: bold; border-top: 2px solid #689DED; border-left:1px solid #689DED; border-bottom: 2px solid #689DED; border-right: 1px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($totales[19],0,'','.'); ?></td>
                </tbody>
            </table>
			</div> <!-- fin div dv -->
			<?php  }?>

	<?php odbc_close( $conn );?>
