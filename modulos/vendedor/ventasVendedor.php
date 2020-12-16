<?php 
require_once("clases/conexionocdb.php");
require_once("clases/funciones.php");

ini_set('max_execution_time', 300); //300 seconds = 5 minutes
$vendedor = $_GET['id'];

$vendedor = str_pad($vendedor, 3, '0', 'STR_PAD_LEFT');

$finicio = $_GET['inicio'];
$ffin = $_GET['fin'];
$marca = $_GET['marca'];
$tipoProducto = $_GET['tipoProducto'];

if(!$finicio)
{
	 $finicio = date("m/d/Y");
	 $ffin= date("m/d/Y");
}

// Consulta para llamar las marcas de los productos
 $sql2= "SELECT   [Code]
      ,[Name]
      ,[U_Marca]
  FROM [RP_VICENCIO].[dbo].[View_OMAR] ORDER BY U_Marca ASC
";
							$rs3 = odbc_exec( $conn, $sql2 );
							if ( !$rs3 )
							{
							exit( "Error en la consulta SQL" );
							}


/********************** para que solo busque por modulos segun pertenesca ******************************************/
if($_SESSION["usuario_modulo"] !=-1)
{
	$modulo = $_SESSION["usuario_modulo"];
	//$modulo =str_pad($modulo, 3, '0', 'STR_PAD_LEFT');
	if($modulo==1){$modulo= "ZFI.1010";}
	else if($modulo==2){$modulo= "ZFI.1132";}
	else if($modulo==3){$modulo= "ZFI.181";}
	else if($modulo==4){$modulo= "ZFI.184";}
	else if($modulo==5){$modulo= "ZFI.2002";}
	else if($modulo==6){$modulo= "ZFI.6115";}
	else if($modulo==7){$modulo= "ZFI.6115";}
	else if($modulo==0){$modulo= "ZFI.2077";}
	
	
	
}

else
{
	$modulo = $_GET['modulo'];
}
/************************************** fin privilegio de modulo *****************************/

 function cambiarFecha($fecha) {
					  return implode("-", array_reverse(explode("-", $fecha)));
					}
					$finicio2 = cambiarFecha($finicio);
					$ffin2 = cambiarFecha($ffin);

if ($marca)
					{
						$nameMarca = ',[Marca]';
						$conMarca= "  AND (Marca LIKE '".$marca."') ";
						$conMarcaGroup = " , Marca ";
					}
if ($modulo)
					{
						$conModulo = "  AND (WhsCode LIKE '".$modulo."') ";
						$conModuloGroup = " , WhsCode ";
					}
if ($tipoProducto)
					{
						$WtipoProducto = "  AND (TipoProducto LIKE '".$tipoProducto."') ";
						
					}



/************************************************************ PARA LOS VENDEDORES **************************************/


/*$sql2="SELECT SUM ([TotalCLP]) AS TotalCLP
	  ,SUM([CANT]) Cantidad
      ,[Vendedor]
      ,[SlpName]
      ,[SlpCode]
	  ".$nameMarca."
  FROM [RP_VICENCIO].[dbo].[SI_VistaUNIONVentasPorVendedor_ON]
 WHERE (FECHA >= '".$finicio2." 00:00:00.000') AND (FECHA <= '".$ffin2." 23:59:59.000') ".$conModulo." ".$conMarca."
  GROUP BY Vendedor,SlpName, SlpCode ".$conModuloGroup." ".$conMarcaGroup."
  ORDER BY TotalCLP DESC
  ";*/

$sql = "

