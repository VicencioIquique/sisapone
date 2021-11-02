<?php 
require_once("clases/conexionocdb.php");
require_once("clases/funciones.php");

ini_set('max_execution_time', 300); //300 seconds = 5 minutes

$periodo = $_GET['periodo'];
$dia = $_GET['dia'];
$agrupar = $_GET['distribuir'];

if(!$periodo)
{
	$periodo =  date('Y-m', strtotime('-1 month'));
}

/********************** para que solo busque por modulos segun pertenesca ******************************************/
if($_SESSION["usuario_modulo"] !=-1)
{
	$modulo = $_SESSION["usuario_modulo"];
	if($modulo == 0)
		$modulo='ZFI.2077';
	if($modulo == 1)
		$modulo='ZFI.1010';
	if($modulo == 2)
		$modulo='ZFI.1132';
	if($modulo ==3)
		$modulo='ZFI.181';
	if($modulo == 4)
		$modulo='ZFI.184';
	if($modulo == 5)
		$modulo='ZFI.2002';
	if($modulo == 6)
		$modulo='ZFI.6115';
	if($modulo == 7)
		$modulo='ZFI.6130';
	if($modulo == 42)
		$modulo='LOCAL.2';
	if($modulo == 48)
		$modulo='LOCAL.8';
}

else
{
	$modulo = $_GET['modulo'];
}

/************************************** fin privilegio de modulo *****************************/

if($agrupar == 'Detalle')
{
  $detalleBol = 'DocNum,';
  $detalleDSM = 'NroDEM,';
  $detalleDEM = 'NroDSM,';
  $cfolio = ' ,OW.FolioNum                      [NroVisacion]';
  $ffolio = ' LEFT JOIN [SBO_Imp_Eximben_SAC]..OWTR OW ON NroDEM = OW.DocNum';
  $wfolio = ' AND (OW.FolioNum IS NOT  NULL OR OW.FolioNum = 0)';
  $gfolio = ' ,OW.FolioNum';
  
  
  
	 if($dia)
	{
	  $WdiaBol = ' AND  DAY(DocDate) = '.$dia;
	  $WdiaDSM = ' AND  DAY(FechaDoc) = '.$dia;
	  
	}
}




/************************************************************ PARA LOS VENDEDORES **************************************/


