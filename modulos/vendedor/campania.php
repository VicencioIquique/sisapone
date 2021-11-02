<?php 
require_once("clases/conexionocdb.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
$vendedor = $_GET['id'];
$vendedorSelect = $_GET['id'];

$vendedor = str_pad($vendedor, 3, '0', 'STR_PAD_LEFT');
$finicio = $_GET['inicio'];
$ffin = $_GET['fin'];
$codbarra = $_GET['codbarra'];
$consultar = $_GET['agregar'];
$tipoProducto = $_GET['tipoProducto'];
$whsCode = $_GET['local'];

if(!$finicio)
{
	 $finicio = date("m/01/Y");
	 $ffin= date("m/d/Y");
}


 function cambiarFecha($fecha) {
					  return implode("-", array_reverse(explode("-", $fecha)));
					}
					$finicio2 = cambiarFecha($finicio);
					$ffin2 = cambiarFecha($ffin);


			if ($whsCode)
					{
						$WwhsCode = "AND T0.WhsCode = '".$whsCode."' ";
						
					}				

?>
<script type="text/javascript">
  $(document).ready(function(){
				//comienza focus en modulo
				$('#moduloid').focus();
				// calendarios en text de fecha inicio fin
				$( "#inicio" ).datepicker( );
				//formatos de las fechas
			   // $('#inicio').datepicker('option', {dateFormat: 'dd-mm-yy'});
				$( "#fin" ).datepicker(  );
				//$('#fin').datepicker('option', {dateFormat: 'dd-mm-yy'});

            });

</script>
<script language="javascript"> 
$(document).ready(function() { 
     $(".botonExcel").click(function(event) { 
     $("#datos_a_enviar").val( $("<div>").append( $("#excel").eq(0).clone()).html()); 
     $("#FormularioExportacion").submit(); 
}); 
}); 
</script> 

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
				<legend>Ingresar Filtros </legend>

							<input name="opc" type="hidden" id="opc" size="40" class="required" value="campania" />
							
                            <!--<label for="fecha1">
					            Inicio
                            <input name="inicio" type="text" id="inicio" size="40" class="required" value="<?php echo $finicio;?>"  />
                            </label>
							<label for="fecha2">
					            Fin
                            <input name="fin" type="text" id="fin" size="40" class="required"  value="<?php echo $ffin;?>" />
                            </label>-->
							<label class="first" for="title1">
									Local
									<select id="local" name="local" class="styled" >
                                    <option></option>
									<option value="ZFI.1010">Local 1010</option>
									<option value="ZFI.184">Local 184</option>
									<option value="ZFI.1132">Local 1132</option>
									<option value="ZFI.2002">Local 2002</option>
									<option value="ZFI.2077">Local 2077</option>
									</select>
				               </label>
                            
							
							
                             <input style="clear:initial;" name="agregar" type="submit" id="agregar" class="submit" value="Consultar" />

			</fieldset>
            </form>
         </div> <!-- fin div two-->
      </div> <!-- fin items -->
    </div> <!-- fin idTabs -->
	
	<div id="excel">
        
        
					
            <table  id="ssptable2" class="lista">
			 <thead>
					<tr>
					    <th colspan="8" >Ventas Campaña Navidad por Local - Desde el 24 de Noviembre 2017 </th>
					
					</tr>
			  </head>
              <thead>
					
                    <tr>
					    <th style="width:150px;">Local</th>
						<th>VTA UND</th>
						<th>INCENTIVO</th> 
						<th>VTA CLP</th> 
						<th>VTA CIF</th> 
						<th>VTA USD</th> 
						<th>REPT /16</th> 
						<!--<th>RETENCION DL</th>-->
											
                    </tr>
                </thead>
                <tbody>
                 <?php
				 
					$total =0;
					$cantotal =0;
					$totalCIFEXT =0;
					$totalCIF=0;
					$totalUSD=0;


$sql="
SELECT 
     TABLA.WhsCode
	,SUM(TABLA.VTACANT) AS VTACANT
	,SUM(TABLA.INCENTIVO) AS INCENTIVO
	,SUM(TABLA.VTACLP) AS VTACLP
	,SUM(TABLA.VTACIF) AS VTACIF
	,SUM(TABLA.VTAUSD) AS VTAUSD
FROM
(
		SELECT T0.WhsCode
			  ,T1.DESC4
			  ,SUM(T0.[Cantidad]) AS VTACANT
			  ,CASE
			      WHEN T1.DESC4 = 'G1' THEN (CONVERT(INT,SUM(T0.[Cantidad])))*1200
                  WHEN T1.DESC4 = 'G2' THEN (CONVERT(INT,SUM(T0.[Cantidad])))*1200 
                  WHEN T1.DESC4 = 'G3' THEN (CONVERT(INT,SUM(T0.[Cantidad])))*1200 				  
				  WHEN T1.DESC4 = 'G4' THEN (CONVERT(INT,SUM(T0.[Cantidad])/2))*1200 
				  WHEN T1.DESC4 = 'G5' THEN (CONVERT(INT,SUM(T0.[Cantidad])/2))*1200 
				  WHEN T1.DESC4 = 'G6' THEN (CONVERT(INT,SUM(T0.[Cantidad])/2))*1200 
				  WHEN T1.DESC4 = 'G7' THEN (CONVERT(INT,SUM(T0.[Cantidad])/3))*1200
				  WHEN T1.DESC4 = 'G8' THEN (CONVERT(INT,SUM(T0.[Cantidad])/4))*1200 
				  ELSE SUM(T0.[Cantidad])*1200
			   END  AS INCENTIVO
			  ,SUM(T0.[TotalCLP]) AS VTACLP
			  ,SUM(T0.[TotalCIF]) AS VTACIF
			  ,SUM(T0.[TotalUSD]) AS VTAUSD
			  
		  FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_VW_VtasD_RPRO] T0
		  LEFT JOIN   [RP_VICENCIO].[dbo].[RP_Articulos] T1   ON  T0.ItemCode COLLATE Latin1_General_CI_AS =  T1.ALU
		   WHERE 1=1
		    --AND T0.Periodo > '2017-11'
		    AND T0.DocDate >= '2017-11-24 00:00:00.000'
			".$WwhsCode."--AND T0.WhsCode = 'ZFI.1132'
			AND T0.ItemCode IN  /*(SELECT  [ALU] COLLATE Latin1_General_CI_AS
								FROM [RP_VICENCIO].[dbo].[RP_Articulos] 
							   WHERE DESC4 <> '')*/
							   ('3432240031754',
								'3432240034663',
								'3432240008459',
								'783320482502',
								'3432240032829',
								'3432240029577',
								'3432240029607',
								'8411061786161',
								'3432240029584',
								'737052522722',
								'737052522555',
								'737052522692',
								'737052522661',
								'3432240024169',
								'3432240023384',
								'3607342137172',
								'3607340205538',
								'085805161088',
								'3274870011801',
								'3274870453359',
								'8011003998456',
								'3352819618004',
								'8426017052177',
								'8426017052238',
								'883915919809',
								'8052086370531',
								'5045415436919',
								'5391512271398',
								'719346607094',
								'719346607049',
								'3386460059114',
								'8034097952241',
								'3439609000215',
								'3607345730738',
								'8034097957017',
								'5045453986186',
								'5045456582149',
								'3386460059183',
								'783320911538',
								'3607349660826',
								'3607348541690',
								'737052413235',
								'737052696164',
								'5391512270582',
								'3432240024237',
								'3352819049259',
								'8011003100033',
								'ZDW751',
								'5060152402744',
								'3386460049030',
								'3607348808229',
								'3607343176538',
								'3607349150747',
								'3607342335684',
								'5060152401839',
								'8052086370852',
								'094922911315',
								'3607342489356',
								'3351500957613',
								'3351500957712',
								'3351500970025',
								'3351500996025',
								'3351500999033',
								'8427395780201',
								'8427395780232',
								'3607348541775',
								'8427395990235',
								'8427395990228',
								'8002135088917',
								'3607346497968',
								'8431754392011',
								'3607349744397',
								'3607340428791',
								'3607346197233',
								'3349668532681',
								'8052086370616',
								'094922911407',
								'8034097951183',
								'679602769341',
								'679602793407',
								'679602709446',
								'679602659345',
								'ZDW501',
								'3607343767569',
								'3607349843076',
								'5060152402751',
								'1800780002602',
								'3607340605109',
								'3607344971385',
								'844061004900',
								'3607347962007',
								'3607343820462',
								'679602791083',
								'3351500957705',
								'3351500970018',
								'3607340302640',
								'3607342771338',
								'3607342772977',
								'5012874212279',
								'3386460028509',
								'8002135088894',
								'679602630115',
								'8032529117626',
								'3386460025171',
								'679602761109',
								'679602731102',
								'679602701105',
								'679602709415',
								'679602711821',
								'679602711838',
								'679602711845',
								'679602711852',
								'679602021104',
								'8007033783940',
								'679602751100',
								'8007033781601',
								'3432240022936',
								'3607342098930',
								'1800780002534',
								'3430750030854',
								'608940550137',
								'3414200161022',
								'3414200800792',
								'3414200812009',
								'3414200812016',
								'679602181082',
								'679602171083',
								'3331845870839',
								'679602811088',
								'679602819305',
								'679602819367',
								'679602769310',
								'5013692201889',
								'8014126023944',
								'8014126025269',
								'8014126000228',
								'679602651066',
								'679602651103',
								'8007033781342',
								'8007033783124',
								'3414200908559',
								'679602730600',
								'679602160308',
								'679602431088',
								'679602439657',
								'8011607153107',
								'YPS501',
								'3331845884850',
								'3414200161015',
								'8411061592113',
								'8410225529606',
								'3414200802536',
								'3414200800594',
								'8427395510266',
								'8427395520265',
								'8427395510204',
								'8427395514363',
								'8427395514462',
								'8427395524454',
								'8427395510297',
								'8427395510228',
								'679602170154',
								'679602160155',
								'679602610827',
								'679602471060',
								'3331845871836',
								'8427395560285',
								'8427395500281',
								'8427395560261',
								'8014126023951',
								'679602911153',
								'679602211048',
								'679602431064',
								'8411061411803',
								'YPBV21',
								'RBP501',
								'8411061401804',
								'8411061292488',
								'8411061763278',
								'8411061771419',
								'3331845995006',
								'8427395563552',
								'8427395563538')
		  GROUP BY T0.WhsCode,T1.DESC4
		  --ORDER BY T0.WhsCode
) AS TABLA
GROUP BY TABLA.WhsCode

