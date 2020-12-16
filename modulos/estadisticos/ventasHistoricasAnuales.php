<script type="text/javascript" src="js/jquery.base64.js"></script>
<script type="text/javascript" src="js/jquery.btechco.excelexport.js"></script>

<?php
set_time_limit(600);
require_once("clases/conexionocdb.php");
$consultar = $_GET['agregar'];
$anio = date("Y");
if($consultar){
	$plazo = $_GET['plazo'];
	$anio_desde = $anio - $plazo;
}
$cont = $_GET['cont'];
$seis_anios = array();
$tres_anios = array();
$total_modulo = array();
$total_galpon = array();
$total_mensual = array();
$total_acumulada = array();
$total_prom_seis_anio = array();
$total_prom_anio_anterior = array();
$total_prom_anio_actual = array();
$total_prom_tres_anio = array();
$total_cif = array();
$TABLA = array();
$TABLA = array (
	1 => array (
		2000 => 325109,
		2001 => 294449,
		2002 => 247239, 
		2003 => 252242,
		2004 => 259001,
		2005 => 228252,
		2006 => 396717,
		2007 => 437693,
		2008 => 518111,
		2009 => 547126,
		2010 => 916147,
		2011 => 915853,
		2012 => 1065220,
		2013 => 1231994,
		2014 => 1236854,
		"Galpon" => 3000 
	),
	2 => array (
		2000 => 516747,
		2001 => 406193,
		2002 => 322681, 
		2003 => 268251,
		2004 => 350872,
		2005 => 336939,
		2006 => 489497,
		2007 => 505473,
		2008 => 842910,
		2009 => 623132,
		2010 => 1037710,
		2011 => 1298098,
		2012 => 1484379,
		2013 => 1698703,
		2014 => 1500045,
		"Galpon" => 7000 
	),
	3 => array (
		2000 => 369599,
		2001 => 305228,
		2002 => 278758, 
		2003 => 218589,
		2004 => 222045,
		2005 => 276076,
		2006 => 405530,
		2007 => 465924,
		2008 => 749342,
		2009 => 452289,
		2010 => 618900,
		2011 => 1008875,
		2012 => 1162730,
		2013 => 1506554,
		2014 => 1071808,
		"Galpon" => 12000
	),
	4 => array (
		2000 => 363866,
		2001 => 325893,
		2002 => 216382, 
		2003 => 240288,
		2004 => 289562,
		2005 => 289530,
		2006 => 458365,
		2007 => 465712,
		2008 => 759661,
		2009 => 534862,
		2010 => 792295,
		2011 => 1178031,
		2012 => 1373957,
		2013 => 1415443,
		2014 => 386624,
		"Galpon" => 17000
	),
	5 => array (
		2000 => 402584,
		2001 => 337767,
		2002 => 276891, 
		2003 => 307694,
		2004 => 300001,
		2005 => 328026,
		2006 => 402308,
		2007 => 622466,
		2008 => 922295,
		2009 => 855030,
		2010 => 1004329,
		2011 => 1252941,
		2012 => 1360590,
		2013 => 1558273,
		2014 => 1390885,
		"Galpon" => 5000
	),
	6=> array (
		2000 => 381759,
		2001 => 307771,
		2002 => 230586, 
		2003 => 248479,
		2004 => 295998,
		2005 => 321611,
		2006 => 412594,
		2007 => 525818,
		2008 => 713885,
		2009 => 807285,
		2010 => 959092,
		2011 => 1157463,
		2012 => 1292232,
		2013 => 1346002,
		2014 => 1170708,
		"Galpon" => 30000
	),
	7 => array (
		2000 => 475423,
		2001 => 349396,
		2002 => 357729, 
		2003 => 334205,
		2004 => 377816,
		2005 => 399310,
		2006 => 517215,
		2007 => 681127,
		2008 => 942111,
		2009 => 876100,
		2010 => 1218183,
		2011 => 1515481,
		2012 => 1649987,
		2013 => 1524338,
		2014 => 1536882,
		"Galpon" => 23000 
	),
	8 => array (
		2000 => 425219,
		2001 => 242576,
		2002 => 258738, 
		2003 => 262705,
		2004 => 259317,
		2005 => 399173,
		2006 => 457979,
		2007 => 569314,
		2008 => 947839,
		2009 => 789653,
		2010 => 1059593,
		2011 => 1312070,
		2012 => 1398793,
		2013 => 1354640,
		2014 => 1313686,
		"Galpon" => 22000 
	),
	9 => array (
		2000 => 430933,
		2001 => 282842,
		2002 => 267935, 
		2003 => 289285,
		2004 => 272409,
		2005 => 428299,
		2006 => 508411,
		2007 => 583177,
		2008 => 833751,
		2009 => 733223,
		2010 => 1125310,
		2011 => 1219137,
		2012 => 1429881,
		2013 => 1144156,
		2014 => 1087000,
		"Galpon" => 16000 
	),
	10 => array (
		2000 => 367798,
		2001 => 255046,
		2002 => 284598, 
		2003 => 321880,
		2004 => 409291,
		2005 => 506105,
		2006 => 549292,
		2007 => 778557,
		2008 => 838263,
		2009 => 950138,
		2010 => 1318685,
		2011 => 1632834,
		2012 => 1639975,
		2013 => 1389589,
		2014 => 1254380,
		"Galpon" => 37000
	),
	11 => array (
		2000 => 492356,
		2001 => 344090,
		2002 => 365596, 
		2003 => 351105,
		2004 => 358013,
		2005 => 562253,
		2006 => 692585,
		2007 => 911655,
		2008 => 931851,
		2009 => 1139416,
		2010 => 1265511,
		2011 => 1426729,
		2012 => 1896144,
		2013 => 1817154,
		2014 => 1380240,
		"Galpon" => 28000 
	),
	12 => array (
		2000 => 646759,
		2001 => 576529,
		2002 => 570883, 
		2003 => 564014,
		2004 => 584304,
		2005 => 841575,
		2006 => 1135116,
		2007 => 1390104,
		2008 => 1422600,
		2009 => 1978254,
		2010 => 2219101,
		2011 => 2621049,
		2012 => 3494273,
		2013 => 2633397,
		2014 => 2618166,
		"Galpon" => 26000
	)
);
$sql="SELECT 
	Periodo
	,SUM(CtoVtaCIF) AS CIF
	,SUM(Total_CLP) AS TOTAL_PESO
	,SUM(Total_USD) AS TOTAL_DOLAR
