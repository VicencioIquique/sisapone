<?php 

require_once("clases/conexionocdb.php");
ini_set('max_execution_time', 600); //300 seconds = 5 minutes
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




 function cambiarFecha($fecha) {
					  return implode("-", array_reverse(explode("-", $fecha)));
					}
					$finicio2 = cambiarFecha($finicio);
					$ffin2 = cambiarFecha($ffin);


							
							
?>
<script type="text/javascript">
  $(document).ready(function(){
				//comienza focus en modulo
				$('#codbarra2').focus();
				// calendarios en text de fecha inicio fin
				$( "#inicio" ).datepicker( );
				//formatos de las fechas
			   // $('#inicio').datepicker('option', {dateFormat: 'dd-mm-yy'});
				$( "#fin" ).datepicker(  );
				//$('#fin').datepicker('option', {dateFormat: 'dd-mm-yy'});
				 $( document ).tooltip();
            });

</script>


<form action="" method="GET" id="horizontalForm">
        
            <fieldset>
				<legend>Ingresar Fechas</legend>
							 
							 <input name="opc" type="hidden" id="opc" size="40" class="required" value="buscarCodigo" />
							 
                             

							 <label for="sku">
					            Codigo de Barra
                            <input name="codbarra" type="text" class="codbarra2" id="codbarra2" size="40"  value="<?php echo $codbarra;?>" />
                            </label>
							 <input  style="clear:initial;"name="agregar" type="submit" id="agregar" class="submit" value="Consultar" />

			</fieldset>
            </form>
			  <?php
				 
				$sql= "SELECT     dbo.RP_Articulos.ALU, dbo.RP_Articulos.PRICE01, dbo.oITM_From_SBO.ItemName AS DESC1
FROM         dbo.RP_Articulos LEFT OUTER JOIN
                      dbo.oITM_From_SBO ON dbo.RP_Articulos.ALU = dbo.oITM_From_SBO.ItemCode COLLATE SQL_Latin1_General_CP1_CI_AS
