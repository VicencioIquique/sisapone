<?php 
require_once("clases/conexionocdb.php");
require_once("clases/funciones.php");

ini_set('max_execution_time', 600); //300 seconds = 5 minutes

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


$sql="
      SELECT  
       [Empresa]
	  ,[TipoProducto]
	  ,[CardCode]
	  ,[CardName]
	  ,[Emp_Relacionada]
      ,SUM([Quantity])            [Quantity]
      ,SUM([Total_CLP])           [Total_CLP]
      ,SUM([Total_USD])           [Total_USD]
      ,SUM([CtoVtaCIF])           [CtoVtaCIF]
     
  FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_VW_VtasD_CIF]
  WHERE 1=1
    AND Periodo = '".$periodo."'
    AND TipoVenta = 'Mayorista'
	AND TipoProducto = 'Producto Regular'
	AND Empresa = 'EXB_ZOFRI'
	AND CardCode in('C96526630','C96526630-5')
  GROUP BY
        Empresa
	   ,TipoProducto
	   ,CardCode
	   ,CardName
	   ,Emp_Relacionada

  ";
  
  $sqlSRFSinValor="
      SELECT  
       [Empresa]
	  ,[TipoProducto]
	  ,SUM([Quantity])            [Quantity]
      ,SUM([Total_CLP])           [Total_CLP]
      ,SUM([Total_USD])           [Total_USD]
      ,SUM([CtoVtaCIF])           [CtoVtaCIF]
     
  FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_VW_VtasD_CIF]
  WHERE 1=1
    AND Periodo = '".$periodo."'
    AND TipoVenta = 'Mayorista'
	AND TipoProducto <> 'Producto Regular'
  GROUP BY
        Empresa
	   ,TipoProducto

  ";
  
  
