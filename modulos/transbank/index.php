<?php 
require_once("clases/conexionocdb.php");
ini_set('max_execution_time', 600); //300 seconds = 5 minutes


$consultar = $_GET['agregar'];



/********************** para que solo busque por modulos segun pertenesca ******************************************/
if($_SESSION["usuario_modulo"] !=-1)
{
	$modulo = $_SESSION["usuario_modulo"];
	$modulo =str_pad($modulo, 3, '0', 'STR_PAD_LEFT');
}

else
{
	$modulo = $_GET['modulo'];
}
/************************************** fin privilegio de modulo *****************************/


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
				 $( document ).tooltip();
            });
			

</script>

<script language="javascript"> 
$(document).ready(function() { 
     $(".botonExcel").click(function(event) { 
     $("#datos_a_enviar").val( $("<div>").append( $("#ssptable2").eq(0).clone()).html()); 
     $("#FormularioExportacion").submit(); 
}); 
}); 
</script> 



<div class="idTabs">
      <ul>
        <li><a href="#one"><img src="images/agregar.png" width="30px" height="30px" /></a></li>
		<?php // pregunta si ha ingresado una fecha para que se muestre el imagen link de generar Excel
					
		
		
			echo'<form action="/sisapone/clases/ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion"> 
			<center><img src="images/excel.png" width="30px" height="30px" class="botonExcel"  /> </center>
			<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" /> 
			</form> ';
		?>
	 </ul>
      <div class="items">
        <div id="one"> <form action="" method="GET" id="horizontalForm">
        
            <fieldset>
				<legend>Filtros</legend>
							 
							 <input name="opc" type="hidden" id="opc" size="40" class="required" value="transbank" />
	
                             <input style="clear:initial;" name="refrescar" type="submit" id="agregar" class="submit" value="Refrescar" />

			</fieldset>
            </form>
         </div> <!-- fin div two-->
      </div> <!-- fin items -->
    </div> <!-- fin idTabs -->



                 <?php

$sqlAbonos= "
SELECT 
      [bodega] WhsCode
      ,[tipoPago] AS TipoPago
      ,SUM([monto]) AS TOTAL
      
  FROM [RP_VICENCIO].[dbo].[sisap_abonosTransbank]
  GROUP BY bodega,tipoPago  
";				 
				 			
$sql= "
SELECT  
      [WhsCode]
     ,[TipoPago]
      
      ,SUM([Monto]) AS TOTAL

  FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_VW_MedPagos]
  WHERE TipoPago IN ('StoreCredit','CreditCard','DebitCard')
  GROUP BY WhsCode,TipoPago
  ORDER BY WhsCode      