$sql="SELECT      
      'BOLETA LOCAL 181' COLLATE SQL_Latin1_General_CP850_CI_AS  AS  [Titulo] 
      ,[WhsCode] COLLATE SQL_Latin1_General_CP850_CI_AS              [WhsCode]
      ,DAY(DocDate)             AS                                   [Dia]
      ,MIN(DocNum)      COLLATE SQL_Latin1_General_CP850_CI_AS       [Desde]
      ,MAX(DocNum)    COLLATE SQL_Latin1_General_CP850_CI_AS         [Hasta]
      ,COUNT(DISTINCT DocNum)           
      - ISNULL(SUM(CASE
          WHEN ObjType = 14 THEN 1
       END),0)                                                       [Nro]
      ,SUM([TotalCLP])                                               [Valor]
      ,'0.00' COLLATE SQL_Latin1_General_CP850_CI_AS                 [IVA]
      ,SUM([TotalCIF])                                               [CIF]
  FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_VW_VtasD_RPRO]
  WHERE WhsCode = '".$modulo."'
        AND Periodo = '".$periodo."'
		".$WdiaBol."
  GROUP BY
          ". $detalleBol ."
	      DAY(DocDate)
	     ,WhsCode  
  ORDER BY
           Titulo,Dia
  ";

  
  /*DECLARACINES DE SALIDA */
  $sql2="SELECT      
     'DECLARACION DE SALIDA MOD ' AS [Titulo] 
      ,BO.Bodega                        [WhsCode]
	  ".$cfolio."
      ,DAY(FechaDoc)            AS      [Dia]
      ,MIN(NroDEM)                      [Desde]
      ,MAX(NroDEM)                      [Hasta]
      ,MIN(OW.FolioNum)                 [fDesde]
      ,MAX(OW.FolioNum)                 [fHasta]
      ,COUNT( DISTINCT OW.FolioNum)          [Nro]
      ,SUM((CifUnitario))               [Valor]
      ,'0.00'                           [IVA]
      ,SUM((CifUnitario * Cantidad))    [CIF]
  FROM [RP_VICENCIO].[dbo].[RP_DEM] 
  LEFT JOIN RP_VICENCIO..Bodega BO  ON CodModulo = BO.Retail
  LEFT JOIN [SBO_Imp_Eximben_SAC]..OWTR OW ON NroDEM = OW.DocNum
  WHERE BO.Bodega  = '".$modulo."'
        AND STR(YEAR(FechaDoc),4,0)+'-'+
       REPLACE(STR(MONTH(FechaDoc),2,0),' ',0)= '".$periodo."'
	    ".$wfolio."
          ".$WdiaDSM."
  GROUP BY
          ". $detalleDSM ."
	      DAY(FechaDoc)
	     ,BO.Bodega 
		 ".$gfolio."
		 
     ORDER BY
           Titulo,Dia
  ";
  
  /* DECLARACIONES DE ENTRADA*/
  $sql3="
  SELECT
      'DECLARACION DE ENTRADA' AS [Titulo] 
      ,BO.Bodega                        [WhsCode]
      ,DAY(FechaDoc)            AS      [Dia]
      ,MIN(OW.FolioNum)                 [Desde]
      ,MAX(OW.FolioNum)                 [Hasta]
      ,COUNT( DISTINCT OW.FolioNum)     [Nro]
      ,SUM((CifUnitario))               [Valor]
      ,'0.00'                           [IVA]
      ,SUM((CifUnitario * Cantidad))    [CIF]
  FROM [RP_VICENCIO].[dbo].[RP_DSM] 
  LEFT JOIN RP_VICENCIO..Bodega BO  ON TOrigen = BO.Retail
  LEFT JOIN [SBO_Imp_Eximben_SAC]..OWTR OW ON NroDSM = OW.DocNum
  WHERE BO.Bodega  =  '".$modulo."'
        AND STR(YEAR(FechaDoc),4,0)+'-'+
        REPLACE(STR(MONTH(FechaDoc),2,0),' ',0)= '".$periodo."'
	    AND OW.FolioNum <> 0 AND OW.FolioNum IS NOT NULL
         ".$WdiaDSM."
  GROUP BY
         ". $detalleDEM ."
	      DAY(FechaDoc)
	     ,BO.Bodega 
		 
     ORDER BY
           Titulo,Dia
  ";
 
 
 /*DECLARACIONES DE SALIDA ANORMAL*/
  $sql4="SELECT      
     'DECLARACION DE SALIDA MOD ' AS    [Titulo] 
      ,BO.Bodega                        [WhsCode]
      ,DAY(FechaDoc)            AS      [Dia]
       ,MIN(OW.FolioNum)                [FDesde]
      ,MAX(OW.FolioNum)                 [FHasta]
      ,MIN(NroDEM)                      [Desde]
      ,MAX(NroDEM)                      [Hasta]
      ,COUNT( DISTINCT NroDEM)          [Nro]
      ,SUM((CifUnitario))               [Valor]
      ,'0.00'                           [IVA]
      ,SUM((CifUnitario * Cantidad))    [CIF]
  FROM [RP_VICENCIO].[dbo].[RP_DEM] 
  LEFT JOIN RP_VICENCIO..Bodega BO  ON CodModulo = BO.Retail
  LEFT JOIN [SBO_Imp_Eximben_SAC]..OWTR OW ON NroDEM = OW.DocNum
  WHERE BO.Bodega  = '".$modulo."'
        AND STR(YEAR(FechaDoc),4,0)+'-'+
       REPLACE(STR(MONTH(FechaDoc),2,0),' ',0)= '".$periodo."'
	     AND (OW.FolioNum IS  NULL OR OW.FolioNum = 0)
          ".$WdiaDSM."
  GROUP BY
          ". $detalleDSM ."
	      DAY(FechaDoc)
	     ,BO.Bodega 
    ORDER BY
           Titulo,Dia
  ";
  
  /* DECLARACIONES DE ENTRADA ANORMAL */
  $sql5="
  SELECT
      'DECLARACION DE ENTRADA' AS       [Titulo] 
      ,BO.Bodega                        [WhsCode]
      ,DAY(FechaDoc)            AS      [Dia]
      ,MIN(OW.FolioNum)                 [FDesde]
      ,MAX(OW.FolioNum)                 [FHasta]
      ,MIN(NroDSM)                      [Desde]
      ,MAX(NroDSM)                      [Hasta]
      ,COUNT( DISTINCT NroDSM)     [Nro]
      ,SUM((CifUnitario))               [Valor]
      ,'0.00'                           [IVA]
      ,SUM((CifUnitario * Cantidad))    [CIF]
  FROM [RP_VICENCIO].[dbo].[RP_DSM] 
  LEFT JOIN RP_VICENCIO..Bodega BO  ON TOrigen = BO.Retail
  LEFT JOIN [SBO_Imp_Eximben_SAC]..OWTR OW ON NroDSM = OW.DocNum
  WHERE BO.Bodega  =  '".$modulo."'
        AND STR(YEAR(FechaDoc),4,0)+'-'+
        REPLACE(STR(MONTH(FechaDoc),2,0),' ',0)= '".$periodo."'
	     AND (OW.FolioNum IS  NULL OR OW.FolioNum = 0)
         ".$WdiaDSM."
  GROUP BY
         ". $detalleDEM ."
	      DAY(FechaDoc)
	     ,BO.Bodega 
		 
     ORDER BY
           Titulo,Dia
  ";
