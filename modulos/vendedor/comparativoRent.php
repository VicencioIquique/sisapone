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
$marca = $_GET['marca'];
$segmento = $_GET['segmento'];

if(!$finicio)
{
	 $finicio = date("m/01/Y");
	 $ffin= date("m/d/Y");
}

if($marca){
	$marcaSQL = "  AND Marca = '".$marca."'";
	$marcaGroup = " ,Marca";
}
if($segmento){
	$segmentoSQL = " AND Segmento = '".$segmento."'";
	$segmentoGroup = " ,Segmento";
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
				<legend>Ingresar Fechas</legend>
						
						
                            
							  <input name="opc" type="hidden" id="opc" size="40" class="required" value="comparativoRent" />
							
							
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
							   
							    <?php
									$sql = "SELECT DISTINCT Marca FROM SBO_Imp_Eximben_SAC.dbo.VIC_VW_ItemsVenta
											ORDER BY Marca ASC";
									$rs = odbc_exec( $conn, $sql );
									if ( !$rs ){
										exit( "Error en la consulta SQL" );
									}
									
									echo '<label class="first" for="title1">
									Marca
									<select id="marca" name="marca"  class="styled" width="20">';
									while($resultado = odbc_fetch_array($rs))
									{
										echo'<option value="'.$resultado['Marca'].'">'.$resultado['Marca'].'</option>';
									}									
																		
									echo'
									</select>
				               </label>';?>
							
								  <?php
									$sql = "SELECT DISTINCT Segmento FROM SBO_Imp_Eximben_SAC.dbo.VIC_VW_ItemsVenta
											ORDER BY Segmento ASC";
									$rs = odbc_exec( $conn, $sql );
									if ( !$rs ){
										exit( "Error en la consulta SQL" );
									}
									
									echo '<label class="first" for="title1">
									
									Segmento
									<select id="segmento" name="segmento"    class="styled" >
									<option value=""></option>';
									while($resultado = odbc_fetch_array($rs))
									{
										echo'<option value="'.$resultado['Segmento'].'">'.$resultado['Segmento'].'</option>';
									}									
																		
									echo'
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
					<th>Marca: </th>
					<th><?php if($marca) echo $marca; else echo 'TODAS LAS MARCAS'?> </th>
				</tr>
			  </head>
			 <thead>
					<tr>
					    <th  ></th>
						<th cols="5" >2017</th>
						<th  ></th>
						<th  ></th>
						<th  ></th>
						<th  ></th>
						<th  ></th>
						
						<th cols="4" >2018</th>
						<th  ></th>
						<th  ></th>
						<th  ></th>
						<th  ></th>
						<th  ></th>
						
						<th cols="4" >Porcentajes</th>
						<th  ></th>
						<th	 ></th>
						<th	 ></th>
						
						
                    </tr>
			  </head>
              <thead>
					
                    <tr>
						<th style="width:150px;">Locales</th>
						<th>Un.</th>
						<th>CLP</th> 
						<th>Media</th> 
						<th>USD</th> 
						<th>CIF</th> 
						<th style="color:#008000">Rent</th>
						
						<th>Un.</th>
						<th>CLP</th> 
						<th>Media</th> 
						<th>USD</th> 
						<th>CIF</th> 
						<th style="color:#008000">Rent</th>
						
						<th>% Un.</th>
						<th>% CLP</th> 
						<th>% USD</th> 
						<th>% CIF</th> 
						
						
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
      ,SUM([TotalCLP]) / NULLIF(SUM([Cantidad]),0) [Media]
      ,SUM([TotalCIF]) [TotalCIF]
      ,SUM([TotalUSD]) [TotalUSD]
      ,(((SUM([TotalUSD]) - SUM([TotalCIF]))*100) /SUM([TotalUSD])) [Rentabilidad]
  FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_VW_VtasD_RPRO]
  WHERE (DocDate >= '".$finicio2." 00:00:00.000') AND (DocDate <= '".$ffin2." 23:59:59.000')
       AND Empresa NOT LIKE 'EXB_AEROP'
	   AND WhsCode NOT IN ('ZFI.6115','ZFI.6130')
	     ".$WtipoProducto."
		 ".$marcaSQL."
		 ".$segmentoSQL."
		 GROUP BY [Empresa]
          ,[WhsCode]
		  ".$marcaGroup."
		  ".$segmentoGroup."
  ORDER BY WhsCode
";



$sql2="

SELECT
       [Empresa]
      ,[WhsCode]
  
      ,SUM([Cantidad]) [Cantidad]
      ,SUM([TotalCLP]) [TotalCLP]
	  ,SUM([TotalCLP]) / NULLIF(SUM([Cantidad]),0) [Media]
      ,SUM([TotalCIF]) [TotalCIF]
      ,SUM([TotalUSD]) [TotalUSD]
      ,(((SUM([TotalUSD]) - SUM([TotalCIF]))*100) /SUM([TotalUSD])) [Rentabilidad]
	  
  FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_VW_VtasD_RPRO]
  WHERE (DocDate >= '".date ( 'Y-m-j' ,strtotime ( '-1 year' , strtotime ( $finicio2 ) ))." 00:00:00.000') AND (DocDate <= '".date ( 'Y-m-j' ,strtotime ( '-1 year' , strtotime ( $ffin2 ) ))." 23:59:59.000')
    AND Empresa NOT LIKE 'EXB_AEROP'
	AND WhsCode NOT IN ('ZFI.6115','ZFI.6130')
		      ".$WtipoProducto." 
			  ".$marcaSQL."
			  ".$segmentoSQL."
  GROUP BY [Empresa]
          ,[WhsCode]
		   ".$marcaGroup."
		   ".$segmentoGroup."
  ORDER BY WhsCode
