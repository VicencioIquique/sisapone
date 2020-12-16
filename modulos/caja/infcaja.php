<?php 

require_once("clases/conexionocdb.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes

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

switch ($modulo) {
	case '007':
        $bodega = "ZFI.6130";
        break;
	case '006':
        $bodega = "ZFI.6115";
        break;
	case '005':
        $bodega = "ZFI.2002";
        break;
	case '004':
        $bodega = "ZFI.184";
        break;
	case '003':
        $bodega = "ZFI.181";
        break;
	case '002':
        $bodega = "ZFI.1132";
        break;
	case '001':
        $bodega = "ZFI.1010";
        break;
	case '000':
        $bodega = "ZFI.2077";
        break;
}



/************************************** fin privilegio de modulo *****************************/
$finicio = $_GET['inicio'];
$mes = substr($finicio, 0, 2);
$dia   = substr($finicio, 3, 2);
$ano = substr($finicio, 6, 4);

if($finicio != ""){
	$fecha = $dia."/".$mes."/".$ano;
	$fecha2 = $ano."-".$mes."-".$dia;
}
					
					$sql ="SELECT SUM(dbo.RP_ReceiptsDet_SAP.PrecioExtendido) AS Sumaventa, dbo.RP_ReceiptsDet_SAP.Bodega, dbo.RP_ReceiptsDet_SAP.TipoDocto, 
                      dbo.RP_ReceiptsDet_SAP.NumeroDocto AS NRODOCTO, CONVERT(varchar, dbo.RP_ReceiptsCab_SAP.FechaDocto, 103) AS Fecha, DATENAME(weekday, 
                      dbo.RP_ReceiptsCab_SAP.FechaDocto) AS DIA, dbo.RP_ReceiptsCab_SAP.RetencionDL18219 AS RETEN, dbo.RP_ReceiptsCab_SAP.Workstation

FROM         dbo.RP_ReceiptsDet_SAP INNER JOIN
                      dbo.RP_ReceiptsCab_SAP ON dbo.RP_ReceiptsDet_SAP.ID = dbo.RP_ReceiptsCab_SAP.ID
WHERE CONVERT(varchar,dbo.RP_ReceiptsCab_SAP.FechaDocto,103) LIKE '".$fecha."' AND (CONVERT(INT, dbo.RP_ReceiptsDet_SAP.Bodega) = '".$modulo."')
GROUP BY dbo.RP_ReceiptsDet_SAP.Bodega, dbo.RP_ReceiptsDet_SAP.TipoDocto, dbo.RP_ReceiptsDet_SAP.NumeroDocto, dbo.RP_ReceiptsCab_SAP.FechaDocto, 
                      dbo.RP_ReceiptsCab_SAP.RetencionDL18219, dbo.RP_ReceiptsCab_SAP.Workstation

ORDER BY NRODOCTO"; // para ver las boletas, facturas y srf!




$sql2="SELECT    SUM(dbo.RP_ReceiptsPagos_SAP.Monto) AS TOTAL, dbo.RP_ReceiptsPagos_SAP.FechaDoc, dbo.RP_ReceiptsPagos_SAP.TipoPago, 
                      dbo.RP_ReceiptsPagos_SAP.WorkStation, dbo.RP_ReceiptsCab_SAP.FechaDocto, DATEDIFF(day, dbo.RP_ReceiptsCab_SAP.FechaDocto, 
                      dbo.RP_ReceiptsPagos_SAP.FechaDoc) AS Dias, dbo.RP_ReceiptsCab_SAP.RutCliente
FROM         dbo.RP_ReceiptsPagos_SAP INNER JOIN
                      dbo.RP_ReceiptsCab_SAP ON dbo.RP_ReceiptsPagos_SAP.ID = dbo.RP_ReceiptsCab_SAP.ID
WHERE     (dbo.RP_ReceiptsCab_SAP.FechaDocto >= '".$fecha2." 00:00:00.000') AND (dbo.RP_ReceiptsCab_SAP.FechaDocto <= '".$fecha2." 23:59:59.000') AND 
                      (dbo.RP_ReceiptsPagos_SAP.Bodega LIKE '".$modulo."') AND (dbo.RP_ReceiptsPagos_SAP.TipoDocto NOT LIKE 3)
GROUP BY dbo.RP_ReceiptsPagos_SAP.TipoDocto, dbo.RP_ReceiptsPagos_SAP.FechaDoc, dbo.RP_ReceiptsPagos_SAP.TipoPago, dbo.RP_ReceiptsPagos_SAP.WorkStation, 
                      dbo.RP_ReceiptsCab_SAP.FechaDocto, dbo.RP_ReceiptsCab_SAP.RutCliente
ORDER BY dbo.RP_ReceiptsPagos_SAP.TipoDocto, dbo.RP_ReceiptsPagos_SAP.TipoPago"; // para ver los medios de pago

$sql3="SELECT     TOP (100) PERCENT SUM(dbo.RP_ReceiptsPagos_SAP.Monto) AS TOTAL, CONVERT(varchar, dbo.RP_ReceiptsPagos_SAP.FechaDoc, 103) AS fpago, 
                      dbo.RP_ReceiptsPagos_SAP.TipoPago, dbo.RP_ReceiptsPagos_SAP.WorkStation, CONVERT(varchar, dbo.RP_ReceiptsCab_SAP.FechaDocto, 103) AS fcompra, DATEDIFF(day, dbo.RP_ReceiptsCab_SAP.FechaDocto, dbo.RP_ReceiptsPagos_SAP.FechaDoc) AS Dias, dbo.RP_ReceiptsCab_SAP.RutCliente, 
                      dbo.RP_ReceiptsPagos_SAP.NumeroDoc
FROM         dbo.RP_ReceiptsPagos_SAP INNER JOIN
                      dbo.RP_ReceiptsCab_SAP ON dbo.RP_ReceiptsPagos_SAP.ID = dbo.RP_ReceiptsCab_SAP.ID
WHERE     (dbo.RP_ReceiptsCab_SAP.FechaDocto >= '".$fecha2." 00:00:00.000') AND (dbo.RP_ReceiptsCab_SAP.FechaDocto <= '".$fecha2." 23:59:59.000') AND 
                      (dbo.RP_ReceiptsPagos_SAP.Bodega LIKE '".$modulo."') AND (dbo.RP_ReceiptsPagos_SAP.TipoDocto NOT LIKE 3)AND 
                      (dbo.RP_ReceiptsPagos_SAP.TipoPago LIKE 'Payments')
GROUP BY dbo.RP_ReceiptsPagos_SAP.TipoDocto, dbo.RP_ReceiptsPagos_SAP.FechaDoc, dbo.RP_ReceiptsPagos_SAP.TipoPago, dbo.RP_ReceiptsPagos_SAP.WorkStation, 
                      dbo.RP_ReceiptsCab_SAP.FechaDocto, dbo.RP_ReceiptsCab_SAP.RutCliente, dbo.RP_ReceiptsPagos_SAP.NumeroDoc

ORDER BY dbo.RP_ReceiptsPagos_SAP.TipoDocto, dbo.RP_ReceiptsPagos_SAP.TipoPago,Dias";

				 
$sql4= "SELECT [Workstation]
      ,CASE [TipoDocto]
         WHEN 1 THEN 'BF'
         WHEN 4 THEN 'BM'
         WHEN 3 THEN 'NC'
       END                   [TipoDocto]
      ,MIN(CONVERT(int,[DocNum]))         [Min]
      ,MAX(CONVERT(int,[DocNum]))         [Max]
      ,SUM([Cantidad])       [Cantidad]
      ,SUM([TotalCLP])       [TotalCLP]
      ,SUM([TotalCIF])       [TotalCIF]
      ,SUM([TotalUSD])       [TotalUSD]
      ,SUM([RetencionDL])    [RetencionDL]
  FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_VW_VtasD_RPRO]
  WHERE CONVERT(varchar,[DocDate],103) LIKE '".$fecha."'
  AND WhsCode LIKE '".$bodega."'
  GROUP BY [Workstation]
          ,[TipoDocto]
  ORDER BY Workstation";
  
 /* $sql4="SELECT [WorkStation]
      ,CASE [TipoDocto]
         WHEN 1 THEN 'BF'
         WHEN 4 THEN 'BM'
         WHEN 3 THEN 'NC'
       END                   [TipoDocto]
      ,MIN(CONVERT(int,[NumeroDocto])) [Min]
      ,MAX(CONVERT(int,[NumeroDocto])) [Max]
      ,SUM([Monto]) [TotalCLP]
  FROM [RP_VICENCIO].[dbo].[RP_ReceiptsPagos_SAP]
  WHERE CONVERT(varchar,[FechaDoc],103) LIKE '09/10/2015' AND Bodega LIKE '002'
  GROUP BY [WorkStation], [TipoDocto]
  ORDER BY Workstation";*/

