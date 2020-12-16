<?php 

require_once("clases/conexionocdb.php");
ini_set('max_execution_time', 600); //300 seconds = 5 minutes
$nroBoleta = $_GET['nroBoleta'];
$caja = $_GET['caja'];
$bodega = $_GET['bodega'];



/********************** para que solo busque por modulos segun pertenesca ******************************************/
if($_SESSION["usuario_modulo"] !=0)
{
	$modulo = $_SESSION["usuario_modulo"];
	$modulo =str_pad($modulo, 3, '0', 'STR_PAD_LEFT');
}

else
{
	$modulo = $_GET['modulo'];
}
/************************************** fin privilegio de modulo *****************************/

				 
$sql= "SELECT     dbo.RP_ReceiptsCab_SAP.Bodega, dbo.RP_ReceiptsCab_SAP.Workstation AS CAJA, dbo.RP_ReceiptsCab_SAP.TipoDocto, dbo.RP_ReceiptsCab_SAP.NumeroDocto, 
                      CONVERT(varchar, dbo.RP_ReceiptsCab_SAP.FechaDocto, 103) AS Fecha, dbo.RP_ReceiptsDet_SAP.Secuencia, dbo.RP_ReceiptsDet_SAP.Sku, 
                      dbo.oITM_From_SBO.ItemName, dbo.RP_ReceiptsDet_SAP.Cantidad, dbo.RP_ReceiptsDet_SAP.PrecioExtendido, dbo.RP_ReceiptsCab_SAP.Total, 
                      dbo.RP_ReceiptsPagos_SAP.TipoPago, dbo.RP_ReceiptsCab_SAP.Vendedor AS VendedorBoleta, dbo.RP_ReceiptsDet_SAP.Vendedor AS VendedorDetalle, 
                      dbo.RP_Articulos.PRICE01 AS PrecioOriginal, CONVERT(VARCHAR(8), dbo.RP_ReceiptsCab_SAP.FechaDocto, 108) AS HORA
FROM         dbo.RP_Articulos LEFT OUTER JOIN
                      dbo.RP_ReceiptsDet_SAP ON dbo.RP_Articulos.ALU = dbo.RP_ReceiptsDet_SAP.Sku RIGHT OUTER JOIN
                      dbo.RP_ReceiptsCab_SAP LEFT OUTER JOIN
                      dbo.RP_ReceiptsPagos_SAP ON dbo.RP_ReceiptsCab_SAP.ID = dbo.RP_ReceiptsPagos_SAP.ID ON 
                      dbo.RP_ReceiptsDet_SAP.ID = dbo.RP_ReceiptsCab_SAP.ID LEFT OUTER JOIN
                      dbo.oITM_From_SBO ON dbo.RP_ReceiptsDet_SAP.Sku = dbo.oITM_From_SBO.ItemCode COLLATE Latin1_General_CI_AS
WHERE     (dbo.RP_ReceiptsCab_SAP.NumeroDocto = ".$nroBoleta.") AND (dbo.RP_ReceiptsCab_SAP.Bodega = ".(int)$bodega." ) AND  dbo.RP_ReceiptsCab_SAP.Workstation = ".$caja." "; /*'".$codbarra."' ";*/

$rs2 = odbc_exec( $conn, $sql );
							if ( !$rs2 )
							{
							exit( "Error en la consulta SQL" );
							}
			 while($resultado1 = odbc_fetch_array($rs2)){ 
					$nroBoleta = $resultado1["NumeroDocto"];
					$bodega = $resultado1["Bodega"];
					$fecha = $resultado1["Fecha"];
					$total = $resultado1["Total"];
					$caja = $resultado1["CAJA"];
					$hora = $resultado1["HORA"];
					$vendedorBoleta = $resultado1["VendedorBoleta"];
					$vendedorDetalle = $resultado1["VendedorDetalle"];
			 
			 }


 function cambiarFecha($fecha) {
					  return implode("-", array_reverse(explode("-", $fecha)));
					}
					$finicio2 = cambiarFecha($finicio);
					$ffin2 = cambiarFecha($ffin);


							
							
