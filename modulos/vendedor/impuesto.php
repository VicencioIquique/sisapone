<?php 
require_once("clases/conexionocdb.php");
require_once("clases/funciones.php");

ini_set('max_execution_time', 300); //300 seconds = 5 minutes

$periodo = $_GET['periodo'];
$dia = $_GET['dia'];
$empresa = $_GET['empresa'];

if(!$periodo)
{
	$periodo =  date('Y-m', strtotime('-1 month'));
}

if($empresa)
{
	$wEmpresa = " AND Empresa LIKE '".$empresa."' ";
}


/************************************************************ PARA LOS VENDEDORES **************************************/


$sql="SELECT 
       [Periodo]
      ,Empresa
	  ,[WhsCode]
      ,CASE [Emp_Relacionada]
	    WHEN 'Y' THEN 'Relacionada'
		ELSE 'No Relacionada'
	   END                 [Emp_Relacionada]	  
      ,SUM([Quantity])     [Quantity]
      ,SUM([Total_CLP])    [Total_CLP]
      ,SUM([Total_USD])    [Total_USD]
      ,SUM([CtoVtaCIF])    [CtoVtaCIF]
      --,SUM( CONVERT(int,Sentido))    [CantoBoletas]
	  ,(SELECT     SUM(TABLA.CIF_CLP)  [CIF_CLP]
			FROM
			(
			SELECT
				  [WhsCode]
				  ,DAY([DocDate])  [DIA]
				  ,SUM([TotalCIF]) [TotalCIF]
				  ,AVG([TipoCambio]) [TipoCambio]
				  ,(SUM([TotalCIF])*AVG([TipoCambio])) [CIF_CLP]
				  ,((SUM([TotalCIF])*0.005)*AVG([TipoCambio])) [RetencionDL]
			  FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_VW_VtasD_RPRO] AS Z
			  WHERE Z.Periodo = '".$periodo."'
			        AND A.Periodo = Z.Periodo AND Z.WhsCode = A.WhsCode
			  GROUP BY WhsCode
				   ,DAY([DocDate])
			 --ORDER BY WhsCode,DAY([DocDate])
			) AS TABLA
                          ) AS RetencionDLCLP
      ,(SELECT SUM(Z.RetencionDL)
          FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_CR_VTAS_IMP_DL] AS Z
         WHERE Z.Periodo = '".$periodo."' AND A.Periodo = Z.Periodo AND Z.WhsCode = A.WhsCode) AS RetencionDL
      ,(SELECT SUM(Z.CantBoletas)
          FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_CR_VTAS_IMP_DL] AS Z
         WHERE Z.Periodo = '".$periodo."'  AND A.Periodo = Z.Periodo AND Z.WhsCode = A.WhsCode) AS BoletasCant
      ,((SUM([CtoVtaCIF])*661.49)*0.52)/100  [CIFxUSD]
      --,[Emp_Relacionada]

  FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_VW_Ventas_Todas] AS A
 WHERE Periodo = '".$periodo."'
       ".$wEmpresa."
 GROUP BY 
        Periodo
       ,Empresa
       ,[Emp_Relacionada]
       ,WhsCode
  ORDER BY
        Empresa
       ,WhsCode
       ,Emp_Relacionada
  ";

  //echo $sql;

		
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
	
	
	

 });//fin funciotn principal

</script>

