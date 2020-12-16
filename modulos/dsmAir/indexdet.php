<?php 
 error_reporting (0);
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




$modulo = $_SESSION["usuario_modulo"];
	if($modulo== 42)
	{
		$modulo=1;
	}
	else if ($modulo== 48)
	{
		$modulo=2;
	}


/************************************************************ PARA LAS HORAS PUNTA ********************************************************************************/



$sql2="SELECT TOP 1000 [NroDEM]
      ,[Guia]
      ,[CodModulo]
      ,[TipoDocto]
      ,[NroItem]
      ,[CodigoProducto]
      ,[ItemNumber]
      ,CONVERT(varchar, [FechaDoc], 103) AS Fecha
      ,[CodMoneda]
      ,[Cantidad]
      ,[DescripcionProducto]
      ,[Z]
      ,[CifUnitario]
      ,[CostoUnitarioUS$]
      ,[CostoUnitario$]
      ,[EnRetailPro]
      ,[FechaIngreso]
      ,[Estado]
      ,[ID]
      ,[TOrigen]
      ,[Comentario2]
      ,[Comentario3]
      ,[Comentario4]
      ,[Comentario5]
      ,[TipoImpuesto]
      ,[PorcentajeImpuesto]
      ,[MontoIva]
      ,[MontoIla]
      ,[MontoExento]
      ,[MontoEspecifico]
      ,[TotalNeto]
      ,[Total]
      ,[Bodega]
      ,[CodeBarr]
      ,[FechaLote]
  FROM [RP_REGGEN].[dbo].[RP_DEM]
 WHERE [CodModulo] = ".$modulo." AND CodModulo <> 'TP8' AND CodModulo <> 'TP2' AND NroDEM = ".$nDsm."

  ORDER BY FechaDoc DESC";
  
  

$sql =" SELECT [NroDEM]  ,[TOrigen],[CodModulo] ,CONVERT(varchar, [FechaDoc], 103) AS Fecha,count([NroDEM]) AS TotalItem,Estado   
FROM [RP_REGGEN].[dbo].[RP_DEM]
 WHERE [CodModulo] = ".$modulo." AND CodModulo <> 'TP8' AND CodModulo <> 'TP2' AND NroDEM = ".$nDsm."
 GROUP BY NroDEM,[FechaDoc],[CodModulo],[TOrigen],Estado ORDER BY FechaDoc DESC";

//echo  $sql;//		$_SESSION["usuario_modulo"];			
						
?>
<link type="text/css" rel="stylesheet" href="css/ui.notify.css" />
<script src="js/jquery.notify.js" type="text/javascript" ></script>
<script src="js/iphone-style-checkboxes.js" type="text/javascript" ></script>
<script type="text/javascript">
  $(document).ready(function(){
   fn_validar_dsmAir();
				//comienza focus en modulo
				$('#moduloid').focus();
				// calendarios en text de fecha inicio fin
				$( "#inicio" ).datepicker( );
				//formatos de las fechas
			   // $('#inicio').datepicker('option', {dateFormat: 'dd-mm-yy'});
				$( "#fin" ).datepicker(  );
				
				//$('#fin').datepicker('option', {dateFormat: 'dd-mm-yy'});
				 $('.on_off :checkbox').iphoneStyle({ checkedLabel: 'Si', uncheckedLabel: 'No' });
				 
      
					  var onchange_checkbox = ($('.onchange :checkbox')).iphoneStyle({
						onChange: function(elem, value) { 
						  $('span#status').html(value.toString());
						}
					  });
					  
					  setInterval(function() {
						onchange_checkbox.prop('checked', !onchange_checkbox.is(':checked')).iphoneStyle("refresh");
						return
					  }, 2500);
				
			});//fin funciotn principal
			
			
			

</script>


         <form action="" method="GET" id="horizontalForm">
            <fieldset >
				<legend>Ingrese Nro. Documento de ingreso de Mercadería</legend>
					<input name="opc" type="hidden" id="opc" size="40" class="required" value="validarDSMAir" />
					
					 <label for="sku">
					            Número de Documento
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
										echo'<option value="'.$modulo.'" selected>'.getmoduloAir($modulo).'</option>';
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
								<span>'.getmoduloAir($codModulo).'</span>
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
						<h3 style="color:#595959;">DOCUMENTO CARGADO CORRECTAMENTE</h3>
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