";

echo $sql;
if($consultar)
							{
                        $rs = odbc_exec( $conn, $sql );
							if ( !$rs)
							{
							    exit( "Error en la consulta SQL" );
							}
					     
				
                            while(($resultado = odbc_fetch_array($rs)) )
							 { 
							    					  
								
								  echo '<tr>
										<td  >'.utf8_encode(str_replace("ZFI.","LOCAL ",$resultado["WhsCode"])).'</td>
										<td >'.number_format($resultado["VTACANT"], 0, '', '.').'</td> 
										<td ><strong>'.number_format($resultado["INCENTIVO"], 0, '', '.').'</strong></td>
										<td ><strong>'.number_format($resultado["VTACLP"], 0, '', '.').'</strong></td>
										<td >'.number_format($resultado["VTACIF"], 2, ',', '.').'</td>
										<td >'.number_format($resultado["VTAUSD"], 2, ',', '.').'</td> 
										<td style=" border-right:2px double #B5B5B5;" >'.number_format($resultado["INCENTIVO"]/16, 0, ',', '.').'</td>'; 
										//<td style=" border-right:2px double #B5B5B5;" >'.number_format($resultado["RetencionDL"], 2, ',', '.').'</td> 
										echo'</tr>' ;
										
										$vecC[] = '<tr><td  >- En el '.utf8_encode(str_replace("ZFI.","Local ",$resultado["WhsCode"])).', de '.number_format($resultado["VTACANT"], 0, '', '.').' unidades que significan CLP $'.number_format($resultado["VTACLP"], 0, '', '.').', se generó una comisión de $'.number_format($resultado["INCENTIVO"], 0, '', '.').' </td></tr>';
										
										$TotalUnidades = $TotalUnidades + $resultado["VTACANT"];									
										$TotalIncent = $TotalIncent + $resultado["INCENTIVO"];
										$TotalCLP = $TotalCLP + $resultado["VTACLP"];	
										$TotalUSD = $TotalUSD + $resultado["VTAUSD"];
										$TotalCIF = $TotalCIF + $resultado["VTACIF"];
											
							} 
				?>
				<tr style=" border-top:2px double #B5B5B5;font-weight: bold;">
					<td>TOTALES</td>
					<td><?php echo number_format($TotalUnidades, 0, '', '.');?></td>
					<td><?php echo number_format($TotalIncent, 0, '', '.');?></td>
					<td><?php echo number_format($TotalCLP, 0, '', '.');?></td>
					<td><?php echo number_format($TotalCIF, 2, ',', '.');?></td>
					<td><?php echo number_format($TotalUSD, 2, ',', '.');?></td>
					<td></td>
				</tr>
               </tbody>	
					
            </table>
			
<!-- Conclusiones -->
<table  id="ssptable" class="lista">
			 <thead>
					<tr>
					    <td colspan="8" >Conclusiones por Local </td>
					
					</tr>
			  </head>
 <tbody>	
  <?php
  // print_r ( $vecC );
   
    for($i=0;$i<=4;$i++) 
	{ 
		echo $vecC[$i]; 
	} 

?>
</tbody>	
				<footer>
					<td></td>
				
				</footer>	
            </table>				
               
			
			
<!-- Locales -->

<table  id="ssptable2" class="lista">
			 <thead>
					<tr>
					    <th colspan="6" >Venta por Grupo de Items</th>
					</tr>
			  </head>
              <thead>
					
                    <tr>
						<th style="width:150px;">Grupos</th>
						<th>VTA UND</th>
						<th>INCENTIVO</th> 
						<th>VTA CLP</th> 
						<th>VTA CIF</th> 
						<th>VTA USD</th> 
						<!--<th>RETENCION DL</th>-->
											
                    </tr>
                </thead>
                <tbody>
                 <?php
				 
					$total =0;
					$cantotal =0;
					$totalCIFEXT =0;
					$totalCIF=0;
					$totalUSD=0;


$sql3="
SELECT --T0.[Marca]
      T1.DESC4
      ,SUM(T0.[Cantidad]) AS VTACANT
	  ,CASE
			      WHEN T1.DESC4 = 'G1' THEN (CONVERT(INT,SUM(T0.[Cantidad])))*1200
                  WHEN T1.DESC4 = 'G2' THEN (CONVERT(INT,SUM(T0.[Cantidad])))*1200 
                  WHEN T1.DESC4 = 'G3' THEN (CONVERT(INT,SUM(T0.[Cantidad])))*1200 				  
				  WHEN T1.DESC4 = 'G4' THEN (CONVERT(INT,SUM(T0.[Cantidad])/2))*1200 
				  WHEN T1.DESC4 = 'G5' THEN (CONVERT(INT,SUM(T0.[Cantidad])/2))*1200 
				  WHEN T1.DESC4 = 'G6' THEN (CONVERT(INT,SUM(T0.[Cantidad])/2))*1200 
				  WHEN T1.DESC4 = 'G7' THEN (CONVERT(INT,SUM(T0.[Cantidad])/3))*1200
				  WHEN T1.DESC4 = 'G8' THEN (CONVERT(INT,SUM(T0.[Cantidad])/4))*1200 
				  ELSE SUM(T0.[Cantidad])*1200
	   END  AS INCENTIVO
      ,SUM(T0.[TotalCLP]) AS VTACLP
      ,SUM(T0.[TotalCIF]) AS VTACIF
      ,SUM(T0.[TotalUSD]) AS VTAUSD
      
  FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_VW_VtasD_RPRO] T0
  LEFT JOIN   [RP_VICENCIO].[dbo].[RP_Articulos] T1   ON  T0.ItemCode COLLATE Latin1_General_CI_AS =  T1.ALU
   WHERE 1=1
		    --AND T0.Periodo > '2017-11'
		    AND T0.DocDate >= '2017-11-24 00:00:00.000'
   ".$WwhsCode." -- AND T0.WhsCode = 'ZFI.1132'
    AND T0.ItemCode IN  /*(SELECT  [ALU] COLLATE Latin1_General_CI_AS
				        FROM [RP_VICENCIO].[dbo].[RP_Articulos] 
				       WHERE DESC4 <> '')*/
					   ('3432240031754',
						'3432240034663',
						'3432240008459',
						'783320482502',
						'3432240032829',
						'3432240029577',
						'3432240029607',
						'8411061786161',
						'3432240029584',
						'737052522722',
						'737052522555',
						'737052522692',
						'737052522661',
						'3432240024169',
						'3432240023384',
						'3607342137172',
						'3607340205538',
						'085805161088',
						'3274870011801',
						'3274870453359',
						'8011003998456',
						'3352819618004',
						'8426017052177',
						'8426017052238',
						'883915919809',
						'8052086370531',
						'5045415436919',
						'5391512271398',
						'719346607094',
						'719346607049',
						'3386460059114',
						'8034097952241',
						'3439609000215',
						'3607345730738',
						'8034097957017',
						'5045453986186',
						'5045456582149',
						'3386460059183',
						'783320911538',
						'3607349660826',
						'3607348541690',
						'737052413235',
						'737052696164',
						'5391512270582',
						'3432240024237',
						'3352819049259',
						'8011003100033',
						'ZDW751',
						'5060152402744',
						'3386460049030',
						'3607348808229',
						'3607343176538',
						'3607349150747',
						'3607342335684',
						'5060152401839',
						'8052086370852',
						'094922911315',
						'3607342489356',
						'3351500957613',
						'3351500957712',
						'3351500970025',
						'3351500996025',
						'3351500999033',
						'8427395780201',
						'8427395780232',
						'3607348541775',
						'8427395990235',
						'8427395990228',
						'8002135088917',
						'3607346497968',
						'8431754392011',
						'3607349744397',
						'3607340428791',
						'3607346197233',
						'3349668532681',
						'8052086370616',
						'094922911407',
						'8034097951183',
						'679602769341',
						'679602793407',
						'679602709446',
						'679602659345',
						'ZDW501',
						'3607343767569',
						'3607349843076',
						'5060152402751',
						'1800780002602',
						'3607340605109',
						'3607344971385',
						'844061004900',
						'3607347962007',
						'3607343820462',
						'679602791083',
						'3351500957705',
						'3351500970018',
						'3607340302640',
						'3607342771338',
						'3607342772977',
						'5012874212279',
						'3386460028509',
						'8002135088894',
						'679602630115',
						'8032529117626',
						'3386460025171',
						'679602761109',
						'679602731102',
						'679602701105',
						'679602709415',
						'679602711821',
						'679602711838',
						'679602711845',
						'679602711852',
						'679602021104',
						'8007033783940',
						'679602751100',
						'8007033781601',
						'3432240022936',
						'3607342098930',
						'1800780002534',
						'3430750030854',
						'608940550137',
						'3414200161022',
						'3414200800792',
						'3414200812009',
						'3414200812016',
						'679602181082',
						'679602171083',
						'3331845870839',
						'679602811088',
						'679602819305',
						'679602819367',
						'679602769310',
						'5013692201889',
						'8014126023944',
						'8014126025269',
						'8014126000228',
						'679602651066',
						'679602651103',
						'8007033781342',
						'8007033783124',
						'3414200908559',
						'679602730600',
						'679602160308',
						'679602431088',
						'679602439657',
						'8011607153107',
						'YPS501',
						'3331845884850',
						'3414200161015',
						'8411061592113',
						'8410225529606',
						'3414200802536',
						'3414200800594',
						'8427395510266',
						'8427395520265',
						'8427395510204',
						'8427395514363',
						'8427395514462',
						'8427395524454',
						'8427395510297',
						'8427395510228',
						'679602170154',
						'679602160155',
						'679602610827',
						'679602471060',
						'3331845871836',
						'8427395560285',
						'8427395500281',
						'8427395560261',
						'8014126023951',
						'679602911153',
						'679602211048',
						'679602431064',
						'8411061411803',
						'YPBV21',
						'RBP501',
						'8411061401804',
						'8411061292488',
						'8411061763278',
						'8411061771419',
						'3331845995006',
						'8427395563552',
						'8427395563538')
  GROUP BY T1.DESC4--,T0.[Marca]
  ORDER BY DESC4,VTACANT

