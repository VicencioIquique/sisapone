<?php 
require_once("clases/conexionocdb.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
$vendedor = $_GET['id'];
$vendedorSelect = $_GET['id'];

$vendedor = str_pad($vendedor, 3, '0', 'STR_PAD_LEFT');
$finicio = $_GET['inicio'];
$ffin = $_GET['fin'];
$codbarra = $_GET['codbarra'];

if(!$finicio)
{
	 $finicio = date("m/d/Y");
	 $ffin= date("m/d/Y");
}



/********************** para que solo busque por modulos segun pertenesca ******************************************/
if($_SESSION["usuario_modulo"] != -1)
{
	$modulo = $_SESSION["usuario_modulo"];
	$modulo =str_pad($modulo, 3, '0', 'STR_PAD_LEFT');
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


$marca = $_GET['marca']; // Pregunta si realmente busco por marca -> crea la consulta WHERE

// Consulta para llamar las marcas de los productos
$sql2= "SELECT  [Code]
      ,[Name]
  FROM [RP_REGGEN].[dbo].[View_OMAR]";
							$rs2 = odbc_exec( $conn, $sql2 );
							if ( !$rs2 )
							{
							exit( "Error en la consulta SQL" );
							}
/************************************************************ PARA LOS VENDEDORES **************************************/

$sql3= "SELECT     SlpCode, SlpName
		FROM       SBO_Eximben_RegGen.dbo.OSLP WHERE SlpCode > 0";
							$rs3 = odbc_exec( $conn, $sql3 );
							if ( !$rs3 )
							{
							exit( "Error en la consulta SQL" );
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


<div class="idTabs">
      <ul>
        <li><a href="#one"><img src="images/agregar.png" width="30px" height="30px" /></a></li>
		
		<?php // pregunta si ha ingresado una fecha para que se muestre el imagen link de generar Excel
		
		if($finicio2){
		
		?>
		     
		<?php }?>
	 </ul>
      <div class="items">
        <div id="one"> <form action="" method="GET" id="horizontalForm">
        
            <fieldset>
				<legend>Busqueda Detallada Aeropuerto</legend>
							 
							 <input name="opc" type="hidden" id="opc" size="40" class="required" value="ventasdet" />
							 
                              <?php
							 	if($_SESSION["usuario_modulo"] == -1)
								{
									
									echo '<label class="first" for="title1">
									Retail
									<select id="moduloid" name="modulo"    class="styled" >';
									if($modulo)
									{
										echo'<option value="'.$modulo.'" selected>'.getmoduloAir($modulo).'</option>';
									}
									
									echo'<option value="001">Local 2</option>
									<option value="002">Local 8</option>
									
									</select>
				            </label>';
								}
					        ?>
							 
							 <?php // para cargar un list con los vendedores
									 echo' <label class="first" for="title1">
									Vendedor
									<select id="vendedor" name="id"    class="styled" >';
																				
											echo'<option value=""></option>';
											if($vendedorSelect)
											{
												echo'<option value="'.$vendedor .'" selected>'.getusuarioAir($vendedorSelect).'</option>';
											}
											 while($resulta = odbc_fetch_array($rs3))
											 { 
												
												 echo'<option value="'.$resulta['SlpCode'].'">'.utf8_encode($resulta['SlpName']).'</option>';
												
											 }
										
				
								  echo'</select>
				            </label>';
					        ?>
                            

                             <label for="fecha1">
					            Inicio
                            <input name="inicio" type="text" id="inicio" size="40" class="required" value="<?php echo $finicio;?>"  />
                            </label>
							 <label for="fecha2">
					            Fin
                            <input name="fin" type="text" id="fin" size="40" class="required"  value="<?php echo $ffin;?>" />
                            </label>
                            
                              </label>
							 <label for="sku">
					            Codigo de Barra
                            <input name="codbarra" type="text" id="codbarra" size="40"  value="<?php echo $codbarra;?>" />
                            </label>
							
							 <?php // para cargar un list con las marcas
									 echo' <label class="first" for="title1">
									Marca
									<select id="marca" name="marca"    class="styled" >';
											 echo'<option value=""></option>';
											if($marca)
												{
													echo'<option value="'.$marca.'" selected>'.utf8_encode($marca).'</option>';
												}
												
											 while($result = odbc_fetch_array($rs2))
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
        
        
        
           
						
            <table  id="ssptable2" class="lista">
              <thead>
                    <tr>
					    <th>Fecha</th>
                        <th>Bol/Fac</th>
						<th>Vendedor</th>						
						<th>Codigo</th>
						<th>Linea</th>
						<th>Descripcion</th>
						<th>Un.</th>
						<th>Precio de Venta</th> 
						<th>USD</th> 
						<th>CIF</th> 
						<!--<th>CIF EXTENDIDO</th> -->
                    </tr>
                </thead>
                <tbody>
                 <?php
				 
					if ($marca)
					{
						$Wmarca = " AND ( RP_REGGEN.oITM_From_SBO.U_VK_Marca LIKE '".$marca."')  ";
					}
					
					if ($codbarra)
					{
						$Wcodbarra = " AND (RP_REGGEN.dbo.RP_ReceiptsDet_SAP.Sku LIKE '".$codbarra."')  ";
					}
					
					if ($_GET['id'])
					{
						$Wvendedor = " AND (RP_REGGEN.dbo.RP_ReceiptsDet_SAP.Vendedor LIKE '".$vendedor."')  ";
					}

					$total =0;
			
			$cantotal =0;
					$totalCIFEXT =0;
					$totalCIF=0;
					$totalUSD=0;
				
					$acumnotascredito=0;
					$cantotalnotacredito =0;
					
					$sql= "SELECT      RP_REGGEN.dbo.RP_ReceiptsDet_SAP.Bodega, CONVERT(varchar, RP_REGGEN.dbo.RP_ReceiptsCab_SAP.FechaDocto, 103) AS Fecha, 
                      RP_REGGEN.dbo.RP_ReceiptsCab_SAP.TipoDocto, RP_REGGEN.dbo.RP_ReceiptsDet_SAP.NumeroDocto, RP_REGGEN.dbo.RP_ReceiptsDet_SAP.Sku, RP_REGGEN.dbo.RP_ReceiptsDet_SAP.Cantidad, 
                      RP_REGGEN.dbo.RP_ReceiptsDet_SAP.PrecioExtendido, RP_REGGEN.dbo.RP_ReceiptsDet_SAP.PrecioExtendido / RP_REGGEN.dbo.RP_ReceiptsCab_SAP.TipoCambio AS USD, 
                      RP_REGGEN.dbo.RP_ReceiptsDet_SAP.CIF, RP_REGGEN.dbo.RP_ReceiptsDet_SAP.CIF * RP_REGGEN.dbo.RP_ReceiptsDet_SAP.Cantidad AS CIFEXTENDIDO, RP_REGGEN.dbo.oITM_From_SBO.ItemName, 
                      RP_REGGEN.dbo.oITM_From_SBO.U_VK_Marca, RP_REGGEN.dbo.RP_ReceiptsDet_SAP.Vendedor, RP_REGGEN.dbo.View_OMAR.Name, RP_REGGEN.dbo.RP_ReceiptsCab_SAP.TipoCambio, RP_REGGEN.dbo.RP_ReceiptsCab_SAP.NumeroDoctoRef, RP_REGGEN.dbo.RP_ReceiptsCab_SAP.Workstation
FROM         RP_REGGEN.dbo.RP_ReceiptsDet_SAP INNER JOIN
                      RP_REGGEN.dbo.RP_ReceiptsCab_SAP ON RP_REGGEN.dbo.RP_ReceiptsDet_SAP.ID = RP_REGGEN.dbo.RP_ReceiptsCab_SAP.ID INNER JOIN
                      RP_REGGEN.dbo.oITM_From_SBO ON RP_REGGEN.dbo.oITM_From_SBO.ItemCode COLLATE SQL_Latin1_General_CP1_CI_AS = RP_REGGEN.dbo.RP_ReceiptsDet_SAP.Sku LEFT OUTER JOIN
                      RP_REGGEN.dbo.View_OMAR ON RP_REGGEN.dbo.View_OMAR.Code = RP_REGGEN.dbo.oITM_From_SBO.U_VK_Marca
WHERE     (RP_REGGEN.dbo.RP_ReceiptsDet_SAP.Bodega = '".$modulo."') AND (RP_REGGEN.dbo.RP_ReceiptsCab_SAP.FechaDocto >= '".$finicio2." 00:00:00.000') AND (RP_REGGEN.dbo.RP_ReceiptsCab_SAP.FechaDocto <= '".$ffin2." 23:59:59.000')  
 ".$Wvendedor." ".$Wmarca." ".$Wcodbarra." ORDER BY RP_REGGEN.dbo.RP_ReceiptsCab_SAP.FechaDocto" ;

					
							//echo $sql;	
							$rs = odbc_exec( $conn, $sql );
							if ( !$rs )
							{
							exit( "Error en la consulta SQL" );
							}

							  while($resultado = odbc_fetch_array($rs)){ 
							  
							    
							  $tipoDocto = substr($resultado["NumeroDoctoRef"],0,1);
							  $caja = substr($resultado["NumeroDoctoRef"],1,1);
							  $bodega = substr($resultado["NumeroDoctoRef"],2,3);
							  $nroDocto = substr($resultado["NumeroDoctoRef"],5);
							  
							  if($resultado["TipoDocto"] == 1)
									{$tipoDoc=4;}
									
									if($resultado["TipoDocto"] == 4)
									{$tipoDoc=1;}
							  		
							  if ($resultado["TipoDocto"] == 3) // resaltar notas de credito
							  {
									echo '<tr style="background-color:#ffd6d2;" title="Anula Documento: '.$tipoDocto.'-'.$caja.'-'. $bodega.'-'. $nroDocto.' ">';
									$acumnotascredito= $acumnotascredito + $resultado["PrecioExtendido"];
									$acumnotascreditoUSD= $acumnotascreditoUSD + $resultado["USD"];
									$cantotalnotacredito = $cantotalnotacredito + $resultado["Cantidad"];
									$cantotalnotacreditoCIF = $cantotalnotacreditoCIF + $resultado["CIF"];
									$cantotalnotacreditoCIFEXT = $cantotalnotacreditoCIFEXT + $resultado["CIF"];
									
							  }
							  else if (verSiNulo($tipoDoc,$resultado["Workstation"],$resultado["Bodega"],$resultado["NumeroDocto"]) == 1) // resaltar notas de credito
							  {
									echo '<tr style="background-color:#bdd8e9;"  >';
								
								
							  }
							 else 
								{
									echo '<tr>';
								}
							  
							   
									echo '<td >'.$resultado["Fecha"].'</td>
									<td >'.$resultado["NumeroDocto"].'</td>
									<td >'.utf8_encode(getusuarioAir((int)$resultado["Vendedor"])).'</td>
									<td >'.$resultado["Sku"].'</td> 
									<td >'.utf8_encode($resultado["Name"]).'</td> 
									<td >'.utf8_encode($resultado["ItemName"]).'</td> 
									<td >'.number_format($resultado["Cantidad"], 0, '', '.').'</td> 
									<td ><strong>'.number_format($resultado["PrecioExtendido"], 0, '', '.').'</strong></td>
									<td >'.number_format($resultado["USD"], 2, ',', '.').'</td> 
									<td >'.number_format($resultado["CIF"], 2, ',', '.').'</td> 
									 ' ;/*<td >'.number_format($resultado["CIFEXTENDIDO"], 2, ',', '.').'</td>*/
							if ($resultado["TipoDocto"] != 3) // resaltar notas de credito
							  {
									$total = $total + $resultado["PrecioExtendido"];
									$cantotal = $cantotal + $resultado["Cantidad"];
									$totalUSD = $totalUSD + $resultado["USD"];
									$totalCIF = $totalCIF + $resultado["CIF"];
									$totalCIFEXT = $totalCIFEXT + $resultado["CIFEXTENDIDO"];
								}	
									
							 echo '</tr>';
								}
							

				?>
                </tbody>
                <tfoot>
                	<tr>
                    	<td colspan="11">Cantidad: <strong> <?php echo $cantotal-$cantotalnotacredito; ?></strong> Productos. --- TOTAL de: <strong>$<?php echo number_format($total-$acumnotascredito, 0, '', '.'); ?></strong> --- USD: <strong><?php echo number_format($totalUSD-$acumnotascreditoUSD, 2, ',', '.'); ?></strong> --- CIF: <strong><?php echo number_format($totalCIF-$acumnotascreditoCIF, 2, ',', '.'); ?></strong> --- TOTAL VENTAS CIF: <strong><?php echo number_format($totalCIFEXT-cantotalnotacreditoCIFEXT, 2, ',', '.'); ?></strong></td>
                    </tr>
                </tfoot>
            </table>
			
            


	<?php odbc_close( $conn );?>