//echo $sql;

	echo'  <script src="graficos/amcharts/amcharts.js" type="text/javascript"></script>   ';	
	
	

					include("graficos/topVendedores.php");					
?>
<script type="text/javascript">
  $(document).ready(function(){
				//comienza focus en modulo
				$('#moduloid').focus();
				// calendarios en text de fecha inicio fin
				
				$(".periodo").datepicker({
				dateFormat: 'yy-mm',
				changeMonth: true,
				changeYear: true,
				
				showButtonPanel: true,

				onClose: function(dateText, inst) {
					var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
					var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
					$(this).val($.datepicker.formatDate('yy-mm', new Date(year, month, 1)));
				}
			});

			$(".periodo").focus(function () {
				$(".ui-datepicker-calendar").hide();
				$("#ui-datepicker-div").position({
					my: "center top",
					at: "center bottom",
					of: $(this)
				});
			});
	
	
	$('#dia').datepicker( {
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'dd'
		
    });

 });//fin funciotn principal

</script>

<script language="javascript"> 
$(document).ready(function() { 
     $(".botonExcel1").click(function(event) { 
		 $("#datos_a_enviar").val( $("<div>").append( $(".t1").eq(0).clone()).html()); 
		 $("#FormularioExportacion").submit(); 
      });
	  $(".botonExcel2").click(function(event) { 
		 $("#datos_a_enviar").val( $("<div>").append( $(".t2").eq(0).clone()).html()); 
		 $("#FormularioExportacion").submit(); 
      }); 
	  $(".botonExcel3").click(function(event) { 
		 $("#datos_a_enviar").val( $("<div>").append( $(".t3").eq(0).clone()).html()); 
		 $("#FormularioExportacion").submit(); 
      }); 
	  $(".botonExcel4").click(function(event) { 
		 $("#datos_a_enviar").val( $("<div>").append( $(".t4").eq(0).clone()).html()); 
		 $("#FormularioExportacion").submit(); 
      }); 
	  $(".botonExcel5").click(function(event) { 
		 $("#datos_a_enviar").val( $("<div>").append( $(".t5").eq(0).clone()).html()); 
		 $("#FormularioExportacion").submit(); 
      }); 
}); 
</script> 