";

$sql2="
SELECT 
     --TABLA.DESC4
	 CASE
		WHEN TABLA.DESC4 = 'G1' THEN 'G1 - PROMOCION 1'
		WHEN TABLA.DESC4 = 'G2' THEN 'G2 - PROMOCION 2'
		WHEN TABLA.DESC4 = 'G3' THEN 'G3 - PROMOCION 3'
	    WHEN TABLA.DESC4 = 'G4' THEN 'G4 - PROMOCION 4 , (2 x)'
		WHEN TABLA.DESC4 = 'G5' THEN 'G5 - PROMOCION 5 , (2 x)'
		WHEN TABLA.DESC4 = 'G6' THEN 'G6 - PROMOCION 6 , (2 x)'
		WHEN TABLA.DESC4 = 'G7' THEN 'G7 - PROMOCION 7 , (3 x)'
		WHEN TABLA.DESC4 = 'G8' THEN 'G8 - PROMOCION 8 , (4 x)'
		
		ELSE TABLA.DESC4
	 END  [DESC4]
	,SUM(TABLA.VTACANT) AS VTACANT
	,SUM(TABLA.INCENTIVO) AS INCENTIVO
	,SUM(TABLA.VTACLP) AS VTACLP
	,SUM(TABLA.VTACIF) AS VTACIF
	,SUM(TABLA.VTAUSD) AS VTAUSD