$sqlTraspasos="
      SELECT  
       [Empresa]
	  ,[TipoProducto]
	  ,[CardCode]
	  ,[CardName]
	  ,[Emp_Relacionada]
      ,SUM([Quantity])            [Quantity]
      ,SUM([Total_CLP])           [Total_CLP]
      ,SUM([Total_USD])           [Total_USD]
      ,SUM([CtoVtaCIF])           [CtoVtaCIF]
     
  FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_VW_VtasD_CIF]
  WHERE 1=1
    AND Periodo = '".$periodo."'
    AND TipoVenta = 'Mayorista'
	AND TipoProducto = 'Producto Regular'
	AND Emp_Relacionada = 'Y'
	AND CardName NOT in('IMP.EXIMBEN S.AC. LOC. 2-3 INT.2DO.PISO','IMP.EXIMBEN S.A.C. LOC. 8 INT.2DO.PISO  12278')
  GROUP BY
        Empresa
	   ,TipoProducto
	   ,CardCode
	   ,CardName
	   ,Emp_Relacionada

  ";


  

		
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
		
			echo'<form action="/sisap/clases/ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion"> 
			<center><img src="images/excel.png" width="30px" height="30px" class="botonExcel"  /> </center>
			<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" /> 
			</form> ';
		}?>
	   </ul>
       <div class="items">
        <div id="one"> <form action="" method="GET" id="horizontalForm">
            <fieldset>
				<legend>Ingresar Fechas</legend>
							 
							 <input name="opc" type="hidden" id="opc" size="40" class="required" value="impuestoMay" />
							
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
                        <th><form action="/sisap/clases/ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion"> 
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
                        <th colspan="10">Documentos SRF</th>
                       
                    </tr>
			   </thead>
              <thead>
			        <tr>
                        <th>#</th>
                        <th>EMPRESA ORIGEN</th>
						<th>TIPO PRODUCTO</th>
						<th>CARDCORE</th>
						<th>DESTINO</th>
                        <th>EMPRESA RELACIONADA</th>
                        <th>CANT</th>
						<th>TOTAL CLP</th>
						<th>TOTAL USD</th>
						<th>TOTAL VTA CIF</th>
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
									
									echo'<td ><strong>'.$resultado["Empresa"].'</strong></td>
									<td ><strong>'.$resultado["TipoProducto"].'</strong></td>
									<td ><strong>'.$resultado["CardCode"].'</strong></td>
									<td ><strong>'.$resultado["CardName"].'</strong></td>
									<td ><strong>'.$resultado["Emp_Relacionada"].'</strong></td>
									<td ><strong>'.number_format($resultado["Quantity"], 0, ',', '.').'</strong></td>
									<td ><strong>'.number_format($resultado["Total_CLP"], 0, ',', '.').'</strong></td>
									<td ><strong>'.number_format($resultado["Total_USD"], 2, ',', '.').'</strong></td>
									<td ><strong>'.number_format($resultado["CtoVtaCIF"], 2, ',', '.').'</strong></td>' ;
									
									$totalCant = $totalCant + $resultado["Quantity"];
									$totalCLP = $totalCLP + $resultado["Total_CLP"];
									$totalUSD = $totalUSD + $resultado["Total_USD"];
									$totalVtaCIF = $totalVtaCIF + $resultado["CtoVtaCIF"];
									
									
									
							}
							
				?>
                </tbody>
                <tbody>
                	<tr  style=" border-top:2px double #B5B5B5;">
                    	<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
                        <td><strong><?php echo number_format($totalCant, 0, ',', '.') ?></strong></td>
                        <td><strong><?php echo number_format($totalCLP, 0, ',', '.') ?></strong></td>
                        <td><strong><?php echo number_format($totalUSD, 0, ',', '.') ?></strong></td>
						<td><strong><?php echo number_format($totalVtaCIF, 2, ',', '.') ?></strong></td>                
                    </tr>
                </tbody>
				
				<!-- SRF Sin Valor -->
				 <thead>
					<tr>
                        <th colspan="10">Documentos SRF SIN VALOR COMERCIAL</th>
                       
                    </tr>
			   </thead>
              <thead>
			        <tr>
                        <th>#</th>
                        <th>EMPRESA ORIGEN</th>
						<th>TIPO PRODUCTO</th>
						<th></th>
						<th></th>
                        <th></th>
                        <th>CANT</th>
						<th>TOTAL CLP</th>
						<th>TOTAL USD</th>
						<th>TOTAL VTA CIF</th>
                    </tr>
               </thead>
                <tbody>
                 <?php
				 
			
							
							//echo $sql;	
							$rs2 = odbc_exec( $conn, $sqlSRFSinValor );
							if ( !$rs2 )
							{
							exit( "Error en la consulta SQL" );
							}
							
							  while($resultado2 = odbc_fetch_array($rs2)){ 
							 
							   echo '<tr>
									<td style="background-color:#6C6B6B;color:#fff;font-weight:bold; font-size:15px; width:22px; text-align:center;" >'.utf8_encode($resultado2["Dia"]).'</td>';
									
									echo'<td ><strong>'.$resultado2["Empresa"].'</strong></td>
									<td ><strong>'.$resultado2["TipoProducto"].'</strong></td>
									<td ><strong></strong></td>
									<td ><strong></strong></td>
									<td ><strong></strong></td>
									<td ><strong>'.number_format($resultado2["Quantity"], 0, ',', '.').'</strong></td>
									<td ><strong>'.number_format($resultado2["Total_CLP"], 0, ',', '.').'</strong></td>
									<td ><strong>'.number_format($resultado2["Total_USD"], 2, ',', '.').'</strong></td>
									<td ><strong>'.number_format($resultado2["CtoVtaCIF"], 2, ',', '.').'</strong></td>' ;
									
									$totalCant2 = $totalCant2 + $resultado2["Quantity"];
									$totalCLP2 = $totalCLP2 + $resultado2["Total_CLP"];
									$totalUSD2 = $totalUSD2 + $resultado2["Total_USD"];
									$totalVtaCIF2 = $totalVtaCIF2 + $resultado2["CtoVtaCIF"];
									
									
									
							}
							
				?>
                </tbody>
                <tbody>
                	<tr  style=" border-top:2px double #B5B5B5;">
                    	<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
                        <td><strong><?php echo number_format($totalCant2, 0, ',', '.') ?></strong></td>
                        <td><strong><?php echo number_format($totalCLP2, 0, ',', '.') ?></strong></td>
                        <td><strong><?php echo number_format($totalUSD2, 0, ',', '.') ?></strong></td>
						<td><strong><?php echo number_format($totalVtaCIF2, 2, ',', '.') ?></strong></td>                
                    </tr>
                </tbody>
				
				 
				<!-- TRASPASOS -->
				 <thead>
					<tr>
                        <th colspan="10">Documentos de TRASPASO</th>
                       
                    </tr>
			   </thead>
              <thead>
			        <tr>
                        <th>#</th>
                        <th>EMPRESA ORIGEN</th>
						<th>TIPO PRODUCTO</th>
						<th>CARDCORE</th>
						<th>DESTINO</th>
                        <th>EMPRESA RELACIONADA</th>
                        <th>CANT</th>
						<th>TOTAL CLP</th>
						<th>TOTAL USD</th>
						<th>TOTAL VTA CIF</th>
                    </tr>
               </thead>
                <tbody>
                 <?php
				 
			
							
							//echo $sql;	
							$rs3 = odbc_exec( $conn, $sqlTraspasos );
							if ( !$rs3 )
							{
							exit( "Error en la consulta SQL" );
							}
							
							  while($resultado3 = odbc_fetch_array($rs3)){ 
							 
							   echo '<tr>
									<td style="background-color:#6C6B6B;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" >'.utf8_encode($resultado3["Dia"]).'</td>';
									
									echo'<td ><strong>'.$resultado3["Empresa"].'</strong></td>
									<td ><strong>'.$resultado3["TipoProducto"].'</strong></td>
									<td ><strong>'.$resultado3["CardCode"].'</strong></td>
									<td ><strong>'.$resultado3["CardName"].'</strong></td>
									<td ><strong>'.$resultado3["Emp_Relacionada"].'</strong></td>
									<td ><strong>'.number_format($resultado3["Quantity"], 0, ',', '.').'</strong></td>
									<td ><strong>'.number_format($resultado3["Total_CLP"], 0, ',', '.').'</strong></td>
									<td ><strong>'.number_format($resultado3["Total_USD"], 2, ',', '.').'</strong></td>
									<td ><strong>'.number_format($resultado3["CtoVtaCIF"], 2, ',', '.').'</strong></td>' ;
									
									$totalCant3 = $totalCant3 + $resultado3["Quantity"];
									$totalCLP3 = $totalCLP3 + $resultado3["Total_CLP"];
									$totalUSD3 = $totalUSD3 + $resultado3["Total_USD"];
									$totalVtaCIF3 = $totalVtaCIF3 + $resultado3["CtoVtaCIF"];
									
									
									
							}
							
				?>
                </tbody>
                <tbody>
                	<tr  style=" border-top:2px double #B5B5B5;">
                    	<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
                        <td><strong><?php echo number_format($totalCant3, 0, ',', '.') ?></strong></td>
                        <td><strong><?php echo number_format($totalCLP3, 0, ',', '.') ?></strong></td>
                        <td><strong><?php echo number_format($totalUSD3, 0, ',', '.') ?></strong></td>
						<td><strong><?php echo number_format($totalVtaCIF3, 2, ',', '.') ?></strong></td>                
                    </tr>
                </tbody>
				
            </table>
</div> <!-- fin de TAB 1 -->

  
  
  
<script type="text/javascript"> 
  $("#usual1 ul").idTabs(); 
</script>
           
			
            


<?php odbc_close( $conn );?>