<div class="idTabs">
      <ul>
        <li><a href="#one"><img src="images/buscar.png" width="30px" height="30px" /></a></li>
		<?php // pregunta si ha ingresado una fecha para que se muestre el imagen link de generar Excel
					
		if($periodo3){
		
			echo'<form action="/sisapone/clases/ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion"> 
			<center><img src="images/excel.png" width="30px" height="30px" class="botonExcel"  /> </center>
			<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" /> 
			</form> ';
		}?>
	 </ul>
      <div class="items">
        <div id="one"> <form action="" method="GET" id="horizontalForm">
            <fieldset>
				<legend>Ingresar Fechas</legend>
							 
							 <input name="opc" type="hidden" id="opc" size="40" class="required" value="movDoc" />
							
							<?php
							 	if($_SESSION["usuario_modulo"] == -1)
								{
									
									echo '<label class="first" for="title1">
									Retail
									<select id="modulo" name="modulo"     class="styled" >
									<option ></option>';
									if($modulo)
									{
										echo'<option value="'.$modulo.'" selected>'.$modulo.'</option>';
									}
									
									echo'
									
									<option value="ZFI.2077">Modulo 2077</option>
									<option value="ZFI.1010">Modulo 1010</option>
									<option value="ZFI.1132">Modulo 1132</option>
									<option value="ZFI.181">Modulo 181</option>
									<option value="ZFI.184">Modulo 184</option>
									<option value="ZFI.2002">Modulo 2002</option>
									<option value="ZFI.6115">Modulo 6115</option>
									<option value="ZFI.6130">Modulo 6130</option>
									<option value="LOCAL.2">Local 2</option>
									<option value="LOCAL.8">Local 8</option>
									</select>
				            </label>';
								}
					        
								echo'<label >
										Periodo:
										<input type="text" id="periodo" name="periodo" class="periodo" size="5" value="'.$periodo.'"  />
						  </label>';
						  
						  echo'<label >
										Día:
										<input type="text" id="dia" name="dia" class="dia" size="5" value="'.$dia.'"  />
						  </label>';
					        ?>
					       
							
                             <?php
							 	
									
									echo '<label class="first" for="title1">
									Agrupar Por:
									<select id="distribuir" name="distribuir"    class="styled" >';
									if($distribuir)
									{
										echo'<option value="'.$distribuir.'" selected>'.$distribuir.'</option>';
									}									
																		
									echo'
									<option value="Dias">Dias</option>
									<option value="Detalle">Detalle</option>
									</select>
				            </label>';
							
					        ?>
							
                            
                             <input name="agregar" type="submit" id="agregar" class="submit" value="Consultar" />

			</fieldset>
            </form>
         </div> <!-- fin div two-->
      </div> <!-- fin items -->
    </div> <!-- fin idTabs -->
      
      