FROM SBO_Imp_Eximben_SAC.[dbo].[VIC_VW_Ventas]
WHERE 
	Empresa NOT LIKE '%EXB_AEROP%'
	AND TipoProducto LIKE 'Producto Regular'
	AND Periodo BETWEEN '2015-01' AND '2030-12'
GROUP BY Periodo
ORDER BY Periodo ASC;";
?>
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
<div class="idTabs">
	<ul>
		<li><a href="#one"><img src="images/agregar.png" width="30px" height="30px" /></a></li>
	</ul>
	<div class="items">
		<div id="one">
        	<form action="" method="GET" id="horizontalForm">
            	<fieldset>
					<legend>Ventas Historicas Anuales</legend>
						<input name="opc" type="hidden" id="opc" class="required" value="ventasAnuales" />
                    	<label class="first" for="bodega"> Plazo
                    	<select id="plazo" name="plazo" class="styled" >
                        	<option value = ''></option>
							<option value = '3'>Corto Plazo (3 Años)</option>
							<option value = '6'>Mediano Plazo (6 Años)</option>
							<option value = '10'>Largo Plazo (10 Años)</option>
						</select>
                    	</label>
						<input name="cont" type="hidden" id="cont" size="40" class="required" value="1" />
						<input style="clear:initial;" name="agregar" type="submit" id="agregar" class="submit" value="Consultar" />
				</fieldset>
			</form>
		</div> <!-- fin div one-->
	</div> <!-- fin items -->
</div> <!-- fin idTabs -->
<div id="preloader">
	<div id="status">&nbsp;<?php if($cont == 1){echo 'Un momento por favor, estamos generando su reporte.';}?></div>
</div>
<!-- Formulario de descarga -->
<div id="dialogDescarga" title="Ventas Historicas por Marca">
		<img src="images/export_excel.png" id="descargarExcel" style="display: block; margin-left: auto; margin-right: auto; cursor:pointer;"/>
		<p style="text-align:center;">Click en la imagen <br>para descargar</p>
</div>


<?php
if($consultar){

	  $rs = odbc_exec( $conn, $sql );
	  if ( !$rs){
		  exit( "Error en la consulta SQL" );
	  }
	  $periodo = 0;
	  
	  while($resultado = odbc_fetch_array($rs)){
		  list($periodoAnio, $periodoMes) = split('[-]', $resultado["Periodo"]);
		  $periodoMes=(string)(int)$periodoMes; //QUITAMOS EL CERO DEL MES ES DECIR 01 queda en 1
		  $TABLA[$periodoMes][$periodoAnio] = round($resultado["TOTAL_DOLAR"]); 
		  if($periodoAnio == $anio){
			  $total_cif[$periodoMes][$periodoAnio] = round($resultado["CIF"]); 
		  }
	  }
	  
	  for($mes=1;$mes<=12;$mes++){
		  $seis_anios[$mes] = $TABLA[$mes][$anio-5]+$TABLA[$mes][$anio-4]+$TABLA[$mes][$anio-3]+$TABLA[$mes][$anio-2]+$TABLA[$mes][$anio-1]+$TABLA[$mes][$anio];
		  $tres_anios[$mes] = $TABLA[$mes][$anio-3]+$TABLA[$mes][$anio-2]+$TABLA[$mes][$anio-1];
	  }
	  $total_seis_anios = $seis_anios[1]+$seis_anios[2]+$seis_anios[3]+$seis_anios[4]+$seis_anios[5]+$seis_anios[6]+$seis_anios[7]+$seis_anios[8]+$seis_anios[9]+$seis_anios[10]+$seis_anios[11]+$seis_anios[12];
	  
	  $total_anio_anterior = $TABLA[1][$anio-1]+$TABLA[2][$anio-1]+$TABLA[3][$anio-1]+$TABLA[4][$anio-1]+$TABLA[5][$anio-1]+$TABLA[6][$anio-1]+$TABLA[7][$anio-1]+$TABLA[8][$anio-1]+$TABLA[9][$anio-1]+$TABLA[10][$anio-1]+$TABLA[11][$anio-1]+$TABLA[12][$anio-1];
	  
	  $total_anio = $TABLA[1][$anio]+$TABLA[2][$anio]+$TABLA[3][$anio]+$TABLA[4][$anio]+$TABLA[5][$anio]+$TABLA[6][$anio]+$TABLA[7][$anio]+$TABLA[8][$anio]+$TABLA[9][$anio]+$TABLA[10][$anio]+$TABLA[11][$anio]+$TABLA[12][$anio];
	  
	  $total_tres_anios=$tres_anios[1]+$tres_anios[2]+$tres_anios[3]+$tres_anios[4]+$tres_anios[5]+$tres_anios[6]+$tres_anios[7]+$tres_anios[8]+$tres_anios[9]+$tres_anios[10]+$tres_anios[11]+$tres_anios[12];
}