";
									
		
				//echo $sql;
		?>
				
            <table    id="ssptable2"  class="lista">
              <thead>
                   <tr>
					    <th>Retail</th>
						<th>T. Debito</th>
						<th>T. Credito</th>
						<th>Credito de tienda</th>
						<th>Saldo Por Cobrar</th>
						<th>Abono</th>
					</tr>	
           
              </thead>
              <tbody>
		<?php
		
		$rs1 = odbc_exec( $conn, $sqlAbonos );
					if ( !$rs1 )
					{
					exit( "Error en la consulta SQL" );
					}
							
					while($resultado1 = odbc_fetch_array($rs1))
					{
					  if($resultado1["WhsCode"] == "LOCAL.2")
					  {
					
							if($resultado1["TipoPago"] == "CreditCard")
							$Alocal2CC = $resultado1["TOTAL"];
							else if($resultado1["TipoPago"] == "DebitCard")
							$Alocal2DC = $resultado1["TOTAL"];
							
					  }
					  if($resultado1["WhsCode"] == "LOCAL.8")
					  {
							if($resultado1["TipoPago"] == "CreditCard")
							$Alocal8CC=$resultado1["TOTAL"];
							else if($resultado1["TipoPago"] == "DebitCard")
							$Alocal8DC=$resultado1["TOTAL"];
						
					  }
					  if($resultado1["WhsCode"] == "LOCAL.8")
					  {
							if($resultado1["TipoPago"] == "CreditCard")
							$Alocal8CC=$resultado1["TOTAL"];
							else if($resultado1["TipoPago"] == "DebitCard")
							$Alocal8DC=$resultado1["TOTAL"];
							
					  }
					  
					  if($resultado1["WhsCode"] == "ZFI.1010")
					  {
							if($resultado1["TipoPago"] == "CreditCard")
							$Ar1010CC=$resultado1["TOTAL"];
							else if($resultado1["TipoPago"] == "DebitCard")
							$Ar1010DC=$resultado1["TOTAL"];
							
					  }
					  
					  if($resultado1["WhsCode"] == "ZFI.1132")
					  {
							if($resultado1["TipoPago"] == "CreditCard")
							$Ar1132CC=$resultado1["TOTAL"];
							else if($resultado1["TipoPago"] == "DebitCard")
							$Ar1132DC=$resultado1["TOTAL"];
							
					  }
					
					  if($resultado1["WhsCode"] == "ZFI.181")
					  {
							if($resultado1["TipoPago"] == "CreditCard")
							$Ar181CC=$resultado1["TOTAL"];
							else if($resultado1["TipoPago"] == "DebitCard")
							$Ar181DC=$resultado1["TOTAL"];
							
					  }
					  
					   if($resultado1["WhsCode"] == "ZFI.184")
					  {
							if($resultado1["TipoPago"] == "CreditCard")
							$Ar184CC=$resultado1["TOTAL"];
							else if($resultado1["TipoPago"] == "DebitCard")
							$Ar184DC=$resultado1["TOTAL"];
							
					  }
					   if($resultado1["WhsCode"] == "ZFI.2002")
					  {
							if($resultado1["TipoPago"] == "CreditCard")
							$Ar2002CC=$resultado1["TOTAL"];
							else if($resultado1["TipoPago"] == "DebitCard")
							$Ar2002DC=$resultado1["TOTAL"];
							
					  }
					   if($resultado1["WhsCode"] == "ZFI.6115")
					  {
							if($resultado1["TipoPago"] == "CreditCard")
							$Ar6115CC=$resultado1["TOTAL"];
							else if($resultado1["TipoPago"] == "DebitCard")
							$Ar6115DC=$resultado1["TOTAL"];
							
					  }
					   if($resultado1["WhsCode"] == "ZFI.6130")
					  {
							if($resultado1["TipoPago"] == "CreditCard")
							$Ar6130CC=$resultado1["TOTAL"];
							else if($resultado1["TipoPago"] == "DebitCard")
							$Ar6130DC=$resultado1["TOTAL"];
							
					  }
					   if($resultado1["WhsCode"] == "ZFI.2077")
					  {
							if($resultado1["TipoPago"] == "CreditCard")
							$Ar2077CC=$resultado1["TOTAL"];
							else if($resultado1["TipoPago"] == "DebitCard")
							$Ar2077DC=$resultado1["TOTAL"];
							
					  }
					  
					} // End While
		
		$Attlocal2 = ($Alocal2CC + $Alocal2DC) ;
		$Attlocal8 = ($Alocal8CC + $lAocal8DC);
		
		$Att1010 = ($Ar1010CC + $Ar1010DC);
		$Att1132 =  ($Ar1132CC + $Ar1132DC );
		$Att181 = ($r181CC + $Ar181DC);
		$Att184 =  ($Ar184CC + $Ar184DC);
		$Att2002 =  ($Ar2002CC + $Ar2002DC);
		$Att6115 = ($Ar6115CC + $Ar6115DC);
		$Att6130 = ($Ar6130CC + $Ar6130DC);
		
		$Att2077 = ($Ar2077CC + $Ar2077DC);
		
		
		/***************************************************  Por Retirar ******************************************************/
		
					$rs = odbc_exec( $conn, $sql );
					if ( !$rs )
					{
					exit( "Error en la consulta SQL" );
					}
							
					while($resultado = odbc_fetch_array($rs))
					{
					  if($resultado["WhsCode"] == "LOCAL.2")
					  {
					
							if($resultado["TipoPago"] == "CreditCard")
							$local2CC = $resultado["TOTAL"];
							else if($resultado["TipoPago"] == "DebitCard")
							$local2DC = $resultado["TOTAL"];
							else if($resultado["TipoPago"] == "StoreCredit")
							$local2SC = $resultado["TOTAL"];
					  }
					  if($resultado["WhsCode"] == "LOCAL.8")
					  {
							if($resultado["TipoPago"] == "CreditCard")
							$local8CC=$resultado["TOTAL"];
							else if($resultado["TipoPago"] == "DebitCard")
							$local8DC=$resultado["TOTAL"];
							else if($resultado["TipoPago"] == "StoreCredit")
							$local8SC=$resultado["TOTAL"];
					  }
					  if($resultado["WhsCode"] == "LOCAL.8")
					  {
							if($resultado["TipoPago"] == "CreditCard")
							$local8CC=$resultado["TOTAL"];
							else if($resultado["TipoPago"] == "DebitCard")
							$local8DC=$resultado["TOTAL"];
							else if($resultado["TipoPago"] == "StoreCredit")
							$local8SC=$resultado["TOTAL"];
					  }
					  
					  if($resultado["WhsCode"] == "ZFI.1010")
					  {
							if($resultado["TipoPago"] == "CreditCard")
							$r1010CC=$resultado["TOTAL"];
							else if($resultado["TipoPago"] == "DebitCard")
							$r1010DC=$resultado["TOTAL"];
							else if($resultado["TipoPago"] == "StoreCredit")
							$r1010SC=$resultado["TOTAL"];
					  }
					  
					  if($resultado["WhsCode"] == "ZFI.1132")
					  {
							if($resultado["TipoPago"] == "CreditCard")
							$r1132CC=$resultado["TOTAL"];
							else if($resultado["TipoPago"] == "DebitCard")
							$r1132DC=$resultado["TOTAL"];
							else if($resultado["TipoPago"] == "StoreCredit")
							$r1132SC=$resultado["TOTAL"];
					  }
					
					  if($resultado["WhsCode"] == "ZFI.181")
					  {
							if($resultado["TipoPago"] == "CreditCard")
							$r181CC=$resultado["TOTAL"];
							else if($resultado["TipoPago"] == "DebitCard")
							$r181DC=$resultado["TOTAL"];
							else if($resultado["TipoPago"] == "StoreCredit")
							$r181SC=$resultado["TOTAL"];
					  }
					  
					   if($resultado["WhsCode"] == "ZFI.184")
					  {
							if($resultado["TipoPago"] == "CreditCard")
							$r184CC=$resultado["TOTAL"];
							else if($resultado["TipoPago"] == "DebitCard")
							$r184DC=$resultado["TOTAL"];
							else if($resultado["TipoPago"] == "StoreCredit")
							$r184SC=$resultado["TOTAL"];
					  }
					   if($resultado["WhsCode"] == "ZFI.2002")
					  {
							if($resultado["TipoPago"] == "CreditCard")
							$r2002CC=$resultado["TOTAL"];
							else if($resultado["TipoPago"] == "DebitCard")
							$r2002DC=$resultado["TOTAL"];
							else if($resultado["TipoPago"] == "StoreCredit")
							$r2002SC=$resultado["TOTAL"];
					  }
					   if($resultado["WhsCode"] == "ZFI.6115")
					  {
							if($resultado["TipoPago"] == "CreditCard")
							$r6115CC=$resultado["TOTAL"];
							else if($resultado["TipoPago"] == "DebitCard")
							$r6115DC=$resultado["TOTAL"];
							else if($resultado["TipoPago"] == "StoreCredit")
							$r6115SC=$resultado["TOTAL"];
					  }
					   if($resultado["WhsCode"] == "ZFI.6130")
					  {
							if($resultado["TipoPago"] == "CreditCard")
							$r6130CC=$resultado["TOTAL"];
							else if($resultado["TipoPago"] == "DebitCard")
							$r6130DC=$resultado["TOTAL"];
							else if($resultado["TipoPago"] == "StoreCredit")
							$r6130SC=$resultado["TOTAL"];
					  }
					   if($resultado["WhsCode"] == "ZFI.2077")
					  {
							if($resultado["TipoPago"] == "CreditCard")
							$r2077CC=$resultado["TOTAL"];
							else if($resultado["TipoPago"] == "DebitCard")
							$r2077DC=$resultado["TOTAL"];
							else if($resultado["TipoPago"] == "StoreCredit")
							$r2077SC=$resultado["TOTAL"];
					  }
					  
					} // End While
		
		/**** Calculos de Resultado ****/
		$ttlocal2 = $local2CC + $local2DC + $local2SC - ($Alocal2CC + $Alocal2DC) ;
		$ttlocal8 = $local8CC + $local8DC + $local8SC - ($Alocal8CC + $lAocal8DC);
		
		$tt1010 = $r1010CC + $r1010DC + $r1010SC - ($Ar1010CC + $Ar1010DC);
		$tt1132 = $r1132CC + $r1132DC + $r1132SC - ($Ar1132CC + $Ar1132DC );
		$tt181 = $r181CC + $r181DC + $r181SC - ($r181CC + $Ar181DC);
		$tt184 = $r184CC + $r184DC + $r184SC - ($Ar184CC + $Ar184DC);
		$tt2002 = $r2002CC + $r2002DC + $r2002SC - ($Ar2002CC + $Ar2002DC);
		$tt6115 = $r6115CC + $r6115DC + $r6115SC - ($Ar6115CC + $Ar6115DC);
		$tt6130 = $r6130CC + $r6130DC + $r6130SC - ($Ar6130CC + $Ar6130DC);
		
		$tt2077 = $r2077CC + $r2077DC + $r2077SC - ($Ar2077CC + $Ar2077DC);
		
		
		$totaltcreditos = $local2CC + $local8CC + $r1010CC + $r1132CC + $r181CC + $r184CC + $r2002CC + $r6115CC +$r6130CC + $r2077CC ;
		$Atotaltcreditos = $Alocal2CC + $Alocal8CC + $Ar1010CC + $Ar1132CC + $Ar181CC + $Ar184CC + $Ar2002CC + $Ar6115CC +$Ar6130CC + $Ar2077CC ;
		$totaltdebitos = $local2DC + $local8DC + $r1010DC + $r1132DC + $r181DC + $r184DC + $r2002DC + $r6115DC +$r6130DC +$r2077DC ;
		$Atotaltdebitos = $Alocal2DC + $Alocal8DC + $Ar1010DC + $Ar1132DC + $Ar181DC + $Ar184DC + $Ar2002DC + $Ar6115DC +$Ar6130DC +$Ar2077DC ;
		$totalctienda = $local2SC + $local8SC + $r1010SC + $r1132SC + $r181SC + $r184SC + $r2002SC + $r6115SC +$r6130SC +$r2077SC ;
			
		?>
		<tr>
			<td ><strong>Local 2</strong></td> 
			<td ><?php echo number_format($local2CC -$Alocal2CC, 0, '', '.'); ?></td> 
			<td ><?php echo number_format($local2DC-$Alocal2DC , 0, '', '.'); ?></td> 
			<td ><?php echo number_format($local2SC, 0, '', '.'); ?></td> 
			<td style="border-right: 1px solid #3F9DD0; background-color:#D9E3E8;"><?php echo number_format($ttlocal2, 0, '', '.'); ?></td> 
		    <td ><?php echo number_format($Attlocal2, 0, '', '.'); ?></td>
		</tr>
		</tr>
		    <td ><strong>Local 8</strong></td> 
			<td ><?php echo number_format($local8CC - $Alocal8CC, 0, '', '.'); ?></td> 
			<td ><?php echo number_format($local8DC - $Alocal8DC, 0, '', '.'); ?></td> 
			<td ><?php echo number_format($local8SC, 0, '', '.'); ?></td> 
			<td style="border-right: 1px solid #3F9DD0; background-color:#D9E3E8;" ><?php echo number_format($ttlocal8, 0, '', '.'); ?></td> 
			<td ><?php echo number_format($Attlocal8, 0, '', '.'); ?></td> 
		</tr>
		
		</tr>
		    <td ><strong>Modulo 1010</strong></td> 
			<td ><?php echo number_format($r1010CC - $Ar1010CC, 0, '', '.'); ?></td> 
			<td ><?php echo number_format($r1010DC - $Ar1010DC, 0, '', '.'); ?></td> 
			<td ><?php echo number_format($r1010SC , 0, '', '.'); ?></td> 
			<td style="border-right: 1px solid #3F9DD0; background-color:#D9E3E8;" ><?php echo number_format($tt1010  , 0, '', '.'); ?></td> 
			<td ><?php echo number_format($Att1010, 0, '', '.'); ?></td>
		</tr>
		
		</tr>
		    <td ><strong>Modulo 1132</strong></td> 
			<td ><?php echo number_format($r1132CC-$Ar1132CC, 0, '', '.'); ?></td> 
			<td ><?php echo number_format($r1132DC-$Ar1132DC, 0, '', '.'); ?></td> 
			<td ><?php echo number_format($r1132SC, 0, '', '.'); ?></td> 
			<td style="border-right: 1px solid #3F9DD0; background-color:#D9E3E8;" ><?php echo number_format($tt1132, 0, '', '.'); ?></td> 
			<td ><?php echo number_format($Att1132, 0, '', '.'); ?></td> 
		</tr>
		
		</tr>
		    <td ><strong>Modulo 181</strong></td> 
			<td ><?php echo number_format($r181CC - $Ar181CC, 0, '', '.'); ?></td> 
			<td ><?php echo number_format($r181DC - $Ar181DC, 0, '', '.'); ?></td> 
			<td ><?php echo number_format($r181SC, 0, '', '.'); ?></td> 
			<td  style="border-right: 1px solid #3F9DD0; background-color:#D9E3E8;"><?php echo number_format($tt181, 0, '', '.'); ?></td> 
			<td ><?php echo number_format($Att181, 0, '', '.'); ?></td>
		</tr>
		
		</tr>
		    <td ><strong>Modulo 184</strong></td> 
			<td ><?php echo number_format($r184CC - $Ar184CC, 0, '', '.'); ?></td> 
			<td ><?php echo number_format($r184DC - $Ar184DC, 0, '', '.'); ?></td> 
			<td ><?php echo number_format($r184SC, 0, '', '.'); ?></td> 
			<td style="border-right: 1px solid #3F9DD0; background-color:#D9E3E8;" ><?php echo number_format($tt184, 0, '', '.'); ?></td> 
			<td ><?php echo number_format($Att184, 0, '', '.'); ?></td> 
		</tr>
		</tr>
		    <td ><strong>Modulo 2002</strong></td> 
			<td ><?php echo number_format($r2002CC - $Ar2002CC, 0, '', '.'); ?></td> 
			<td ><?php echo number_format($r2002DC - $Ar2002DC, 0, '', '.'); ?></td> 
			<td ><?php echo number_format($r2002SC, 0, '', '.'); ?></td> 
			<td style="border-right: 1px solid #3F9DD0; background-color:#D9E3E8;" ><?php echo number_format($tt2002, 0, '', '.'); ?></td> 
			<td ><?php echo number_format($Att2002, 0, '', '.'); ?></td>
		</tr>
		</tr>
		    <td ><strong>Modulo 6115</strong></td> 
			<td ><?php echo number_format($r6115CC - $Ar6115CC, 0, '', '.'); ?></td> 
			<td ><?php echo number_format($r6115DC - $Ar6115DC, 0, '', '.'); ?></td> 
			<td ><?php echo number_format($r6115SC, 0, '', '.'); ?></td> 
			<td style="border-right: 1px solid #3F9DD0; background-color:#D9E3E8;" ><?php echo number_format($tt6115, 0, '', '.'); ?></td> 
			<td ><?php echo number_format($Att6115, 0, '', '.'); ?></td> 
		</tr>
		</tr>
		    <td ><strong>Modulo 6130</strong></td> 
			<td ><?php echo number_format($r6130CC - $Ar6130CC, 0, '', '.'); ?></td> 
			<td ><?php echo number_format($r6130DC - $Ar6130DC, 0, '', '.'); ?></td> 
			<td ><?php echo number_format($r6130SC, 0, '', '.'); ?></td> 
			<td style="border-right: 1px solid #3F9DD0; background-color:#D9E3E8;" ><?php echo number_format($tt6130, 0, '', '.'); ?></td> 
			<td ><?php echo number_format($Att6130, 0, '', '.'); ?></td> 
		</tr>
		</tr>
		    <td ><strong>Modulo 2077</strong></td> 
			<td ><?php echo number_format($r2077CC - $Ar2077CC, 0, '', '.'); ?></td> 
			<td ><?php echo number_format($r2077DC - $Ar2077DC, 0, '', '.'); ?></td> 
			<td ><?php echo number_format($r2077SC, 0, '', '.'); ?></td> 
			<td style="border-right: 1px solid #3F9DD0; background-color:#D9E3E8;" ><?php echo number_format($tt2077, 0, '', '.'); ?></td> 
			<td ><?php echo number_format($Att2077, 0, '', '.'); ?></td>
		</tr>
		
		</tbody>
		<tfoot>
			<tr style=" border-top:2px double #B5B5B5;">
				<td ><strong>Totales</strong></td> 
				<td ><?php echo number_format($totaltcreditos - $Atotaltcreditos, 0, '', '.'); ?></td> 
				<td ><?php echo number_format($totaltdebitos - $Atotaltdebitos, 0, '', '.'); ?></td> 
				<td ><?php echo number_format($totalctienda, 0, '', '.'); ?></td> 
				<td style="border-right: 1px solid #3F9DD0; background-color:#D9E3E8;" ><?php echo number_format(($totaltcreditos - $Atotaltcreditos)+($totaltdebitos - $Atotaltdebitos)+$totalctienda, 0, '', '.'); ?></td> 
				<td ><?php echo number_format($Atotaltcreditos + Atotaltdebitos, 0, '', '.'); ?></td>
			</tr>
		</tfoot>
	</table>



	<?php odbc_close( $conn );?>