<div id="usual1" class="usual" > 
  <ul> 
    <li ><a id="tabdua" href="#tab1" class="selected">BOLETAS</a></li> 
	 
    <li ><a id="tabdua" href="#tab3">DECLARACIONES DE SALIDA</a></li> 
	<li ><a id="tabdua" href="#tab4">DECLARACIONES DE ENTRADA</a></li> 
	
	<li ><a id="tabdua" href="#tab5">DSM IRREGULARES</a></li> 
	<li ><a id="tabdua" href="#tab6">DEM IRREGULARES</a></li> 
	
  </ul> 
  
  <div id="tab1">
  <table  id="ssptable2" class="t1" >
            <thead>
                    <tr>
                        <th><form action="/sisapone/clases/ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion"> 
			<center><img src="images/excel.png" width="25px" height="25px" class="botonExcel1"  /> </center>
			<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" /> 
			</form></th>
                        <th></th>
						<th style="font-size:14px;" >MOVIMIENTOS BOLETAS LOCAL</th>
                        <th></th>
						<th></th>
                        <th></th>
                    </tr>
               </thead>
              <thead>
                    <tr>
                        <th>DIA</th>
                        <th>DESDE - HASTA</th>
						<th>NRO</th>
                        <th>VALOR</th>
						<th>IVA</th>
                        <th>CIF</th>
                    </tr>
               </thead>
                <tbody>
                 <?php
				 
			
							
							//echo $sql;	
							$rs2 = odbc_exec( $conn, $sql );
							if ( !$rs2 )
							{
							exit( "Error en la consulta SQL" );
							}
							
							  while($resultado = odbc_fetch_array($rs2)){ 
							 
							   echo '<tr>
									<td style="background-color:#6C6B6B;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" >'.utf8_encode($resultado["Dia"]).'</td>';
									if($agrupar == 'Detalle')
									{
									    echo '<td >'.utf8_encode($resultado["Desde"]).'</td>';
									}
									else 
									{
									  echo '<td >'.utf8_encode($resultado["Desde"]).' - '.$resultado["Hasta"].'</td>';
									}
									echo'<td ><strong>'.number_format($resultado["Nro"], 0, '', '.').'</strong></td>
									<td ><strong>'.number_format($resultado["Valor"], 2, ',', '.').'</strong></td>
									<td ><strong>'.number_format($resultado["IVA"], 2, ',', '.').'</strong></td>
									<td ><strong>'.number_format($resultado["CIF"], 2, ',', '.').'</strong></td></tr>' ;
									$totalNro = $totalNro + $resultado["Nro"];
									$totalValor = $totalValor + $resultado["Valor"];
									$totalIVA = $totalIVA + $resultado["IVA"];
									$totalCIF = $totalCIF + $resultado["CIF"];
									
							}
							
				?>
                </tbody>
                <tfoot>
                	<tr  style=" border-top:2px double #B5B5B5;">
                    	<td></td>
						<td></td>
                        <td><strong><?php echo number_format($totalNro, 0, '', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($totalValor, 2, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($totalIVA, 2, ',', '.'); ?></strong></td>
						 <td><strong><?php echo number_format($totalCIF, 2, ',', '.'); ?></strong></td>
                  
                    </tr>
                </tfoot>
            </table>
</div> <!-- fin de TAB 1 -->

  
  <div id="tab3"> 
  <table  id="ssptable2" class="t2">
              <thead>
                    <tr>
                        <th><form action="/sisapone/clases/ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion"> 
			<center><img src="images/excel.png" width="25px" height="25px" class="botonExcel2"  /> </center>
			<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" /> 
			</form></th>
                        <th></th>
						<th style="font-size:14px;" >DECLARACIONES DE SALIDA OK</th>
                        <th></th>
						<th></th>
                        <th></th>
						<th></th>
                    </tr>
               </thead>
			  <thead>
                    <tr>
                        <th>DIA</th>
                        <th>DESDE - HASTA</th>
						<th>NRO</th>
						<th>NRO VISACION</th>
                        <th>VALOR</th>
						<th>IVA</th>
                        <th>CIF</th>
                    </tr>
                </thead>
                <tbody>
                 <?php
				 
			
							
							//echo $sql;	
							$rs = odbc_exec( $conn, $sql2 );
							if ( !$rs )
							{
							exit( "Error en la consulta SQL" );
							}
							
							  while($resultado = odbc_fetch_array($rs)){ 
							 
							   echo '<tr>
									<td style="background-color:#6C6B6B;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" >'.utf8_encode($resultado["Dia"]).'</td>';
									if($agrupar == 'Detalle')
									{
									    echo '<td >'.utf8_encode($resultado["Desde"]).'</td>';
									}
									else 
									{
									  echo '<td >'.utf8_encode($resultado["Desde"]).' - '.$resultado["Hasta"].'</td>';
									}
									
									echo'<td ><strong>'.number_format($resultado["Nro"], 0, '', '.').'</strong></td>
									<td ><strong>'.number_format($resultado["NroVisacion"], 0, '', '').'</strong></td>
									<td ><strong>'.number_format($resultado["Valor"], 2, ',', '.').'</strong></td>
									<td ><strong>'.number_format($resultado["IVA"], 2, ',', '.').'</strong></td>
									<td ><strong>'.number_format($resultado["CIF"], 2, ',', '.').'</strong></td></tr>' ;
									$totalNro2 = $totalNro2 + $resultado["Nro"];
									$totalValor2 = $totalValor2 + $resultado["Valor"];
									$totalIVA2 = $totalIVA2 + $resultado["IVA"];
									$totalCIF2 = $totalCIF2 + $resultado["CIF"];
							
							}
							

				?>
                </tbody>
                <tfoot>
                		<tr  style=" border-top:2px double #B5B5B5;">
                    	<td></td>
						<td></td>
                        <td><strong><?php echo number_format($totalNro2, 0, '', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($totalValor2, 2, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($totalIVA2, 2, ',', '.'); ?></strong></td>
						 <td><strong><?php echo number_format($totalCIF2, 2, ',', '.'); ?></strong></td>
                 
                    </tr>
                </tfoot>
            </table>
   </div>  <!-- fin de tab 3 -->
   
   <div id="tab4"> 
  <table  id="ssptable2" class="t3">
              <thead>
                    <tr>
                        <th><form action="/sisapone/clases/ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion"> 
			<center><img src="images/excel.png" width="25px" height="25px" class="botonExcel3"  /> </center>
			<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" /> 
			</form></th>
                        <th></th>
						<th style="font-size:14px;" >DECLARACIONES DE ENTRADA OK</th>
                        <th></th>
						<th></th>
                        <th></th>
                    </tr>
               </thead>
			  <thead>
                    <tr>
                        <th>DIA</th>
                        <th>DESDE - HASTA</th>
						<th>NRO</th>
                        <th>VALOR</th>
						<th>IVA</th>
                        <th>CIF</th>
                    </tr>
                </thead>
                <tbody>
                 <?php
				 
			
							
							//echo $sql;	
							$rs3 = odbc_exec( $conn, $sql3 );
							if ( !$rs3 )
							{
							exit( "Error en la consulta SQL" );
							}
							
							  while($resultado3 = odbc_fetch_array($rs3)){ 
							 
							   echo '<tr>
									<td style="background-color:#6C6B6B;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" >'.utf8_encode($resultado3["Dia"]).'</td>';
									if($agrupar == 'Detalle')
									{
									    echo '<td >'.utf8_encode($resultado3["Desde"]).'</td>';
									}
									else 
									{
									  echo '<td >'.utf8_encode($resultado3["Desde"]).' - '.$resultado3["Hasta"].'</td>';
									}
									
									echo'<td ><strong>'.number_format($resultado3["Nro"], 0, '', '.').'</strong></td>
									<td ><strong>'.number_format($resultado3["Valor"], 2, ',', '.').'</strong></td>
									<td ><strong>'.number_format($resultado3["IVA"], 2, ',', '.').'</strong></td>
									<td ><strong>'.number_format($resultado3["CIF"], 2, ',', '.').'</strong></td></tr>' ;
									$totalNro3 = $totalNro3 + $resultado3["Nro"];
									$totalValor3 = $totalValor3 + $resultado3["Valor"];
									$totalIVA3= $totalIVA3 + $resultado3["IVA"];
									$totalCIF3 = $totalCIF3 + $resultado3["CIF"];
							
							}
							

				?>
                </tbody>
                <tfoot>
                		<tr  style=" border-top:2px double #B5B5B5;">
                    	<td></td>
						<td></td>
                        <td><strong><?php echo number_format($totalNro3, 0, '', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($totalValor3, 2, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($totalIVA3, 2, ',', '.'); ?></strong></td>
						 <td><strong><?php echo number_format($totalCIF3, 2, ',', '.'); ?></strong></td>
                 
                    </tr>
                </tfoot>
            </table>
   </div>  <!-- fin de tab 4 -->
   
  <!-- ##################################################### MOVIMIENTOS EXTRANIOSS #########################################################*/ -->
     <div id="tab5"> 
  <table  id="ssptable2" class="t4">
                <thead>
                    <tr>
                        <th><form action="/sisapone/clases/ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion"> 
			<center><img src="images/excel.png" width="25px" height="25px" class="botonExcel4"  /> </center>
			<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" /> 
			</form></th>
                        <th></th>
						<th style="font-size:14px;" >DSM IRREGULARES</th>
                        <th></th>
						<th></th>
						<th></th>
                        <th></th>
                    </tr>
               </thead>
			  <thead>
                    <tr>
                        <th>DIA</th>
                        <th>DESDE - HASTA (Nro. Visación)</th>
						<th>DESDE - HASTA (Nro. Doc.)</th>
						<th>NRO</th>
                        <th>VALOR</th>
						<th>IVA</th>
                        <th>CIF</th>
                    </tr>
                </thead>
                <tbody>
                 <?php
				 
			
							
							//echo $sql;	
							$rs4 = odbc_exec( $conn, $sql4 );
							if ( !$rs4 )
							{
							exit( "Error en la consulta SQL" );
							}
							
							  while($resultado = odbc_fetch_array($rs4)){ 
							 
							   echo '<tr>
									<td style="background-color:#6C6B6B;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" >'.utf8_encode($resultado["Dia"]).'</td>';
									if($agrupar == 'Detalle')
									{
									    echo '<td >'.utf8_encode($resultado["FDesde"]).'</td>';
									}
									else 
									{
									  echo '<td >'.utf8_encode($resultado["FDesde"]).' - '.$resultado["FHasta"].'</td>';
									}
									
									if($agrupar == 'Detalle')
									{
									    echo '<td >'.utf8_encode($resultado["Desde"]).'</td>';
									}
									else 
									{
									  echo '<td >'.utf8_encode($resultado["Desde"]).' - '.$resultado["Hasta"].'</td>';
									}
									
									echo'<td ><strong>'.number_format($resultado["Nro"], 0, '', '.').'</strong></td>
									<td ><strong>'.number_format($resultado["Valor"], 2, ',', '.').'</strong></td>
									<td ><strong>'.number_format($resultado["IVA"], 2, ',', '.').'</strong></td>
									<td ><strong>'.number_format($resultado["CIF"], 2, ',', '.').'</strong></td></tr>' ;
									$totalNro4 = $totalNro4 + $resultado["Nro"];
									$totalValor4 = $totalValor4 + $resultado["Valor"];
									$totalIVA4 = $totalIVA4 + $resultado["IVA"];
									$totalCIF4 = $totalCIF4 + $resultado["CIF"];
							
							}
							

				?>
                </tbody>
                <tfoot>
                		<tr  style=" border-top:2px double #B5B5B5;">
                    	<td></td>
						<td></td>
						<td></td>
                        <td><strong><?php echo number_format($totalNro4, 0, '', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($totalValor4, 2, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($totalIVA4, 2, ',', '.'); ?></strong></td>
						 <td><strong><?php echo number_format($totalCIF4, 2, ',', '.'); ?></strong></td>
                 
                    </tr>
                </tfoot>
            </table>
   </div>  <!-- fin de tab5-->
   
   <div id="tab6"> 
  <table  id="ssptable2" class="t5">
               <thead>
                    <tr>
                        <th><form action="/sisapone/clases/ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion"> 
			<center><img src="images/excel.png" width="25px" height="25px" class="botonExcel5"  /> </center>
			<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" /> 
			</form></th>
                        <th></th>
						<th style="font-size:14px;" >DSM IRREGULARES</th>
                        <th></th>
						<th></th>
						<th></th>
                        <th></th>
                    </tr>
               </thead>
			  <thead>
                    <tr>
                        <th>DIA</th>
                        <th>DESDE - HASTA (Nro. Visación)</th>
						<th>DESDE - HASTA (Nro. Doc.)</th>
						<th>NRO</th>
                        <th>VALOR</th>
						<th>IVA</th>
                        <th>CIF</th>
                    </tr>
                </thead>
                <tbody>
                 <?php
				 
			
							
							//echo $sql;	
							$rs5 = odbc_exec( $conn, $sql5 );
							if ( !$rs5 )
							{
							exit( "Error en la consulta SQL" );
							}
							
							  while($resultado3 = odbc_fetch_array($rs5)){ 
							 
							   echo '<tr>
									<td style="background-color:#6C6B6B;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" >'.utf8_encode($resultado3["Dia"]).'</td>';
									if($agrupar == 'Detalle')
									{
									    echo '<td >'.utf8_encode($resultado3["FDesde"]).'</td>';
									}
									else 
									{
									  echo '<td >'.utf8_encode($resultado3["FDesde"]).' - '.$resultado3["FHasta"].'</td>';
									}
									
									if($agrupar == 'Detalle')
									{
									    echo '<td >'.utf8_encode($resultado3["Desde"]).'</td>';
									}
									else 
									{
									  echo '<td >'.utf8_encode($resultado3["Desde"]).' - '.$resultado3["Hasta"].'</td>';
									}
									
									echo'
									<td ><strong>'.number_format($resultado3["Nro"], 0, '', '.').'</strong></td>
									<td ><strong>'.number_format($resultado3["Valor"], 2, ',', '.').'</strong></td>
									<td ><strong>'.number_format($resultado3["IVA"], 2, ',', '.').'</strong></td>
									<td ><strong>'.number_format($resultado3["CIF"], 2, ',', '.').'</strong></td></tr>' ;
									$totalNro5 = $totalNro5 + $resultado3["Nro"];
									$totalValor5 = $totalValor5 + $resultado3["Valor"];
									$totalIVA5= $totalIVA5 + $resultado3["IVA"];
									$totalCIF5 = $totalCIF5 + $resultado3["CIF"];
							
							}
							

				?>
                </tbody>
                <tfoot>
                		<tr  style=" border-top:2px double #B5B5B5;">
                    	<td></td>
						<td></td>
						<td></td>
                        <td><strong><?php echo number_format($totalNro5, 0, '', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($totalValor5, 2, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($totalIVA5, 2, ',', '.'); ?></strong></td>
						 <td><strong><?php echo number_format($totalCIF5, 2, ',', '.'); ?></strong></td>
                 
                    </tr>
                </tfoot>
            </table>
   </div>  <!-- fin de tab 6 -->
  
<script type="text/javascript"> 
  $("#usual1 ul").idTabs(); 
</script>
           
			
            


<?php odbc_close( $conn );?>