";
		
/************ SQLS Para 6115 6130 **************************/
$sql3="

SELECT
       [Empresa]
      ,[WhsCode]
  
      ,SUM([Cantidad]) [Cantidad]
      ,SUM([TotalCLP]) [TotalCLP]
	  ,SUM([TotalCLP]) / NULLIF(SUM([Cantidad]),0) [Media]
      ,SUM([TotalCIF]) [TotalCIF]
      ,SUM([TotalUSD]) [TotalUSD]
      ,(((SUM([TotalUSD]) - SUM([TotalCIF]))*100) /SUM([TotalUSD])) [Rentabilidad]
	  
  FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_VW_VtasD_RPRO]
  WHERE (DocDate >= '".$finicio2." 00:00:00.000') AND (DocDate <= '".$ffin2." 23:59:59.000')
       AND Empresa NOT LIKE 'EXB_AEROP'
	   AND WhsCode  IN ('ZFI.6115','ZFI.6130')
	   	     ".$WtipoProducto." 
			 ".$marcaSQL."
			 ".$segmentoSQL."
  GROUP BY [Empresa]
          ,[WhsCode]
		   ".$marcaGroup."
		   ".$segmentoGroup."
  ORDER BY WhsCode
";



$sql4="

SELECT
       [Empresa]
      ,[WhsCode]
  
      ,SUM([Cantidad]) [Cantidad]
      ,SUM([TotalCLP]) [TotalCLP]
	  ,SUM([TotalCLP]) / NULLIF(SUM([Cantidad]),0) [Media]
      ,SUM([TotalCIF]) [TotalCIF]
      ,SUM([TotalUSD]) [TotalUSD]
      ,(((SUM([TotalUSD]) - SUM([TotalCIF]))*100) /SUM([TotalUSD])) [Rentabilidad]
	  
  FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_VW_VtasD_RPRO]
  WHERE (DocDate >= '".date ( 'Y-m-j' ,strtotime ( '-1 year' , strtotime ( $finicio2 ) ))." 00:00:00.000') AND (DocDate <= '".date ( 'Y-m-j' ,strtotime ( '-1 year' , strtotime ( $ffin2 ) ))." 23:59:59.000')
    AND Empresa NOT LIKE 'EXB_AEROP'
	AND WhsCode  IN ('ZFI.6115','ZFI.6130')
		      ".$WtipoProducto." 
			  ".$marcaSQL."
			  ".$segmentoSQL."
  GROUP BY [Empresa]
          ,[WhsCode]
		  ".$marcaGroup."
		  ".$segmentoGroup."
  ORDER BY WhsCode
";
	
/************ SQLS Para AEROPUERTO **************************/
$sql5="

SELECT
       [Empresa]
      ,[WhsCode]
  
      ,SUM([Cantidad]) [Cantidad]
      ,SUM([TotalCLP]) [TotalCLP]
	  ,SUM([TotalCLP]) / NULLIF(SUM([Cantidad]),0) [Media]
      ,SUM([TotalCIF]) [TotalCIF]
      ,SUM([TotalUSD]) [TotalUSD]
      ,(((SUM([TotalUSD]) - SUM([TotalCIF]))*100) /SUM([TotalUSD])) [Rentabilidad]
	  
  FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_VW_VtasD_RPRO]
  WHERE (DocDate >= '".$finicio2." 00:00:00.000') AND (DocDate <= '".$ffin2." 23:59:59.000')
       AND Empresa  LIKE 'EXB_AEROP'
	   --AND WhsCode  IN ('ZFI.6115','ZFI.6130')
	   	      ".$WtipoProducto." 
			  ".$marcaSQL."
			  ".$segmentoSQL."
  GROUP BY [Empresa]
          ,[WhsCode]
		   ".$marcaGroup."
		   ".$segmentoGroup."
  ORDER BY WhsCode
";



$sql6="

SELECT
       [Empresa]
      ,[WhsCode]
  
      ,SUM([Cantidad]) [Cantidad]
      ,SUM([TotalCLP]) [TotalCLP]
	  ,SUM([TotalCLP]) / NULLIF(SUM([Cantidad]),0) [Media]
      ,SUM([TotalCIF]) [TotalCIF]
      ,SUM([TotalUSD]) [TotalUSD]
      ,(((SUM([TotalUSD]) - SUM([TotalCIF]))*100) /SUM([TotalUSD])) [Rentabilidad]
	  
  FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_VW_VtasD_RPRO]
  WHERE (DocDate >= '".date ( 'Y-m-j' ,strtotime ( '-1 year' , strtotime ( $finicio2 ) ))." 00:00:00.000') AND (DocDate <= '".date ( 'Y-m-j' ,strtotime ( '-1 year' , strtotime ( $ffin2 ) ))." 23:59:59.000')
    AND Empresa  LIKE 'EXB_AEROP'
	--AND WhsCode  IN ('ZFI.6115','ZFI.6130')
		      ".$WtipoProducto." 
			  ".$marcaSQL."
			  ".$segmentoSQL."
  GROUP BY [Empresa]
          ,[WhsCode]
		   ".$marcaGroup."
		   ".$segmentoGroup."
  ORDER BY WhsCode