?>
<script type="text/javascript" src="js/jquery.numeric.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
				//comienza focus en modulo
				
			
				// calendarios en text de fecha inicio fin
			
            });

</script>


<form id="horizontalForm">

        
           <fieldset style="background-color:#FCFCFC;" >
		   
				<legend>Boleta Nro <?php echo $nroBoleta;?> del <?php echo getmodulo($bodega);?></legend>
							 
						 <input name="opc" type="hidden" id="opc" size="40" class="required" value="buscarCodigoBodega" />
					 <label for="sku">
					            Fecha
                            <input style="background-color:#F1F1F1;color:#6C6B6B;font-weight:bold; font-size:18px; height:40px; width:110px; text-align:center;" name="codbarra" type="text" class="codbarra2" id="codbarra2" size="40"  value="<?php echo $fecha;?>" disabled/>
                            </label>
					 <label for="sku">
					            Hora
                            <input style="background-color:#F1F1F1;color:#6C6B6B;font-weight:bold; font-size:18px; height:40px; width:110px; text-align:center;" name="codbarra" type="text" class="codbarra2" id="codbarra2" size="40"  value="<?php echo $hora;?>" disabled/>
                            </label>
						    <label for="sku">
					            Caja
                            <input style="background-color:#F1F1F1;color:#6C6B6B;font-weight:bold; font-size:18px; height:40px; width:30px; text-align:center;" name="codbarra" type="text" class="codbarra2" id="codbarra2" size="40"  value="<?php echo $caja;?>" disabled/>
                            </label>
							<label for="sku">
					            Vendedor
                            <input style="background-color:#F1F1F1;color:#6C6B6B;font-weight:bold; font-size:14px; height:40px; width:180px; text-align:center;" name="codbarra" type="text" class="codbarra2" id="codbarra2" size="40"  value="<?php echo getusuarioRP($vendedorBoleta);?>" disabled/>
                            </label>
							
							
							 

			</fieldset>
            </form>
			  <?php
			  echo'	
					 <table  id="ssptable2" class="lista">
							  <thead>
									<tr>
										<th>#</th>
										<th >Vendedor</th>
										<th >Codigo</th>
										<th >Descripción</th> 
										<th >Cantidad</th> 
										<th >Precio Original</th> 
										<th >Precio Ext.</th> 
					
									</tr>
								</thead>
								<tbody>';

					 
					 //$stock = explode("-",stockModulos($codbarra));
							//echo $sql;	
							$rs = odbc_exec( $conn, $sql );
							if ( !$rs )
							{
							exit( "Error en la consulta SQL" );
							}

							  while($resultado = odbc_fetch_array($rs)){ 
					    	echo'
								 <tr>
										  
										<td style="background-color:#6C6B6B;color:#fff;font-weight:bold; font-size:12px; width:14px; text-align:center;" >'.$resultado["Secuencia"].'</td> 
										<td >'.getusuarioRP($resultado["VendedorDetalle"]).'</td> 
										<td >'.$resultado["Sku"].'</td> 
										<td >'.$resultado["ItemName"].'</td> 
										<td >'.(int)$resultado["Cantidad"].'</td> 
										<td >'.number_format((int)$resultado["PrecioOriginal"], 0, ',', '.').'</td> 
										<td >'.number_format((int)$resultado["PrecioExtendido"], 0, ',', '.').'</td> 
										
								</tr> ';
         }
		 
		 echo '
		 	
		
			</tbody>
			 <tfoot style=" border-top:2px double #B5B5B5;">
			  <tr >
			  
			 </tr>
			</tfoot>
		</table>
		<div style="text-align:right;  width:500px; height:40px; float:right; font-size:30px; color:#6C6B6B; margin-right:15px;font-weight:bold;" >Total: $'.number_format((int)$total, 0, ',', '.').'</div>';
?>
<form id="horizontalForm">

        
           <fieldset style="background-color:#FCFCFC;" >
		   
				
							 
					
							
							 

			</fieldset>
            </form>

 <?php odbc_close( $conn );?>