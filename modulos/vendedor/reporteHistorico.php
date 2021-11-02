<script type="text/javascript" src="modulos/vendedor/js/jquery.base64.js"></script>
<script type="text/javascript" src="modulos/vendedor/js/jquery.btechco.excelexport.js"></script>
<style>
	#ssptable2{
		background-color:red;
	}
</style>
<?php
require_once("clases/conexionocdb.php");
ini_set('max_execution_time', 30000); //300 seconds = 5 minutes

$finicio = $_GET['inicio'];
$fecha = substr($finicio,0,4);
$fcorteStock = $_GET['corteStock'];
$fmarca = $_GET['linea'];
$ffin = $_GET['fin'];
$proveedor = $_GET['proveedor'];
$cont = $_GET['cont'];
$consultar = $_GET['agregar'];
/*SQL SEGMENTO*/
$sqlSegmento = "SELECT DISTINCT Segmento FROM [DTW_VICENCIO].dbo.VIC_VW_ItemsVenta WHERE Marca = '".$fmarca."' and Segmento <> 'No Aplica'";
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
$sqlSegmento = "SELECT DISTINCT Status FROM [DTW_VICENCIO].dbo.VIC_VW_ItemsVenta WHERE Marca = '".$fmarca."' and Segmento <> 'No Aplica' AND TipoProducto = 'Producto Regular' AND AreaNegocio='Perfumes' ORDER BY Status DESC";
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

