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


			if ($tipoProducto)
					{
						$WtipoProducto = "  AND (TipoProducto LIKE '".$tipoProducto."') ";
						
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
     $("#datos_a_enviar").val( $("<div>").append( $("#ssptable2").eq(0).clone()).html()); 
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
				<legend>Ingresar Fechas </legend>
						
						
                            
							  <input name="opc" type="hidden" id="opc" size="40" class="required" value="ventasmodulodet" />
							
							
                             <label for="fecha1">
					            Inicio
                            <input name="inicio" type="text" id="inicio" size="40" class="required" value="<?php echo $finicio;?>"  />
                            </label>
							 <label for="fecha2">
					            Fin
                            <input name="fin" type="text" id="fin" size="40" class="required"  value="<?php echo $ffin;?>" />
                            </label>
                            
                            <?php
							 	
									
									echo '<label class="first" for="title1">
									Tipo de Producto
									<select id="tipoProducto" name="tipoProducto"    class="styled" >';
									if($tipoProducto)
									{
										echo'<option value="'.$tipoProducto.'" selected>'.$tipoProducto.'</option>';
									}									
																		
									echo'
									<option></option>
									<option value="Producto Regular">Producto Regular</option>
									</select>
				               </label>';?>
							
							
                             <input style="clear:initial;" name="agregar" type="submit" id="agregar" class="submit" value="Consultar" />

			</fieldset>
            </form>
         </div> <!-- fin div two-->
      </div> <!-- fin items -->
    </div> <!-- fin idTabs -->
        
        
					
            <table  id="ssptable2" class="lista">
			 <thead>
					<tr>
					    <th ></th>
						<th cols="5" >Desde</th>
						<th  ><?php echo $finicio;?></th>
						<th  >Hasta</th>
						<th  ><?php echo $ffin;?></th>
						<th  ></th>
						
						
						
						
                    </tr>
			  </head>
              <thead>
					
                    <tr>
						<th style="width:150px;">Locales</th>
						<th>Un.</th>
						<th> CLP</th> 
						<th>Media</th> 
						<th>USD</th> 
						<th>CIF</th> 
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
       [Empresa]
      ,[WhsCode]
      
  
      ,SUM([Cantidad]) [Cantidad]
      ,SUM([TotalCLP]) [TotalCLP]
      ,CASE
	  WHEN SUM([Cantidad]) = 0
	 	THEN SUM([TotalCLP])
	  	ELSE (SUM([TotalCLP])/SUM([Cantidad]))
  		END AS [Media] 
  ,SUM([TotalCIF]) [TotalCIF]
      ,SUM([TotalUSD]) [TotalUSD]
      ,SUM(RetencionDL)[RetencionDL]
  FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_VW_VtasD_RPRO_Slim]
  WHERE (DocDate >= '".$finicio2." 00:00:00.000') AND (DocDate <= '".$ffin2." 23:59:59.000')
       AND Empresa NOT LIKE 'EXB_AEROP'
	   AND WhsCode NOT IN ('ZFI.6115','ZFI.6130')
	     ".$WtipoProducto."
  GROUP BY [Empresa]
          ,[WhsCode]
  ORDER BY WhsCode
";




		
/************ SQLS Para 6115 6130 **************************/
$sql3="

SELECT
       [Empresa]
      ,[WhsCode]
      
  
      ,SUM([Cantidad]) [Cantidad]
      ,SUM([TotalCLP]) [TotalCLP]
      ,(SUM([TotalCLP])/SUM([Cantidad])) [Media]
      ,SUM([TotalCIF]) [TotalCIF]
      ,SUM([TotalUSD]) [TotalUSD]
      ,SUM(RetencionDL) [RetencionDL]
  FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_VW_VtasD_RPRO_Slim]
  WHERE (DocDate >= '".$finicio2." 00:00:00.000') AND (DocDate <= '".$ffin2." 23:59:59.000')
       AND Empresa NOT LIKE 'EXB_AEROP'
	   AND WhsCode  IN ('ZFI.6115','ZFI.6130')
	   	     ".$WtipoProducto."
  GROUP BY [Empresa]
          ,[WhsCode]
  ORDER BY WhsCode
";




	
/************ SQLS Para AEROPUERTO **************************/
$sql5="