WHERE     (dbo.RP_Articulos.ALU ='".$codbarra."') ";
							
						//echo $sql;
			
		$SQLEC ="select sum(Cantidad) as cant,ItemCode from rp_vicencio.dbo.SI_LotesDisponibles  where itemcode ='".$codbarra."' and bodega ='009'group by ItemCode ";



					$rsStockEC = odbc_exec( $conn, $SQLEC );
					$resultadoEC = odbc_fetch_array($rsStockEC);
			
					 $stock = explode("-",stockModulos($codbarra));
					 $stockAir = explode("-",stockAeropuerto($codbarra));
							//echo $sql;	
							$rs = odbc_exec( $conn, $sql );
							if ( !$rs )
							{
							exit( "Error en la consulta SQL" );
							}

							  while($resultado = odbc_fetch_array($rs)){ 
							  
							
			
		echo'	<div id="muestraPrecio" class="caja" style="margin-top:10px;overflow:auto;">
					<div id="muestraPrecio" class="caja2" style="margin-top:10px; font-size:24px; text-align:center; padding-top:20px;background-color: #9BD7D5;">
							'.$resultado["DESC1"].'	
					</div>
						<div id="muestraPrecio" class="caja2" style="margin-top:10px; font-size:24px; text-align:center; padding-top:15px;float:left; width:45%; background-color: #129793;border: 1px solid #d5d5d5;">
						<span style="font-size:40px; text-shadow: #333333 0px 0px 8px; text-shadow: #333333 0px 0px 10px 8px; "s >COD: '.$resultado["ALU"].'</span>
						</div>
						<div id="muestraPrecio" class="caja2" style="margin-top:10px; font-size:24px; text-align:center; padding-top:15px;float:right;width:45%; background-color: #129793;border: 1px solid #d5d5d5;">
								<span style="font-size:40px; text-shadow: #333333 0px 0px 10px; text-shadow: #333333 0px 0px 10px 10px; ">$ '. number_format((int)$resultado["PRICE01"], 0, '', '.').'.-</span>	
						</div>
						
						
						
						<div id="muestraPrecio" class="caja2" style="margin-top:10px; font-size:24px; text-align:center; padding-top:10px;float:left;width:7%; height:10px; background-color: #054950;border: 1px solid #d5d5d5;">
									
								<a href="modulos/indicadores/rotacion.php?sku='.$codbarra.'&bodega=1" onclick="$(this).modal({width:1110, height:445}).open(); return false;"><span>1010</span></a>

			</div>
						<div id="muestraPrecio" class="caja2" style="margin-top:10px; font-size:24px; text-align:center; padding-top:10px;float:left;width:7%; height:10px; background-color: #054950;border: 1px solid #d5d5d5;">
								<a href="modulos/indicadores/rotacion.php?sku='.$codbarra.'&bodega=2" onclick="$(this).modal({width:1110, height:445}).open(); return false;"><span>1132</span></a>
						</div>
						<div id="muestraPrecio" class="caja2" style="margin-top:10px; font-size:24px; text-align:center; padding-top:10px;float:left;width:7%; height:10px;  background-color: #054950;border: 1px solid #d5d5d5;">
								<a href="modulos/indicadores/rotacion.php?sku='.$codbarra.'&bodega=3" onclick="$(this).modal({width:1110, height:445}).open(); return false;"><span>E-C</span></a>
						</div>
						<div id="muestraPrecio" class="caja2" style="margin-top:10px; font-size:24px; text-align:center; padding-top:10px;float:left;width:7%;height:10px;  background-color: #054950;border: 1px solid #d5d5d5;">
								<a href="modulos/indicadores/rotacion.php?sku='.$codbarra.'&bodega=4" onclick="$(this).modal({width:1110, height:445}).open(); return false;"><span>184</span></a>
						</div>
						<div id="muestraPrecio" class="caja2" style="margin-top:10px; font-size:24px; text-align:center; padding-top:10px;float:left;width:9%;height:10px;  background-color: #054950;border: 1px solid #d5d5d5;">
								<a href="modulos/indicadores/rotacion.php?sku='.$codbarra.'&bodega=5" onclick="$(this).modal({width:1110, height:445}).open(); return false;"><span>2002</span></a>
						</div>
						<div id="muestraPrecio" class="caja2" style="margin-top:10px; font-size:24px; text-align:center; padding-top:10px;float:left;width:8.5%; height:10px; background-color: #054950;border: 1px solid #d5d5d5;">
								<a href="modulos/indicadores/rotacion.php?sku='.$codbarra.'&bodega=6" onclick="$(this).modal({width:1110, height:445}).open(); return false;"><span>6115</span></a>	
						</div>
						<div id="muestraPrecio" class="caja2" style="margin-top:10px; font-size:24px;  text-align:center; padding-top:10px;float:left;width:8%;height:10px;  background-color: #054950;border: 1px solid #d5d5d5;">
								<a href="modulos/indicadores/rotacion.php?sku='.$codbarra.'&bodega=7" onclick="$(this).modal({width:1110, height:445}).open(); return false;"><span>6130</span></a>	
						</div>
						<div id="muestraPrecio" class="caja2" style="margin-top:10px; font-size:24px;  text-align:center; padding-top:10px;float:left;width:8%;height:10px;  background-color: #054950;border: 1px solid #d5d5d5;">
									<a href="modulos/indicadores/rotacion.php?sku='.$codbarra.'&bodega=8" onclick="$(this).modal({width:1110, height:445}).open(); return false;"><span>2077</span></a>		
						</div>
						<!-- modulos -->
										
						<div id="muestraPrecio" class="caja2" style="margin-top:1px; font-size:24px; text-align:center; padding-top:10px;float:left;width:7%; height:80px; background-color: #054950;border: 1px solid #d5d5d5;">
								<span style="font-size:55px;  text-shadow: #000 0px 0px 10px; text-shadow: #000 0px 0px 10px 10px; ">'.$stock[0].'</span>	

						</div>
						<div id="muestraPrecio" class="caja2" style="margin-top:1px; font-size:24px; text-align:center; padding-top:10px;float:left;width:7%; height:80px; background-color: #054950;border: 1px solid #d5d5d5;">
								<span style="font-size:55px; text-shadow: #000 0px 0px 10px; text-shadow: #000 0px 0px 10px 10px;">'.$stock[1].'</span>	
						</div>
						<div id="muestraPrecio" class="caja2" style="margin-top:1px; font-size:24px; text-align:center; padding-top:10px;float:left;width:7%; height:80px;  background-color: #054950;border: 1px solid #d5d5d5;">
								<span style="font-size:55px; text-shadow: #000 0px 0px 10px; text-shadow: #000 0px 0px 10px 10px;">'.(int)$resultadoEC["cant"].'</span>	
						</div>
						<div id="muestraPrecio" class="caja2" style="margin-top:1px; font-size:24px; text-align:center; padding-top:10px;float:left;width:7%;height:80px;  background-color: #054950;border: 1px solid #d5d5d5;">
								<span style="font-size:55px; text-shadow: #000 0px 0px 10px; text-shadow: #000 0px 0px 10px 10px;">'.$stock[3].'</span>	
						</div>
						<div id="muestraPrecio" class="caja2" style="margin-top:1px; font-size:24px; text-align:center; padding-top:10px;float:left;width:9%;height:80px;  background-color: #054950;border: 1px solid #d5d5d5;">
								<span style="font-size:55px; text-shadow: #000 0px 0px 10px; text-shadow: #000 0px 0px 10px 10px;">'.$stock[4].'</span>	
						</div>
						<div id="muestraPrecio" class="caja2" style="margin-top:1px; font-size:24px; text-align:center; padding-top:10px;float:left;width:8.5%; height:80px; background-color: #054950;border: 1px solid #d5d5d5;">
								<span style="font-size:55px; text-shadow: #000 0px 0px 10px; text-shadow: #000 0px 0px 10px 10px;">'.$stock[5].'</span>	
						</div>
						<div id="muestraPrecio" class="caja2" style="margin-top:1px; font-size:24px; text-align:center; padding-top:10px;float:left;width:8%;height:80px;  background-color: #054950;border: 1px solid #d5d5d5;">
								<span style="font-size:55px; text-shadow: #000 0px 0px 10px; text-shadow: #000 0px 0px 10px 10px;">'.$stock[6].'</span>	
						</div>
						<div id="muestraPrecio" class="caja2" style="margin-top:1px; font-size:24px; text-align:center; padding-top:10px;float:left;width:8%;height:80px;  background-color: #054950;border: 1px solid #d5d5d5;">
								<span style="font-size:55px; text-shadow: #000 0px 0px 10px; text-shadow: #000 0px 0px 10px 10px;">'.$stock[8].'</span>	<!-- 7 -->
						</div>
						
						<!-- ICONOS -->
						
						<div id="muestraPrecio" class="caja2" style="margin-top:0px; font-size:24px; text-align:center; padding-top:10px;float:left;width:7%; height:10px; background-color: #054950;border: 1px solid #d5d5d5;">
									
								<a href="modulos/indicadores/evolucionPrecio.php?sku='.$codbarra.'&bodega=1" onclick="$(this).modal({width:1110, height:445}).open(); return false;"><span>$</span></a>

			</div>
						<div id="muestraPrecio" class="caja2" style="margin-top:0px; font-size:24px; text-align:center; padding-top:10px;float:left;width:7%; height:10px; background-color: #054950;border: 1px solid #d5d5d5;">
								<a href="modulos/indicadores/evolucionPrecio.php?sku='.$codbarra.'&bodega=2" onclick="$(this).modal({width:1110, height:445}).open(); return false;"><span>$</span></a>
						</div>
						<div id="muestraPrecio" class="caja2" style="margin-top:0px; font-size:24px; text-align:center; padding-top:10px;float:left;width:7%; height:10px;  background-color: #054950;border: 1px solid #d5d5d5;">
								<a href="modulos/indicadores/evolucionPrecio.php?sku='.$codbarra.'&bodega=3" onclick="$(this).modal({width:1110, height:445}).open(); return false;"><span>$</span></a>
						</div>
						<div id="muestraPrecio" class="caja2" style="margin-top:0px; font-size:24px; text-align:center; padding-top:10px;float:left;width:7%;height:10px;  background-color: #054950;border: 1px solid #d5d5d5;">
								<a href="modulos/indicadores/evolucionPrecio.php?sku='.$codbarra.'&bodega=4" onclick="$(this).modal({width:1110, height:445}).open(); return false;"><span>$</span></a>
						</div>
						<div id="muestraPrecio" class="caja2" style="margin-top:0px; font-size:24px; text-align:center; padding-top:10px;float:left;width:9%;height:10px;  background-color: #054950;border: 1px solid #d5d5d5;">
								<a href="modulos/indicadores/evolucionPrecio.php?sku='.$codbarra.'&bodega=5" onclick="$(this).modal({width:1110, height:445}).open(); return false;"><span>$</span></a>
						</div>
						<div id="muestraPrecio" class="caja2" style="margin-top:0px; font-size:24px; text-align:center; padding-top:10px;float:left;width:8.5%; height:10px; background-color: #054950;border: 1px solid #d5d5d5;">
								<a href="modulos/indicadores/evolucionPrecio.php?sku='.$codbarra.'&bodega=6" onclick="$(this).modal({width:1110, height:445}).open(); return false;"><span>$</span></a>	
						</div>
						<div id="muestraPrecio" class="caja2" style="margin-top:0px; font-size:24px;  text-align:center; padding-top:10px;float:left;width:8%;height:10px;  background-color: #054950;border: 1px solid #d5d5d5;">
								<a href="modulos/indicadores/evolucionPrecio.php?sku='.$codbarra.'&bodega=7" onclick="$(this).modal({width:1110, height:445}).open(); return false;"><span>$</span></a>	
						</div>
						<div id="muestraPrecio" class="caja2" style="margin-top:0px; font-size:24px;  text-align:center; padding-top:10px;float:left;width:8%;height:10px;  background-color: #054950;border: 1px solid #d5d5d5;">
									<a href="modulos/indicadores/evolucionPrecio.php?sku='.$codbarra.'&bodega=8" onclick="$(this).modal({width:1110, height:445}).open(); return false;"><span>$</span></a>		
						</div>
						<!-- AEROPUERTO -->
						
						<div id="muestraPrecio" class="caja2" style="margin-top:5px; font-size:24px; text-align:center; padding-top:10px;float:left; width:45%; height:10px; background-color: #05355C;border: 1px solid #d5d5d5;">
						<span style="font-size:24x; text-shadow: #333333 0px 0px 8px; text-shadow: #333333 0px 0px 10px 8px; " >Aeropuerto Local 2</span>
						</div>
						<div id="muestraPrecio" class="caja2" style="margin-top:5px; font-size:24px; text-align:center; padding-top:10px;float:right;width:45%;  height:10px; background-color: #05355C;border: 1px solid #d5d5d5;">
								<span style="font-size:24px; text-shadow: #333333 0px 0px 10px; text-shadow: #333333 0px 0px 10px 10px; ">Aeropuerto Local 8</span>	
						</div>
						
						<div id="muestraPrecio" class="caja2" style="margin-top:1px; font-size:24px; text-align:center; padding-top:10px;float:left; width:45%; background-color: #0C4675;border: 1px solid #d5d5d5;">
						<span style="font-size:40px; text-shadow: #333333 0px 0px 8px; text-shadow: #333333 0px 0px 10px 8px; " >'.$stockAir[0].'</span>
						</div>
						<div id="muestraPrecio" class="caja2" style="margin-top:1px; font-size:24px; text-align:center; padding-top:10px;float:right;width:45%; background-color: #0C4675;border: 1px solid #d5d5d5;">
								<span style="font-size:40px; text-shadow: #333333 0px 0px 10px; text-shadow: #333333 0px 0px 10px 10px; ">'. number_format((int)$stockAir[1], 0, '', '.').'</span>	
						</div>
						
			</div>';
         }
  
  
  //desde aquí muestra tabla para detalle		 