FROM
(
		SELECT T0.WhsCode
			  ,T1.DESC4
			  ,SUM(T0.[Cantidad]) AS VTACANT
			  ,CASE
			      WHEN T1.DESC4 = 'G1' THEN (CONVERT(INT,SUM(T0.[Cantidad])))*1200
                  WHEN T1.DESC4 = 'G2' THEN (CONVERT(INT,SUM(T0.[Cantidad])))*1200 
                  WHEN T1.DESC4 = 'G3' THEN (CONVERT(INT,SUM(T0.[Cantidad])))*1200 				  
				  WHEN T1.DESC4 = 'G4' THEN (CONVERT(INT,SUM(T0.[Cantidad])/2))*1200 
				  WHEN T1.DESC4 = 'G5' THEN (CONVERT(INT,SUM(T0.[Cantidad])/2))*1200 
				  WHEN T1.DESC4 = 'G6' THEN (CONVERT(INT,SUM(T0.[Cantidad])/2))*1200 
				  WHEN T1.DESC4 = 'G7' THEN (CONVERT(INT,SUM(T0.[Cantidad])/3))*1200
				  WHEN T1.DESC4 = 'G8' THEN (CONVERT(INT,SUM(T0.[Cantidad])/4))*1200 
				  ELSE SUM(T0.[Cantidad])*1200
			   END  AS INCENTIVO
			  ,SUM(T0.[TotalCLP]) AS VTACLP
			  ,SUM(T0.[TotalCIF]) AS VTACIF
			  ,SUM(T0.[TotalUSD]) AS VTAUSD
			  
		  FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_VW_VtasD_RPRO] T0
		  LEFT JOIN   [RP_VICENCIO].[dbo].[RP_Articulos] T1   ON  T0.ItemCode COLLATE Latin1_General_CI_AS =  T1.ALU
		   WHERE 1=1
		    --AND T0.Periodo > '2017-11'
		    AND T0.DocDate >= '2017-11-24 00:00:00.000'
			".$WwhsCode." --AND T0.WhsCode = 'ZFI.1132'
			AND T0.ItemCode IN  /*(SELECT  [ALU] COLLATE Latin1_General_CI_AS
								FROM [RP_VICENCIO].[dbo].[RP_Articulos] 
							   WHERE DESC4 <> '')*/
							   ('3432240031754',
								'3432240034663',
								'3432240008459',
								'783320482502',
								'3432240032829',
								'3432240029577',
								'3432240029607',
								'8411061786161',
								'3432240029584',
								'737052522722',
								'737052522555',
								'737052522692',
								'737052522661',
								'3432240024169',
								'3432240023384',
								'3607342137172',
								'3607340205538',
								'085805161088',
								'3274870011801',
								'3274870453359',
								'8011003998456',
								'3352819618004',
								'8426017052177',
								'8426017052238',
								'883915919809',
								'8052086370531',
								'5045415436919',
								'5391512271398',
								'719346607094',
								'719346607049',
								'3386460059114',
								'8034097952241',
								'3439609000215',
								'3607345730738',
								'8034097957017',
								'5045453986186',
								'5045456582149',
								'3386460059183',
								'783320911538',
								'3607349660826',
								'3607348541690',
								'737052413235',
								'737052696164',
								'5391512270582',
								'3432240024237',
								'3352819049259',
								'8011003100033',
								'ZDW751',
								'5060152402744',
								'3386460049030',
								'3607348808229',
								'3607343176538',
								'3607349150747',
								'3607342335684',
								'5060152401839',
								'8052086370852',
								'094922911315',
								'3607342489356',
								'3351500957613',
								'3351500957712',
								'3351500970025',
								'3351500996025',
								'3351500999033',
								'8427395780201',
								'8427395780232',
								'3607348541775',
								'8427395990235',
								'8427395990228',
								'8002135088917',
								'3607346497968',
								'8431754392011',
								'3607349744397',
								'3607340428791',
								'3607346197233',
								'3349668532681',
								'8052086370616',
								'094922911407',
								'8034097951183',
								'679602769341',
								'679602793407',
								'679602709446',
								'679602659345',
								'ZDW501',
								'3607343767569',
								'3607349843076',
								'5060152402751',
								'1800780002602',
								'3607340605109',
								'3607344971385',
								'844061004900',
								'3607347962007',
								'3607343820462',
								'679602791083',
								'3351500957705',
								'3351500970018',
								'3607340302640',
								'3607342771338',
								'3607342772977',
								'5012874212279',
								'3386460028509',
								'8002135088894',
								'679602630115',
								'8032529117626',
								'3386460025171',
								'679602761109',
								'679602731102',
								'679602701105',
								'679602709415',
								'679602711821',
								'679602711838',
								'679602711845',
								'679602711852',
								'679602021104',
								'8007033783940',
								'679602751100',
								'8007033781601',
								'3432240022936',
								'3607342098930',
								'1800780002534',
								'3430750030854',
								'608940550137',
								'3414200161022',
								'3414200800792',
								'3414200812009',
								'3414200812016',
								'679602181082',
								'679602171083',
								'3331845870839',
								'679602811088',
								'679602819305',
								'679602819367',
								'679602769310',
								'5013692201889',
								'8014126023944',
								'8014126025269',
								'8014126000228',
								'679602651066',
								'679602651103',
								'8007033781342',
								'8007033783124',
								'3414200908559',
								'679602730600',
								'679602160308',
								'679602431088',
								'679602439657',
								'8011607153107',
								'YPS501',
								'3331845884850',
								'3414200161015',
								'8411061592113',
								'8410225529606',
								'3414200802536',
								'3414200800594',
								'8427395510266',
								'8427395520265',
								'8427395510204',
								'8427395514363',
								'8427395514462',
								'8427395524454',
								'8427395510297',
								'8427395510228',
								'679602170154',
								'679602160155',
								'679602610827',
								'679602471060',
								'3331845871836',
								'8427395560285',
								'8427395500281',
								'8427395560261',
								'8014126023951',
								'679602911153',
								'679602211048',
								'679602431064',
								'8411061411803',
								'YPBV21',
								'RBP501',
								'8411061401804',
								'8411061292488',
								'8411061763278',
								'8411061771419',
								'3331845995006',
								'8427395563552',
								'8427395563538')
		  GROUP BY T0.WhsCode,T1.DESC4
		  --ORDER BY T0.WhsCode
) AS TABLA
GROUP BY TABLA.DESC4