$sql5= "SELECT RPAG.TipoPago
      ,RPAG.Descripcion1
      ,MIN(CONVERT(int,RPRV.[DocNum]))         [Min]
      ,MAX(CONVERT(int,RPRV.[DocNum]))         [Max]
      ,SUM(RPRV.[Cantidad])       [Cantidad]
      ,SUM(RPRV.[TotalCLP])       [TotalCLP]
      ,SUM(RPRV.[TotalCIF])       [TotalCIF]
      ,SUM(RPRV.[TotalUSD])       [TotalUSD]
      ,SUM(RPRV.[RetencionDL])    [RetencionDL]
  FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_VW_VtasD_RPRO] RPRV
  INNER JOIN RP_VICENCIO.dbo.RP_ReceiptsPagos_SAP RPAG ON RPRV.TransId = RPAG.ID 
  WHERE CONVERT(varchar,RPRV.DocDate,103) LIKE '".$fecha."'
  AND WhsCode LIKE '".$bodega."'
  GROUP BY RPAG.TipoPago
          ,RPAG.Descripcion1";

?>
<script type="text/javascript">
  $(document).ready(function(){
				//comienza focus en modulo
				$('#moduloid').focus();
				// calendarios en text de fecha inicio fin
				$( "#inicio" ).datepicker( );
				//formatos de las fechas
			   //$('#inicio').datepicker('option', {dateFormat: 'dd/mm/yy'});
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
		      <li><a target="_blank" href="../SISAP/modulos/impresiones/infcajapdf.php?modulo=<?php echo $modulo; ?>&inicio=<?php echo $finicio2; ?>&fin=<?php echo $ffin2; ?>"><img src="images/reports.png" width="30px" height="30px" /></a></li>
		<?php }?>
	 </ul>
      <div class="items">
        <div id="one"> <form action="" method="GET" id="horizontalForm">
            <fieldset>
				<legend>Ingresar Fechas</legend>
							 
							 <input name="opc" type="hidden" id="opc" size="40" class="required" value="infcaja" />
							 
							 
						
							 
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
									
									echo'
									<option value="000">Modulo 2077</option>
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
					            Fecha
                            <input name="inicio" type="text" id="inicio" size="40" class="required" value="<?php echo $finicio;?>"  />
                            </label>
						
							
							
							
              <input name="agregar" type="submit" id="agregar" class="submit" value="Consultar" />

			</fieldset>
            </form>
         </div> <!-- fin div two-->3
      </div> <!-- fin items -->
    </div> <!-- fin idTabs -->
        
        
           


	<div id="usual1" class="usual" > 
  <ul> 
    <li ><a id="tabdua" href="#tab1" class="selected">Caja</a></li> 
    <li ><a id="tabdua" href="#tab2">Detalle Cheques</a></li> 
  </ul> 
  
<div id="tab1">
	
 <?php /************************************************************************* Inicio Ventas por factura Boleta SF **********************************/
					$total =0;
					$cantotal =0;
	
							$rs = odbc_exec( $conn, $sql );
							if ( !$rs )
							{
								exit( "Error en la consulta SQL" );
							}
							
							$maxlun=$maxlun2=$maxlun4=$maxmart=$maxmart4=$maxmart2=$maxmier=$maxmier2=$maxjuev=$maxjuev2=$maxvier=$maxvier2=$maxsab=$maxsab2=$maxdom=$maxdom2=$maxstd=$maxstd2 = -9999999;
							$minlun=$minlun2=$minlun4=$minmart=$minmart4=$minmart2=$minmier=$minmier2=$minjuev=$minjuev2=$minvier=$minvier2=$minsab=$minsab2=$mindom=$mindom2=$minstd=$minstd2 =9999999;
							//$maxlun2 = -9999999;
							//$minlun2 =999999999999999;
							$acumlun=0;$acumlun2=$acumlun3 =0;$acummart=$acummart2=$acummart3 =0;$acummier=$acummier2=$acummier3 =0;$acumjuev=$acumjuev2=$acumjuev3 =0;$acumvier=$acumvier2=$acumvier3 =0;$acumsab=$acumsab2=$acumsab3 =0;$acumdom=$acumdom2=$acumdom3 =0;$acumstd=$acumstd2=$acumstd3 =0;
							
							$acumreten1=$acumreten2=$acumreten3=0; // acumulador de ley de retencion 18219
							
							$notaCreditoCaja1=$notaCreditoCaja2=$notaCreditoCaja8=0;
							

							  while($resultado = odbc_fetch_array($rs)){ 
							   /*echo '<tr>
									<td >'.$resultado["FechaDoc"].'</td>
							         <td >'.utf8_encode($resultado["TipoDocto"]).'</td>
									<td >'.number_format($resultado["TOTAL"], 0, '', '.').'</td> ' ;*/
									
									
									$total = $total + $resultado["Sumaventa"];
									$cantotal = $cantotal + $resultado["Cantidad"];
									$numerodocto =  intval($resultado["NRODOCTO"]);
									$nombredia = utf8_encode($resultado["DIA"]);
									$caja = $resultado["Workstation"];
									
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

		 					if($nombredia)
								{
										
										if($resultado["TipoDocto"] == 1 || $resultado["TipoDocto"] == 4) // para encontrar el mayor y menor numero de documento
										{
										$acumstd = $acumstd + $resultado["Sumaventa"];
										if($numerodocto>$maxstd && $resultado["TipoDocto"] == 1  )
										{
											$maxstd = $numerodocto;
										}
										if($numerodocto<$minstd && $resultado["TipoDocto"] == 1)
										{
											 $minstd = $numerodocto;
											
										}
										
									}//fin if docto 1 -4
									
									 if($resultado["TipoDocto"] == 2) // para encontrar el mayor y menor numero de documento
									{
										$acumstd2 = $acumstd2 + $resultado["Sumaventa"];
										if($numerodocto>$maxstd2)
										{
											$maxstd2 = $numerodocto;
										}
									    if($numerodocto<$minstd2)
										{
											 $minstd2 = $numerodocto;
											
										}
										
									} //fin if docto2
									
									if($resultado["TipoDocto"] == 3) // para encontrar el mayor y menor numero de documento
									{
										if($resultado["Workstation"]==1) // notas de credito por caja
										{
											$notaCreditoCaja1 =  $notaCreditoCaja1 + $resultado["Sumaventa"];
										}
										if($resultado["Workstation"]==2)
										{
											 $notaCreditoCaja2 =  $notaCreditoCaja2 + $resultado["Sumaventa"];
										}
										if($resultado["Workstation"]==8)
										{
											 $notaCreditoCaja8 =  $notaCreditoCaja8 + $resultado["Sumaventa"];
										}
									
										$acumstd3 = $acumstd3 + $resultado["Sumaventa"];
										
									} //fin if docto 3
								} // fin lunes
								
		 
								if($caja == 1)
								{
										
										if($resultado["TipoDocto"] == 1 ) // para encontrar el mayor y menor numero de documento
										{
										$acumlun = $acumlun + $resultado["Sumaventa"];
										if($numerodocto>$maxlun && $resultado["TipoDocto"] == 1  )
										{
											$maxlun = $numerodocto;
										}
										if($numerodocto<$minlun && $resultado["TipoDocto"] == 1)
										{
											 $minlun = $numerodocto;
											
										}
										
										
									}//fin if docto 1 -4
									
									if( $resultado["TipoDocto"] == 4) // para encontrar el mayor y menor boleta manual
										{
											$acumlun4 = $acumlun4 + $resultado["Sumaventa"];
											if($numerodocto>$maxlun4 && $resultado["TipoDocto"] == 4  )
											{
												$maxlun4 = $numerodocto;
											}
											if($numerodocto<$minlun4 && $resultado["TipoDocto"] == 4)
											{
												 $minlun4 = $numerodocto;
												
											}
										}
									
									 if($resultado["TipoDocto"] == 2) // para encontrar el mayor y menor numero de documento
									{
										$acumlun2 = $acumlun2 + $resultado["Sumaventa"];
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
										$acumlun3 = $acumlun3 + $resultado["Sumaventa"];
										
									} //fin if docto 3
								} // fin lunes
								if($caja == 2)
								{
										
									if($resultado["TipoDocto"] == 1 ) // para encontrar el mayor y menor numero de documento
									{
										$acummart = $acummart + $resultado["Sumaventa"];
										if($numerodocto>$maxmart && $resultado["TipoDocto"] == 1)
										{
											$maxmart = $numerodocto;
										}
										if($numerodocto<$minmart && $resultado["TipoDocto"] == 1)
										{
											 $minmart = $numerodocto;
											
										}
										
									}
									
									if( $resultado["TipoDocto"] == 4) // para encontrar el mayor y menor boleta manual
										{
											$acummart4 = $acummart4 + $resultado["Sumaventa"];
											if($numerodocto>$maxmart4 && $resultado["TipoDocto"] == 4  )
											{
												$maxmart4 = $numerodocto;
											}
											if($numerodocto<$minmart4 && $resultado["TipoDocto"] == 4)
											{
												 $minmart4 = $numerodocto;
												
											}
										}
									
									if($resultado["TipoDocto"] == 2 ) // para encontrar el mayor y menor numero de documento
									{
										$acummart2 = $acummart2 + $resultado["Sumaventa"];
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
										
									} //fin if docto 3
								} //fin martes
								if($caja == 8)
								{
									if($resultado["TipoDocto"] == 1 || $resultado["TipoDocto"] == 4) // para encontrar el mayor y menor numero de documento
									{
										$acummier = $acummier + $resultado["Sumaventa"];
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
										
									} //fin if docto 3
								} // fin miercoles
								if($nombredia == 'Thursday')
								{
										
									if($resultado["TipoDocto"] == 1 || $resultado["TipoDocto"] == 4) // para encontrar el mayor y menor numero de documento
									{
										$acumjuev = $acumjuev + $resultado["Sumaventa"];
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
										
									} //fin if docto 3
								} // fin jueves
								if($nombredia == 'Friday')
								{
										
									if($resultado["TipoDocto"] == 1 || $resultado["TipoDocto"] == 4) // para encontrar el mayor y menor numero de documento
									{
										$acumvier = $acumvier + $resultado["Sumaventa"];
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
										
									} //fin if docto 3
								} // viernes
								if($nombredia == 'Saturday')
								{
										
									if($resultado["TipoDocto"] == 1 || $resultado["TipoDocto"] == 4) // para encontrar el mayor y menor numero de documento
									{
										$acumsab = $acumsab + $resultado["Sumaventa"];
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
										
									} //fin if docto 3
								} // fin Sabado
								if($nombredia == 'Sunday')
								{
										
									if($resultado["TipoDocto"] == 1 || $resultado["TipoDocto"] == 4) // para encontrar el mayor y menor numero de documento
									{
										$acumdom = $acumdom + $resultado["Sumaventa"];
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
										
									} //fin if docto 3
								} // Total por Dias de la semana
							  }
					?>
				
            
             <table  id="ssptable" class="lista" >
              <thead>
                    <tr>
                        <th width="114" rowspan="2">Caja</th>
					    <th width="114" rowspan="2">Tipo Doc.</th>
                        <th width="144" colspan="2" align="center">Desde</th>
                        <th colspan="2" align="center">Hasta</th>
						<th width="200" rowspan="2">ESTA CAJA ESTA CUADRADA</th>
                    </tr>
                    <tr>
 
                    </tr>
                </thead>
                <tbody>
     				  <tr >
                                      <td id="celdcolor" >Venta Boletas</td>
                                      <td colspan="2" align="center" >&nbsp;</td>
                                      <td colspan="2" align="center" >&nbsp;</td>                                      <td >&nbsp;</td>
                                      <td >&nbsp;</td>
                      </tr>
                 <?php
				$rs4= odbc_exec( $conn, $sql4 );
							if ( !$rs4 )
							{
								exit( "Error en la consulta SQL" );
							}
				  $CreditoTienda=$TotalIngreso = 0;
				  while($row = odbc_fetch_array($rs4)){ 
				         echo'<tr >
						              <td  ></td>
                                      <td  >Caja: '.$row["Workstation"].' '.$row["TipoDocto"].'</td>
                                      <td colspan="2" align="center" >'.$row["Min"].'</td>
                                      <td colspan="2" align="center" >'.$row["Max"].'</td>                                      
									  <td >'.number_format($row["TotalCLP"], 0, ',', '.').'</td>
                             </tr>';
					    if($row["TipoDocto"] == "NC"){
						 	$CreditoTienda = $CreditoTienda + $row["TotalCLP"];
						 }
						 $TotalIngreso = $TotalIngreso + $row["TotalCLP"];
				  }
				?>             
                             <tr >
						              <td  ></td>
                                      <td  ></td>
                                      <td colspan="2" align="center" ></td>                                     
                                      <td colspan="2" id="celdcolor" >TOTAL INGRESO</td>
									  <td  id="celdcolor2" ><strong><?php echo number_format($TotalIngreso, 0, ',', '.'); ?></strong></td>
                             </tr>                     
               </tbody>
                <tfoot>
                	<tr>
                    	
                    </tr>
                </tfoot>
            </table>
  
  <?php // tabla que mustra el detalle de tipo de medio de pago
					
				$rs2 = odbc_exec( $conn, $sql2 );
							if ( !$rs2 )
							{
								exit( "Error en la consulta SQL" );
							}
							 $total1 =0;
							 $cash=$tCredito=$tDebito=$chequealdia=$chequeafecha = 0;
							  while($resultado2 = odbc_fetch_array($rs2)){ 
							  		
									if($resultado2["TipoPago"]=="Cash")
									{
										$cash =  $cash + $resultado2["TOTAL"];
									}
									
									if($resultado2["TipoPago"]=="CreditCard")
									{
										$tCredito = $tCredito + $resultado2["TOTAL"];
									}
									
														
									if($resultado2["TipoPago"]=="DebitCard")
									{
										$tDebito = $tDebito + $resultado2["TOTAL"];
									}
									 if($resultado2["TipoPago"]=="Payments")
									{
											
											
											if( $resultado2["Dias"]>0)
											{
																				
												$chequeafecha = $chequeafecha + $resultado2["TOTAL"];
											
											}	
											
											if( $resultado2["Dias"]==0)
											{
																				
												$chequealdia = $chequealdia + $resultado2["TOTAL"];
											
											}
									
									
									}
									
									
				 	
									 //$total1 = $total1 + $resultado2["TOTAL"];
								} // fin while
									
								$depositoDia = $cash+$chequealdia;
								$depositoPendiente= $tCredito+$tDebito+$chequeafecha;

				$rs4 = odbc_exec( $conn, $sql5 );
							if ( !$rs4)
							{
								exit( "Error en la consulta SQL" );
							}
							
							 $ConvenioPersonal= 0;
							  while($resultado4 = odbc_fetch_array($rs4)){ 
									if($resultado4["TipoPago"]=="CreditCard")
									{
										if($resultado4["Descripcion1"]=="Person"){
											$ConvenioPersonal = $ConvenioPersonal + $resultado4["TotalCLP"];
										}
									}
								} // fin while
									$tCredito = $tCredito - $ConvenioPersonal;
				
?> <!-- php de la primera tabla de arriba o abajo en realidad da igual la cosa es separar-->      
<!-- tabla numero 2 ****************************************************************************************************************************-->     
  <table  id="ssptable" class="lista" >
              <thead>
                    <tr>
					    <th width="238" >2.- Depositos por venta del dia</th>
                        <th width="144" colspan="2" align="center"></th>
                        <th colspan="2" align="center"></th>
						<th width="200" ></th>
                    </tr>
                    <tr>
 
                    </tr>
    </thead>
                <tbody>
     				  <tr >
                                      <td id="celdcolor" >Efectivo</td>
                                      <td colspan="2" align="center" >&nbsp;</td>
                                      <td colspan="2" align="center" >&nbsp;</td>
                                      
                                      <td ><?php echo number_format($cash, 0, '', '.'); ?></td>
                  </tr>
                                    <tr >
                                      <td id="celdcolor" >Efectivo US$</td>
                                      <td colspan="2" align="center" >&nbsp;</td>
                                      <td colspan="2" align="left" >TC$</td>
                                     
                                      <td >&nbsp;</td>
                                    </tr>
                                    <tr >
                                      <td id="celdcolor" >Cheques</td>
                                      <td colspan="2" align="center" >&nbsp;</td>
                                      <td colspan="2" align="center" >&nbsp;</td>
                                      
                                      <td ><?php echo number_format($chequealdia, 0, '', '.'); ?></td>
                                    </tr>
                                    <tr >
                                      <td id="celdcolor" >cheques bco. chile</td>
                                      <td colspan="2" >&nbsp;</td>
                                      <td colspan="2" >&nbsp;</td>
                                     
                                      <td >&nbsp;</td>
                                    </tr>
                                    <tr >
                                      <td id="celdcolor" >cheques otros bancos</td>
                                      <td colspan="2" >&nbsp;</td>
                                      <td colspan="2" >&nbsp;</td>
                                      <td >&nbsp;</td>
                                    </tr>
                                   
                                    <tr >
                                      <td >&nbsp;</td>
                                      <td colspan="2" >&nbsp;</td>
                                      <td colspan="2" id="celdcolor" >TOTAL DEPOSITO</td>
                                      <td ><strong><?php echo number_format($depositoDia, 0, '', '.'); ?></strong></td>
                                    </tr>
                                  
               </tbody>
                <tfoot>
                	<tr>
                    	
                    </tr>
                </tfoot>
  </table>
            
<!-- FIN tabla numero 2 ****************************************************************************************************************************-->       

<!-- tabla numero 3 ****************************************************************************************************************************-->     
<table  id="ssptable" class="lista" >
              <thead>
                    <tr>
					    <th width="253" >3.- Depositos pendientes por credito</th>
                        <th width="142" colspan="2" align="center"></th>
                        <th colspan="2" align="center"></th>
						<th width="200" ></th>
                    </tr>
                    <tr>
 
                    </tr>
    </thead>
                <tbody>
     				  <tr >
                                      <td id="celdcolor" >Tarjetas de credito</td>
                                      <td colspan="2" align="center" >&nbsp;</td>
                                      <td colspan="2" align="center" >&nbsp;</td>
                                      
                                      <td ><?php echo number_format($tCredito, 0, '', '.'); ?></td>
                  </tr>
                                    <tr >
                                      <td id="celdcolor" >Tarjetas de debito</td>
                                      <td colspan="2" align="center" >&nbsp;</td>
                                      <td colspan="2" align="left" >&nbsp;</td>
                                     
                                      <td ><?php echo number_format($tDebito, 0, '', '.'); ?></td>
                                    </tr>
                                    <tr >
                                      <td id="celdcolor" >Cheques a fecha</td>
                                      <td colspan="2" align="center" >&nbsp;</td>
                                      <td colspan="2" align="center" >&nbsp;</td>
                                      
                                      <td ><?php echo number_format($chequeafecha, 0, '', '.'); ?></td>
                                    </tr>
                                    <tr >
                                      <td id="celdcolor" >Convenios Personales</td>
                                      <td colspan="2" align="center" >&nbsp;</td>
                                      <td colspan="2" align="center" >&nbsp;</td>
                                      
                                      <td ><?php echo number_format($ConvenioPersonal, 0, '', '.'); ?></td>
                                    </tr>
                                    <tr >
                                      <td id="celdcolor" >Credito Tienda</td>
                                      <td colspan="2" align="center" >&nbsp;</td>
                                      <td colspan="2" align="center" >&nbsp;</td>
                                      
                                      <td ><?php echo number_format($CreditoTienda, 0, '', '.'); ?></td>
                                    </tr>
                                    <tr >
                                      <td id="celdcolor" >Vales - Otros</td>
                                      <td colspan="2" >&nbsp;</td>
                                      <td colspan="2" >&nbsp;</td>
                                     
                                      <td >&nbsp;</td>
                                    </tr>
                                    <tr >
                                      <td >&nbsp;</td>
                                      <td colspan="2" >&nbsp;</td>
                                      <td colspan="2" id="celdcolor" >TOTAL Creditos&nbsp;</td>
                                      <td ><strong><?php echo number_format($depositoPendiente+$CreditoTienda, 0, '', '.'); ?></strong></td>
                                    </tr>
                                    <tr >
                                      <td >&nbsp;</td>
                                      <td colspan="2" >&nbsp;</td>
                                      <td colspan="2"  ></td>
                                      <td id="celdcolor2" ><strong><?php echo number_format(($depositoDia+$depositoPendiente)+$CreditoTienda, 0, '', '.');?></strong></td>
                                    </tr>
                                  
               </tbody>
                <tfoot>
                	<tr>
                    	
                    </tr>
                </tfoot>
  </table>
            

<!-- FIN tabla numero 3 ****************************************************************************************************************************-->           
<!-- ************************************************************************Fin Cuadre Caja Boletafactura SRF ******************************-->
</div> <!-- fin de detalle de cierre de caja-->
 

<div id="tab2">
  <table  id="ssptable" class="lista">
              <thead>
                    <tr>
                        <th>Fecha Emision</th>
						<th>Tipo Cheque</th>
                        <th>Nro° Documento</th>
                        <th>Rut Cliente</th>
                        <th>Fecha Pago</th>
                        <th>Dias</th>
                         <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                 <?php
				 
								
					$total =0;
					$cantotal =0;
					
		
			
							//echo $sql;	
							$rs3 = odbc_exec( $conn, $sql3 );
							if ( !$rs3 )
							{
							exit( "Error en la consulta SQL" );
							}

							  while($result = odbc_fetch_array($rs3)){ 
							  
							  if($result["TipoPago"]=="Payments")$tipoPago="Cheque";
							  
							  
							   echo '<tr>
									<td >'.$result["fcompra"].'</td>
									<td >';
									 if($result["Dias"] ==0)echo'Cheque al Dia';
					                 else echo 'Cheque a Fecha';
									 echo'.</td>
									 <td >'.$result["NumeroDoc"].'</td>
									<td >'.$result["RutCliente"].'</td>
									<td >'.$result["fpago"].'</td>
									<td >'.$result["Dias"].'</td>
									<td ><strong>'.number_format($result["TOTAL"], 0, '', '.').'</strong></td> ' ;
									//$total = $total + $result["Monto"];
									//$cantotal = $cantotal + $resultado["Cantidad"];
									
									
							?>
							<?php echo '</tr>';
								}
							

				?>
                </tbody>
                <tfoot>
                	
                </tfoot>
            </table>
</div> <!-- fin de grafico de marcas -->	
	

<script type="text/javascript"> 

  $("#usual1 ul").idTabs(); 
</script>			
<?php odbc_close( $conn );?>