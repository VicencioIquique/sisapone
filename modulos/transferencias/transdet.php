<?php 
require_once("clases/conexionocdb.php");//incluimos archivo de conexión
require_once("clases/funciones.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes

$nDsm = $_GET['nDsm'];
$vendedor = str_pad($vendedor, 3, '0', 'STR_PAD_LEFT');
$modulo = $_GET['modulo'];
$finicio = $_GET['inicio'];
$ffin = $_GET['fin'];

if(!$finicio)
{
	 $finicio = date("m/d/Y");
	 $ffin= date("m/d/Y");
}

function cambiarFecha($fecha) 
{
  return implode("-", array_reverse(explode("-", $fecha)));
}
$finicio2 = cambiarFecha($finicio);
$ffin2 = cambiarFecha($ffin);

if ($modulo)// si selecciono modulo, se genera la consulta
{
	$conModulo = "  AND (Bodega LIKE '".$modulo."') ";
	$conModuloGroup = " , Bodega ";
}

/************************************************************ PARA LAS HORAS PUNTA ********************************************************************************/



$sql2="SELECT   dbo.OWTR.DocNum, dbo.OWTR.Filler, dbo.WTR1.WhsCode, dbo.OWTR.U_Bes_TipoDoc, dbo.OWTR.DocDate, 
                      dbo.VISAP_TRANSFERENCIAS.folio, dbo.WTR1.Quantity, dbo.WTR1.ItemCode, dbo.WTR1.Dscription
FROM         dbo.OWTR INNER JOIN
                      dbo.WTR1 ON dbo.OWTR.DocEntry = dbo.WTR1.DocEntry INNER JOIN
                      dbo.VISAP_TRANSFERENCIAS ON dbo.OWTR.DocEntry = dbo.VISAP_TRANSFERENCIAS.DocEntry
WHERE     (dbo.OWTR.Filler = 'ZFI.13-6') AND (dbo.OWTR.DocNum = 1334)
 ";
  
  $sql="SELECT      dbo.OWTR.DocNum, dbo.OWTR.Filler, dbo.WTR1.WhsCode, dbo.OWTR.U_Bes_TipoDoc, dbo.OWTR.DocDate, 
                      dbo.VISAP_TRANSFERENCIAS.folio, dbo.WTR1.Quantity, dbo.WTR1.ItemCode, dbo.WTR1.Dscription
FROM         dbo.OWTR INNER JOIN
                      dbo.WTR1 ON dbo.OWTR.DocEntry = dbo.WTR1.DocEntry INNER JOIN
                      dbo.VISAP_TRANSFERENCIAS ON dbo.OWTR.DocEntry = dbo.VISAP_TRANSFERENCIAS.DocEntry
WHERE     (dbo.OWTR.Filler = 'ZFI.13-6') AND (dbo.OWTR.DocNum = 1334)
ORDER BY dbo.OWTR.DocNum DESC";

//echo  $sql2;//		$_SESSION["usuario_modulo"];			
						
?>
<link type="text/css" rel="stylesheet" href="css/ui.notify.css" />
<script src="js/jquery.notify.js" type="text/javascript" ></script>
<script src="js/iphone-style-checkboxes.js" type="text/javascript" ></script>
<script type="text/javascript">
  $(document).ready(function(){
   fn_validar_dsm();
				//comienza focus en modulo
				$('#moduloid').focus();
				// calendarios en text de fecha inicio fin
				$( "#inicio" ).datepicker( );
				//formatos de las fechas
			   // $('#inicio').datepicker('option', {dateFormat: 'dd-mm-yy'});
				$( "#fin" ).datepicker(  );
				
				
			});//fin funciotn principal
			
			
			

</script>


         <form action="" method="GET" id="horizontalForm">
            <fieldset >
				<legend>Ingrese Nro. Documento Salida a Módulos</legend>
					<input name="opc" type="hidden" id="opc" size="40" class="required" value="transdet" />
					
					 <label for="sku">
					            Número de DSM
                            <input name="nDsm" type="text" class="nDsm" id="nDsm" size="40"  value="<?php echo $nDsm;?>" />
                     </label>
				  <?php
							 	if($_SESSION["usuario_modulo"] == -1)
								{
									
									echo '<label class="first" for="title1">
									Retail
									<select id="moduloid" name="modulo"    class="styled" >
									<option ></option>';
									if($modulo)
									{
										echo'<option value="'.$modulo.'" selected>'.getmodulo($modulo).'</option>';
									}
									echo'<option value="001">Modulo 1010</option>
									<option value="002">Modulo 1132</option>
									<option value="003">Modulo 181</option>
									<option value="004">Modulo 184</option>
									<option value="005">Modulo 2002</option>
									<option value="006">Modulo 6115</option>
									<option value="007">Modulo 6130</option>
									</select>
				            </label>';
								}
						
							$rs = odbc_exec( $conn, $sql );
	
	if ( !$rs )
	{
		exit( "Error en la consulta SQL" );
	}

	
  while($resultado = odbc_fetch_array($rs)){ 
	
	$NroDEM = $resultado["NroDEM"];
	$fecha = $resultado["Fecha"];
	$origen = $resultado["TOrigen"];
    $estado = $resultado["Estado"];
	$codModulo = $resultado["CodModulo"];
	$totalItem = $resultado["TotalItem"];
  
  }
 //echo $sql;
  if($NroDEM)
			{
			
					  
						 echo' </br>
						 <div class="caja" style="width:97%;background-color: #FFF;">
							<div class="caja2" style="font-size:24px; text-align:center;width:20%;float:left;height:20px; margin-right:2px; margin-bottom:2px;background-color: #129793">
								<span>Fecha</span>
							</div>
							<div class="caja2" style="font-size:24px; text-align:center;width:20%;float:left;height:20px;margin-right:2px;  margin-bottom:2px;background-color: #129793">
								<span>Origen</span>
							</div>
							<div class="caja2" style="font-size:24px; text-align:center;width:20%;float:left;height:20px;margin-right:2px;  margin-bottom:2px;background-color: #129793">
								<span>Destino</span>
							</div>
							<div class="caja2" style="font-size:24px; text-align:center;width:19%;float:left;height:20px;margin-right:2px;  margin-bottom:2px;background-color: #129793">
								<span>Items</span>
							</div>
							<div class="caja2" style="font-size:24px; text-align:center;width:20%;float:left;height:30px;margin-right:2px;background-color: #054950;padding-top:15px;">
								<span>'.$fecha.'</span>
							</div>
							<div class="caja2" style="font-size:24px; text-align:center;width:20%;float:left;height:30px;margin-right:2px;background-color: #054950;padding-top:15px;">
								<span>'.$origen.'</span>
									
										<img style="position:absolute;z-index:20; margin-top:-64px; margin-left:105px; width:44px; " src="images/curva2.png" >
								
							</div>
							<div class="caja2" style="font-size:24px; text-align:center;width:20%;float:left;height:30px;margin-right:2px;background-color: #054950;padding-top:15px;">
								<span>'.getmodulo($codModulo).'</span>
							</div>
							<div class="caja2" style="font-size:24px; text-align:center;width:19%;float:left;height:30px;margin-right:2px;background-color: #054950;padding-top:15px;">
								<span>'.$totalItem.'</span>
							</div>
						 
						 </div>';
				}
						 
						    ?>
				</fieldset>
            </form>
<?php 
			if($NroDEM)
			{
				//echo $estado;
				if($estado == 0)
				{
				echo'<table style="float:right;margin-bottom:5px; margin-right:15px;">
					<td class="on_off">
						<input type="checkbox" checked="checked" class="sino" id="on_off_on" />
					</td>	
					</table>';
				}
				else if($estado == 1)
				{
				echo'<table style="float:right;margin-bottom:5px; margin-right:15px;">
					<td>
						<h3 style="color:#595959;">DSM CARGADO CORRECTAMENTE</h3>
					</td>	
					</table>';
				}
}
	if($NroDEM)
			{
			echo'
      
      
<div id="usual1" class="usual" > 
  <ul> 
    <li ><a id="tabdua" href="#tab1" class="selected">Detalle Documento Salida a Módulo</a></li> 
    <!--<li ><a id="tabdua" href="#tab3">Detalle Items</a></li>--> 
  </ul> 
  <div id="tab3">
  
  
  </div> <!-- fin de grafico de marcas -->
  <div id="tab1"> 
  	<table  id="ssptable" class="lista">
      <thead>
            <tr>
				<th>N°</th>        
                <th>Codigo Barra</th>
				<th>Descrip.</th>
				<th>Cantidad</th>
				<th>Z</th>
            </tr>
      </thead>
      <tbody>';}


   //  echo $sql2;	
	$rs2 = odbc_exec( $conn, $sql2 );
	
	if ( !$rs2 )
	{
		exit( "Error en la consulta SQL" );
	}
	
  while($resultado2 = odbc_fetch_array($rs2)){ 
		   echo '<tr  >
				<td style="background-color:#393939;color:#FFF;width:20px;text-align:center;font-weight:bold;font-size:16px;">'.($resultado2["NroItem"]+1).'</td>
				<td style="background-color:#CDCDCD;color:#000;width:100px;text-align:center;font-weight:bold;">'.$resultado2["CodigoProducto"].' <!--<img src="images/flecha2.png"  />--> </td>
				<td >'.$resultado2["DescripcionProducto"].'</td>
				<td ><strong>'.number_format($resultado2["Cantidad"], 0, '', '.').'</strong></td>
				<td >'.$resultado2["Z"].'</td>
				</tr>' ;
			}?>
 </tbody>
	  <tfoot>
			<tr>
			
			</tr>
	  </tfoot>
	</table>
 </div> 
  <div id="container" style="display:none">
		<div id="guardado">
			<h4>#{title}</h4>
			<text>#{text}</text>
		</div>
 </div> <!-- fin de tabla de vendedores -->
<script type="text/javascript"> 
  $("#usual1 ul").idTabs(); 
</script>
 <?php odbc_close( $conn );?>