";
	

		
echo $sql2;
                        $rs = odbc_exec( $conn, $sql );
							if ( !$rs)
							{
							    exit( "Error en la consulta SQL" );
							}
					      $rs2 = odbc_exec( $conn, $sql2 );
							if ( !$rs2)
							{
							   exit( "Error en la consulta SQL" );
							}
				/* MODULPS 6115 6130 */
                $rs3 = odbc_exec( $conn, $sql3 );
							if ( !$rs3)
							{
							    exit( "Error en la consulta SQL" );
							}
					      $rs4 = odbc_exec( $conn, $sql4);
							if ( !$rs4)
							{
							   exit( "Error en la consulta SQL" );
							}				
				
				/* MODULPS AEROPUERTO */
                $rs5 = odbc_exec( $conn, $sql5 );
							if ( !$rs5)
							{
							    exit( "Error en la consulta SQL" );
							}
			 $rs6= odbc_exec( $conn, $sql6);
							if ( !$rs6)
							{
							   exit( "Error en la consulta SQL" );
							}				
										
							
				if($consultar)
							{
                            while(($resultado = odbc_fetch_array($rs)) && ($resultado2 = odbc_fetch_array($rs2)))
							 { 
							    					  
								
								  echo '<tr>
																			
										<td  >'.utf8_encode(str_replace("ZFI.","LOCAL ",$resultado2["WhsCode"])).'</td> 
										<td  style=" border-left:2px double #B5B5B5;" >'.number_format($resultado2["Cantidad"], 0, '', '.').'</td> 
										<td ><strong>'.number_format($resultado2["TotalCLP"], 0, '', '.').'</strong></td>
										<td ><strong>'.number_format($resultado2["Media"], 0, '', '.').'</strong></td>
										<td >'.number_format($resultado2["TotalUSD"], 2, ',', '.').'</td> 
										<td  style=" border-right:2px double #B5B5B5;" >'.number_format($resultado2["TotalCIF"], 2, ',', '.').'</td> 
										<td  style=" border-right:2px double #B5B5B5; color:#008000;"" >'.number_format($resultado2["Rentabilidad"], 0, ',', '.').'%</td> 
										
										
										<td >'.number_format($resultado["Cantidad"], 0, '', '.').'</td> 
										<td ><strong>'.number_format($resultado["TotalCLP"], 0, '', '.').'</strong></td>
										<td ><strong>'.number_format($resultado["Media"], 0, '', '.').'</strong></td>
										<td >'.number_format($resultado["TotalUSD"], 2, ',', '.').'</td> 
										<td style=" border-right:2px double #B5B5B5;" >'.number_format($resultado["TotalCIF"], 2, ',', '.').'</td> 
										<td  style=" border-right:2px double #B5B5B5; color:#008000;" >'.number_format($resultado["Rentabilidad"], 0, ',', '.').'%</td> 
										
										<td ><strong>'; 
										if($resultado2["Cantidad"] == 0)
											echo number_format(0, 0, ',', '.').'%</strong></td> 
										<td ><strong>';
										else
											echo number_format((($resultado["Cantidad"]-$resultado2["Cantidad"])/$resultado2["Cantidad"])*100, 0, ',', '.').'%</strong></td> 
										<td ><strong>'; 
										if($resultado2["TotalCLP"] == 0)
											echo number_format(0, 0, ',', '.').'%</strong></td> 
										<td ><strong>';
										else
											echo number_format((($resultado["TotalCLP"]-$resultado2["TotalCLP"])/$resultado2["TotalCLP"])*100, 0, ',', '.').'%</strong></td>
										<td ><strong>';
										if($resultado2["TotalUSD"] == 0)
											echo number_format(0, 0, ',', '.').'%</strong></td> 
										<td ><strong>';
										else
											echo number_format((($resultado["TotalUSD"]-$resultado2["TotalUSD"])/$resultado2["TotalUSD"])*100, 0, ',', '.').'%</strong></td>
										<td ><strong>';
										if($resultado2["TotalCIF"] == 0)
											echo number_format(0, 0, ',', '.').'%</strong></td> 
										<td style="color:#008000;"><strong>';
										else
											echo number_format((($resultado["TotalCIF"]-$resultado2["TotalCIF"])/$resultado2["TotalCIF"])*100, 0, ',', '.').'%</strong></td>
										</tr>' ;
										
										$TotalUnidadesActual = $TotalUnidadesActual + $resultado2["Cantidad"];
										$TotalCLPActual = $TotalCLPActual + $resultado2["TotalCLP"];
										$TotalUSDActual = $TotalUSDActual + $resultado2["TotalUSD"];
										$TotalCIFActual = $TotalCIFActual + $resultado2["TotalCIF"];
										
										$TotalUnidadesHoy = $TotalUnidadesHoy + $resultado["Cantidad"];
										$TotalCLPHoy = $TotalCLPHoy + $resultado["TotalCLP"];
										$TotalUSDHoy = $TotalUSDHoy + $resultado["TotalUSD"];
										$TotalCIFHoy = $TotalCIFHoy + $resultado["TotalCIF"];
										
										
											
							} 
				?>
				
                </tbody>
                <tbody>		
					<tr style=" border-top:2px double #B5B5B5;">
						<td><strong>TOTALES PERFUMERÍA</strong></td>
						<td><strong><?php echo number_format($TotalUnidadesActual, 0, '', '.'); ?></strong></td>
						<td><strong><?php echo number_format($TotalCLPActual, 0, '', '.'); ?></strong></td>
						<td><strong><?php
						if($TotalUnidadesActual ==0)
						echo number_format(0, 0, ',', '.');
						else
						echo number_format($TotalCLPActual/$TotalUnidadesActual, 0, ',', '.'); ?></strong></td>
						<td><strong><?php echo number_format($TotalUSDActual, 2, ',', '.'); ?></strong></td>
						<td><strong><?php echo number_format($TotalCIFActual, 2, ',', '.'); ?></strong></td>
						<td style="color:#008000;"><?php if($TotalUSDActual == 0){
							echo number_format(0, 0 ,',', '.');
						}else{
							echo number_format(((($TotalUSDActual - $TotalCIFActual)* 100) / $TotalUSDActual),0,',','.');
						}?>%</td>
												
						<td><strong><?php echo number_format($TotalUnidadesHoy, 0, '', '.'); ?></strong></td>
						<td><strong><?php echo number_format($TotalCLPHoy, 0, '', '.'); ?></strong></td>
						<td><strong><?php
						if($TotalUnidadesHoy ==0)
						echo number_format(0, 0, ',', '.');
						else
						echo number_format($TotalCLPHoy/$TotalUnidadesHoy, 0, ',', '.'); ?></strong></td>
						<td><strong><?php echo number_format($TotalUSDHoy, 2, ',', '.'); ?></strong></td>
						<td><strong><?php echo number_format($TotalCIFHoy, 2, ',', '.'); ?></strong></td>
						<td style="color:#008000;"><?php if($TotalUSDHoy == 0){
							echo number_format(0, 0 ,',', '.');
						}else{
							echo number_format(((($TotalUSDHoy - $TotalCIFHoy)* 100) / $TotalUSDHoy),0,',','.');
						}?>%</td>
						
						<td><strong><?php
						if($TotalUnidadesActual ==0)
						echo number_format(0, 0, ',', '.');
						else
						echo number_format((($TotalUnidadesHoy-$TotalUnidadesActual)/$TotalUnidadesActual)*100, 0, ',', '.'); ?>%</strong></td>
						<td><strong><?php 
						if($TotalCLPActual ==0)
						echo number_format(0, 0, ',', '.');
						else
						echo number_format((($TotalCLPHoy-$TotalCLPActual)/$TotalCLPActual)*100, 0, ',', '.'); ?>%</strong></td>
						<td><strong><?php
						if($TotalUSDActual ==0)
						echo number_format(0, 0, ',', '.');
						else
						echo number_format((($TotalUSDHoy-$TotalUSDActual)/$TotalUSDActual)*100, 0, ',', '.'); ?>%</strong></td>
						<td><strong><?php 
						if($TotalCIFActual ==0)
						echo number_format(0, 0, ',', '.');
						else
						echo number_format((($TotalCIFHoy-$TotalCIFActual)/$TotalCIFActual)*100, 0, ',', '.'); ?>%</strong></td>
					</tr>
                </tbody>
				<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				
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
                            while(($resultado3 = odbc_fetch_array($rs3)) && ($resultado4 = odbc_fetch_array($rs4)))
							 { 
							    					  
								
								  echo '<tr>
																			
										<td  >'.utf8_encode(str_replace("ZFI.","LOCAL ",$resultado4["WhsCode"])).'</td> 
										<td  style=" border-left:2px double #B5B5B5;" >'.number_format($resultado4["Cantidad"], 0, '', '.').'</td> 
										<td ><strong>'.number_format($resultado4["TotalCLP"], 0, '', '.').'</strong></td>
										<td ><strong>'.number_format($resultado4["Media"], 0, '', '.').'</strong></td>
										<td >'.number_format($resultado4["TotalUSD"], 2, ',', '.').'</td> 
										<td  style=" border-right:2px double #B5B5B5;" >'.number_format($resultado4["TotalCIF"], 2, ',', '.').'</td> 
										<td  style=" border-right:2px double #B5B5B5; color:#008000;" >'.number_format($resultado4["Rentabilidad"], 0, ',', '.').'%</td> 
										
										<td >'.number_format($resultado3["Cantidad"], 0, '', '.').'</td> 
										<td ><strong>'.number_format($resultado3["TotalCLP"], 0, '', '.').'</strong></td>
										<td ><strong>'.number_format($resultado3["Media"], 0, '', '.').'</strong></td>
										<td >'.number_format($resultado3["TotalUSD"], 2, ',', '.').'</td> 
										<td style=" border-right:2px double #B5B5B5;" >'.number_format($resultado3["TotalCIF"], 2, ',', '.').'</td> 
										<td  style=" border-right:2px double #B5B5B5; color:#008000;" >'.number_format($resultado3["Rentabilidad"], 0, ',', '.').'%</td> 
									
										<td >'.number_format((($resultado3["Cantidad"]-$resultado4["Cantidad"])/$resultado4["Cantidad"])*100, 0, ',', '.').'%</td> 
										<td ><strong>'.number_format((($resultado3["TotalCLP"]-$resultado4["TotalCLP"])/$resultado4["TotalCLP"])*100, 0, ',', '.').'%</strong></td>
										<td >'.number_format((($resultado3["TotalUSD"]-$resultado4["TotalUSD"])/$resultado4["TotalUSD"])*100, 0, ',', '.').'%</td> 
										<td >'.number_format((($resultado3["TotalCIF"]-$resultado4["TotalCIF"])/$resultado4["TotalCIF"])*100, 0, ',', '.').'%</td> 
										
										
										</tr>' ;
										
										$TotalUnidadesActual2 = $TotalUnidadesActual2 + $resultado4["Cantidad"];
										$TotalCLPActual2 = $TotalCLPActual2 + $resultado4["TotalCLP"];
										$TotalUSDActual2 = $TotalUSDActual2 + $resultado4["TotalUSD"];
										$TotalCIFActual2 = $TotalCIFActual2 + $resultado4["TotalCIF"];
										
										$TotalUnidadesHoy2 = $TotalUnidadesHoy2 + $resultado3["Cantidad"];
										$TotalCLPHoy2 = $TotalCLPHoy2 + $resultado3["TotalCLP"];
										$TotalUSDHoy2 = $TotalUSDHoy2 + $resultado3["TotalUSD"];
										$TotalCIFHoy2 = $TotalCIFHoy2 + $resultado3["TotalCIF"];
										
										
											
							} 
				?>
				
				</tbody>	
                 <tbody>		
					<tr style=" border-top:2px double #B5B5B5;">
						<td><strong>TOTALES COSMÉTICOS</strong></td>
						<td><strong><?php echo number_format($TotalUnidadesActual2, 0, '', '.'); ?></strong></td>
						<td><strong><?php echo number_format($TotalCLPActual2, 0, '', '.'); ?></strong></td>
						<td><strong><?php 
						if($TotalUnidadesActual2 ==0)
						echo number_format(0, 0, ',', '.');
						else
						echo number_format($TotalCLPActual2/$TotalUnidadesActual2, 0, ',', '.'); ?></strong></td>
						<td><strong><?php echo number_format($TotalUSDActual2, 2, ',', '.'); ?></strong></td>
						<td><strong><?php echo number_format($TotalCIFActual2, 2, ',', '.'); ?></strong></td>
						<td style="color:#008000;"><?php if($TotalUSDActual2 == 0){
							echo number_format(0, 0 ,',', '.');
						}else{
							echo number_format(((($TotalUSDActual2 - $TotalCIFActual2)* 100) / $TotalUSDActual2),0,',','.');
						}?>%</td>
						
						<td><strong><?php echo number_format($TotalUnidadesHoy2, 0, '', '.'); ?></strong></td>
						<td><strong><?php echo number_format($TotalCLPHoy2, 0, '', '.'); ?></strong></td>
						<td><strong><?php
                        if($TotalUnidadesHoy2 ==0)
						echo number_format(0, 0, ',', '.');
						else
						echo number_format($TotalCLPHoy2/$TotalUnidadesHoy2, 0, ',', '.'); ?></strong></td>
						<td><strong><?php echo number_format($TotalUSDHoy2, 2, ',', '.'); ?></strong></td>
						<td><strong><?php echo number_format($TotalCIFHoy2, 2, ',', '.'); ?></strong></td>
						<td style="color:#008000;"><?php if($TotalUSDHoy2 == 0){
							echo number_format(0, 0 ,',', '.');
						}else{
							echo number_format(((($TotalUSDHoy2 - $TotalCIFHoy2)* 100) / $TotalUSDHoy2),0,',','.');
						}?>%</td>
						
						<td><strong><?php 
						if($TotalUnidadesActual2 ==0)
						echo number_format(0, 0, ',', '.');
						else
						echo number_format((($TotalUnidadesHoy2-$TotalUnidadesActual2)/$TotalUnidadesActual2)*100, 0, ',', '.'); ?>%</strong></td>
						<td><strong><?php
						if($TotalCLPActual2 ==0)
						echo number_format(0, 0, ',', '.');
						else
						echo number_format((($TotalCLPHoy2-$TotalCLPActual2)/$TotalCLPActual2)*100, 0, ',', '.'); ?>%</strong></td>
						<td><strong><?php 
						if($TotalUSDActual2 ==0)
						echo number_format(0, 0, ',', '.');
						else
						echo number_format((($TotalUSDHoy2-$TotalUSDActual2)/$TotalUSDActual2)*100, 0, ',', '.'); ?>%</strong></td>
						<td><strong><?php
						if($TotalCIFActual2 ==0)
						echo number_format(0, 0, ',', '.');
						else
						echo number_format((($TotalCIFHoy2-$TotalCIFActual2)/$TotalCIFActual2)*100, 0, ',', '.'); ?>%</strong></td>
					</tr>
                </tbody>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>AEROPUERTO<span> - Venta neta sin IVA - Dolar observado</span></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					
					<td></td>
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
                            while(($resultado3 = odbc_fetch_array($rs5)) && ($resultado4 = odbc_fetch_array($rs6)))
							 { 
							    					  
								
								  echo '<tr>
																			
										<td  >'.utf8_encode(str_replace("LOCAL.","LOCAL ",$resultado4["WhsCode"])).'</td> 
										<td  style=" border-left:2px double #B5B5B5;" >'.number_format($resultado4["Cantidad"], 0, '', '.').'</td> 
										<td ><strong>'.number_format($resultado4["TotalCLP"], 0, '', '.').'</strong></td>
										<td ><strong>'.number_format($resultado4["Media"], 0, '', '.').'</strong></td>
										<td >'.number_format($resultado4["TotalUSD"], 2, ',', '.').'</td> 
										<td  style=" border-right:2px double #B5B5B5;" >'.number_format($resultado4["TotalCIF"], 2, ',', '.').'</td> 
										<td  style=" border-right:2px double #B5B5B5; color:#008000;" >'.number_format($resultado4["Rentabilidad"], 0, ',', '.').'%</td> 
										
										<td >'.number_format($resultado3["Cantidad"], 0, '', '.').'</td> 
										<td ><strong>'.number_format($resultado3["TotalCLP"], 0, '', '.').'</strong></td>
										<td ><strong>'.number_format($resultado3["Media"], 0, '', '.').'</strong></td>
										<td >'.number_format($resultado3["TotalUSD"], 2, ',', '.').'</td> 
										<td style=" border-right:2px double #B5B5B5;" >'.number_format($resultado3["TotalCIF"], 2, ',', '.').'</td> 
										<td  style=" border-right:2px double #B5B5B5; color:#008000;" >'.number_format($resultado3["Rentabilidad"], 0, ',', '.').'%</td> 
										
										<td >'.number_format((($resultado3["Cantidad"]-$resultado4["Cantidad"])/$resultado4["Cantidad"])*100, 0, ',', '.').'%</td> 
										<td ><strong>'.number_format((($resultado3["TotalCLP"]-$resultado4["TotalCLP"])/$resultado4["TotalCLP"])*100, 0, ',', '.').'%</strong></td>
										<td >'.number_format((($resultado3["TotalUSD"]-$resultado4["TotalUSD"])/$resultado4["TotalUSD"])*100, 0, ',', '.').'%</td> 
										<td >'.number_format((($resultado3["TotalCIF"]-$resultado4["TotalCIF"])/$resultado4["TotalCIF"])*100, 0, ',', '.').'%</td> 
										
										
										</tr>' ;
										
										$TotalUnidadesActual3 = $TotalUnidadesActual3 + $resultado4["Cantidad"];
										$TotalCLPActual3 = $TotalCLPActual3 + $resultado4["TotalCLP"];
										$TotalUSDActual3 = $TotalUSDActual3 + $resultado4["TotalUSD"];
										$TotalCIFActual3 = $TotalCIFActual3 + $resultado4["TotalCIF"];
										
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
						<td><strong><?php echo number_format($TotalUnidadesActual3, 0, '', '.'); ?></strong></td>
						<td><strong><?php echo number_format($TotalCLPActual3, 0, '', '.'); ?></strong></td>
						<td><strong><?php
                        if($TotalUnidadesActual3 ==0)
						echo number_format(0, 0, ',', '.');
						else
						echo number_format($TotalCLPActual3/$TotalUnidadesActual3, 0, ',', '.');

						?></strong></td>
						<td><strong><?php echo number_format($TotalUSDActual3, 2, ',', '.'); ?></strong></td>
						<td><strong><?php echo number_format($TotalCIFActual3, 2, ',', '.'); ?></strong></td>
						<td style="color:#008000;"><?php if($TotalUSDActual3 == 0){
							echo number_format(0, 0 ,',', '.');
						}else{
							echo number_format(((($TotalUSDActual3 - $TotalCIFActual3)* 100) / $TotalUSDActual3),0,',','.');
						}?>%</td>
						
						<td><strong><?php echo number_format($TotalUnidadesHoy3, 0, '', '.'); ?></strong></td>
						<td><strong><?php echo number_format($TotalCLPHoy3, 0, '', '.'); ?></strong></td>
						<td><strong><?php 
						if($TotalUnidadesHoy3 ==0)
						echo number_format(0, 0, ',', '.');
						else
						echo number_format($TotalCLPHoy3/$TotalUnidadesHoy3, 0, ',', '.'); ?></strong></td>
						<td><strong><?php echo number_format($TotalUSDHoy3, 2, ',', '.'); ?></strong></td>
						<td><strong><?php echo number_format($TotalCIFHoy3, 2, ',', '.'); ?></strong></td>
						<td style="color:#008000;"><?php if($TotalUSDHoy3 == 0){
							echo number_format(0, 0 ,',', '.');
						}else{
							echo number_format(((($TotalUSDHoy3 - $TotalCIFHoy3)* 100) / $TotalUSDHoy3),0,',','.');
						}?>%</td>
												
						<td><strong><?php 
						if($TotalUnidadesActual3 ==0)
						echo number_format(0, 0, ',', '.');
						else
						echo number_format((($TotalUnidadesHoy3-$TotalUnidadesActual3)/$TotalUnidadesActual3)*100, 0, ',', '.'); ?>%</strong></td>
						<td><strong><?php 
						if($TotalCLPActual3 ==0)
						echo number_format(0, 0, ',', '.');
						else
						echo number_format((($TotalCLPHoy3-$TotalCLPActual3)/$TotalCLPActual3)*100, 0, ',', '.'); ?>%</strong></td>
						<td><strong><?php 
						if($TotalUSDActual3 ==0)
						echo number_format(0, 0, ',', '.');
						else
						echo number_format((($TotalUSDHoy3-$TotalUSDActual3)/$TotalUSDActual3)*100, 0, ',', '.'); ?>%</strong></td>
						<td><strong><?php 
						if($TotalCIFActual3 ==0)
						echo number_format(0, 0, ',', '.');
						else
						echo number_format((($TotalCIFHoy3-$TotalCIFActual3)/$TotalCIFActual3)*100, 0, ',', '.'); ?>%</strong></td>
					</tr>
                </tbody>
				<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				
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
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					
					
					<td></td>
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
	  ,SUM([Total_CLP]) / NULLIF(SUM([Quantity]),0) [Media]
      ,SUM([Total_USD])                   [TotalUSD]
      ,SUM([CtoVtaCIF])                   [TotalCIF]
      ,(((SUM([Total_USD]) - SUM([CtoVtaCIF]))*100) /SUM([Total_USD])) [Rentabilidad]
	  
  FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_VW_Vtas_Mayor_CIF]
  WHERE Emp_Relacionada = 'N'
  AND (DocDate >= '".$finicio2." 00:00:00.000') AND (DocDate <= '".$ffin2." 23:59:59.000')
  ".$marcaSQL."
  ".$segmentoSQL."
  GROUP BY [TipoVenta]
  ".$marcaGroup."
  ".$segmentoGroup."

";

$sql8="
SELECT 
       [TipoVenta]
      ,SUM([Quantity])                    [Cantidad]
      ,SUM([Total_CLP])                   [TotalCLP]
	  ,SUM([Total_CLP]) / NULLIF(SUM([Quantity]),0) [Media]
      ,SUM([Total_USD])                   [TotalUSD]
      ,SUM([CtoVtaCIF])                   [TotalCIF]
      ,(((SUM([Total_USD]) - SUM([CtoVtaCIF]))*100) /SUM([Total_USD])) [Rentabilidad]
	  
  FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_VW_Vtas_Mayor_CIF]
  WHERE Emp_Relacionada = 'N'
  AND (DocDate >= '".date ( 'Y-m-j' ,strtotime ( '-1 year' , strtotime ( $finicio2 ) ))." 00:00:00.000') AND (DocDate <= '".date ( 'Y-m-j' ,strtotime ( '-1 year' , strtotime ( $ffin2 ) ))." 23:59:59.000')
  ".$marcaSQL."
  ".$segmentoSQL."
  GROUP BY [TipoVenta]
  ".$marcaGroup."
  ".$segmentoGroup."