";

//echo $sql2;
if($consultar)
							{
                        $rs2 = odbc_exec( $conn, $sql2 );
							if ( !$rs2)
							{
							    exit( "Error en la consulta SQL" );
							}
					     
				
                            while(($resultado2 = odbc_fetch_array($rs2)) )
							 { 
							    					  
								
								  echo '<tr>
										<td  >'.utf8_encode($resultado2["DESC4"]).'</td> 									
										<td >'.number_format($resultado2["VTACANT"], 0, '', '.').'</td> 
										<td ><strong>'.number_format($resultado2["INCENTIVO"], 0, '', '.').'</strong></td>
										<td ><strong>'.number_format($resultado2["VTACLP"], 0, '', '.').'</strong></td>
										<td >'.number_format($resultado2["VTACIF"], 2, ',', '.').'</td>
										<td >'.number_format($resultado2["VTAUSD"], 2, ',', '.').'</td> ';
										
										
										$TotalUnidadesHoy = $TotalUnidadesHoy + $resultado2["VTACANT"];									
										$TotalIncentivo = $TotalIncentivo + $resultado2["INCENTIVO"];
										$TotalCLPHoy = $TotalCLPHoy + $resultado2["VTACLP"];	
										$TotalUSDHoy = $TotalUSDHoy + $resultado2["VTAUSD"];
										$TotalCIFHoy = $TotalCIFHoy + $resultado2["VTACIF"];
											
							} 
				?>
				<tr style=" border-top:2px double #B5B5B5;font-weight: bold;">
					<td>TOTALES</td>
					<td><?php echo number_format($TotalUnidadesHoy, 0, '', '.');?></td>
					<td><?php echo number_format($TotalIncentivo, 0, '', '.');?></td>
					<td><?php echo number_format($TotalCLPHoy, 0, '', '.');?></td>
					<td><?php echo number_format($TotalCIFHoy, 2, ',', '.');?></td>
					<td><?php echo number_format($TotalUSDHoy, 2, ',', '.');?></td>
				</tr>	
               </tbody>	
				
            </table>
    </div> <!-- fin excel -->
			
							<?php } } odbc_close( $conn );?>