/****** Version 3/2/2015  ******/
SELECT
       [Vendedor]
      ,SUM([Cantidad])       [Cantidad]
      ,SUM([TotalCLP])       [TotalCLP]
      ,SUM([TotalCIF])       [TotalCIF]
      ,SUM([TotalUSD])       [TotalUSD]
      ".$nameMarca."
  FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_VW_VtasD_RPRO]
  WHERE  ([DocDate] >= '".$finicio2." 00:00:00.000') AND ([DocDate] <= '".$ffin2." 23:59:59.000')
  AND Empresa IN ('EXB_ZOFRI','SVX_ZOFRI')  ".$conModulo." ".$conMarca."
  ".$WtipoProducto."
  GROUP BY Vendedor ".$conModuloGroup."  ".$conMarcaGroup."
  ORDER BY TotalCLP DESC

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
				$( "#inicio" ).datepicker( );
				//formatos de las fechas
			   // $('#inicio').datepicker('option', {dateFormat: 'dd-mm-yy'});
				$( "#fin" ).datepicker(  );
				//$('#fin').datepicker('option', {dateFormat: 'dd-mm-yy'});
				
	

            });//fin funciotn principal

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
        <li><a href="#one"><img src="images/buscar.png" width="30px" height="30px" /></a></li>
		<?php // pregunta si ha ingresado una fecha para que se muestre el imagen link de generar Excel
					
		if($finicio2){
		
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
							 
							 <input name="opc" type="hidden" id="opc" size="40" class="required" value="topvendedores" />
							 
							 
							
							 
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
									</select>
				            </label>';
								}
					        
					       ?>
							
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
									<option value="Sin valor Comercial">Sin valor Comercial</option>
									</select>
				            </label>';
							
					        ?>
							
                             <?php // para cargar un list con las marcas
									 echo' <label class="first" for="title1">
									Marca
									<select id="marca" name="marca"    class="styled" >';
											if($marca)
												{
													echo'<option value="'.$marca.'" selected>'.utf8_encode($marca).'</option>';
												}
											 echo'<option value=""></option>';	
											 while($result = odbc_fetch_array($rs3))
											 { 
												
												 echo'<option value="'.$result['Code'].'">'.utf8_encode($result['Name']).'</option>';
												
											 }
										
				
								  echo'</select>
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
    <li ><a id="tabdua" href="#tab1" class="selected">Gráfico Top Vendedores</a></li> 
    <li ><a id="tabdua" href="#tab3">Detalle</a></li> 
  </ul> 
  
  <div id="tab1"><?php 
					
					
					
					//echo' <div id="ventanual" style="width:100%; height:200px;"></div>';
					echo'<div id="topVendedores" style="width:100%; height: 400px;"></div>';
					
					
					?>
</div> <!-- fin de grafico de marcas -->

  
  <div id="tab3"> 
  <table  id="ssptable2" class="lista">
              <thead>
                    <tr>
                        <th>Nombre Vendedor</th>
                        <th>Total Cant</th>
                        <th>Total CLP</th>
						<th>Pi %</th>
                        <th>Pa %</th>
                    </tr>
                </thead>
                <tbody>
                 <?php
				 
					
					$total =0;
					$cantotal =0;
								
							//echo $sql;	
							$rs2 = odbc_exec( $conn, $sql );
							if ( !$rs2 )
							{
							exit( "Error en la consulta SQL" );
							}
							 while($resultado2 = odbc_fetch_array($rs2)){ 
							   
									$total2 = $total2 + $resultado2["TotalCLP"];
									$Pi1[] = (($resultado["TotalCLP"]/$total2)*100);
									
								}
							
							
							//echo $sql;	
							$rs = odbc_exec( $conn, $sql );
							if ( !$rs )
							{
							exit( "Error en la consulta SQL" );
							}
							  $k = -1;
							  while($resultado = odbc_fetch_array($rs)){ 
							  $Pa = $pa + $Pi1[$k];
							   echo '<tr>
									<td >'.utf8_encode($resultado["Vendedor"]).'</td>
									<td ><strong>'.number_format($resultado["Cantidad"], 0, '', '.').'</strong></td>
									<td ><strong>'.number_format($resultado["TotalCLP"], 0, '', '.').'</strong></td>
									<td ><strong>'.number_format(($resultado["TotalCLP"]/$total2)*100, 2, ',', '.').'%</strong></td>
									<td ><strong>'.number_format($pa = $pa +(($resultado["TotalCLP"]/$total2)*100), 2, ',', '.').'%</strong></td>
									</tr>' ;
									$totalPi= $totalPi + (($resultado["TotalCLP"]/$total2)*100);
									$total = $total + $resultado["TotalCLP"];
									$totalCant = $totalCant + $resultado["Cantidad"];
									//$cantotal = $cantotal + $resultado["Cantidad"];
								$k++;
								}
							

				?>
                </tbody>
                <tfoot>
                	<tr  style=" border-top:2px double #B5B5B5;">
                    	<td></td>
                        <td><strong><?php echo number_format($totalCant, 0, '', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($total, 0, '', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($totalPi, 2, ',', '.'); ?>%</strong></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
            </div>  <!-- fin de tabla de vendedores -->
  
  
<script type="text/javascript"> 
  $("#usual1 ul").idTabs(); 
</script>
           
			
            


<?php odbc_close( $conn );?>