SELECT
       [Empresa]
      ,[WhsCode]
      
  
      ,SUM([Cantidad]) [Cantidad]
      ,SUM([TotalCLP]) [TotalCLP]
      ,(SUM([TotalCLP])/SUM([Cantidad])) [Media]
      ,SUM([TotalCIF]) [TotalCIF]
      ,SUM([TotalUSD]) [TotalUSD]
      
  FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_VW_VtasD_RPRO_Slim]
  WHERE (DocDate >= '".$finicio2." 00:00:00.000') AND (DocDate <= '".$ffin2." 23:59:59.000')
       AND Empresa  LIKE 'EXB_AEROP'
	   --AND WhsCode  IN ('ZFI.6115','ZFI.6130')
	   	     ".$WtipoProducto."
  GROUP BY [Empresa]
          ,[WhsCode]
  ORDER BY WhsCode
";


echo $sql;

	

		
//echo $sql3;
//echo $sql5;
                        $rs = odbc_exec( $conn, $sql );
							if ( !$rs)
							{
							    exit( "Error en la consulta SQL" );
							}
					     
				/* MODULPS 6115 6130 */
                $rs3 = odbc_exec( $conn, $sql3 );
							if ( !$rs3)
							{
							    exit( "Error en la consulta SQL" );
							}
					    
				
				/* MODULPS AEROPUERTO */
                $rs5 = odbc_exec( $conn, $sql5 );
							if ( !$rs5)
							{
							    exit( "Error en la consulta SQL" );
							}
						
										
							
				if($consultar)
							{
                            while(($resultado = odbc_fetch_array($rs)) )
							 { 
							    					  
								
								  echo '<tr>
										<td  >'.utf8_encode(str_replace("ZFI.","LOCAL ",$resultado["WhsCode"])).'</td> 									
										<td >'.number_format($resultado["Cantidad"], 0, '', '.').'</td> 
										<td ><strong>'.number_format($resultado["TotalCLP"], 0, '', '.').'</strong></td>
										<td ><strong>'.number_format($resultado["Media"], 0, '', '.').'</strong></td>
										<td >'.number_format($resultado["TotalUSD"], 2, ',', '.').'</td> 
										<td style=" border-right:2px double #B5B5B5;" >'.number_format($resultado["TotalCIF"], 2, ',', '.').'</td>'; 
										//<td style=" border-right:2px double #B5B5B5;" >'.number_format($resultado["RetencionDL"], 2, ',', '.').'</td> 
										echo'</tr>' ;
										
										
										$TotalUnidadesHoy = $TotalUnidadesHoy + $resultado["Cantidad"];
										$TotalCLPHoy = $TotalCLPHoy + $resultado["TotalCLP"];
										$TotalUSDHoy = $TotalUSDHoy + $resultado["TotalUSD"];
										$TotalCIFHoy = $TotalCIFHoy + $resultado["TotalCIF"];
										
										
											
							} 
				?>
				
                </tbody>
                <tbody>		
					<tr style=" border-top:2px double #B5B5B5;">
						<td><strong>TOTALES</strong></td>
						
						
						<td><strong><?php echo number_format($TotalUnidadesHoy, 0, '', '.'); ?></strong></td>
						<td><strong><?php echo number_format($TotalCLPHoy, 0, '', '.'); ?></strong></td>
						<td><strong><?php
						if($TotalUnidadesHoy ==0)
						echo number_format(0, 0, ',', '.');
						else
						echo number_format($TotalCLPHoy/$TotalUnidadesHoy, 0, ',', '.'); ?></strong></td>
						<td><strong><?php echo number_format($TotalUSDHoy, 2, ',', '.'); ?></strong></td>
						<td><strong><?php echo number_format($TotalCIFHoy, 2, ',', '.'); ?></strong></td>
						
						
					
					</tr>
                </tbody>
				<tr>
				<td></td>
				
				
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				
				<td></td>
				
				</tr>
				<tbody>
				
				<?php
				/* PARA LOS MODULOS 6115 6130*/
				if($consultar)
							{
                            while(($resultado3 = odbc_fetch_array($rs3)))
							 { 
							    					  
								
								  echo '<tr>
																			
										
										
										<td  >'.utf8_encode(str_replace("ZFI.","LOCAL ",$resultado3["WhsCode"])).'</td> 
										<td >'.number_format($resultado3["Cantidad"], 0, '', '.').'</td> 
										<td ><strong>'.number_format($resultado3["TotalCLP"], 0, '', '.').'</strong></td>
										<td ><strong>'.number_format($resultado3["Media"], 0, '', '.').'</strong></td>
										<td >'.number_format($resultado3["TotalUSD"], 2, ',', '.').'</td> 
										<td style=" border-right:2px double #B5B5B5;" >'.number_format($resultado3["TotalCIF"], 2, ',', '.').'</td> 
										<!--<td>RETENCION</td>-->
										
										
										</tr>' ;
										
									
										
										$TotalUnidadesHoy2 = $TotalUnidadesHoy2 + $resultado3["Cantidad"];
										$TotalCLPHoy2 = $TotalCLPHoy2 + $resultado3["TotalCLP"];
										$TotalUSDHoy2 = $TotalUSDHoy2 + $resultado3["TotalUSD"];
										$TotalCIFHoy2 = $TotalCIFHoy2 + $resultado3["TotalCIF"];
										
										
											
							} 
				?>
				
				</tbody>	
                 <tbody>		
					<tr style=" border-top:2px double #B5B5B5;">
						<td><strong>TOTALES</strong></td>
						
						<td><strong><?php echo number_format($TotalUnidadesHoy2, 0, '', '.'); ?></strong></td>
						<td><strong><?php echo number_format($TotalCLPHoy2, 0, '', '.'); ?></strong></td>
						<td><strong><?php
                        if($TotalUnidadesHoy2 ==0)
						echo number_format(0, 0, ',', '.');
						else
						echo number_format($TotalCLPHoy2/$TotalUnidadesHoy2, 0, ',', '.'); ?></strong></td>
						<td><strong><?php echo number_format($TotalUSDHoy2, 2, ',', '.'); ?></strong></td>
						<td><strong><?php echo number_format($TotalCIFHoy2, 2, ',', '.'); ?></strong></td>
						
					
					</tr>
                </tbody>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					
					<td></td>
					
				</tr>
				<tr>
					<td>AEROPUERTO (venta neta)</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					
					<td></td>
					
				</tr>
				<tbody>	

<?php
				/* PARA LOS MODULOS DE AEROPUERTO*/
				if($consultar)
							{
                            while(($resultado3 = odbc_fetch_array($rs5)))
							 { 
							    					  
								
								  echo '<tr>
																			
										
										
										<td  >'.utf8_encode(str_replace("LOCAL.","LOCAL ",$resultado3["WhsCode"])).'</td> 
										<td >'.number_format($resultado3["Cantidad"], 0, '', '.').'</td> 
										<td ><strong>'.number_format($resultado3["TotalCLP"], 0, '', '.').'</strong></td>
										<td ><strong>'.number_format($resultado3["Media"], 0, '', '.').'</strong></td>
										<td >'.number_format($resultado3["TotalUSD"], 2, ',', '.').'</td> 
										<td style=" border-right:2px double #B5B5B5;" >'.number_format($resultado3["TotalCIF"], 2, ',', '.').'</td> 
										<!--<td>RETENCION</td>-->
									
										</tr>' ;
										
									
										
										$TotalUnidadesHoy3 = $TotalUnidadesHoy3 + $resultado3["Cantidad"];
										$TotalCLPHoy3 = $TotalCLPHoy3 + $resultado3["TotalCLP"];
										$TotalUSDHoy3 = $TotalUSDHoy3 + $resultado3["TotalUSD"];
										$TotalCIFHoy3 = $TotalCIFHoy3 + $resultado3["TotalCIF"];
										
										
											
							} 
				?>
				
				</tbody>	
                 <tbody>		
					<tr style=" border-top:2px double #B5B5B5;">
						<td><strong>TOTALES</strong></td>
						
						
						<td><strong><?php echo number_format($TotalUnidadesHoy3, 0, '', '.'); ?></strong></td>
						<td><strong><?php echo number_format($TotalCLPHoy3, 0, '', '.'); ?></strong></td>
						<td><strong><?php 
						if($TotalUnidadesHoy3 ==0)
						echo number_format(0, 0, ',', '.');
						else
						echo number_format($TotalCLPHoy3/$TotalUnidadesHoy3, 0, ',', '.'); ?></strong></td>
						<td><strong><?php echo number_format($TotalUSDHoy3, 2, ',', '.'); ?></strong></td>
						<td><strong><?php echo number_format($TotalCIFHoy3, 2, ',', '.'); ?></strong></td>
						
					
					</tr>
                </tbody>
				<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				
				<td></td>
				
				</tr>
				<tr>
					<td>VENTA MAYORISTA</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					
					<td></td>
					
				</tr>
				<tbody>	


<?php
/************ SQLS Para AEROPUERTO **************************/
$sql7="
SELECT 
       [TipoVenta]
      ,SUM([Quantity])                    [Cantidad]
      ,SUM([Total_CLP])                   [TotalCLP]
      ,(SUM([Total_CLP])/SUM([Quantity])) [Media]
      ,SUM([Total_USD])                   [TotalUSD]
      ,SUM([CtoVtaCIF])                   [TotalCIF]
      
  FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_VW_Vtas_Mayor_CIF]
  WHERE Emp_Relacionada = 'N'
  AND (DocDate >= '".$finicio2." 00:00:00.000') AND (DocDate <= '".$ffin2." 23:59:59.000')
  GROUP BY [TipoVenta]

";

$sql8="
SELECT 
       [TipoVenta]
      ,SUM([Quantity])                    [Cantidad]
      ,SUM([Total_CLP])                   [TotalCLP]
      ,(SUM([Total_CLP])/SUM([Quantity])) [Media]
      ,SUM([Total_USD])                   [TotalUSD]
      ,SUM([CtoVtaCIF])                   [TotalCIF]
      
  FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_VW_Vtas_Mayor_CIF]
  WHERE Emp_Relacionada = 'N'
  AND (DocDate >= '".date ( 'Y-m-j' ,strtotime ( '-1 year' , strtotime ( $finicio2 ) ))." 00:00:00.000') AND (DocDate <= '".date ( 'Y-m-j' ,strtotime ( '-1 year' , strtotime ( $ffin2 ) ))." 23:59:59.000')
  GROUP BY [TipoVenta]

";

//echo $sql7;
//echo $sql8;

/* MODULPS AEROPUERTO */
                $rs7 = odbc_exec( $conn, $sql7 );
							if ( !$rs7)
							{
							    exit( "Error en la consulta SQL" );
							}
			    $rs8 = odbc_exec( $conn, $sql8);
							if ( !$rs8)
							{
							   exit( "Error en la consulta SQL" );
							}	
				/* PARA LA VENTA MAYORISTA*/
				if($consultar)
							{
                            while(($resultado7 = odbc_fetch_array($rs7)) )
							 { 
							    					  
								
								  echo '<tr>
																			
										<td  >MAYORISTA</td> 									
										
										<td >'.number_format($resultado7["Cantidad"], 0, '', '.').'</td> 
										<td ><strong>'.number_format($resultado7["TotalCLP"], 0, '', '.').'</strong></td>
										<td ><strong>'.number_format($resultado7["Media"], 0, '', '.').'</strong></td>
										<td >'.number_format($resultado7["TotalUSD"], 2, ',', '.').'</td> 
										<td style=" border-right:2px double #B5B5B5;" >'.number_format($resultado7["TotalCIF"], 2, ',', '.').'</td> 
										<!--<td>RETENCION</td>-->
										</tr>' ;
										
			
										$TotalUnidadesHoy4 = $TotalUnidadesHoy4 + $resultado7["Cantidad"];
										$TotalCLPHoy4 = $TotalCLPHoy4 + $resultado7["TotalCLP"];
										$TotalUSDHoy4 = $TotalUSDHoy4 + $resultado7["TotalUSD"];
										$TotalCIFHoy4 = $TotalCIFHoy4 + $resultado7["TotalCIF"];
										
										
											
							} 
				?>
				
				</tbody>	
                 <tbody>		
					<tr style=" border-top:2px double #B5B5B5;">
						<td><strong>TOTALES</strong></td>
						
						
						<td><strong><?php echo number_format($TotalUnidadesHoy4, 0, '', '.'); ?></strong></td>
						<td><strong><?php echo number_format($TotalCLPHoy4, 0, '', '.'); ?></strong></td>
						<td><strong><?php
						if($TotalUnidadesHoy4 ==0)
						echo number_format(0, 0, ',', '.');
						else
						echo number_format($TotalCLPHoy4/$TotalUnidadesHoy4, 0, ',', '.'); ?></strong></td>
						<td><strong><?php echo number_format($TotalUSDHoy4, 2, ',', '.'); ?></strong></td>
						<td><strong><?php echo number_format($TotalCIFHoy4, 2, ',', '.'); ?></strong></td>
						
					
					</tr>
                </tbody>
				<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				
				<td></td>
				
				</tr>
				<tbody>					
            </table>
			<?php } }} }?>
			
			

		
            


	<?php odbc_close( $conn );?>