";

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
                            while(($resultado7 = odbc_fetch_array($rs7)) && ($resultado8 = odbc_fetch_array($rs8)))
							 { 
							    					  
								
								  echo '<tr>
																			
										<td  >MAYORISTA</td> 
										<td  style=" border-left:2px double #B5B5B5;" >'.number_format($resultado8["Cantidad"], 0, '', '.').'</td> 
										<td ><strong>'.number_format($resultado8["TotalCLP"], 0, '', '.').'</strong></td>
										<td ><strong>'.number_format($resultado8["Media"], 0, '', '.').'</strong></td>
										<td >'.number_format($resultado8["TotalUSD"], 2, ',', '.').'</td> 
										<td  style=" border-right:2px double #B5B5B5;" >'.number_format($resultado8["TotalCIF"], 2, ',', '.').'</td> 
										<td  style=" border-right:2px double #B5B5B5; color:#008000;" >'.number_format($resultado8["Rentabilidad"], 0, ',', '.').'%</td>  
										
										<td >'.number_format($resultado7["Cantidad"], 0, '', '.').'</td> 
										<td ><strong>'.number_format($resultado7["TotalCLP"], 0, '', '.').'</strong></td>
										<td ><strong>'.number_format($resultado7["Media"], 0, '', '.').'</strong></td>
										<td >'.number_format($resultado7["TotalUSD"], 2, ',', '.').'</td> 
										<td style=" border-right:2px double #B5B5B5;" >'.number_format($resultado7["TotalCIF"], 2, ',', '.').'</td> 
										<td  style=" border-right:2px double #B5B5B5; color:#008000;" >'.number_format($resultado7["Rentabilidad"], 0, ',', '.').'%</td> 
										
										<td >'.number_format((($resultado7["Cantidad"]-$resultado8["Cantidad"])/$resultado8["Cantidad"])*100, 0, ',', '.').'%</td> 
										<td ><strong>'.number_format((($resultado7["TotalCLP"]-$resultado8["TotalCLP"])/$resultado8["TotalCLP"])*100, 0, ',', '.').'%</strong></td>
										<td >'.number_format((($resultado7["TotalUSD"]-$resultado8["TotalUSD"])/$resultado8["TotalUSD"])*100, 0, ',', '.').'%</td> 
										<td >'.number_format((($resultado7["TotalCIF"]-$resultado8["TotalCIF"])/$resultado8["TotalCIF"])*100, 0, ',', '.').'%</td> 
										
										</tr>' ;
										
										$TotalUnidadesActual4 = $TotalUnidadesActual4 + $resultado8["Cantidad"];
										$TotalCLPActual4 = $TotalCLPActual4 + $resultado8["TotalCLP"];
										$TotalUSDActual4 = $TotalUSDActual4 + $resultado8["TotalUSD"];
										$TotalCIFActual4 = $TotalCIFActual4 + $resultado8["TotalCIF"];
										
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
						<td><strong><?php echo number_format($TotalUnidadesActual4, 0, '', '.'); ?></strong></td>
						<td><strong><?php echo number_format($TotalCLPActual4, 0, '', '.'); ?></strong></td>
						<td><strong><?php 
						if($TotalUnidadesActual4 ==0)
						echo number_format(0, 0, ',', '.');
						else
						echo number_format($TotalCLPActual4/$TotalUnidadesActual4, 0, ',', '.'); ?></strong></td>
						<td><strong><?php echo number_format($TotalUSDActual4, 2, ',', '.'); ?></strong></td>
						<td><strong><?php echo number_format($TotalCIFActual4, 2, ',', '.'); ?></strong></td>
						<td style="color:#008000;"><?php if($TotalUSDActual4 == 0){
							echo number_format(0, 0 ,',', '.');
						}else{
							echo number_format(((($TotalUSDActual4 - $TotalCIFActual4)* 100) / $TotalUSDActual4),0,',','.');
						}?>%</td>
						<td><strong><?php echo number_format($TotalUnidadesHoy4, 0, '', '.'); ?></strong></td>
						<td><strong><?php echo number_format($TotalCLPHoy4, 0, '', '.'); ?></strong></td>
						<td><strong><?php
						if($TotalUnidadesHoy4 ==0)
						echo number_format(0, 0, ',', '.');
						else
						echo number_format($TotalCLPHoy4/$TotalUnidadesHoy4, 0, ',', '.'); ?></strong></td>
						<td><strong><?php echo number_format($TotalUSDHoy4, 2, ',', '.'); ?></strong></td>
						<td><strong><?php echo number_format($TotalCIFHoy4, 2, ',', '.'); ?></strong></td>
						<td style="color:#008000;"><?php if($TotalUSDHoy4 == 0){
							echo number_format(0, 0 ,',', '.');
						}else{
							echo number_format(((($TotalUSDHoy4 - $TotalCIFHoy4)* 100) / $TotalUSDHoy4),0,',','.');
						}?>%</td>
						
						<td><strong><?php 
						if($TotalUnidadesActual4 ==0)
						echo number_format(0, 0, ',', '.');
						else
						echo number_format((($TotalUnidadesHoy4-$TotalUnidadesActual4)/$TotalUnidadesActual4)*100, 0, ',', '.'); ?>%</strong></td>
						<td><strong><?php 
						if($TotalCLPActual4 ==0)
						echo number_format(0, 0, ',', '.');
						else
						echo number_format((($TotalCLPHoy4-$TotalCLPActual4)/$TotalCLPActual4)*100, 0, ',', '.'); ?>%</strong></td>
						<td><strong><?php 
						if($TotalUSDActual4 ==0)
						echo number_format(0, 0, ',', '.');
						else
						echo number_format((($TotalUSDHoy4-$TotalUSDActual4)/$TotalUSDActual4)*100, 0, ',', '.'); ?>%</strong></td>
						<td><strong><?php 
						if($TotalCIFActual4 ==0)
						echo number_format(0, 0, ',', '.');
						else
						echo number_format((($TotalCIFHoy4-$TotalCIFActual4)/$TotalCIFActual4)*100, 0, ',', '.'); ?>%</strong></td>
					</tr>
                </tbody>
				<tbody>
					<th>
					</th>
				</body>
				<tr>
				<td><b>TOTAL FINAL</b></td>
				<td><?php $TotalFinalUnidadesActual = $TotalUnidadesActual + $TotalUnidadesActual2 + $TotalUnidadesActual3 + $TotalUnidadesActual4; echo '<b>'.$TotalFinalUnidadesActual.'</b>';?></td>
				<td><?php $TotalFinalCLPActual = $TotalCLPActual+$TotalCLPActual2+$TotalCLPActual3+$TotalCLPActual4; echo '<b>'.number_format($TotalFinalCLPActual, 0, '', '.').'</b>';?></td>
				<td><?php 
					if($TotalFinalUnidadesActual ==0)
						echo number_format(0, 0, ',', '.');
					else
						echo '<b>'.number_format($TotalFinalCLPActual/$TotalFinalUnidadesActual,0,",",".").'</b>'?>
				</td>
				<td><?php $TotalFinalUSDActual=$TotalUSDActual+$TotalUSDActual2+$TotalUSDActual3+$TotalUSDActual4; echo '<b>'.number_format($TotalFinalUSDActual,2,",",".").'</b>';?></td>
				<td><?php $TotalFinalCIFActual=$TotalCIFActual+$TotalCIFActual2+$TotalCIFActual3+$TotalCIFActual4; echo '<b>'.number_format($TotalFinalCIFActual,2,",",".").'</b>';?></td>
				<td style="color:#008000;">
					<?php if($TotalFinalUSDActual == 0){
							echo number_format(0, 0 ,',', '.');
						}else{
							echo number_format(((($TotalFinalUSDActual - $TotalFinalCIFActual)* 100) / $TotalFinalUSDActual),0,',','.');
						}
					?>%
				</td>
				
				<td><?php $TotalFinalUnidadesHoy = $TotalUnidadesHoy + $TotalUnidadesHoy2 + $TotalUnidadesHoy3 + $TotalUnidadesHoy4; echo '<b>'.$TotalFinalUnidadesHoy.'</b>';?></td>
				<td><?php $TotalFinalCLPHoy = $TotalCLPHoy+$TotalCLPHoy2+$TotalCLPHoy3+$TotalCLPHoy4; echo '<b>'.number_format($TotalFinalCLPHoy, 0, '', '.').'</b>';?></td>
				<td><?php 
					if($TotalFinalUnidadesHoy ==0)
						echo number_format(0, 0, ',', '.');
					else
					echo '<b>'.number_format($TotalFinalCLPHoy/$TotalFinalUnidadesHoy, 0, ',', '.').'</b>'?>
				</td>
				<td><?php $TotalFinalUSDHoy=$TotalUSDHoy+$TotalUSDHoy2+$TotalUSDHoy3+$TotalUSDHoy4; echo '<b>'.number_format($TotalFinalUSDHoy,2,",",".").'</b>';?></td>
				<td><?php $TotalFinalCIFHoy=$TotalCIFHoy+$TotalCIFHoy2+$TotalCIFHoy3+$TotalCIFHoy4; echo '<b>'.number_format($TotalFinalCIFHoy,2,",",".").'</b>';?></td>
				<td style="color:#008000;">
					<?php if($TotalFinalUSDHoy == 0){
							echo number_format(0, 0 ,',', '.');
						}else{
							echo number_format(((($TotalFinalUSDHoy - $TotalFinalCIFHoy)* 100) / $TotalFinalUSDHoy),0,',','.');
						}
					?>%
				</td>
				
				<td>
					<strong>
						<?php 
							if($TotalFinalUnidadesActual ==0)
							echo number_format(0, 0, ',', '.');
							else
							echo number_format((($TotalFinalUnidadesHoy-$TotalFinalUnidadesActual)/$TotalFinalUnidadesActual)*100, 0, ',', '.'); 
						?>%
					</strong>
				</td>
				<td>
					<strong>
						<?php 
							if($TotalFinalCLPActual ==0)
							echo number_format(0, 0, ',', '.');
							else
							echo number_format((($TotalFinalCLPHoy-$TotalFinalCLPActual)/$TotalFinalCLPActual)*100, 0, ',', '.'); 
						?>%
					</strong>
				</td>
				<td>
					<strong>
						<?php 
							if($TotalFinalUSDActual ==0)
							echo number_format(0, 0, ',', '.');
							else
							echo number_format((($TotalFinalUSDHoy-$TotalFinalUSDActual)/$TotalFinalUSDActual)*100, 0, ',', '.'); 
						?>%
					</strong>
				</td>
				<td>
					<strong>
						<?php 
							if($TotalFinalCIFActual ==0)
							echo number_format(0, 0, ',', '.');
							else
							echo number_format((($TotalFinalCIFHoy-$TotalFinalCIFActual)/$TotalFinalCIFActual)*100, 0, ',', '.'); 
						?>%
					</strong>
				</td>
				</tr>
				<tbody>					
            </table>
			<?php } }} }?>
			
			

		
            


	<?php odbc_close( $conn );?>