if($consultar){ ?>




<div id="dv">
<table id="ssptable2" class="lista" style="display:none;">
	<thead>
    	<tr>
        	<th colspan="2" width="85"></th>
        	<th colspan="16" width="114" style="font-size:24px; text-decoration:blink;" align="left">VENTAS HISTORICAS EN US$ - 
				<?php 
                    $fecha = date("m"); 
                    switch($fecha){
                        case 1: echo "ENERO"; break;
                        case 2: echo "FEBRERO"; break;
                        case 3: echo "MARZO"; break;
                        case 4: echo "ABRIL"; break;
                        case 5: echo "MAYO"; break;
                        case 6: echo "JUNIO"; break;
                        case 7: echo "JULIO"; break;
                        case 8: echo "AGOSTO"; break;
                        case 9: echo "SEPTIEMBRE"; break;
                        case 10: echo "OCTUBRE"; break;
                        case 11: echo "NOVIEMBRE"; break;
                        case 12: echo "DICIEMBRE"; break;
                    }
                ?>
            </th>
		</tr>
    </thead>
    <thead>
    	<tr>
        	<th colspan="2" width="85"></th>
			<th colspan="16" width="114" style="font-size:14px; text-decoration:blink;" align="left">FECHA: <?php echo date("d/m/Y"); ?></th>
		</tr>
    </thead>
	<thead>
    	<tr>
            <?php
	 			for($i=$anio_desde;$i<=$anio;$i++){
					echo '<th width="85"></th>';
				}
	 		?>
            <th width="85"></th>
            <th width="85"></th>
            <th width="85"></th>
        	<th colspan="2" width="114"></th>
			<th colspan="2" width="114" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">ESTIMADO <?php echo $anio; ?></th>
			<th width="85" style="border-top: 2px solid #689DED; border-right: 2px solid #689DED; border-left: 2px solid #689DED; background-color:#DCE6F1;">PROMEDIO</th>
            <th width="85" style="border-top: 2px solid #689DED; border-right: 2px solid #689DED; border-left: 2px solid #689DED; background-color:#DCE6F1;">VENTA</th>
            <th width="85"></th>
            <th width="85"></th>
            <th width="85"></th>
			<th width="85" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-right: 2px solid #689DED; background-color:#DCE6F1;">% PROM</th>
		</tr>
    </thead>
    <thead>
		<tr>
			 <?php
	 			for($i=$anio_desde;$i<=$anio;$i++){
					echo '<th width="85"></th>';
				}
	 		?>
            <th width="85"></th>
            <th width="85"></th>
            <th width="85"></th>
			<th width="85" style="border-top: 2px solid #689DED; border-right: 2px solid #689DED; border-left: 2px solid #689DED; background-color:#DCE6F1;">TTL.DIFE</th>
			<th width="85" style="border-top: 2px solid #689DED; border-right: 2px solid #689DED;  border-left: 2px solid #689DED; background-color:#DCE6F1;">TT.VTA</th>
			<th width="85" style="background-color:#DCE6F1; border-left: 2px solid #689DED; border-right: 2px solid #689DED;" valign="bottom">MODULO</th>
			<th width="85" style="background-color:#DCE6F1; border-left: 2px solid #689DED; border-right: 2px solid #689DED;" valign="bottom">Galpon</th>
			<th width="85" style="background-color:#DCE6F1; border-left: 2px solid #689DED; border-right: 2px solid #689DED;">MENSUAL</th>
			<th width="85" style="background-color:#DCE6F1; border-left: 2px solid #689DED; border-right: 2px solid #689DED;">ACUMULADA</th>
			<th width="85" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-right: 2px solid #689DED; background-color:#DCE6F1;">6 AÑOS</th>
			<th width="85" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-right: 2px solid #689DED; background-color:#DCE6F1;">% PROM</th>
			<th width="85" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-right: 2px solid #689DED; background-color:#DCE6F1;">% PROM</th>
			<th width="85" style="border-right: 2px solid #689DED; border-left: 2px solid #689DED; border-right: 2px solid #689DED; background-color:#DCE6F1;">3 AÑOS</th>
		</tr>
	</thead>
    <thead>
		<tr>
			<th style="border-bottom: 2px solid #689DED; border-right: 2px solid #689DED;"></th>
		<?php
	 		for($i=$anio_desde;$i<=$anio;$i++){
				echo '<th width="85" style="border-bottom: 2px solid #689DED; border-top: 2px solid #689DED; border-right: 2px solid #689DED; border-left: 2px solid #689DED; background-color:#DCE6F1;">'.$i.'</th>';
			}
	 	?>
        <th width="85" style="border-bottom: 2px solid #689DED; border-top: 2px solid #689DED; border-right: 2px solid #689DED; border-left: 2px solid #689DED; background-color:#DCE6F1;">CIF <?php echo $anio; ?></th>
        <th width="100" style="border-bottom: 2px solid #689DED; border-top: 2px solid #689DED; border-right: 2px solid #689DED; border-left: 2px solid #689DED; background-color:#DCE6F1;">RENTABILIDAD</th>
		<th width="85" style="border-bottom: 2px solid #689DED; border-right: 2px solid #689DED; border-left: 2px solid #689DED; background-color:#DCE6F1;"><?php echo utf8_encode($anio-1 .'-'. $anio); ?></th>
		<th width="85" style="border-bottom: 2px solid #689DED; border-right: 2px solid #689DED; border-left: 2px solid #689DED; background-color:#DCE6F1;"><?php echo utf8_encode("ACUM ". $anio); ?></th>
		<th width="85" style="border-bottom: 2px solid #689DED; border-right: 2px solid #689DED; border-left: 2px solid #689DED; background-color:#DCE6F1;">40% / 12</th>
		<th width="85" style="border-bottom: 2px solid #689DED; border-right: 2px solid #689DED; border-left: 2px solid #689DED; background-color:#DCE6F1;"></th>
		<th width="85" style="border-bottom: 2px solid #689DED; border-right: 2px solid #689DED; border-left: 2px solid #689DED; background-color:#DCE6F1;">6 AÑOS</th>
		<th width="85" style="border-bottom: 2px solid #689DED; border-right: 2px solid #689DED; border-left: 2px solid #689DED; background-color:#DCE6F1;">6 AÑOS</th>
		<th width="85" style="border-bottom: 2px solid #689DED; border-right: 2px solid #689DED; border-left: 2px solid #689DED; background-color:#DCE6F1;">%</th>
		<th width="85" style="border-bottom: 2px solid #689DED; border-right: 2px solid #689DED; border-left: 2px solid #689DED; background-color:#DCE6F1;">AÑO <?php echo $anio-1; ?></th>
		<th width="85" style="border-bottom: 2px solid #689DED; border-right: 2px solid #689DED; border-left: 2px solid #689DED; background-color:#DCE6F1;">AÑO <?php echo $anio; ?></th>
		<th width="85" style="border-bottom: 2px solid #689DED; border-right: 2px solid #689DED; border-left: 2px solid #689DED; background-color:#DCE6F1;"><?php echo $anio-3; ?> - <?php echo $anio-2; ?> - <?php echo $anio-1; ?></th>
	</tr>
    </thead>
    <tbody>
		<?php
            $mes = 1;
            while($mes < 13){
        ?>
		<tr>
			<td width="85" style="border-left: 2px solid #689DED; border-right: 2px solid #689DED; background-color:#DCE6F1;">
			<?php 
                switch($mes){
                    case 1: 
                        echo "ENE"; 
                        break;
                    case 2: 
                        echo "FEB";
                        break;
                    case 3: 
                        echo "MAR";
                        break;
                    case 4: 
                        echo "ABR";
                        break;
                    case 5: 
                        echo "MAY";
                        break;
                    case 6: 
                        echo "JUN";
                        break;
                    case 7: 
                        echo "JUL";
                        break;
                    case 8: 
                        echo "AGO";
                        break;
                    case 9: 
                        echo "SEP";
                        break;
                    case 10: 
                        echo "OCT";
                        break;
                    case 11: 
                        echo "NOV";
                        break;
                    case 12: 
                        echo "DIC";
                        break;
                }
            ?>
            </td>
            <?php
                for($i=$anio_desde;$i<=$anio;$i++){
                    echo '<td width="85">'.number_format($TABLA[$mes][$i], 0, ',', '.').'</td>';
                }
            ?>
            <td align="right" width="85"><?php echo number_format($total_cif[$mes][$anio], 0, ',', '.'); ?></td>
            <td align="right" width="85"><?php if($TABLA[$mes][$anio] != 0){ echo number_format(($TABLA[$mes][$anio]-$total_cif[$mes][$anio])/$TABLA[$mes][$anio], 2, ',', '.'); } else { echo 0; }?> %</td> 
            <td align="right" width="85"><?php echo number_format($TABLA[$mes][$anio] - $TABLA[$mes][$anio-1], 0, ',', '.'); ?></td>
            <td width="85"><?php echo number_format($TABLA[$mes][$anio], 0, ',', '.'); ?></td>
            <td width="85"><?php $total_modulo[$mes] += $TABLA[$mes][$anio-1]*1.4; echo number_format($TABLA[$mes][$anio-1]*1.4, 0, ',', '.'); ?></td> <!-- MODULO +40%/12 -->
            <td width="85"><?php $total_galpon[$mes] += $TABLA[$mes]["Galpon"];  echo number_format($TABLA[$mes]["Galpon"], 0, ',', '.'); ?></td> <!-- GALPON -->
            <td width="85"><?php $total_mensual[$mes] += $seis_anios[$mes]/6; echo number_format($seis_anios[$mes]/6, 0, ',', '.'); ?></td> <!-- PROMEDIO MENSUAL 6 AÑOS -->
            <td width="85"><?php $total_acumulada[$mes] += $seis_anios[$mes]; echo number_format($seis_anios[$mes], 0, ',', '.'); ?></td> <!-- VENTA ACUMULADA 6 AÑOS % -->
            <td width="85"><?php $total_prom_seis_anio[$mes] += ($seis_anios[$mes]*100)/$total_seis_anios; echo number_format(($seis_anios[$mes]*100)/$total_seis_anios, 0, ',', '.') ."%"; ?></td> <!-- 6 AÑOS % -->
            <td width="85"><?php $total_prom_anio_anterior[$mes] += ($TABLA[$mes][$anio-1]*100)/$total_anio_anterior; echo number_format(($TABLA[$mes][$anio-1]*100)/$total_anio_anterior, 0, ',', '.') ."%"; ?></td> <!-- % PROM AÑO 2014 -->
            <td width="85"><?php $total_prom_anio_actual[$mes] += ($TABLA[$mes][$anio]*100)/$total_anio; echo number_format(($TABLA[$mes][$anio]*100)/$total_anio, 0, ',', '.') ."%"; ?></td> <!-- % PROM AÑO 2015 -->
            <td width="85" style="border-right: 2px solid #689DED;"><?php $total_prom_tres_anio[$mes] += ($tres_anios[$mes]*100)/$total_tres_anios; echo number_format(($tres_anios[$mes]*100)/$total_tres_anios, 0, ',', '.') ."%"; ?></td>
        </tr>
    <?php $mes++; } ?>
    	<tr>
        	<td width="85" style="border-top: 2px solid #689DED; border-bottom: 2px solid #689DED; border-right: 2px solid #689DED; background-color:#DCE6F1;">TOT..US$</td>
        <?php 
			for($ianio=$anio_desde;$ianio<=$anio;$ianio++){
				$total_anio = 0; 
				for($imes=1;$imes<=12;$imes++){
					$total_anio = $total_anio + $TABLA[$imes][$ianio];
				}
				echo '<td align="right" style="border-top: 2px solid #689DED; border-bottom: 2px solid #689DED;" width="85">'. number_format($total_anio, 0, ',', '.') .'</td>';
			}
        ?>
        	<td width="85" style="border-top: 2px solid #689DED; border-bottom: 2px solid #689DED;"></td>
        	<td width="85" style="border-top: 2px solid #689DED; border-bottom: 2px solid #689DED;"></td>
            <td width="85" style="border-top: 2px solid #689DED; border-bottom: 2px solid #689DED;"></td>
            <td width="85" style="border-top: 2px solid #689DED; border-bottom: 2px solid #689DED;"></td>
        	<td align="right" width="85" style="border-top: 2px solid #689DED; border-bottom: 2px solid #689DED;"><?php echo number_format($total_modulo[1] + $total_modulo[2] + $total_modulo[3] + $total_modulo[4] + $total_modulo[5] + $total_modulo[6] + $total_modulo[7] + $total_modulo[8] + $total_modulo[9] + $total_modulo[10] + $total_modulo[11] + $total_modulo[12], 0, ',', '.'); ?></td>
        	<td align="right" width="85" style="border-top: 2px solid #689DED; border-bottom: 2px solid #689DED;"><?php echo number_format($total_galpon[1] + $total_galpon[2] + $total_galpon[3] + $total_galpon[4] + $total_galpon[5] + $total_galpon[6] + $total_galpon[7] + $total_galpon[8] + $total_galpon[9] + $total_galpon[10] + $total_galpon[11] + $total_galpon[12], 0, ',', '.'); ?></td>
        	<td align="right" width="85" style="border-top: 2px solid #689DED; border-bottom: 2px solid #689DED;"><?php echo number_format($total_mensual[1] + $total_mensual[2] + $total_mensual[3] + $total_mensual[4] + $total_mensual[5] + $total_mensual[6] + $total_mensual[7] + $total_mensual[8] + $total_mensual[9] + $total_mensual[10] + $total_mensual[11] + $total_mensual[12], 0, ',', '.'); ?></td>
        	<td align="right" width="85" style="border-top: 2px solid #689DED; border-bottom: 2px solid #689DED;"><?php echo number_format($total_acumulada[1] + $total_acumulada[2] + $total_acumulada[3] + $total_acumulada[4] + $total_acumulada[5] + $total_acumulada[6] + $total_acumulada[7] + $total_acumulada[8] + $total_acumulada[9] + $total_acumulada[10] + $total_acumulada[11] + $total_acumulada[12], 0, ',', '.'); ?></td>
       		<td align="right" width="85" style="border-top: 2px solid #689DED; border-bottom: 2px solid #689DED;"><?php echo number_format($total_prom_seis_anio[1] + $total_prom_seis_anio[2] + $total_prom_seis_anio[3] + $total_prom_seis_anio[4] + $total_prom_seis_anio[5] + $total_prom_seis_anio[6] + $total_prom_seis_anio[7] + $total_prom_seis_anio[8] + $total_prom_seis_anio[9] + $total_prom_seis_anio[10] + $total_prom_seis_anio[11] + $total_prom_seis_anio[12], 0, ',', '.'). "%"; ?></td>
        	<td align="right" width="85" style="border-top: 2px solid #689DED; border-bottom: 2px solid #689DED;"><?php echo number_format($total_prom_anio_anterior[1] + $total_prom_anio_anterior[2] + $total_prom_anio_anterior[3] + $total_prom_anio_anterior[4] + $total_prom_anio_anterior[5] + $total_prom_anio_anterior[6] + $total_prom_anio_anterior[7] + $total_prom_anio_anterior[8] + $total_prom_anio_anterior[9] + $total_prom_anio_anterior[10] + $total_prom_anio_anterior[11] + $total_prom_anio_anterior[12], 0, ',', '.'). "%"; ?></td>
        	<td align="right" width="85" style="border-top: 2px solid #689DED; border-bottom: 2px solid #689DED;"><?php echo number_format($total_prom_anio_actual[1] + $total_prom_anio_actual[2] + $total_prom_anio_actual[3] + $total_prom_anio_actual[4] + $total_prom_anio_actual[5] + $total_prom_anio_actual[6] + $total_prom_anio_actual[7] + $total_prom_anio_actual[8] + $total_prom_anio_actual[9] + $total_prom_anio_actual[10] + $total_prom_anio_actual[11] + $total_prom_anio_actual[12], 0, ',', '.'). "%"; ?></td>
        	<td align="right" width="85" style="border-top: 2px solid #689DED; border-bottom: 2px solid #689DED; border-right: 2px solid #689DED;"><?php echo number_format($total_prom_tres_anio[1] + $total_prom_tres_anio[2] + $total_prom_tres_anio[3] + $total_prom_tres_anio[4] + $total_prom_tres_anio[5] + $total_prom_tres_anio[6] + $total_prom_tres_anio[7] + $total_prom_tres_anio[8] + $total_prom_tres_anio[9] + $total_prom_tres_anio[10] + $total_prom_tres_anio[11] + $total_prom_tres_anio[12], 0, ',', '.'). "%"; ?></td>
		</tr>
    </tbody>
    <thead>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    </thead>
   	<thead>
    	<tr>
            <?php
	 			for($i=$anio_desde;$i<=$anio;$i++){
					echo '<th width="85"></th>';
				}
	 		?>
            <th width="85"></th>
        	<th colspan="2" width="114"></th>
			<th colspan="2" width="114"></th>
			<th width="85" style="border-top: 2px solid #689DED; border-right: 2px solid #689DED; border-left: 2px solid #689DED; background-color:#DCE6F1;">PROMEDIO</th>
            <th width="85" style="border-top: 2px solid #689DED; border-right: 2px solid #689DED; border-left: 2px solid #689DED; background-color:#DCE6F1;">VENTA</th>
            <th width="85"></th>
            <th width="85"></th>
            <th width="85"></th>
			<th width="85" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-right: 2px solid #689DED; background-color:#DCE6F1;">% PROM</th>
		</tr>
    </thead>
    <thead>
		<tr>
        	
			 <?php
	 			for($i=$anio_desde;$i<=$anio;$i++){
					echo '<th width="85"></th>';
				}
	 		?>
            <th width="85"></th>
			<th width="85" style="border-top: 2px solid #689DED; background-color:#DCE6F1; border-left: 2px solid #689DED; border-right: 2px solid #689DED;" valign="bottom">CRECIMIENTO</th>
			<th width="85"></th>
			<th width="85" style="border-top: 2px solid #689DED; background-color:#DCE6F1; border-left: 2px solid #689DED; border-right: 2px solid #689DED;" valign="bottom">MODULO</th>
			<th width="85" valign="bottom"></th>
			<th width="85" style="border-top: 2px solid #689DED; background-color:#DCE6F1; border-left: 2px solid #689DED; border-right: 2px solid #689DED;">MENSUAL</th>
			<th width="85" style="background-color:#DCE6F1; border-left: 2px solid #689DED; border-right: 2px solid #689DED;">ACUMULADA</th>
			<th width="85" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-right: 2px solid #689DED; background-color:#DCE6F1;">6 AÑOS</th>
			<th width="85" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-right: 2px solid #689DED; background-color:#DCE6F1;">% PROM</th>
			<th width="85" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-right: 2px solid #689DED; background-color:#DCE6F1;">% PROM</th>
			<th width="85" style="border-right: 2px solid #689DED; border-left: 2px solid #689DED; border-right: 2px solid #689DED; background-color:#DCE6F1;">3 AÑOS</th>
		</tr>
	</thead>
    <thead>
		<tr>
			<th style="border-bottom: 2px solid #689DED; border-right: 2px solid #689DED;"></th>
		<?php
	 		for($i=$anio_desde;$i<=$anio;$i++){
				echo '<th width="85" style="border-bottom: 2px solid #689DED; border-top: 2px solid #689DED; border-right: 2px solid #689DED; border-left: 2px solid #689DED; background-color:#DCE6F1;">'.$i.'</th>';
			}
	 	?>
		<th width="85" style="border-bottom: 2px solid #689DED; border-right: 2px solid #689DED; border-left: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($TABLA[$mes][$anio] - $TABLA[$mes][$anio-1], 0, ',', '.'); ?></th>
		<th width="85"></th>
		<th width="85" style="border-bottom: 2px solid #689DED; border-right: 2px solid #689DED; border-left: 2px solid #689DED; background-color:#DCE6F1;"><?php echo "40% / 12"; ?></th>
		<th width="85"></th>
		<th width="85" style="border-bottom: 2px solid #689DED; border-right: 2px solid #689DED; border-left: 2px solid #689DED; background-color:#DCE6F1;">6 AÑOS</th>
		<th width="85" style="border-bottom: 2px solid #689DED; border-right: 2px solid #689DED; border-left: 2px solid #689DED; background-color:#DCE6F1;">6 AÑOS</th>
		<th width="85" style="border-bottom: 2px solid #689DED; border-right: 2px solid #689DED; border-left: 2px solid #689DED; background-color:#DCE6F1;">%</th>
		<th width="85" style="border-bottom: 2px solid #689DED; border-right: 2px solid #689DED; border-left: 2px solid #689DED; background-color:#DCE6F1;"><?php echo $anio-1; ?></th>
		<th width="85" style="border-bottom: 2px solid #689DED; border-right: 2px solid #689DED; border-left: 2px solid #689DED; background-color:#DCE6F1;">AÑO <?php echo $anio; ?></th>
		<th width="85" style="border-bottom: 2px solid #689DED; border-right: 2px solid #689DED; border-left: 2px solid #689DED; background-color:#DCE6F1;"><?php echo $anio-3; ?> - <?php echo $anio-2; ?> - <?php echo $anio-1; ?></th>
	</tr>
    </thead>
    <tbody>
		<tr>
        	<td style="border-right: 2px solid #689DED; border-left: 2px solid #689DED; background-color:#DCE6F1;">1 TR</td>
            <?php
                for($i=$anio_desde;$i<=$anio;$i++){
                    echo '<td width="85">'.number_format($TABLA[1][$i]+$TABLA[2][$i]+$TABLA[3][$i], 0, ',', '.').'</td>';
                }
            ?>
            <td align="right" width="85" style="border-right: 2px solid #689DED;"><?php echo number_format(((($TABLA[1][$anio] + $TABLA[2][$anio] + $TABLA[3][$anio])-($TABLA[1][$anio-1] + $TABLA[2][$anio-1] + $TABLA[3][$anio-1]))*100)/($TABLA[1][$anio-1] + $TABLA[2][$anio-1] + $TABLA[3][$anio-1]), 0, ',', '.') ."%"; ?></td>
            <td width="85"></td>
            <td width="85" style="border-right: 2px solid #689DED; border-left: 2px solid #689DED;"><?php echo number_format($total_modulo[1] + $total_modulo[2] + $total_modulo[3], 0, ',', '.'); ?></td> <!-- MODULO +40%/12 -->
            <td width="85"></td> <!-- GALPON -->
            <td width="85" style="border-left: 2px solid #689DED;"><?php echo number_format($total_mensual[1] + $total_mensual[2] + $total_mensual[3], 0, ',', '.'); ?></td> <!-- PROMEDIO MENSUAL 6 AÑOS -->
            <td width="85"><?php echo number_format($total_acumulada[1] + $total_acumulada[2] + $total_acumulada[3], 0, ',', '.'); ?></td> <!-- VENTA ACUMULADA 6 AÑOS % -->
            <td width="85"><?php echo number_format($total_prom_seis_anio[1] + $total_prom_seis_anio[2] + $total_prom_seis_anio[3], 0, ',', '.') ."%"; ?></td> <!-- 6 AÑOS % -->
            <td width="85"><?php echo number_format($total_prom_anio_anterior[1] + $total_prom_anio_anterior[2] + $total_prom_anio_anterior[3], 0, ',', '.') ."%"; ?></td> <!-- % PROM AÑO 2014 -->
            <td width="85"><?php echo number_format($total_prom_anio_actual[1] + $total_prom_anio_actual[2] + $total_prom_anio_actual[3], 0, ',', '.') ."%"; ?></td> <!-- % PROM AÑO 2015 -->
            <td width="85" style="border-right: 2px solid #689DED;"><?php echo number_format($total_prom_tres_anio[1] + $total_prom_tres_anio[2] + $total_prom_tres_anio[3], 0, ',', '.') ."%"; ?></td>
        </tr>
        <tr>
        	<td style="border-right: 2px solid #689DED; border-left: 2px solid #689DED; background-color:#DCE6F1;">2 TR</td>
            <?php
                for($i=$anio_desde;$i<=$anio;$i++){
                    echo '<td width="85">'.number_format($TABLA[4][$i]+$TABLA[5][$i]+$TABLA[6][$i], 0, ',', '.').'</td>';
                }
            ?>
            <td align="right" width="85" style="border-right: 2px solid #689DED;"><?php echo number_format(((($TABLA[4][$anio] + $TABLA[5][$anio] + $TABLA[6][$anio])-($TABLA[4][$anio-1] + $TABLA[5][$anio-1] + $TABLA[6][$anio-1]))*100)/($TABLA[4][$anio-1] + $TABLA[5][$anio-1] + $TABLA[6][$anio-1]), 0, ',', '.') ."%"; ?></td>
            <td width="85"></td>
            <td width="85" style="border-right: 2px solid #689DED; border-left: 2px solid #689DED;"><?php echo number_format($total_modulo[4] + $total_modulo[5] + $total_modulo[6], 0, ',', '.'); ?></td> <!-- MODULO +40%/12 -->
            <td width="85"></td> <!-- GALPON -->
            <td width="85" style="border-left: 2px solid #689DED;"><?php echo number_format($total_mensual[4] + $total_mensual[5] + $total_mensual[6], 0, ',', '.'); ?></td> <!-- PROMEDIO MENSUAL 6 AÑOS -->
            <td width="85"><?php echo number_format($total_acumulada[4] + $total_acumulada[5] + $total_acumulada[6], 0, ',', '.'); ?></td> <!-- VENTA ACUMULADA 6 AÑOS % -->
            <td width="85"><?php echo number_format($total_prom_seis_anio[4] + $total_prom_seis_anio[5] + $total_prom_seis_anio[6], 0, ',', '.') ."%"; ?></td> <!-- 6 AÑOS % -->
            <td width="85"><?php echo number_format($total_prom_anio_anterior[4] + $total_prom_anio_anterior[5] + $total_prom_anio_anterior[6], 0, ',', '.') ."%"; ?></td> <!-- % PROM AÑO 2014 -->
            <td width="85"><?php echo number_format($total_prom_anio_actual[4] + $total_prom_anio_actual[5] + $total_prom_anio_actual[6], 0, ',', '.') ."%"; ?></td> <!-- % PROM AÑO 2015 -->
            <td width="85" style="border-right: 2px solid #689DED;"><?php echo number_format($total_prom_tres_anio[4] + $total_prom_tres_anio[5] + $total_prom_tres_anio[6], 0, ',', '.') ."%"; ?></td>
        </tr>
        <tr>
        	<td style="border-right: 2px solid #689DED; border-left: 2px solid #689DED; background-color:#DCE6F1;">3 TR</td>
            <?php
                for($i=$anio_desde;$i<=$anio;$i++){
                    echo '<td width="85">'.number_format($TABLA[7][$i]+$TABLA[8][$i]+$TABLA[9][$i], 0, ',', '.').'</td>';
                }
            ?>
            <td align="right" width="85" style="border-right: 2px solid #689DED;"><?php echo number_format(((($TABLA[7][$anio] + $TABLA[8][$anio] + $TABLA[9][$anio])-($TABLA[7][$anio-1] + $TABLA[8][$anio-1] + $TABLA[9][$anio-1]))*100)/($TABLA[7][$anio-1] + $TABLA[8][$anio-1] + $TABLA[9][$anio-1]), 0, ',', '.') ."%"; ?></td>
            <td width="85"></td>
            <td width="85" style="border-right: 2px solid #689DED; border-left: 2px solid #689DED;"><?php echo number_format($total_modulo[7] + $total_modulo[8] + $total_modulo[9], 0, ',', '.'); ?></td> <!-- MODULO +40%/12 -->
            <td width="85"></td> <!-- GALPON -->
            <td width="85" style="border-left: 2px solid #689DED;"><?php echo number_format($total_mensual[7] + $total_mensual[8] + $total_mensual[9], 0, ',', '.'); ?></td> <!-- PROMEDIO MENSUAL 6 AÑOS -->
            <td width="85"><?php echo number_format($total_acumulada[7] + $total_acumulada[8] + $total_acumulada[9], 0, ',', '.'); ?></td> <!-- VENTA ACUMULADA 6 AÑOS % -->
            <td width="85"><?php echo number_format($total_prom_seis_anio[7] + $total_prom_seis_anio[8] + $total_prom_seis_anio[9], 0, ',', '.') ."%"; ?></td> <!-- 6 AÑOS % -->
            <td width="85"><?php echo number_format($total_prom_anio_anterior[7] + $total_prom_anio_anterior[8] + $total_prom_anio_anterior[9], 0, ',', '.') ."%"; ?></td> <!-- % PROM AÑO 2014 -->
            <td width="85"><?php echo number_format($total_prom_anio_actual[7] + $total_prom_anio_actual[8] + $total_prom_anio_actual[9], 0, ',', '.') ."%"; ?></td> <!-- % PROM AÑO 2015 -->
            <td width="85" style="border-right: 2px solid #689DED;"><?php echo number_format($total_prom_tres_anio[7] + $total_prom_tres_anio[8] + $total_prom_tres_anio[9], 0, ',', '.') ."%"; ?></td>
        </tr>
        <tr>
        	<td style="border-bottom: 2px solid #689DED; border-right: 2px solid #689DED; border-left: 2px solid #689DED; background-color:#DCE6F1;">4 TR</td>
            <?php
                for($i=$anio_desde;$i<=$anio;$i++){
                    echo '<td width="85" style="border-bottom: 2px solid #689DED;">'.number_format($TABLA[10][$i]+$TABLA[11][$i]+$TABLA[12][$i], 0, ',', '.').'</td>';
                }
            ?>
            <td align="right" width="85" style="border-bottom: 2px solid #689DED; border-right: 2px solid #689DED;"><?php echo number_format(((($TABLA[10][$anio] + $TABLA[11][$anio] + $TABLA[12][$anio])-($TABLA[10][$anio-1] + $TABLA[11][$anio-1] + $TABLA[12][$anio-1]))*100)/($TABLA[10][$anio-1] + $TABLA[11][$anio-1] + $TABLA[12][$anio-1]), 0, ',', '.') ."%"; ?></td>
            <td width="85"></td>
            <td width="85" style="border-bottom: 2px solid #689DED; border-right: 2px solid #689DED; border-left: 2px solid #689DED;"><?php echo number_format($total_modulo[10] + $total_modulo[11] + $total_modulo[12], 0, ',', '.'); ?></td> <!-- MODULO +40%/12 -->
            <td width="85"></td> <!-- GALPON -->
            <td width="85" style="border-bottom: 2px solid #689DED; border-left: 2px solid #689DED;"><?php echo number_format($total_mensual[10] + $total_mensual[11] + $total_mensual[12], 0, ',', '.'); ?></td> <!-- PROMEDIO MENSUAL 6 AÑOS -->
            <td width="85" style="border-bottom: 2px solid #689DED;"><?php echo number_format($total_acumulada[10] + $total_acumulada[11] + $total_acumulada[12], 0, ',', '.'); ?></td> <!-- VENTA ACUMULADA 6 AÑOS % -->
            <td width="85" style="border-bottom: 2px solid #689DED;"><?php echo number_format($total_prom_seis_anio[10] + $total_prom_seis_anio[11] + $total_prom_seis_anio[12], 0, ',', '.') ."%"; ?></td> <!-- 6 AÑOS % -->
            <td width="85" style="border-bottom: 2px solid #689DED;"><?php echo number_format($total_prom_anio_anterior[10] + $total_prom_anio_anterior[11] + $total_prom_anio_anterior[12], 0, ',', '.') ."%"; ?></td> <!-- % PROM AÑO 2014 $total_prom_anio_anterior -->
            <td width="85" style="border-bottom: 2px solid #689DED;"><?php echo number_format($total_prom_anio_actual[10] + $total_prom_anio_actual[11] + $total_prom_anio_actual[12], 0, ',', '.') ."%"; ?></td> <!-- % PROM AÑO 2015 -->
            <td width="85" style="border-bottom: 2px solid #689DED; border-right: 2px solid #689DED;"><?php echo number_format($total_prom_tres_anio[10] + $total_prom_tres_anio[11] + $total_prom_tres_anio[12], 0, ',', '.') ."%"; ?></td>
        </tr>
        <tr>
        	<td style="border-right: 2px solid #689DED; border-left: 2px solid #689DED; background-color:#DCE6F1;">1 SEM</td>
            <?php
                for($i=$anio_desde;$i<=$anio;$i++){
                    echo '<td width="65">'.number_format($TABLA[1][$i] + $TABLA[2][$i] + $TABLA[3][$i] + $TABLA[4][$i] + $TABLA[5][$i] + $TABLA[6][$i], 0, ',', '.').'</td>';
                }
            ?>
            <td align="right" width="85" style="border-right: 2px solid #689DED;"><?php echo number_format(((($TABLA[1][$anio] + $TABLA[2][$anio] + $TABLA[3][$anio] + $TABLA[4][$anio] + $TABLA[5][$anio] + $TABLA[6][$anio])-($TABLA[1][$anio-1] + $TABLA[2][$anio-1] + $TABLA[3][$anio-1] + $TABLA[4][$anio-1] + $TABLA[5][$anio-1] + $TABLA[6][$anio-1]))*100)/($TABLA[1][$anio-1] + $TABLA[2][$anio-1] + $TABLA[3][$anio-1] + $TABLA[4][$anio-1] + $TABLA[5][$anio-1] + $TABLA[6][$anio-1]), 0, ',', '.') ."%"; ?></td>
            <td width="85"></td>
            <td width="85" style="border-right: 2px solid #689DED; border-left: 2px solid #689DED;"><?php echo number_format($total_modulo[1] + $total_modulo[2] + $total_modulo[3] + $total_modulo[4] + $total_modulo[5] + $total_modulo[6], 0, ',', '.'); ?></td> <!-- MODULO +40%/12 -->
            <td width="85"></td> <!-- GALPON -->
            <td width="85" style="border-left: 2px solid #689DED;"><?php echo number_format($total_mensual[1] + $total_mensual[2] + $total_mensual[3] + $total_mensual[4] + $total_mensual[5] + $total_mensual[6], 0, ',', '.'); ?></td> <!-- PROMEDIO MENSUAL 6 AÑOS -->
            <td width="85"><?php echo number_format($total_mensual[1] + $total_mensual[2] + $total_mensual[3] + $total_acumulada[4] + $total_acumulada[5] + $total_acumulada[6], 0, ',', '.'); ?></td> <!-- VENTA ACUMULADA 6 AÑOS % -->
            <td width="85"><?php echo number_format($total_prom_seis_anio[1] + $total_prom_seis_anio[2] + $total_prom_seis_anio[3] + $total_prom_seis_anio[4] + $total_prom_seis_anio[5] + $total_prom_seis_anio[6], 0, ',', '.') ."%"; ?></td> <!-- 6 AÑOS % -->
            <td width="85"><?php echo number_format($total_prom_anio_anterior[1] + $total_prom_anio_anterior[2] + $total_prom_anio_anterior[3] + $total_prom_anio_anterior[4] + $total_prom_anio_anterior[5] + $total_prom_anio_anterior[6], 0, ',', '.') ."%"; ?></td> <!-- % PROM AÑO 2014 -->
            <td width="85"><?php echo number_format($total_prom_anio_actual[1] + $total_prom_anio_actual[2] + $total_prom_anio_actual[3] + $total_prom_anio_actual[4] + $total_prom_anio_actual[5] + $total_prom_anio_actual[6], 0, ',', '.') ."%"; ?></td> <!-- % PROM AÑO 2015 -->
            <td width="85" style="border-right: 2px solid #689DED;"><?php echo number_format($total_prom_tres_anio[1] + $total_prom_tres_anio[2] + $total_prom_tres_anio[3] + $total_prom_tres_anio[4] + $total_prom_tres_anio[5] + $total_prom_tres_anio[6], 0, ',', '.') ."%"; ?></td>
        </tr>
        <tr>
        	<td style="border-bottom: 2px solid #689DED; border-right: 2px solid #689DED; border-left: 2px solid #689DED; background-color:#DCE6F1;">2 SEM</td>
           
           <?php
                for($i=$anio_desde;$i<=$anio;$i++){
                    echo '<td width="65" style="border-bottom: 2px solid #689DED;">'.number_format($TABLA[7][$i] + $TABLA[8][$i] + $TABLA[9][$i] + $TABLA[10][$i] + $TABLA[11][$i] + $TABLA[12][$i], 0, ',', '.').'</td>';
                }
            ?>
            <td align="right" width="85" style="border-bottom: 2px solid #689DED; border-right: 2px solid #689DED;"><?php echo number_format(((($TABLA[7][$anio] + $TABLA[8][$anio] + $TABLA[9][$anio]+$TABLA[10][$anio] + $TABLA[11][$anio] + $TABLA[12][$anio])-($TABLA[7][$anio-1] + $TABLA[8][$anio-1] + $TABLA[9][$anio-1]+$TABLA[10][$anio-1] + $TABLA[11][$anio-1] + $TABLA[12][$anio-1]))*100)/($TABLA[7][$anio-1] + $TABLA[8][$anio-1] + $TABLA[9][$anio-1]+$TABLA[10][$anio-1] + $TABLA[11][$anio-1] + $TABLA[12][$anio-1]), 0, ',', '.') ."%"; ?></td>
            <td width="85"></td>
            <td width="85" style="border-bottom: 2px solid #689DED; border-right: 2px solid #689DED; border-left: 2px solid #689DED;"><?php echo number_format($total_modulo[7] + $total_modulo[8] + $total_modulo[9]+$total_modulo[10] + $total_modulo[11] + $total_modulo[12], 0, ',', '.'); ?></td> <!-- MODULO +40%/12 -->
            <td width="85"></td> <!-- GALPON -->
            <td width="85" style="border-bottom: 2px solid #689DED; border-left: 2px solid #689DED;"><?php echo number_format($total_mensual[7] + $total_mensual[8] + $total_mensual[9]+$total_mensual[10] + $total_mensual[11] + $total_mensual[12], 0, ',', '.'); ?></td> <!-- PROMEDIO MENSUAL 6 AÑOS -->
            <td width="85" style="border-bottom: 2px solid #689DED;"><?php echo number_format($total_acumulada[7] + $total_acumulada[8] + $total_acumulada[9]+$total_acumulada[10] + $total_acumulada[11] + $total_acumulada[12], 0, ',', '.'); ?></td> <!-- VENTA ACUMULADA 6 AÑOS % -->
            <td width="85" style="border-bottom: 2px solid #689DED;"><?php echo number_format($total_prom_seis_anio[7] + $total_prom_seis_anio[8] + $total_prom_seis_anio[9]+$total_prom_seis_anio[10] + $total_prom_seis_anio[11] + $total_prom_seis_anio[12], 0, ',', '.') ."%"; ?></td> <!-- 6 AÑOS % -->
            <td width="85" style="border-bottom: 2px solid #689DED;"><?php echo number_format($total_prom_anio_anterior[7] + $total_prom_anio_anterior[8] + $total_prom_anio_anterior[9]+$total_prom_anio_anterior[10] + $total_prom_anio_anterior[11] + $total_prom_anio_anterior[12], 0, ',', '.') ."%"; ?></td> <!-- % PROM AÑO 2014 $total_prom_anio_anterior -->
            <td width="85" style="border-bottom: 2px solid #689DED;"><?php echo number_format($total_prom_anio_actual[7] + $total_prom_anio_actual[8] + $total_prom_anio_actual[9]+$total_prom_anio_actual[10] + $total_prom_anio_actual[11] + $total_prom_anio_actual[12], 0, ',', '.') ."%"; ?></td> <!-- % PROM AÑO 2015 -->
            <td width="85" style="border-bottom: 2px solid #689DED; border-right: 2px solid #689DED;"><?php echo number_format($total_prom_tres_anio[7] + $total_prom_tres_anio[8] + $total_prom_tres_anio[9]+$total_prom_tres_anio[10] + $total_prom_tres_anio[11] + $total_prom_tres_anio[12], 0, ',', '.') ."%"; ?></td>
        </tr>
    </tbody>
</table></div>
<?php odbc_close( $conn ); } ?>