echo'</br>
 <div id="usual1" class="usual" > 
  <ul> 
    <li ><a id="tabdua" href="#tab1" class="selected">Detalle Saldos</a></li> 
   
  </ul> 
  <div id="tab3">
  
  
  </div> <!-- fin de grafico de marcas 
  <div id="tab1"> 
  	<table  id="ssptable" class="lista">
      <thead>
            <tr>
				<th>N°</th>        
                <th>Codigo Barra</th>
				<th>Descrip.</th>
				<th>Cantidad</th>
				<th>Lote</th>
				<th>Bodega</th>
            </tr>
      </thead>
      <tbody>-->';
	
	$sql2="SELECT TOP 1000 [ItemCode]
      ,[BatchNum]
      ,[WhsCode]
      ,[ItemName]
      ,[SuppSerial]
      ,[IntrSerial]
      ,[ExpDate]
      ,[PrdDate]
      ,[InDate]
      ,[Located]
      ,[Notes]
      ,[Quantity]
      ,[BaseType]
      ,[BaseEntry]
      ,[BaseNum]
      ,[BaseLinNum]
      ,[CardCode]
      ,[CardName]
      ,[CreateDate]
      ,[Status]
      ,[Direction]
      ,[IsCommited]
      ,[OnOrder]
      ,[Consig]
      ,[DataSource]
      ,[UserSign]
      ,[Transfered]
      ,[Instance]
      ,[SysNumber]
      ,[LogInstanc]
      ,[UserSign2]
      ,[UpdateDate]
      ,[U_ZF_CIF_U]
      ,[Location]
      ,[ExpensesAc]
      ,[grupo_bodega]
  FROM [SBO_Imp_Eximben_SAC].[dbo].[SI_Stock_Bodega_SAPJC]
  WHERE ItemCode = '".$codbarra."' AND(WhsCode IN ('ZFI.1010','ECM.2002', 'ZFI.184', 'ZFI.2002', 'ZFI.1132', 'ZFI.6130', 'ZFI.6115'))