<script language="javascript"> 
$(document).ready(function() { 
     $(".botonExcel1").click(function(event) { 
		 $("#datos_a_enviar").val( $("<div>").append( $(".t1").eq(0).clone()).html()); 
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
							 
							 <input name="opc" type="hidden" id="opc" size="40" class="required" value="impuesto" />
							
							<?php
							 	
					        
								echo'<label >
										Periodo:
										<input type="text" id="periodo" name="periodo" class="periodo" size="5" value="'.$periodo.'"  />
						         </label>';
						        
								
								echo '<label class="first" for="title1">
									Empresa
									<select id="empresa" name="empresa"    class="styled" >
									<option ></option>';
									
									echo'
									<option value="EXB_ZOFRI">Eximben</option>
									<option value="SVX_ZOFRI">Servimex</option>
									<option value="EXB_AEROP">Aeropuerto</option>
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
    <li ><a id="tabdua" href="#tab1" class="selected">Ventas</a></li> 
	 
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
						<th style="font-size:14px;" >Ventas Periodo <?php echo $periodo;?></th>
                        <th></th>
						<th></th>
                        <th></th>
                    </tr>
               </thead>
              <thead>
                    <tr>
                        <th>#</th>
                        <th>PERIODO</th>
						<th>EMPRESA</th>
						<th>BODEGA</th>
                        <th>EMPRESA RELACIONADA</th>
                        <th>CANT</th>
						<th>TOTAL CLP</th>
						<th>TOTAL USD</th>
						<th>TOTAL VTA CIF</th>
						<th>TOTAL VTA CIF EN CLP</th>
						<th>RETENCION DL</th>
						<th>CANT DOCUMENTOS</th>
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
									
									echo'<td ><strong>'.$resultado["Periodo"].'</strong></td>
									<td ><strong>'.$resultado["Empresa"].'</strong></td>
									<td ><strong>'.$resultado["WhsCode"].'</strong></td>
									<td ><strong>'.$resultado["Emp_Relacionada"].'</strong></td>
									<td ><strong>'.number_format($resultado["Quantity"], 0, ',', '.').'</strong></td>
									<td ><strong>'.number_format($resultado["Total_CLP"], 0, ',', '.').'</strong></td>
									<td ><strong>'.number_format($resultado["Total_USD"], 2, ',', '.').'</strong></td>
									<td ><strong>'.number_format($resultado["CtoVtaCIF"], 2, ',', '.').'</strong></td>									
									<td ><strong>'.number_format($resultado["RetencionDLCLP"], 0, ',', '.').'</strong></td>
									<td ><strong>'.number_format($resultado["RetencionDL"], 2, ',', '.').'</strong></td>
									<td ><strong>'.number_format($resultado["BoletasCant"], 0, ',', '.').'</strong></td>' ;
									
									$totalCant = $totalCant + $resultado["Quantity"];
									$totalCLP = $totalCLP + $resultado["Total_CLP"];
									$totalUSD = $totalUSD + $resultado["Total_USD"];
									$totalVtaCIF = $totalVtaCIF + $resultado["CtoVtaCIF"];
									$totalVtaCIFCLP = $totalVtaCIFCLP + $resultado["RetencionDLCLP"];
									$totalReten = $totalReten + $resultado["RetencionDL"];
									$totalBolCant = $totalBolCant + $resultado["BoletasCant"];
									
									
									
							}
							
				?>
                </tbody>
                <tfoot>
                	<tr  style=" border-top:2px double #B5B5B5;">
                    	<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
                        <td><strong><?php echo number_format($totalCant, 0, ',', '.') ?></strong></td>
                        <td><strong><?php echo number_format($totalCLP, 0, ',', '.') ?></strong></td>
                        <td><strong><?php echo number_format($totalUSD, 0, ',', '.') ?></strong></td>
						<td><strong><?php echo number_format($totalVtaCIF, 2, ',', '.') ?></strong></td>
						<td><strong><?php echo number_format($totalVtaCIFCLP, 0, ',', '.') ?></strong></td>
						<td><strong><?php echo number_format($totalReten, 2, ',', '.') ?></strong></td>
						<td><strong><?php echo number_format($totalBolCant, 0, ',', '.') ?></strong></td>                  
                    </tr>
                </tfoot>
            </table>
</div> <!-- fin de TAB 1 -->

  
  
  
<script type="text/javascript"> 
  $("#usual1 ul").idTabs(); 
</script>
           
			
            


<?php odbc_close( $conn );?>