?>
<script type="text/javascript">
  $(document).ready(function(){
				//comienza focus en modulo
				$('#moduloid').focus();
				// calendarios en text de fecha inicio fin
				
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
				<legend>Ingresar Fechas</legend>
					<input name="opc" type="hidden" id="opc" size="40" class="required" value="reporteHistorico" />
                        <label for="fecha1">
				            Periodo
							<select id="inicio" name="inicio" class="styled" style="">
								<option value=""></option>
								<?php
									/*$sql="SELECT DISTINCT Periodo FROM SBO_Reports.dbo.Historico";
									$rs = odbc_exec( $conn, $sql );
									if ( !$rs){
										exit( "Error en la consulta SQL" );
									}
									while($resultado = odbc_fetch_array($rs)){
										echo'
											<option value="'.substr($resultado['Periodo'],0,7).'">'.substr($resultado['Periodo'],0,7).'</option>
										';
									}*/
									
								?>
								<option value="2017-07">2017-07</option>
								<option value="2017-07">2017-08</option>
							</select>
                        </label>
						
						<label class="first" for="title1">
							Proveedor
							<select id="proveedor" name="proveedor" class="styled" >
								<option value=""></option>
								<?php
									$sql="SELECT DISTINCT Proveedor FROM DTW_VICENCIO.dbo.VIC_VW_ItemsVenta ORDER  BY Proveedor ASC";
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
							<select id="linea" name="linea"  class="styled" width="30" class="required">
								<!--<option value=""></option>-->
							</select><br>
							<img id="cargaLinea" src="modulos/vendedor/images/loading3.gif" width="20" style="display:none;"/>
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
                	<th colspan="25" align="center" style="font-size:34px; border-top: 1px solid #689DED; border-right: 1px solid #689DED; "><?php echo $fmarca.' '.substr($finicio,0,4);?></th>
                </tr>
              </thead>
              <thead>
              	<tr>
					<th align="left" style="border-left: 1px solid #689DED;">Segmento: <?php echo $segmento;?></th>
                	<th colspan="25" align="center" style="font-size:14px; border-right: 1px solid #689DED;"><?php echo 'REPORTE COMERCIAL'; ?></th>
                </tr>
              </thead>
              <thead>
              	<tr>
					<th align="left" style="border-left: 1px solid #689DED;">Status: <?php echo $status;?></th>
                	<th colspan="25" align="center" style="font-size:24px;border-right: 1px solid #689DED; ">(1) Área Comercial / Comite Ejecutivo</th>
                </tr>
              </thead>
			  <thead>
              	<tr>
					<th colspan="26" align="left" style="border-right:1px solid #689DED; border-left: 1px solid #689DED;">Tipo de cambio acordado: <?php echo $tipoCambioAcordado;?></th>
                </tr>
              </thead>
			   <thead>
              	<tr>
					<th colspan="26" align="left" style="border-bottom:1px solid #689DED; border-right:1px solid #689DED; border-left: 1px solid #689DED;">Periodo de informe: <?php echo $finicio;?></th>
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

					</tr>
			  </head>
			  
			<thead>
				<tr>
                    <th style="border-top: 1px solid #689DED;"></th>
					<th style="border-top: 1px solid #689DED;"></th>
					<th style="border-top: 1px solid #689DED;border-right: 1px solid #689DED;"></th>
					<!--<th style="border-top: 1px solid #689DED; "></th>
					<th style="border-top: 1px solid #689DED;"></th>
					<th style="border-top: 1px solid #689DED;"></th>
					<th style="border-top: 1px solid #689DED;"></th>
					<th style="border-top: 1px solid #689DED;"></th>-->
					<th colspan="13" style="border-top: 1px solid #689DED;">Unidades Vendidas Periodo <?php echo substr($finicio,0,4); ?></th>
					<!--<th style="border-top: 1px solid #689DED;"></th>
					<th style="border-top: 1px solid #689DED;"></th>
					<th style="border-top: 1px solid #689DED;"></th>
					<th style="border-top: 1px solid #689DED;"></th>
					<th style="border-top: 1px solid #689DED;"></th>-->
					<!-- VALORES DE VENTA 2015 -->
					<th colspan="6" style="border: 1px solid #689DED;">Valores Ref <?php echo substr($finicio,0,4); ?></th>
					
					<!-- STOCK EXIMBEN CIERRE 2015 -->
					<th colspan="2" style="border: 1px solid #689DED;">Stock Consolidado <?php echo $fcorteStock; ?></th>
					<th colspan="2" style="border-top: 1px solid #689DED;">Suggested</th>
					
					
				</tr>
			</head>  
			  
            <thead>
				<tr>
                    <th style="border-top: 1px solid #689DED; border-bottom: 1px solid #689DED;"></th>
					<th style="border-top: 1px solid #689DED; border-bottom: 1px solid #689DED;">REFERENCE</th>
					<th style="border-top: 1px solid #689DED; border-bottom: 1px solid #689DED; width:300px;">DESCRIPTION</th>
					<th style="border-top: 1px solid #689DED; border-bottom: 1px solid #689DED; border-left: 1px solid #689DED;"><?php echo $fecha."-01";?></th>
					<th style="border-top: 1px solid #689DED; border-bottom: 1px solid #689DED;"><?php echo $fecha."-02";?></th>
					<th style="border-top: 1px solid #689DED; border-bottom: 1px solid #689DED;"><?php echo $fecha."-03";?></th>
					<th style="border-top: 1px solid #689DED; border-bottom: 1px solid #689DED;"><?php echo $fecha."-04";?></th>
					<th style="border-top: 1px solid #689DED; border-bottom: 1px solid #689DED;"><?php echo $fecha."-05";?></th>
					<th style="border-top: 1px solid #689DED; border-bottom: 1px solid #689DED;"><?php echo $fecha."-06";?></th>
					<th style="border-top: 1px solid #689DED; border-bottom: 1px solid #689DED;"><?php echo $fecha."-07";?></th>
					<th style="border-top: 1px solid #689DED; border-bottom: 1px solid #689DED;"><?php echo $fecha."-08";?></th>
					<th style="border-top: 1px solid #689DED; border-bottom: 1px solid #689DED;"><?php echo $fecha."-09";?></th>
					<th style="border-top: 1px solid #689DED; border-bottom: 1px solid #689DED;"><?php echo $fecha."-10";?></th>
					<th style="border-top: 1px solid #689DED; border-bottom: 1px solid #689DED;"><?php echo $fecha."-11";?></th>
					<th style="border-top: 1px solid #689DED; border-bottom: 1px solid #689DED;"><?php echo $fecha."-12";?></th>
					<th style="border-top: 1px solid #689DED; border-bottom: 1px solid #689DED;">TOTAL UNITS</th>
					<!-- VALORES DE VENTA Y COMPRA 2015 -->
					<th style="border-top: 1px solid #689DED; border-bottom: 1px solid #689DED; border-left: 1px solid #689DED;"><?php echo 'CLP '.$fecha; ?></th>
					<th style="border-top: 1px solid #689DED; border-bottom: 1px solid #689DED;"><?php echo 'USD '.$fecha; ?></th>
					<th style="border-top: 1px solid #689DED; border-bottom: 1px solid #689DED;">TOTAL PRECIO COMPRA</th>
					<th style="border-top: 1px solid #689DED; border-bottom: 1px solid #689DED;">% MARGEN</th>
					<th style="border-top: 1px solid #689DED; border-bottom: 1px solid #689DED;">PRECIO COMPRA UNITARIO</th>
					
					<th style="border-top: 1px solid #689DED; border-bottom: 1px solid #689DED; border-right: 1px solid #689DED;">CIF ADUANERO</th>
					<!-- STOCK EXIMBEN CIERRE 2015 -->
					<th style="border-top: 1px solid #689DED; border-bottom: 1px solid #689DED; border-left: 1px solid #689DED;">UNITS</th>
					<th style="border-top: 1px solid #689DED; border-bottom: 1px solid #689DED; border-right: 1px solid #689DED;">CIF</th>
					
					<!--<th style="border-top: 1px solid #689DED; border-bottom: 1px solid #689DED;">PRE-PACKS</th>-->
					<th style="border-top: 1px solid #689DED; border-bottom: 1px solid #689DED;">DUTY FREE</th>
					<!--<th style="border-top: 1px solid #689DED; border-bottom: 1px solid #689DED;">RETAIL DUTY FREE (USD)</th>-->
					<th style="border-top: 1px solid #689DED; border-bottom: 1px solid #689DED;">RETAIL USA</th>
					<!--<th style="border-top: 1px solid #689DED; border-bottom: 1px solid #689DED;">UNITS ORDERED</th>-->
				</tr>
			</head>
                <tbody>
                 <?php



	/*$sql ="SELECT 
		   [Referencia] as [REFERENCIA]
		  ,[Linea] as [LINEA]
		  ,[Description] as [DESCRIPTION]
		  ,[Status] as [Status]
		  ,[PurFactor1]
		  ,[Enero]
		  ,[Febrero]
		  ,[Marzo]
		  ,[Abril]
		  ,[Mayo]
		  ,[Junio]
		  ,[Julio]
		  ,[Agosto]
		  ,[Septiembre]
		  ,[Octubre]
		  ,[Noviembre]
		  ,[Diciembre]
		  ,[Total_UNDS]
		  ,[Total_CLP]
		  ,[Total_USD]
		  ,[CtoVtaCIF]
		  ,[Stock]
		  ,[Cif_Total]
		  ,[PrePacks]
		  ,[RetailDutyFree]
		  ,[PrecioCompra]
	  FROM [SBO_Reports].[dbo].[Historico]
	  WHERE Periodo = '".$finicio."' AND Marca = '".$fmarca."'
	  ORDER BY Status DESC, Linea ASC, RetailDutyFree DESC";*/
	  
	$sql="
	 
SELECT 
  TABLA.ItemCode AS [REFERENCIA]
 ,TABLA.Linea + '           ' + TABLA.SubLinea AS [LINEA]
 ,TABLA.ItemName AS [DESCRIPTION]
 ,TABLA.Status AS [Status]
 ,TABLA.PurFactor1
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
 ,SUM(TABLA.Enero)+SUM(TABLA.Febrero)+SUM(TABLA.Marzo) +SUM(TABLA.Abril)+SUM(TABLA.Mayo)+SUM(TABLA.Junio) +SUM(TABLA.Julio)+SUM(TABLA.Agosto)+SUM(TABLA.Septiembre)+SUM(TABLA.Octubre)+SUM(TABLA.Noviembre)+SUM(TABLA.Diciembre) AS [Total_UNDS]
 ,CAST((SELECT SUM(Total_CLP) FROM [DTW_VICENCIO].[dbo].[VIC_VW_Ventas] WHERE ItemCode = TABLA.ItemCode AND 1=1
		 AND Periodo LIKE '2017%' 
		 AND Marca = '".$fmarca."'
		 AND AreaNegocio = 'Perfumes'
		 AND TipoProducto = 'Producto Regular'
		 AND ItemCode NOT LIKE '%INV%') AS INT) as [Total_CLP]
 ,(SELECT SUM(Total_USD) FROM [DTW_VICENCIO].[dbo].[VIC_VW_Ventas] WHERE ItemCode = TABLA.ItemCode AND 1=1
		 AND Periodo LIKE '2017%' 
		 AND Marca = '".$fmarca."'
		 AND AreaNegocio = 'Perfumes' 
		 AND TipoProducto = 'Producto Regular'
		 AND ItemCode NOT LIKE '%INV%') as [Total_USD]
 ,(SELECT SUM(CtoVtaCIF) FROM [DTW_VICENCIO].[dbo].[VIC_VW_Ventas] WHERE ItemCode = TABLA.ItemCode AND 1=1
		 AND Periodo LIKE '2017%' 
		 AND Marca = '".$fmarca."'
		 AND AreaNegocio = 'Perfumes' 
		 AND TipoProducto = 'Producto Regular'
		 AND ItemCode NOT LIKE '%INV%') as [CtoVtaCIF]
 ,TABLA.Stock
 ,ROUND(TABLA.Cif_Total,2,1) as Cif_Total
 ,TABLA.PrePacks
 ,TABLA.RetailDutyFree
 ,TABLA.PrecioCompra
 ,Periodo = '".$finicio."'
 ,Marca = '".$fmarca."'
FROM (
 SELECT
   Linea
  ,SubLinea
  ,Marca
  ,ItemCode
  ,ItemName
  ,Status
  ,PurFactor1
  ,ISNULL([2017-01],0) AS Enero
  ,ISNULL([2017-02],0) AS Febrero
  ,ISNULL([2017-03],0) AS Marzo
  ,ISNULL([2017-04],0) AS Abril
  ,ISNULL([2017-05],0) AS Mayo
  ,ISNULL([2017-06],0) AS Junio
  ,ISNULL([2017-07],0) AS Julio
  ,ISNULL([2017-08],0) AS Agosto
  ,ISNULL([2017-09],0) AS Septiembre
  ,ISNULL([2017-10],0) AS Octubre
  ,ISNULL([2017-11],0) AS Noviembre
  ,ISNULL([2017-12],0) AS Diciembre
  ,ISNULL([2017-01],0) + ISNULL([2017-02],0) + ISNULL([2017-03],0) +ISNULL([2017-04],0) + ISNULL([2017-05],0) + ISNULL([2017-06],0) +ISNULL([2017-07],0) + ISNULL([2017-08],0) + ISNULL([2017-09],0) +ISNULL([2017-10],0) + ISNULL([2017-11],0) + ISNULL([2017-12],0) AS [Total_UNDS]
  ,Total_CLP
  ,Total_USD
  ,CtoVtaCIF
  ,Stock
  ,Cif_Total
  ,PrePacks
  ,RetailDutyFree
  ,PrecioCompra
 FROM (
  SELECT A.Quantity
   ,A.Periodo
   ,A.Status
   ,A.AreaNegocio
   ,A.TipoProducto
   ,A.Linea
   ,A.SubLinea
   ,A.Marca
   ,A.ItemCode
   ,OI.PurFactor1
   ,A.FrgnName AS ItemName
   ,A.Total_CLP
   ,A.Total_USD
   ,A.CtoVtaCIF
   ,(SELECT
       SUM(Z.Quantity)
   FROM [DTW_VICENCIO].[dbo].[STOCK_POR_PERIODO_BODEGA] AS Z
   WHERE Z.Periodo = '2017-07' AND Z.ItemCode = A.ItemCode
   AND Z.WhsCode NOT LIKE '%INV%'
   ) AS Stock
   ,(SELECT SUM(X.StockVal) FROM [DTW_VICENCIO].[dbo].[STOCK_POR_PERIODO_BODEGA] AS X WHERE X.Periodo = '".$finicio."' AND X.ItemCode = A.ItemCode AND X.WhsCode NOT LIKE '%INV%') AS Cif_Total
   ,OI.U_Unid_por_caja AS [PrePacks]
   ,( SELECT Y.Price FROM [DTW_VICENCIO].[dbo].ITM1 AS Y WHERE Y.PriceList = 3 AND Y.ItemCode = A.ItemCode) AS RetailDutyFree
   ,( SELECT Y.Price FROM [DTW_VICENCIO].[dbo].ITM1 AS Y WHERE Y.PriceList = 2 AND Y.ItemCode = A.ItemCode) AS PrecioCompra
  FROM [DTW_VICENCIO].[dbo].OITM OI
  LEFT JOIN [DTW_VICENCIO].[dbo].[VIC_VW_Ventas] AS A ON OI.ItemCode = A.ItemCode
  WHERE 1=1
     AND A.Periodo LIKE '2017%' 
     AND A.Marca = '".$fmarca."'
     AND A.AreaNegocio = 'Perfumes'
	 AND A.TipoProducto = 'Producto Regular'
	 AND A.ItemCode NOT LIKE '%INV%'
  ) V
  PIVOT (
   SUM(Quantity)
   FOR Periodo in (
     [2017-01]
    ,[2017-02]
    ,[2017-03]
    ,[2017-04]
    ,[2017-05]
    ,[2017-06]
    ,[2017-07]
    ,[2017-08]
    ,[2017-09]
    ,[2017-10]
    ,[2017-11]
    ,[2017-12]
   )
  ) AS PV
  ) AS TABLA
GROUP BY  TABLA.ItemCode, TABLA.Linea, TABLA.SubLinea, TABLA.Status, TABLA.PurFactor1, TABLA.ItemName, TABLA.PrePacks, TABLA.Stock, TABLA.Cif_Total, TABLA.RetailDutyFree, TABLA.PrecioCompra
 
UNION ALL

SELECT DISTINCT A.Itemcode AS [REFERENCIA]
      ,Linea + '           ' + SubLinea AS [LINEA] 
      ,A.FrgnName AS [DESCRIPTION]
      ,A.Status AS [Status]
      ,A.PurFactor1
      ,0 AS Enero
      ,0 AS Febrero
      ,0 AS Marzo
      ,0 AS Abril
      ,0 AS Mayo
      ,0 AS Junio
      ,0 AS Julio
      ,0 AS Agosto
      ,0 AS Septiembre
      ,0 AS Octubre
      ,0 AS Noviembre
      ,0 AS Diciembre
      ,0 AS Total_UNDS
      ,0 AS Total_CLP
      ,0 AS Total_USD
      ,0 AS CtoVtaCIF
      ,(SELECT SUM(Z.Quantity) FROM [DTW_VICENCIO].[dbo].[STOCK_POR_PERIODO_BODEGA] AS Z WHERE Z.Periodo = '2017-07' AND Z.ItemCode = A.ItemCode AND Z.WhsCode NOT LIKE '%'+'INV'+'%') AS Stock
      ,(SELECT SUM(X.StockVal) FROM [DTW_VICENCIO].[dbo].[STOCK_POR_PERIODO_BODEGA] AS X WHERE X.Periodo = '2017-07' AND X.ItemCode = A.ItemCode AND X.WhsCode NOT LIKE '%'+'INV'+'%') AS Cif_Total
      ,A.PrePacks
      ,(SELECT Y.Price FROM [DTW_VICENCIO].[dbo].ITM1 AS Y WHERE Y.PriceList = 3 AND Y.ItemCode = A.ItemCode) AS RetailDutyFree
	  ,A.LPC_Precio as PrecioCompra
	  ,Periodo = '".$finicio."'
      ,Marca = '".$fmarca."'
FROM [DTW_VICENCIO].[dbo].[VIC_VW_ItemsVenta] AS A
WHERE A.Marca = '".$fmarca."'
      AND A.ItemCode NOT LIKE '%INV%'
      AND A.TipoProducto = 'Producto Regular'
      AND A.AreaNegocio = 'Perfumes'
      AND A.Itemcode NOT IN(SELECT A.Itemcode FROM [DTW_VICENCIO].[dbo].[VIC_VW_ItemsVenta] AS A
                            LEFT JOIN [DTW_VICENCIO].[dbo].[VIC_VW_Ventas] AS B ON A.ItemCode = B.ItemCode
                            WHERE B.Periodo LIKE '2017%' AND A.Marca = '".$fmarca."' AND A.AreaNegocio = 'Perfumes'
                            AND A.ItemCode NOT LIKE '%INV%' AND A.TipoProducto = 'Producto Regular')
GROUP BY A.PurFactor1, A.ItemCode, A.Linea, A.SubLinea, A.Status, A.FrgnName, A.PrePacks, A.LPC_Precio
ORDER BY Status DESC, Linea ASC, RetailDutyFree DESC
	
	";	
	
	
	$acumTotalUnidades = 0;
	$acumTotalCLP = 0;
	$acumTotalUSD = 0;
	$acumTotalCIF = 0;
	$acumVtaCIF = 0;
	$acumStock = 0;
	$acumCIFTotal = 0;
	
	$acumSubTotalTotalUnidadesVigente = 0;
	$acumSubTotalTotalCLPVigente = 0;
	$acumSubTotalTotalUSDVigente = 0;
	$acumSubTotalVtaCIFVigente = 0;
	$acumSubTotalStockVigente = 0;
	
	$acumSubTotalTotalUnidadesDescontinuado = 0;
	$acumSubTotalTotalCLPDescontinuado  = 0;
	$acumSubTotalTotalUSDDescontinuado  = 0;
	$acumSubTotalVtaCIFDescontinuado  = 0;
	$acumSubTotalStockDescontinuado  = 0;
	$descCIF;
	$contDescontinuado =0;
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
					if($contDescontinuado == 0){
						$contDescontinuado++;
						$descCIF = $acumCIFTotal;
						echo '<tr>';
							echo '<td style="border-top: 1px solid #689DED; text-align:left; font-weight:bold;">SUB TOTAL VIGENTE</td>';
							echo '<td style="border-top: 1px solid #689DED;"></td>';
							echo '<td style="border-top: 1px solid #689DED;"></td>';
							echo '<td style="border-top: 1px solid #689DED;"></td>';
							echo '<td style="border-top: 1px solid #689DED;"></td>';
							echo '<td style="border-top: 1px solid #689DED;"></td>';
							echo '<td style="border-top: 1px solid #689DED;"></td>';
							echo '<td style="border-top: 1px solid #689DED;"></td>';
							echo '<td style="border-top: 1px solid #689DED;"></td>';
							echo '<td style="border-top: 1px solid #689DED;"></td>';
							echo '<td style="border-top: 1px solid #689DED;"></td>';
							echo '<td style="border-top: 1px solid #689DED;"></td>';
							echo '<td style="border-top: 1px solid #689DED;"></td>';
							echo '<td style="border-top: 1px solid #689DED;"></td>';
							echo '<td style="border: 1px solid #689DED; font-weight:bold;">Totales</td>';
							echo '<td style="border: 1px solid #689DED; font-weight: bold;">'.number_format($acumSubTotalTotalUnidadesVigente,'0',',','.').'</td>';
							echo '<td style="border: 1px solid #689DED; font-weight: bold;">'.number_format($acumSubTotalTotalCLPVigente,'0',',','.').'</td>';
							echo '<td style="border: 1px solid #689DED; font-weight: bold;">'.number_format($acumSubTotalTotalUSDVigente,'2',',','.').'</td>';
							echo '<td style="border-top: 1px solid #689DED;"></td>';
							echo '<td style="border-top: 1px solid #689DED;"></td>';
							echo '<td style="border-top: 1px solid #689DED;"></td>';
							echo '<td style="border: 1px solid #689DED; font-weight: bold;">'.number_format($acumSubTotalVtaCIFVigente,'2',',','.').'</td>';
							echo '<td style="border: 1px solid #689DED; font-weight: bold;">'.number_format($acumSubTotalStockVigente,'0',',','.').'</td>';
							echo '<td style="border: 1px solid #689DED; font-weight: bold;">'.number_format($acumCIFTotal,'2',',','.').'</td>';
							echo '<td style="border-top: 1px solid #689DED;"></td>';
							echo '<td style="border-top: 1px solid #689DED;"></td>';
						echo '</tr>';
						echo '<tr></tr>';
						$acumSubTotalTotalUnidadesDescontinuado = $acumSubTotalTotalUnidadesDescontinuado + $resultado['Total_UNDS'];
						$acumSubTotalTotalCLPDescontinuado  = $acumSubTotalTotalCLPDescontinuado + $resultado['Total_CLP'];
						$acumSubTotalTotalUSDDescontinuado  = $acumSubTotalTotalUSDDescontinuado + $resultado['Total_USD'];
						$acumSubTotalVtaCIFDescontinuado  = $acumSubTotalVtaCIFDescontinuado + $resultado['CtoVtaCIF'];
						$acumSubTotalStockDescontinuado  = $acumSubTotalStockDescontinuado + $resultado['Stock'];
						echo '<tr style="color:#F30;" >';	
					}else{
						$acumSubTotalTotalUnidadesDescontinuado = $acumSubTotalTotalUnidadesDescontinuado + $resultado['Total_UNDS'];
						$acumSubTotalTotalCLPDescontinuado  = $acumSubTotalTotalCLPDescontinuado + $resultado['Total_CLP'];
						$acumSubTotalTotalUSDDescontinuado  = $acumSubTotalTotalUSDDescontinuado + $resultado['Total_USD'];
						$acumSubTotalVtaCIFDescontinuado  = $acumSubTotalVtaCIFDescontinuado + $resultado['CtoVtaCIF'];
						$acumSubTotalStockDescontinuado  = $acumSubTotalStockDescontinuado + $resultado['Stock'];
						echo '<tr style="color:#F30;" >';	
					}
				}else{
					$acumSubTotalTotalUnidadesVigente = $acumSubTotalTotalUnidadesVigente + $resultado['Total_UNDS'];
					$acumSubTotalTotalCLPVigente  = $acumSubTotalTotalCLPVigente + $resultado['Total_CLP'];
					$acumSubTotalTotalUSDVigente  = $acumSubTotalTotalUSDVigente + $resultado['Total_USD'];
					$acumSubTotalVtaCIFVigente  = $acumSubTotalVtaCIFVigente + $resultado['CtoVtaCIF'];
					$acumSubTotalStockVigente  = $acumSubTotalStockVigente + $resultado['Stock'];
					echo '<tr>';
				}
				if($repiteLinea == utf8_encode($resultado['LINEA'])){
					echo '<td></td>';
					echo '<td>'.utf8_encode($resultado['REFERENCIA'])."&nbsp;".'</td>';
					echo '<td style="">'.utf8_encode($resultado['DESCRIPTION'])."&nbsp;".'</td>';
					echo '<td style="border-left: 1px solid #689DED;">'.number_format($resultado['Enero'],'0',',','.').'</td>';
					echo '<td>'.number_format($resultado['Febrero'],'0',',','.').'</td>';
					echo '<td>'.number_format($resultado['Marzo'],'0',',','.').'</td>';
					echo '<td>'.number_format($resultado['Abril'],'0',',','.').'</td>';
					echo '<td>'.number_format($resultado['Mayo'],'0',',','.').'</td>';
					echo '<td>'.number_format($resultado['Junio'],'0',',','.').'</td>';
					echo '<td>'.number_format($resultado['Julio'],'0',',','.').'</td>';
					echo '<td>'.number_format($resultado['Agosto'],'0',',','.').'</td>';
					echo '<td>'.number_format($resultado['Septiembre'],'0',',','.').'</td>';
					echo '<td>'.number_format($resultado['Octubre'],'0',',','.').'</td>';
					echo '<td>'.number_format($resultado['Noviembre'],'0',',','.').'</td>';
					echo '<td>'.number_format($resultado['Diciembre'],'0',',','.').'</td>';
					echo '<td>'.number_format($resultado['Total_UNDS'],'0',',','.').'</td>';
					echo '<td style="border-left: 1px solid #689DED;">'.number_format($resultado['Total_CLP'],'0',',','.').'</td>';
					echo '<td>'.number_format($resultado['Total_USD'],'2',',','.').'</td>';
					
					$totalPrecioCompra = $resultado['PrecioCompra'] * $resultado['Total_UNDS'];
					echo '<td>'.number_format($totalPrecioCompra,'2',',','.').'</td>';
					
					$varUSD = $resultado['Total_USD'];
					$varCtoVtaCIF = $resultado['CtoVtaCIF'];
					if($varUSD == '0' || $varCtoVtaCIF == '0'){
						$margen = '-';
						echo '<td style="text-align:right;">'.$margen.'</td>';
					}else{
						$margen = ((($varUSD - $varCtoVtaCIF)*100)/ $varUSD);
						if($margen < 0){
							echo '<td style="background-color: #FF0000; color:#FFA500;">'.number_format($margen,'0',',','.').'%</td>'; //MARGEN NEGATIVO DESCONTINUADO
						}else{
							echo '<td>'.number_format($margen,'0',',','.').'%</td>';
						}	
					}
					
					echo '<td>'.number_format($resultado['PrecioCompra'],'2',',','.').'</td>';
					echo '<td>'.number_format($resultado['CtoVtaCIF'],'2',',','.').'</td>';
					echo '<td style="border-left: 1px solid #689DED;">'.number_format($resultado['Stock'],'0',',','.').'</td>';
					if($resultado['Stock'] == 0){
						echo '<td style="border-right: 1px solid #689DED;">'.number_format(0,'2',',','.').'</td>';
					}else{
						echo '<td style="border-right: 1px solid #689DED;">'.number_format($resultado['Cif_Total'],'2',',','.').'</td>';
						$acumCIFTotal = $acumCIFTotal + $resultado['Cif_Total'];
					}
					
					//echo '<td style="border-left: 1px solid #689DED;">'.number_format($resultado['PrePacks'],'0',',','.').'</td>';
					echo '<td>'.number_format($resultado['RetailDutyFree'],'2',',','').'</td>';
					//echo '<td>--</td>';
					echo '<td>'.number_format($resultado['RetailUSA'],'2',',','').'</td>';
				}else{
					echo '<td style="border-top: 1px solid #689DED; text-align:left;">'.utf8_encode($resultado['LINEA']).'</td>';
					echo '<td style="border-top: 1px solid #689DED;">'.utf8_encode($resultado['REFERENCIA'])."&nbsp;".'</td>';
					echo '<td style="border-top: 1px solid #689DED;">'.utf8_encode($resultado['DESCRIPTION'])."&nbsp;".'</td>';
					echo '<td style="border-top: 1px solid #689DED; border-left: 1px solid #689DED;">'.number_format($resultado['Enero'],'0',',','.').'</td>';
					echo '<td style="border-top: 1px solid #689DED;">'.number_format($resultado['Febrero'],'0',',','.').'</td>';
					echo '<td style="border-top: 1px solid #689DED;">'.number_format($resultado['Marzo'],'0',',','.').'</td>';
					echo '<td style="border-top: 1px solid #689DED;">'.number_format($resultado['Abril'],'0',',','.').'</td>';
					echo '<td style="border-top: 1px solid #689DED;">'.number_format($resultado['Mayo'],'0',',','.').'</td>';
					echo '<td style="border-top: 1px solid #689DED;">'.number_format($resultado['Junio'],'0',',','.').'</td>';
					echo '<td style="border-top: 1px solid #689DED;">'.number_format($resultado['Julio'],'0',',','.').'</td>';
					echo '<td style="border-top: 1px solid #689DED;">'.number_format($resultado['Agosto'],'0',',','.').'</td>';
					echo '<td style="border-top: 1px solid #689DED;">'.number_format($resultado['Septiembre'],'0',',','.').'</td>';
					echo '<td style="border-top: 1px solid #689DED;">'.number_format($resultado['Octubre'],'0',',','.').'</td>';
					echo '<td style="border-top: 1px solid #689DED;">'.number_format($resultado['Noviembre'],'0',',','.').'</td>';
					echo '<td style="border-top: 1px solid #689DED;">'.number_format($resultado['Diciembre'],'0',',','.').'</td>';
					echo '<td style="border-top: 1px solid #689DED;">'.number_format($resultado['Total_UNDS'],'0',',','.').'</td>';
					echo '<td style="border-top: 1px solid #689DED; border-left: 1px solid #689DED;">'.number_format($resultado['Total_CLP'],'0',',','.').'</td>';
					echo '<td style="border-top: 1px solid #689DED;">'.number_format($resultado['Total_USD'],'2',',','.').'</td>';
					
					$totalPrecioCompra = $resultado['PrecioCompra'] * $resultado['Total_UNDS'];
					echo '<td style="border-top: 1px solid #689DED;">'.number_format($totalPrecioCompra,'2',',','').'</td>';
					
					$varUSD = $resultado['Total_USD'];
					$varCtoVtaCIF = $resultado['CtoVtaCIF'];
					if($varUSD == '0' || $varCtoVtaCIF == '0'){
						$margen = '-';
						echo '<td style="border-top: 1px solid #689DED; text-align:right;">'.$margen.'</td>';
					}else{
						$margen = ((($varUSD - $varCtoVtaCIF)*100)/ $varUSD);
						if($margen<0){
							echo '<td style="border-top: 1px solid #689DED; background-color:#FF0000; color:#fff;">'.number_format($margen,'0',',','.').'%</td>'; //MARGEN NEGATIVO VIGENTE
						}else{
							echo '<td style="border-top: 1px solid #689DED;">'.number_format($margen,'0',',','.').'%</td>';
						}
					}
					
					echo '<td style="border-top: 1px solid #689DED;">'.number_format($resultado['PrecioCompra'],'2',',','').'</td>';
					
					echo '<td style="border-top: 1px solid #689DED;">'.number_format($resultado['CtoVtaCIF'],'2',',','.').'</td>';
					echo '<td style="border-top: 1px solid #689DED; border-left: 1px solid #689DED; ">'.number_format($resultado['Stock'],'0',',','.').'</td>';
					if($resultado['Stock'] == 0){
						echo '<td style="border-top: 1px solid #689DED; border-right: 1px solid #689DED;">'.number_format(0,'2',',','.').'</td>';
					}else{
						echo '<td style="border-top: 1px solid #689DED; border-right: 1px solid #689DED;">'.number_format($resultado['Cif_Total'],'2',',','.').'</td>';
						$acumCIFTotal = $acumCIFTotal + $resultado['Cif_Total'];
					}
					//echo '<td style="border-top: 1px solid #689DED; border-left: 1px solid #689DED;">'.number_format($resultado['PrePacks'],'0',',','.').'</td>';
					echo '<td style="border-top: 1px solid #689DED;">'.number_format($resultado['RetailDutyFree'],'2',',','').'</td>';
					//echo '<td style="border-top: 1px solid #689DED;">--</td>';
					echo '<td style="border-top: 1px solid #689DED;">'.number_format($resultado['RetailUSA'],'2',',','').'</td>';
					//echo '<td style="border-top: 1px solid #689DED;>'.number_format($resultado['LPC_Precio'],'2',',','').'</td>';
					$repiteLinea = utf8_encode($resultado['LINEA']);
				}
				echo '</tr>';
				$acumTotalUnidades = $acumTotalUnidades + $resultado['Total_UNDS'];
				$acumTotalCLP = $acumTotalCLP + $resultado['Total_CLP'];
				$acumTotalUSD = $acumTotalUSD + $resultado['Total_USD'];
				$acumVtaCIF = $acumVtaCIF + $resultado['CtoVtaCIF'];
				$acumStock = $acumStock + $resultado['Stock'];
				
			}
			echo '<tr>';
				echo '<td style="border-top: 1px solid #689DED; text-align:left; font-weight:bold;">SUB TOTAL DESCONTINUADO</td>';
				echo '<td style="border-top: 1px solid #689DED;"></td>';
				echo '<td style="border-top: 1px solid #689DED;"></td>';
				echo '<td style="border-top: 1px solid #689DED;"></td>';
				echo '<td style="border-top: 1px solid #689DED;"></td>';
				echo '<td style="border-top: 1px solid #689DED;"></td>';
				echo '<td style="border-top: 1px solid #689DED;"></td>';
				echo '<td style="border-top: 1px solid #689DED;"></td>';
				echo '<td style="border-top: 1px solid #689DED;"></td>';
				echo '<td style="border-top: 1px solid #689DED;"></td>';
				echo '<td style="border-top: 1px solid #689DED;"></td>';
				echo '<td style="border-top: 1px solid #689DED;"></td>';
				echo '<td style="border-top: 1px solid #689DED;"></td>';
				echo '<td style="border-top: 1px solid #689DED;"></td>';
				echo '<td style="border: 1px solid #689DED; font-weight:bold;">Totales</td>';
				echo '<td style="border: 1px solid #689DED; font-weight: bold;">'.number_format($acumSubTotalTotalUnidadesDescontinuado,'0',',','.').'</td>';
				echo '<td style="border: 1px solid #689DED; font-weight: bold;">'.number_format($acumSubTotalTotalCLPDescontinuado,'0',',','.').'</td>';
				echo '<td style="border: 1px solid #689DED; font-weight: bold;">'.number_format($acumSubTotalTotalUSDDescontinuado,'2',',','.').'</td>';
				echo '<td style="border-top: 1px solid #689DED;"></td>';
				echo '<td style="border-top: 1px solid #689DED;"></td>';
				echo '<td style="border-top: 1px solid #689DED;"></td>';
				echo '<td style="border: 1px solid #689DED; font-weight: bold;">'.number_format($acumSubTotalVtaCIFDescontinuado,'2',',','.').'</td>';
				echo '<td style="border: 1px solid #689DED; font-weight: bold;">'.number_format($acumSubTotalStockDescontinuado,'0',',','.').'</td>';
				echo '<td style="border: 1px solid #689DED; font-weight: bold;">'.number_format(($acumCIFTotal - $descCIF),'2',',','.').'</td>';
				echo '<td style="border-top: 1px solid #689DED;"></td>';
				echo '<td style="border-top: 1px solid #689DED;"></td>';
			echo '</tr>';
			
			echo '<tr>';
				echo '<td style="border-top: 1px solid #689DED; text-align:left; font-weight:bold;">TOTAL GENERAL</td>';
				echo '<td style="border-top: 1px solid #689DED;"></td>';
				echo '<td style="border-top: 1px solid #689DED;"></td>';
				echo '<td style="border-top: 1px solid #689DED;"></td>';
				echo '<td style="border-top: 1px solid #689DED;"></td>';
				echo '<td style="border-top: 1px solid #689DED;"></td>';
				echo '<td style="border-top: 1px solid #689DED;"></td>';
				echo '<td style="border-top: 1px solid #689DED;"></td>';
				echo '<td style="border-top: 1px solid #689DED;"></td>';
				echo '<td style="border-top: 1px solid #689DED;"></td>';
				echo '<td style="border-top: 1px solid #689DED;"></td>';
				echo '<td style="border-top: 1px solid #689DED;"></td>';
				echo '<td style="border-top: 1px solid #689DED;"></td>';
				echo '<td style="border-top: 1px solid #689DED;"></td>';
				echo '<td style="border: 1px solid #689DED; font-weight:bold;">Totales</td>';
				echo '<td style="border: 1px solid #689DED; font-weight: bold;">'.number_format(($acumSubTotalTotalUnidadesVigente + $acumSubTotalTotalUnidadesDescontinuado),'0',',','.').'</td>';
				echo '<td style="border: 1px solid #689DED; font-weight: bold;">'.number_format($acumTotalCLP,'0',',','.').'</td>';
				echo '<td style="border: 1px solid #689DED; font-weight: bold;">'.number_format($acumTotalUSD,'2',',','.').'</td>';
				echo '<td style="border-top: 1px solid #689DED;"></td>';
				echo '<td style="border-top: 1px solid #689DED;"></td>';
				echo '<td style="border-top: 1px solid #689DED;"></td>';
				echo '<td style="border: 1px solid #689DED; font-weight: bold;">'.number_format($acumVtaCIF,'2',',','.').'</td>';
				echo '<td style="border: 1px solid #689DED; font-weight: bold;">'.number_format($acumStock,'0',',','.').'</td>';
				echo '<td style="border: 1px solid #689DED; font-weight: bold;">'.number_format($acumCIFTotal,'2',',','.').'</td>';
				echo '<td style="border-top: 1px solid #689DED;"></td>';
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
