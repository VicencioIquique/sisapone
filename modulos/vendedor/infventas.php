<?php 
require_once("clases/conexionocdb.php");
require_once("clases/funciones.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes



(INT)$modulo = $_GET['modulo'];
$finicio = $_GET['inicio'];
$ffin = $_GET['fin'];

 function cambiarFecha($fecha) {
					  return implode("-", array_reverse(explode("-", $fecha)));
					}
					$finicio2 = cambiarFecha($finicio);
					$ffin2 = cambiarFecha($ffin);
						
							
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
		      <li><a target="_blank" href="../SISAP/modulos/impresiones/infuno.php?modulo=<?php echo $modulo; ?>&inicio=<?php echo $finicio2; ?>&fin=<?php echo $ffin2; ?>"><img src="images/reports.png" width="30px" height="30px" /></a></li>
		<?php }?>
	 </ul>
      <div class="items">
        <div id="one"> <form action="" method="GET" id="horizontalForm">
            <fieldset>
				<legend>Ingresar Fechas</legend>
							 
							 <input name="opc" type="hidden" id="opc" size="40" class="required" value="infventa" />
							 
							 
						
							 
							 <?php
							 	if($_SESSION["usuario_modulo"] == -1)
								{
									
									echo '<label class="first" for="title1">
									Retail
									<select id="moduloid" name="modulo"    class="styled" >';
									if($modulo)
									{
										echo'<option value="'.$modulo.'" selected>'.getmodulo($modulo).'</option>';
									}
									
									echo'<option value="008">Modulo 2077</option>
									<option value="001">Modulo 1010</option>
									<option value="002">Modulo 1132</option>
									<option value="003">Modulo 181</option>
									<option value="004">Modulo 184</option>
									<option value="005">Modulo 2002</option>
									<option value="006">Modulo 6115</option>
									<option value="007">Modulo 6130</option>
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
							
							
							
                             <input name="agregar" type="submit" id="agregar" class="submit" value="Consultar" />

			</fieldset>
            </form>
         </div> <!-- fin div two-->
      </div> <!-- fin items -->
    </div> <!-- fin idTabs -->
        
 
                 <?php
				 
					

					$total =0;
					$cantotal =0;
					
	
$sql ="SELECT     TOP (100) PERCENT SUM(dbo.RP_ReceiptsDet_SAP.PrecioExtendido) AS Sumaventa, dbo.RP_ReceiptsDet_SAP.Bodega, dbo.RP_ReceiptsDet_SAP.TipoDocto, 
                      dbo.RP_ReceiptsDet_SAP.NumeroDocto AS NRODOCTO, CONVERT(varchar, dbo.RP_ReceiptsCab_SAP.FechaDocto, 103) AS Fecha, DATENAME(weekday, 
                      dbo.RP_ReceiptsCab_SAP.FechaDocto) AS DIA, dbo.RP_ReceiptsCab_SAP.RetencionDL18219 AS RETEN
FROM         dbo.RP_ReceiptsDet_SAP INNER JOIN
                      dbo.RP_ReceiptsCab_SAP ON dbo.RP_ReceiptsDet_SAP.ID = dbo.RP_ReceiptsCab_SAP.ID
WHERE     (CONVERT(datetime, dbo.RP_ReceiptsCab_SAP.FechaDocto, 103) >= '".$finicio2." 00:00:00.000') AND (CONVERT(datetime, dbo.RP_ReceiptsCab_SAP.FechaDocto, 103) 
                      <= '".$ffin2." 23:59:59.000') AND (CONVERT(INT, dbo.RP_ReceiptsDet_SAP.Bodega) = '".$modulo."')
GROUP BY dbo.RP_ReceiptsDet_SAP.Bodega, dbo.RP_ReceiptsDet_SAP.TipoDocto, dbo.RP_ReceiptsDet_SAP.NumeroDocto, dbo.RP_ReceiptsCab_SAP.FechaDocto, 
                      dbo.RP_ReceiptsCab_SAP.RetencionDL18219
ORDER BY NRODOCTO";


					
						//echo $sql;
							//echo " Aqui hay un error que se genera porque son muchos registros que se solicitan, y el tipo de variable solo permite ciertos byte mañana se analizará";	
							$rs = odbc_exec( $conn, $sql );
							if ( !$rs )
							{
							exit( "Error en la consulta SQL" );
							}
							
							$maxlun=$maxlun2=$maxmart=$maxmart2=$maxmier=$maxmier2=$maxjuev=$maxjuev2=$maxvier=$maxvier2=$maxsab=$maxsab2=$maxdom=$maxdom2 = -9999999;
							$minlun=$minlun2=$minmart=$minmart2=$minmier=$minmier2=$minjuev=$minjuev2=$minvier=$minvier2=$minsab=$minsab2=$mindom=$mindom2 =9999999;
							//$maxlun2 = -9999999;
							//$minlun2 =999999999999999;
							$acumlun=0;$acumlun2=$acumlun3 =0;$acummart=$acummart2=$acummart3 =0;$acummier=$acummier2=$acummier3 =0;$acumjuev=$acumjuev2=$acumjuev3 =0;$acumvier=$acumvier2=$acumvier3 =0;$acumsab=$acumsab2=$acumsab3 =0;$acumdom=$acumdom2=$acumdom3 =0;
							
							$acumreten1=$acumreten2=$acumreten3=0; // acumulador de ley de retencion 18219
							$retmon=$retmon2=$retmon3=0; // Lunes
							$rettus=$rettus2=$rettus3=0; // Martes
							$retwed=$retwed2=$retwed3=0; // Miercoles
							$rettur=$rettur2=$rettur3=0; // Jueves
							$retfri=$retfri2=$retfri3=0; // Viernes
							$retsat=$retsat2=$retsat3=0; // Sabado
							$retsun=$retsun2=$retsun3=0; // Domingo
							

							  while($resultado = odbc_fetch_array($rs)){ 
							 
									$total = $total + $resultado["Sumaventa"];
									$cantotal = $cantotal + $resultado["Cantidad"];
									$numerodocto =  intval($resultado["NRODOCTO"]);
									$nombredia = utf8_encode($resultado["DIA"]);
									
									if($resultado["TipoDocto"] == 1 || $resultado["TipoDocto"] == 4)
									{
										$acumreten1 = $acumreten1 + $resultado["RETEN"];
									}
									if($resultado["TipoDocto"] == 2)
									{
										$acumreten2 = $acumreten2 + $resultado["RETEN"];
									}
									if($resultado["TipoDocto"] == 3)
									{
										$acumreten3 = $acumreten3 + $resultado["RETEN"];
									}
		 
								
								if($nombredia == 'Monday')
								{
										
										if($resultado["TipoDocto"] == 1 || $resultado["TipoDocto"] == 4) // para encontrar el mayor y menor numero de documento
										{
											$acumlun = $acumlun + $resultado["Sumaventa"];
											$retmon = $retmon + $resultado["RETEN"];
												if($numerodocto>$maxlun && $resultado["TipoDocto"] == 1  )
												{
													$maxlun = $numerodocto;
												}
												if($numerodocto<$minlun && $resultado["TipoDocto"] == 1)
												{
													 $minlun = $numerodocto;
													
												}
										
									    }//fin if docto 1 -4
									
										 if($resultado["TipoDocto"] == 2) // para encontrar el mayor y menor numero de documento
										{
											$acumlun2 = $acumlun2 + $resultado["Sumaventa"];
											$retmon2 = $retmon2 + $resultado["RETEN"];
											if($numerodocto>$maxlun2)
											{
												$maxlun2 = $numerodocto;
											}
											if($numerodocto<$minlun2)
											{
												 $minlun2 = $numerodocto;
												
											}
											
										} //fin if docto2
										
										if($resultado["TipoDocto"] == 3) // para encontrar el mayor y menor numero de documento
										{
											$retmon3 = $retmon3 + $resultado["RETEN"];
											$acumlun3 = $acumlun3 + $resultado["Sumaventa"];
											
										} //fin if docto 3
								} // fin lunes
								
								if($nombredia == 'Tuesday')
								{
										
									if($resultado["TipoDocto"] == 1 || $resultado["TipoDocto"] == 4) // para encontrar el mayor y menor numero de documento
									{
										$acummart = $acummart + $resultado["Sumaventa"];
										$rettus = $rettus + $resultado["RETEN"];
										if($numerodocto>$maxmart && $resultado["TipoDocto"] == 1)
										{
											$maxmart = $numerodocto;
										}
										if($numerodocto<$minmart && $resultado["TipoDocto"] == 1)
										{
											 $minmart = $numerodocto;
											
										}
										
									}
									
									if($resultado["TipoDocto"] == 2 ) // para encontrar el mayor y menor numero de documento
									{
										$acummart2 = $acummart2 + $resultado["Sumaventa"];
										$rettus2 = $rettus2 + $resultado["RETEN"];
										if($numerodocto>$maxmart2)
										{
											$maxmart2 = $numerodocto;
										}
									    if($numerodocto<$minmart2)
										{
											 $minmart2 = $numerodocto;
											
										}
										
									}
									if($resultado["TipoDocto"] == 3) // para encontrar el mayor y menor numero de documento
									{
										$acummart3 = $acummart3 + $resultado["Sumaventa"];
										$rettus3 = $rettus3 + $resultado["RETEN"];
										
									} //fin if docto 3
								} //fin martes
								if($nombredia == 'Wednesday')
								{
									if($resultado["TipoDocto"] == 1 || $resultado["TipoDocto"] == 4) // para encontrar el mayor y menor numero de documento
									{
										$acummier = $acummier + $resultado["Sumaventa"];
										$retwed = $retwed + $resultado["RETEN"];
										if($numerodocto>$maxmier && $resultado["TipoDocto"] == 1)
										{
											$maxmier = $numerodocto;
										}
										if($numerodocto<$minmier && $resultado["TipoDocto"] == 1)
										{
											 $minmier = $numerodocto;
											
										}
										
									}
									
									if($resultado["TipoDocto"] == 2) // para encontrar el mayor y menor numero de documento
									{
										$acummier2 = $acummier2 + $resultado["Sumaventa"];
										$retwed2 = $retwed2 + $resultado["RETEN"];
										if($numerodocto>$maxmier2)
										{
											$maxmier2 = $numerodocto;
										}
									    if($numerodocto<$minmier2)
										{
											 $minmier2 = $numerodocto;
											
										}
										
									}
									if($resultado["TipoDocto"] == 3) // para encontrar el mayor y menor numero de documento
									{
										$acummier3 = $acummier3 + $resultado["Sumaventa"];
										$retwed3 = $retwed3 + $resultado["RETEN"];
										
									} //fin if docto 3
								} // fin miercoles
								if($nombredia == 'Thursday')
								{
										
									if($resultado["TipoDocto"] == 1 || $resultado["TipoDocto"] == 4) // para encontrar el mayor y menor numero de documento
									{
										$acumjuev = $acumjuev + $resultado["Sumaventa"];
										$rettur = $rettur + $resultado["RETEN"];
										if($numerodocto>$maxjuev && $resultado["TipoDocto"] == 1)
										{
											$maxjuev = $numerodocto;
										}
										if($numerodocto<$minjuev && $resultado["TipoDocto"] == 1)
										{
											 $minjuev = $numerodocto;
											
										}
										
									}
									
									if($resultado["TipoDocto"] == 2) // para encontrar el mayor y menor numero de documento
									{
										$acumjuev2 = $acumjuev2 + $resultado["Sumaventa"];
										$rettur2 = $rettur2 + $resultado["RETEN"];
										if($numerodocto>$maxjuev2)
										{
											$maxjuev2 = $numerodocto;
										}
									    if($numerodocto<$minjuev2)
										{
											 $minjuev2 = $numerodocto;
											
										}
										
									}
									if($resultado["TipoDocto"] == 3) // para encontrar el mayor y menor numero de documento
									{
										$acumjuev3 = $acumjuev3 + $resultado["Sumaventa"];
										$rettur3 = $rettur3 + $resultado["RETEN"];
										
									} //fin if docto 3
								} // fin jueves
								if($nombredia == 'Friday')
								{
										
									if($resultado["TipoDocto"] == 1 || $resultado["TipoDocto"] == 4) // para encontrar el mayor y menor numero de documento
									{
										$acumvier = $acumvier + $resultado["Sumaventa"];
										$retfri = $retfri + $resultado["RETEN"];
										if($numerodocto>$maxvier && $resultado["TipoDocto"] == 1)
										{
											$maxvier = $numerodocto;
										}
										if($numerodocto<$minvier && $resultado["TipoDocto"] == 1)
										{
											 $minvier = $numerodocto;
											
										}
										
									}
									
									if($resultado["TipoDocto"] == 2) // para encontrar el mayor y menor numero de documento
									{
										$acumvier2 = $acumvier2 + $resultado["Sumaventa"];
										$retfri2 = $retfri2 + $resultado["RETEN"];
										if($numerodocto>$maxvier2)
										{
											$maxvier2 = $numerodocto;
										}
									    if($numerodocto<$minvier2)
										{
											 $minvier2 = $numerodocto;
											
										}
										
									}
									if($resultado["TipoDocto"] == 3) // para encontrar el mayor y menor numero de documento
									{
										$acumvier3 = $acumvier3 + $resultado["Sumaventa"];
										$retfri3 = $retfri3 + $resultado["RETEN"];
										
									} //fin if docto 3
								} // viernes
								if($nombredia == 'Saturday')
								{
										
									if($resultado["TipoDocto"] == 1 || $resultado["TipoDocto"] == 4) // para encontrar el mayor y menor numero de documento
									{
										$acumsab = $acumsab + $resultado["Sumaventa"];
										$retsat = $retsat + $resultado["RETEN"];
										if($numerodocto>$maxsab && $resultado["TipoDocto"] == 1)
										{
											$maxsab = $numerodocto;
										}
										if($numerodocto<$minsab && $resultado["TipoDocto"] == 1)
										{
											 $minsab = $numerodocto;
											
										}
										
									}
									
									if($resultado["TipoDocto"] == 2) // para encontrar el mayor y menor numero de documento
									{
										$acumsab2 = $acumsab2 + $resultado["Sumaventa"];
										$retsat2 = $retsat2 + $resultado["RETEN"];
										if($numerodocto>$maxsab2)
										{
											$maxsab2 = $numerodocto;
										}
									    if($numerodocto<$minsab2)
										{
											 $minsab2 = $numerodocto;
											
										}
										
									}
									if($resultado["TipoDocto"] == 3) // para encontrar el mayor y menor numero de documento
									{
										$acumsab3 = $acumsab3 + $resultado["Sumaventa"];
										$retsat3 = $retsat3 + $resultado["RETEN"];
										
									} //fin if docto 3
								} // fin Sabado
								if($nombredia == 'Sunday')
								{
										
									if($resultado["TipoDocto"] == 1 || $resultado["TipoDocto"] == 4) // para encontrar el mayor y menor numero de documento
									{
										$acumdom = $acumdom + $resultado["Sumaventa"];
										$retsun = $retsun + $resultado["RETEN"];
										if($numerodocto>$maxdom && $resultado["TipoDocto"] == 1)
										{
											$maxdom = $numerodocto;
										}
										if($numerodocto<$mindom && $resultado["TipoDocto"] == 1)
										{
											 $mindom = $numerodocto;
											
										}
										
									}
									
									if($resultado["TipoDocto"] == 2) // para encontrar el mayor y menor numero de documento
									{
										$acumdom2 = $acumdom2 + $resultado["Sumaventa"];
										$retsun2 = $retsun2 + $resultado["RETEN"];
										if($numerodocto>$maxdom2)
										{
											$maxdom2 = $numerodocto;
										}
									    if($numerodocto<$mindom2)
										{
											 $mindom2 = $numerodocto;
											
										}
										
									}
									if($resultado["TipoDocto"] == 3) // para encontrar el mayor y menor numero de documento
									{
										$acumdom3 = $acumdom3 + $resultado["Sumaventa"];
										$retsun3 = $retsun3 + $resultado["RETEN"];
										
									} //fin if docto 3
								} // Total por Dias de la semana
					?>
				   <?php // echo '</tr>';
								} // fin while
							//Calculo el total de todos los medios por día
							$acumlunestotal = $acumlun + $acumlun2-$acumlun3;
							$acummartestotal = $acummart + $acummart2 -$acummart3;
							$acummiertotal = $acummier + $acummier2 -$acummier3 ;
							$acumjuevtotal = $acumjuev + $acumjuev2 - $acumjuev3;
							$acumviertotal = $acumvier + $acumvier2- $acumvier3;
							$acumsabtotal = $acumsab + $acumsab2 - $acumsab3;
							$acumdomtotal = $acumdom + $acumdom2 - $acumdom3;
							
							$TOTALBOLETA =  $acumlun + $acummart +$acummier+ $acumjuev +$acumvier +$acumsab +$acumdom - $acumlun3 - $acummart3 -$acummier3-$acumjuev3-$acumvier3 -$acumsab3 -$acumdom3;
							$TOTALFACT =  $acumlun2 + $acummart2 +$acummier2+ $acumjuev2 +$acumvier2 +$acumsab2 +$acumdom2;
							$TOTAL = $acumlunestotal +$acummartestotal+ $acummiertotal+ $acumjuevtotal+ $acumviertotal +$acumsabtotal +$acumdomtotal;
							$TOTALRET = (($retmon+$retmon2)-$retmon3)+(($rettus+$rettus2)-$rettus3)+(($retwed+$retwed2)-$retwed3)+(($rettur+$rettur2)-$rettur3)+(($retfri+$retfri2)-$retfri3)+(($retsat+$retsat2)-$retsat3)+(($retsun+$retsun2)-$retsun3);
							
							//echo $maxlun." menor ".$minlun." ".$acumlun." ".$acummart." ".$acummierc." ".$acumjuev." ".$acumvier." ".$acumsab." ".$acumdom;					
							if($maxlun == -9999999)$maxlun=0; if($minlun == 9999999)$minlun=0;
							if($maxmart == -9999999)$maxmart=0; if($minmart == 9999999)$minmart=0;
							if($maxmier == -9999999)$maxmier=0; if($minmier == 9999999)$minmier=0;
							if($maxjuev == -9999999)$maxjuev=0; if($minjuev == 9999999)$minjuev=0;
							if($maxvier == -9999999)$maxvier=0; if($minvier == 9999999)$minvier=0;
							if($maxsab == -9999999)$maxsab=0; if($minsab == 9999999)$minsab=0;
							if($maxdom == -9999999)$maxdom=0; if($mindom == 9999999)$mindom=0;
							//max min valores 2 facturas
							if($maxlun2 == -9999999)$maxlun2=0; if($minlun2 == 9999999)$minlun2=0;
							if($maxmart2 == -9999999)$maxmart2=0; if($minmart2 == 9999999)$minmart2=0;
							if($maxmier2 == -9999999)$maxmier2=0; if($minmier2 == 9999999)$minmier2=0;
							if($maxjuev2 == -9999999)$maxjuev2=0; if($minjuev2 == 9999999)$minjuev2=0;
							if($maxvier2 == -9999999)$maxvier2=0; if($minvier2 == 9999999)$minvier2=0;
							if($maxsab2 == -9999999)$maxsab2=0; if($minsab2 == 9999999)$minsab2=0;
							if($maxdom2 == -9999999)$maxdom2=0; if($mindom2 == 9999999)$mindom2=0;
							
							
							
						//echo $max2." menor ".$min2;

				?>
             <!--  </tbody>
                <tfoot>
                	<tr>
                    	<td colspan="5">Cantidad: <strong> <?php //echo $cantotal; ?></strong> Productos. - Con un TOTAL de: <strong><?php //echo number_format($total, 0, '', '.'); ?></strong></td>
                    </tr>
                </tfoot>
            </table>-->
            
            
             <table  id="ssptable" class="lista" >
              <thead>
                    <tr>
					    <th width="75" rowspan="2">Fecha</th>
                        <th colspan="2" align="center">Boleta</th>
                        <th width="64" colspan="2" align="center">Factura</th>
						<th width="38" colspan="2" align="center">SRF Modulo</th>
						<th width="38" colspan="2" align="center">Imp. Día</th>
						<th width="44" rowspan="2">Total</th>
                    </tr>
                    <tr>
                      <th>Total </th>
                      <th>Correlativo</th>
                      <th width="64">Total</th>
                      <th width="64">Correlativo</th>
                      <th width="38">Total</th>
                      <th width="38">Correlativo</th>
                       <th width="38"></th>
                    </tr>
                </thead>
                <tbody>
                 <tr>
									<td >Lunes</td>
							         <td width="15" > <?php echo number_format($acumlun-$acumlun3, 0, '', '.'); ?></td>
							         <td width="51" >  <?php echo $minlun; ?> -  <?php echo $maxlun; ?></td>
								     <td > <?php echo  number_format($acumlun2, 0, '', '.'); ?> </td>
								     <td ><?php echo $minlun2; ?> -  <?php echo $maxlun2; ?></td>
									<td colspan="2" >0</td>
									<td colspan="2" ><?php echo number_format(($retmon+$retmon2)-$retmon3, 0, '', '.'); ?></td>
									<td ><strong><?php echo number_format($acumlunestotal, 0, '', '.'); ?></strong></td> 							</tr><tr>
									<td >Martes</td>
							         <td ><?php echo number_format($acummart-$acummart3, 0, '', '.'); ?> </td>
							         <td ><?php echo $minmart; ?> -  <?php echo $maxmart; ?></td>
								     <td ><?php echo number_format($acummart2, 0, '', '.'); ?></td>
								     <td ><?php echo $minmart2; ?> -  <?php echo $maxmart2; ?></td>
									<td colspan="2" >0</td>
									 <td colspan="2" ><?php echo number_format(($rettus+$rettus2)-$rettus3, 0, '', '.'); ?></td>
									<td ><strong><?php echo number_format($acummartestotal, 0, '', '.'); ?></strong></td> 							</tr><tr>
									<td >Miercoles</td>
							         <td ><?php echo number_format($acummier-$acummier3, 0, '', '.'); ?></td>
							         <td ><?php echo $minmier; ?> -  <?php echo $maxmier; ?></td>
								     <td ><?php echo number_format($acummier2, 0, '', '.'); ?></td>
								     <td ><?php echo $minmier2; ?> -  <?php echo $maxmier2; ?></td>
									<td colspan="2" >0</td>
									 <td colspan="2" ><?php echo number_format(($retwed+$retwed2)-$retwed3, 0, '', '.'); ?></td>
									<td ><strong><?php echo number_format($acummiertotal, 0, '', '.'); ?></strong></td> 							</tr><tr>
									<td >Jueves</td>
							         <td ><?php echo number_format($acumjuev-$acumjuev3, 0, '', '.'); ?></td>
							         <td ><?php echo $minjuev; ?> -  <?php echo $maxjuev; ?></td>
								     <td ><?php echo number_format($acumjuev2, 0, '', '.'); ?></td>
							         <td ><?php echo $minjuev2; ?> -  <?php echo $maxjuev2; ?></td>
									<td colspan="2" >0</td>
									 <td colspan="2" ><?php echo number_format(($rettur+$rettur2)-$rettur3, 0, '', '.'); ?></td>
									<td ><strong><?php echo number_format($acumjuevtotal, 0, '', '.'); ?></strong></td> 							</tr><tr>
									<td >Viernes</td>
							         <td ><?php echo number_format($acumvier-$acumvier3, 0, '', '.'); ?></td>
							         <td ><?php echo $minvier; ?> -  <?php echo $maxvier; ?></td>
								     <td ><?php echo number_format($acumvier2, 0, '', '.'); ?></td>
							         <td ><?php echo $minvier2; ?> -  <?php echo $maxvier2; ?></td>
									<td colspan="2" >0</td>
									 <td colspan="2" ><?php echo number_format(($retfri+$retfri2)-$retfri3, 0, '', '.'); ?></td>
									<td ><strong><?php echo number_format($acumviertotal, 0, '', '.'); ?></strong></td> 							</tr><tr>
									<td >Sabado</td>
							         <td ><?php echo number_format($acumsab-$acumsab3, 0, '', '.'); ?></td>
							         <td ><?php echo $minsab; ?> -  <?php echo $maxsab; ?></td>
								     <td ><?php echo number_format($acumsab2, 0, '', '.'); ?></td>
							         <td ><?php echo $minsab2; ?> -  <?php echo $maxsab2; ?></td>
									<td colspan="2" >0</td>
									 <td colspan="2" ><?php echo number_format(($retsat+$retsat2)-$retsat3, 0, '', '.'); ?></td>
									<td ><strong><?php echo number_format($acumsabtotal, 0, '', '.'); ?></strong></td> 							</tr><tr>
									<td >Domingo</td>
							         <td ><?php echo number_format($acumdom-$acumdom3ss, 0, '', '.'); ?></td>
							         <td ><?php echo $mindom; ?> -  <?php echo $maxdom; ?></td>
								     <td ><?php echo number_format($acumdom2, 0, '', '.'); ?></td>
							         <td ><?php echo $mindom2; ?> -  <?php echo $maxdom2; ?></td>
									<td colspan="2" >0</td>
									 <td colspan="2" ><?php echo number_format(($retsun+$retsun2)-$retsun3, 0, '', '.'); ?></td>
									<td ><?php echo number_format($acumdomtotal, 0, '', '.'); ?></td> 							</tr>
                                    <tr >
                                      <td >Total Venta</td>
                                      <td colspan="2" ><strong><?php echo number_format($TOTALBOLETA, 0, '', '.'); ?></strong></td>
                                      <td colspan="2" ><strong><?php echo number_format($TOTALFACT, 0, '', '.'); ?></strong></td>
                                      <td colspan="2" >0</td>
                                       <td colspan="2" ><?php echo number_format($TOTALRET, 0, '', '.'); ?></td>
                                      <td ><strong><?php echo number_format($TOTAL, 0, '', '.'); ?></strong></td>
                                    </tr>
                                    <tr >
                                      <td >Menos Imp.</td>
                                      <td colspan="2" ><strong><?php echo number_format($acumreten1-$acumreten3, 0, '', '.'); ?></strong></td>
                                      <td colspan="2" ><strong><?php echo number_format($acumreten2, 0, '', '.'); ?></strong></td>
                                      <td colspan="2" >&nbsp;</td>
                                      <td colspan="2" >&nbsp;</td>
                                      <td ><strong><?php echo number_format(($acumreten2+$acumreten1)-$acumreten3, 0, '', '.'); ?></strong></td>
                                    </tr>
                                    <tr >
                                      <td >I.V.A. 18%</td>
                                      <td colspan="2" >&nbsp;</td>
                                      <td colspan="2" >&nbsp;</td>
                                      <td colspan="2" >&nbsp;</td>
                                       <td colspan="2">&nbsp;</td>
                                      <td >&nbsp;</td>
                                    </tr>
                                    <tr >
                                      <td >Venta Neta</td>
                                      <td colspan="2" ><strong><?php echo number_format($TOTALBOLETA-($acumreten1-$acumreten3), 0, '', '.'); ?></strong></td>
                                      <td colspan="2" ><strong><?php echo number_format($TOTALFACT-($acumreten2), 0, '', '.'); ?></strong></td>
                                      <td colspan="2" ></td>
                                      <td colspan="2" >&nbsp;</td>
                                      <td ><strong><?php echo number_format(($TOTALBOLETA-($acumreten1-$acumreten3)+($TOTALFACT-($acumreten2))), 0, '', '.'); ?></strong></td>
                                    </tr>
               </tbody>
                <tfoot>
                	<tr>
                    	<td colspan="9">&nbsp;</td>
                    </tr>
                </tfoot>
            </table>

			

			
            


	<?php odbc_close( $conn );?>