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
						
						
                            
							  <input name="opc" type="hidden" id="opc" size="40" class="required" value="dispo" />
							
							
                             <label for="fecha1">
					            Inicio
                            <input name="inicio" type="text" id="inicio" size="40" class="required" value="<?php echo $finicio;?>"  />
                            </label>
							 <label for="fecha2">
					            Fin
                            <input name="fin" type="text" id="fin" size="40" class="required"  value="<?php echo $ffin;?>" />
                            </label>
							
							<label for="fecha2">
					            TransBank Eximben
                            <input name="tbeximben" type="text" id="fin" size="40" class="required"  value="" />
                            </label>
                           
						   
						   <label for="fecha2">
					            TransBank Servimex
                            <input name="tbservimex" type="text" id="fin" size="40" class="required"  value="" />
                            </label>
                           
                           
							
							
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
						<th cols="5" ></th>
						<th  ><?php //echo $finicio;?></th>
						<th  ><?php //echo $ffin;?></th>
						
						
						
						
                    </tr>
			  </head>
              <thead>
					
                    <tr>
						<th style="width:150px;">1.- Caja Locales</th>
						<th>CLP</th>
						<th>USD</th> 
						<th>UF</th> 
						
						<!--<th>RETENCION DL</th>-->
											
                    </tr>
                </thead>
                <tbody>
                 <?php
				 
					


					$cantotal =0;
					$totalCIF=0;
					$totalUF=0;


$sql="
SELECT 
      [WhsCode]
	  ,SUM([Monto]) monto
  FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_VW_MedPagos]
 WHERE TipoPago IN ('Cash')
   AND convert(date,[FechaVenta],111) <= '2017-02-28' AND convert(date,[FechaVenta],111) >= '2017-02-28'
  
	
 GROUP BY WhsCode
";

     $rs = odbc_exec( $conn, $sql );
							if ( !$rs)
							{
							    exit( "Error en la consulta SQL" );
							}
					     
				    if($consultar)
							{
								while(($resultado = odbc_fetch_array($rs)) )
								 { 
														  
									
									  echo '<tr>
											<td  >'.utf8_encode(str_replace("ZFI.","LOCAL ",$resultado["WhsCode"])).'</td> 									
											<td ><strong>'.number_format($resultado["monto"], 0, '', '.').'</strong></td>
											<td ><strong>'.number_format($resultado["monto"], 0, '', '.').'</strong></td>
											<td ><strong>'.number_format($resultado["monto"], 0, '', '.').'</strong></td>'; 
											//<td style=" border-right:2px double #B5B5B5;" >'.number_format($resultado["RetencionDL"], 2, ',', '.').'</td> 
											echo'</tr>' ;
											
										
											$TotalCLPHoy = $TotalCLPHoy + $resultado["monto"];
											$TotalUSDHoy = $TotalUSDHoy + $resultado["monto"];
											$TotalUFHoy  = $TotalUFHoy  + $resultado["monto"];
											
											
												
								} 
							}
							
				?>
				
                </tbody>
              
                
				<tr>
				<td>Total</td>
				<td><?php echo $TotalCLPHoy;?></td>
				<td><?php echo $TotalUSDHoy;?></td>
				<td><?php echo $TotalUFHoy;?></td>
				</tr>
				
				<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				</tr>
				
				
				<tbody>					
            </table>
			
			
			<!-- Cheques -->
			<table  id="ssptable2" class="lista">
			 <thead>
					<tr>
					    <th ></th>
						<th cols="5" ></th>
						<th  ><?php //echo $finicio;?></th>
						<th  ></th>

						
						
						
						
                    </tr>
			  </head>
              <thead>
					
                    <tr>
						<th style="width:150px;">3.- Cheques en Cartera</th>
						<th>CLP</th>
						<th>USD</th> 
						<th>UF</th> 
						
						<!--<th>RETENCION DL</th>-->
											
                    </tr>
                </thead>
                <tbody>
				  <?php //CHEQUES
				 
					


					$cantotal =0;
					$totalCIF=0;
					$totalUF=0;


$sql2="
SELECT 
      [WhsCode]
	  ,SUM([Monto]) monto
  FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_VW_MedPagos]
 WHERE 1=1
    AND TipoPago IN ('Payments')
	AND  convert(date,[FechaVenta],111) >= '2017-02-28'
  
	
 GROUP BY WhsCode
";

     $rs2 = odbc_exec( $conn, $sql2 );
							if ( !$rs2)
							{
							    exit( "Error en la consulta SQL" );
							}
					     
				    if($consultar)
							{
								while(($resultado = odbc_fetch_array($rs2)) )
								 { 
														  
									
									  echo '<tr>
											<td  >'.utf8_encode(str_replace("ZFI.","LOCAL ",$resultado["WhsCode"])).'</td> 									
											<td ><strong>'.number_format($resultado["monto"], 0, '', '.').'</strong></td>
											<td ><strong>'.number_format($resultado["monto"], 0, '', '.').'</strong></td>
											<td ><strong>'.number_format($resultado["monto"], 0, '', '.').'</strong></td>'; 
											//<td style=" border-right:2px double #B5B5B5;" >'.number_format($resultado["RetencionDL"], 2, ',', '.').'</td> 
											echo'</tr>' ;
											
										
											$TotalCLPHoy = $TotalCLPHoy + $resultado["monto"];
											$TotalUSDHoy = $TotalUSDHoy + $resultado["monto"];
											$TotalUFHoy  = $TotalUFHoy  + $resultado["monto"];
											
											
												
								} 
							}
							
				?>
				</tbody>
              
                
				<tr>
				<td>Total</td>
				<td><?php echo $TotalCLPHoy;?></td>
				<td><?php echo $TotalUSDHoy;?></td>
				<td><?php echo $TotalUFHoy;?></td>
				
				</tr>
				
				<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				</tr>
				
				
				<tbody>					
            </table>
			


	<?php odbc_close( $conn );?>