ORDER BY WhsCode  ";

     //echo $sql2;	
	/*$rs2 = odbc_exec( $conn, $sql2 );
	
	if ( !$rs2 )
	{
		exit( "Error en la consulta SQL" );
	}
	$i=0;
  while($resultado2 = odbc_fetch_array($rs2)){ 
		   echo '<tr  >
				<td style="background-color:#393939;color:#FFF;width:20px;text-align:center;font-weight:bold;font-size:16px;">'.($i+1).'</td>
				<td style="background-color:#CDCDCD;color:#000;width:100px;text-align:center;font-weight:bold;">'.$resultado2["ItemCode"].' <!--<img src="images/flecha2.png"  />--> </td>
				<td >'.$resultado2["ItemName"].'</td>
				<td ><strong style="font-size:18px;">'.number_format($resultado2["Quantity"], 0, '', '.').'</strong></td>
				<td >'.$resultado2["BatchNum"].'</td>
				<td style="text-align:center;font-weight:bold;font-size:16px;" >'.$resultado2["WhsCode"].'</td>
				</tr>' ;
			$i++;}*/?>
 <!--</tbody>
	  <tfoot>
			<tr>
			
			</tr>
	  </tfoot>
	</table>
 </div> -->
        
<?php odbc_close( $conn );?>