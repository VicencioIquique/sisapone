<?php 
require_once("clases/conexionocdb.php");
ini_set('max_execution_time', 600); //300 seconds = 5 minutes


$areaNegocio = $_GET['areaNegocio'];
$tipoProducto = $_GET['tipoProducto'];
$periodo = $_GET['periodo'];
$proveedor = $_GET['proveedor'];
$distribuir = $_GET['distribuir'];
$brandManager = $_GET['brandManager'];
$consultar = $_GET['agregar'];
if(!$periodo)
{
	$periodo =  date('Y');
}



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
/************************************** fin privilegio de modulo *****************************/


 function cambiarFecha($fecha) {
					  return implode("-", array_reverse(explode("-", $fecha)));
					}
					$finicio2 = cambiarFecha($finicio);
					$ffin2 = cambiarFecha($ffin);



// Consulta para llamar las marcas de los productos
$sql2= "SELECT 
      DISTINCT[Proveedor]     AS Proveedor
  FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_VW_ItemsVenta]
  ORDER BY Proveedor
";
							$rs2 = odbc_exec( $conn, $sql2 );
							if ( !$rs2 )
							{
							exit( "Error en la consulta SQL" );
							}
/************************************************************ PARA LOS VENDEDORES **************************************/




// Consulta para llamar las marcas de los productos
$sql7= "
SELECT 
      DISTINCT[BrandManager]     AS BrandManager
  FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_VW_ItemsVenta]
  ORDER BY BrandManager
";
							$rs7= odbc_exec( $conn,$sql7);
							if ( !$rs7 )
							{
							exit( "Error en la consulta SQL" );
							}
?>
<script type="text/javascript">
  $(document).ready(function(){
				//comienza focus en modulo
				$('#areaNegocio').focus();
				
				$(".periodo").datepicker({
				dateFormat: 'yy',
				changeYear: true,
				
				showButtonPanel: true,

				onClose: function(dateText, inst) {
					
					var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
					$(this).val($.datepicker.formatDate('yy', new Date(year, 1)));
				}
			});

			$(".periodo").focus(function () {
				$(".ui-datepicker-calendar").hide();
				$("#ui-datepicker-div").position({
					my: "center top",
					at: "center bottom",
					of: $(this)
				});
			});
				
				 
            });//fin
			

</script>

<script language="javascript"> 
$(document).ready(function() { 
     $(".botonExcel").click(function(event) { 
     $("#datos_a_enviar").val( $("<div>").append( $("#tablelike").eq(0).clone()).html()); 
     $("#FormularioExportacion").submit(); 
}); 
}); 
</script> 



<div class="idTabs">
      <ul>
        <li><a href="#one"><img src="images/agregar.png" width="30px" height="30px" /></a></li>
		<?php // pregunta si ha ingresado una fecha para que se muestre el imagen link de generar Excel
					
		if($consultar){
		
			echo'<form action="/sisapone/clases/ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion"> 
			<center><img src="images/excel.png" width="30px" height="30px" class="botonExcel"  /> </center>
			<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" /> 
			</form> ';
		}?>
	 </ul>
      <div class="items">
        <div id="one"> <form action="" method="GET" id="horizontalForm">
        
            <fieldset>
				<legend>Filtros</legend>
							 
							 <input name="opc" type="hidden" id="opc" size="40" class="required" value="ventasPorBodega" />
							 
							 
                              <?php
							 	if($_SESSION["usuario_modulo"] == -1)
								{
									
									echo '<label class="first" for="title1">
									Area de Negocio
									<select id="areaNegocio" name="areaNegocio"    class="styled" >';
									if($areaNegocio)
									{
										echo'<option value="'.$areaNegocio.'" selected>'.$areaNegocio.'</option>';
									}
									echo'
									<option></option>
									<option value="Perfumes">Perfumes</option>
									<option value="Artículos">Artículos</option>
									<option value="Cosmeticos">Cosmeticos</option>
									<option value="Ropa">Ropa</option>
									<option value="Accesorios">Accesorios</option>
									<option value="Confitería">Confitería</option>
									</select>
				            </label>';
								}
					        ?>
							 
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
									Brand Manager
									<select id="brandManager" name="brandManager"    class="styled" >';
									if($brandManager)
									{
										echo'<option value="'.$brandManager.'" selected>'.$brandManager.'</option>';
									}		
											 echo'<option value=""></option>';	
											 while($result = odbc_fetch_array($rs7))
											 { 
												
												 echo'<option value="'.$result['BrandManager'].'">'.utf8_encode($result['BrandManager']).'</option>';
												
											 }
										
				
								  echo'</select>
				            </label>';
							
							echo'<label >
										Periodo:
										<input type="text" id="periodo" name="periodo" class="periodo" size="5" value="'.$periodo.'"  />
						  </label>
							';
							
					        ?>
							
							  <?php // para cargar un list con las marcas
									 echo' <label class="first" for="title1">
									Proveedor
									<select id="proveedor" name="proveedor"    class="styled" >';
											
									echo'<option value=""></option>';	
									 if($proveedor)
									{
										echo'<option value="'.$proveedor.'" selected>'.$proveedor.'</option>';
									}
											 while($result = odbc_fetch_array($rs2))
											 { 
												
												 echo'<option value="'.$result['Proveedor'].'">'.utf8_encode($result['Proveedor']).'</option>';
												
											 }
										
				
								  echo'</select>
				            </label>';
					        ?>
							
							 <?php
							 	
									
									echo '<label class="first" for="title1">
									Distribuir Por:
									<select id="distribuir" name="distribuir"    class="styled" >';
									if($distribuir)
									{
										echo'<option value="'.$distribuir.'" selected>'.$distribuir.'</option>';
									}									
																		
									echo'
									<option value="Unidades">Unidades</option>
									<option value="CLP">CLP</option>
									<option value="USD">USD</option>
									<option value="CIF">CIF</option>
									</select>
				            </label>';
							
					        ?>
							
                             <input style="clear:initial;" name="agregar" type="submit" id="agregar" class="submit" value="Consultar" />

			</fieldset>
            </form>
         </div> <!-- fin div two-->
      </div> <!-- fin items -->
    </div> <!-- fin idTabs -->



                 <?php
				 
				 if($areaNegocio)
				 {
					$WareaNegocio = " AND AreaNegocio LIKE '".$areaNegocio."'";
				 }
				 if($tipoProducto)
				 {
					$WtipoProducto = " AND TipoProducto  LIKE '".$tipoProducto."'";
				 }
				 
				  if($proveedor)
				 {
				    $marcaTablaOn = ",TABLA.Marca               [Marca]";
				    $marcaOn = ",PV.Marca";
					$marcaGroupON = ",TABLA.Marca";
					$Wproveedor = " AND Proveedor = '".$proveedor."'";
				 }
				
				 if($brandManager)
				 {
					$WbrandManager = " AND BrandManager LIKE '".$brandManager."'";
				 }
				 

if($distribuir=="Unidades")
{
	$titulo = "Total_UNDS";
	$sumTotales = ",SUM(TABLA.Total_CLP)      [Total_CLP]
                   ,SUM(TABLA.Total_USD)      [Total_USD]
	               ,SUM(TABLA.CtoVtaCIF)      [CtoVtaCIF]";
	$pivotTotales = ",PV.Total_CLP
		            ,PV.Total_USD
		            ,PV.CtoVtaCIF";
    $pivote ="[Quantity]";
}
else if($distribuir=="CLP")
{
	$titulo = "Total_CLP";
	$sumTotales = ",SUM(TABLA.Quantity)       [Total_UNDS]
                   ,SUM(TABLA.Total_USD)      [Total_USD]
	               ,SUM(TABLA.CtoVtaCIF)      [CtoVtaCIF]";
	$pivotTotales = ",PV.Quantity
		             ,PV.Total_USD
		             ,PV.CtoVtaCIF";
    $pivote ="[Total_CLP]";
}
else if($distribuir=="USD")
{
	$titulo = "Total_USD";
	$sumTotales = ",SUM(TABLA.Quantity)       [Total_UNDS]
                   ,SUM(TABLA.Total_CLP)      [Total_CLP]
	               ,SUM(TABLA.CtoVtaCIF)      [CtoVtaCIF]";
	$pivotTotales = ",PV.Quantity
		             ,PV.Total_CLP
		             ,PV.CtoVtaCIF";
    $pivote ="[Total_USD]";
}

else if($distribuir=="CIF")
{
	$titulo = "CtoVtaCIF";
	$sumTotales = ",SUM(TABLA.Quantity)       [Total_UNDS]
                   ,SUM(TABLA.Total_USD)      [Total_USD]
	               ,SUM(TABLA.Total_CLP)      [Total_CLP]";
	$pivotTotales = ",PV.Quantity
		             ,PV.Total_USD
		             ,PV.Total_CLP";
    $pivote ="[CtoVtaCIF]";
}

				 
$sql="
SELECT
       TABLA.WhsCode             [Bodega]
	  ".$marcaTablaOn."
      ,SUM(TABLA.Enero)          [Enero]
      ,SUM(TABLA.Febrero)        [Febrero]
      ,SUM(TABLA.Marzo)          [Marzo]
      ,SUM(TABLA.Abril)          [Abril]
      ,SUM(TABLA.Mayo)           [Mayo]
      ,SUM(TABLA.Junio)          [Junio]
      ,SUM(TABLA.Julio)          [Julio]
      ,SUM(TABLA.Agosto)         [Agosto]
      ,SUM(TABLA.Septiembre)     [Septiembre]
      ,SUM(TABLA.Octubre)        [Octubre]
      ,SUM(TABLA.Noviembre)      [Noviembre]
      ,SUM(TABLA.Diciembre)      [Diciembre]
      ,SUM(TABLA.Enero)+SUM(TABLA.Febrero)+SUM(TABLA.Marzo)         [1er_Trim]
      ,SUM(TABLA.Abril)+SUM(TABLA.Mayo)+SUM(TABLA.Junio)            [2do_Trim]
      ,SUM(TABLA.Julio)+SUM(TABLA.Agosto)+SUM(TABLA.Septiembre)     [3er_Trim]
      ,SUM(TABLA.Octubre)+SUM(TABLA.Noviembre)+SUM(TABLA.Diciembre) [4to_Trim]
      ,SUM(TABLA.Enero)+SUM(TABLA.Febrero)+SUM(TABLA.Marzo)
	  +SUM(TABLA.Abril)+SUM(TABLA.Mayo)+SUM(TABLA.Junio)
      +SUM(TABLA.Julio)+SUM(TABLA.Agosto)+SUM(TABLA.Septiembre)
      +SUM(TABLA.Octubre)+SUM(TABLA.Noviembre)+SUM(TABLA.Diciembre) [".$titulo."]
	  ".$sumTotales."
FROM
(
		SELECT 
		       PV.WhsCode
			  ".$marcaOn."
		      ".$pivotTotales."
			  ,ISNULL(PV.[".$periodo."-01],0) AS Enero
			  ,ISNULL(PV.[".$periodo."-02],0) AS Febrero
			  ,ISNULL(PV.[".$periodo."-03],0) AS Marzo
			  ,ISNULL(PV.[".$periodo."-04],0) AS Abril 
			  ,ISNULL(PV.[".$periodo."-05],0) AS Mayo
			  ,ISNULL(PV.[".$periodo."-06],0) AS Junio
			  ,ISNULL(PV.[".$periodo."-07],0) AS Julio
			  ,ISNULL(PV.[".$periodo."-08],0) AS Agosto
			  ,ISNULL(PV.[".$periodo."-09],0) AS Septiembre
			  ,ISNULL(PV.[".$periodo."-10],0) AS Octubre
			  ,ISNULL(PV.[".$periodo."-11],0) AS Noviembre
			  ,ISNULL(PV.[".$periodo."-12],0) AS Diciembre    
		  FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_VW_Ventas]
		   pivot (
						 SUM(".$pivote.")
						 for [Periodo] in 
						  ([".$periodo."-01] 
						  ,[".$periodo."-02] 
						  ,[".$periodo."-03] 
						  ,[".$periodo."-04] 
						  ,[".$periodo."-05] 
						  ,[".$periodo."-06] 
						  ,[".$periodo."-07] 
						  ,[".$periodo."-08] 
						  ,[".$periodo."-09] 
						  ,[".$periodo."-10] 
						  ,[".$periodo."-11] 
						  ,[".$periodo."-12] 
							   )) AS PV

	  WHERE 1=1
	       ".$Wproveedor."
		   ".$WtipoProducto."
		   ".$WbrandManager."
		   ".$WareaNegocio."
 ) AS TABLA

GROUP BY TABLA.WhsCode
         ".$marcaGroupON."
 ";
		
		if($consultar)
		{
				//echo $sql;
		?>
		<div style="width: 100%;
overflow-x:auto;
overflow-y:hidden;">				
            <table   width="2500px;" id="tablelike"  class="lista">
              <thead>
			  
				<tr>
						<th>Informe de Ventas por Bodega <?php echo $periodo;  ?> 
                        <?php
						if($proveedor)
						echo "- Proveedor: ".$proveedor." "; 
						if($tipoProducto)
						echo "- ".$tipoProducto." "; 
						if($areaNegocio)
						echo "- ".$areaNegocio." "; 
						?> 
						</th>
						<th></th>
						<?php
						if($proveedor)
						echo "<th></th>"; 
						?> 
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
					</tr>	
                   <tr>
						<th>Bodega</th>
						<?php
						if($proveedor)
						echo "<th>Marca</th>"; 
						?>
						<th>Enero</th>
						<th>Febrero</th>
						<th>Marzo</th>
						<th>Abril</th>
					    <th>Mayo</th>
                        <th>Junio</th>
						<th>Julio</th>
						<th>Agosto</th>
						<th>Septiembre</th> 
						<th>Octubre</th> 
						<th>Noviembre</th> 
						<th>Diciembre</th> 
						<th style=" border-left:1px solid #A4A4A4;">1er Trim</th>
						<th>2do Trim</th> 
						<th>3er Trim</th> 
						<th style=" border-right:1px solid #A4A4A4;">4to Trim</th> 
						<th>Total UNDS</th> 
						<th>Total CLP</th> 
						<th>Total USD</th> 
						<th>Total CIF</th> 
					</tr>	
           
              </thead>
              <tbody>
		<?php
					$rs = odbc_exec( $conn, $sql );
					if ( !$rs )
					{
					exit( "Error en la consulta SQL" );
					}
							
					if( ($distribuir == "USD") || ($distribuir == "CIF"))
					{
					  $decimales = 4;
					}
			         else
					{
					 $decimales = 0;
					}

					while($resultado = odbc_fetch_array($rs))
					{
					  
			
						echo'
						<tr>
						<td >'.utf8_encode((string)$resultado["Bodega"]).'</td>';
						
						if($proveedor)
						echo '<td >'.utf8_encode((string)$resultado["Marca"]).'</td>';
						
						echo'
						<td ><strong>'.number_format($resultado["Enero"], $decimales, ',', '.').'</strong></td>
						<td ><strong>'.number_format($resultado["Febrero"], $decimales, ',', '.').'</strong></td>
						<td ><strong>'.number_format($resultado["Marzo"], $decimales, ',', '.').'</strong></td>
						<td ><strong>'.number_format($resultado["Abril"], $decimales, ',', '.').'</strong></td>
						<td ><strong>'.number_format($resultado["Mayo"], $decimales, ',', '.').'</strong></td>
						<td ><strong>'.number_format($resultado["Junio"], $decimales, ',', '.').'</strong></td>
						<td ><strong>'.number_format($resultado["Julio"], $decimales, ',', '.').'</strong></td>
						<td ><strong>'.number_format($resultado["Agosto"], $decimales, ',', '.').'</strong></td>
						<td ><strong>'.number_format($resultado["Septiembre"], $decimales, ',', '.').'</strong></td>
						<td ><strong>'.number_format($resultado["Octubre"], $decimales, ',', '.').'</strong></td>
						<td ><strong>'.number_format($resultado["Noviembre"], $decimales, ',', '.').'</strong></td>
						<td ><strong>'.number_format($resultado["Diciembre"], $decimales, ',', '.').'</strong></td>
						
						<td style=" border-left:1px solid #575757;"><strong >'.number_format($resultado["1er_Trim"], $decimales, ',', '.').'</strong></td>
						<td ><strong>'.number_format($resultado["2do_Trim"], $decimales, ',', '.').'</strong></td>
						<td ><strong>'.number_format($resultado["3er_Trim"], $decimales, ',', '.').'</strong></td>
						<td style=" border-right:1px solid #575757;"><strong>'.number_format($resultado["4to_Trim"], $decimales, ',', '.').'</strong></td>
						
						<td ><strong>'.number_format($resultado["Total_UNDS"], 0, '', '.').'</strong></td>
						
						
						<td ><strong>'.number_format($resultado["Total_CLP"], 0, '', '.').'</strong></td>
						<td ><strong>'.number_format($resultado["Total_USD"], 4, ',', '.').'</strong></td>
						<td ><strong>'.number_format($resultado["CtoVtaCIF"], 4, ',', '.').'</strong></td>
						
						
						</tr>';
						
						$tenero = $tenero + $resultado["Enero"];
						$tfebrero = $tfebrero + $resultado["Febrero"];
						$tmarzo = $tmarzo + $resultado["Marzo"];
						$tabril = $tabril + $resultado["Abril"];
						$tmayo = $tmayo + $resultado["Mayo"];
						$tjunio = $tjunio + $resultado["Junio"];
						$tjulio = $tjulio+ $resultado["Julio"];
						$tagosto = $tagosto + $resultado["Agosto"];
						$tseptiembre = $tseptiembre + $resultado["Septiembre"];
						$toctubre = $toctubre + $resultado["Octubre"];
						$tnoviembre= $tnoviembre + $resultado["Noviembre"];
						$tdiciembre = $tdiciembre + $resultado["Diciembre"];
						
						$ttrim1 = $ttrim1 + $resultado["1er_Trim"];
						$ttrim2 = $ttrim2 + $resultado["2do_Trim"];
						$ttrim3 = $ttrim3 + $resultado["3er_Trim"];
						$ttrim4 = $ttrim4 + $resultado["4to_Trim"];
						
						$tUNDS = $tUNDS+ $resultado["Total_UNDS"];
						$tCLP = $tCLP + $resultado["Total_CLP"];
						$tUSD = $tUSD + $resultado["Total_USD"];
						$tCIF = $tCIF + $resultado["CtoVtaCIF"];
						
					
					} // Fin While
			
		?>
		</tbody>
		<tfoot>
		<?php
			echo'<tr style="border-top:2px solid #575757;">
						<td >TOTAL</td>' ;
						
						if($proveedor)
						echo '<td ></td>';
						
						echo'                         
						<td ><strong>'.number_format($tenero, $decimales, ',', '.').'</strong></td>
						<td ><strong>'.number_format($tfebrero, $decimales, ',', '.').'</strong></td>
						<td ><strong>'.number_format($tmarzo, $decimales, ',', '.').'</strong></td>
						<td ><strong>'.number_format($tabril, $decimales, ',', '.').'</strong></td>
						<td ><strong>'.number_format($tmayo, $decimales, ',', '.').'</strong></td>
						<td ><strong>'.number_format($tjunio, $decimales, ',', '.').'</strong></td>
						<td ><strong>'.number_format($tjulio, $decimales, ',', '.').'</strong></td>
						<td ><strong>'.number_format($tagosto, $decimales, ',', '.').'</strong></td>
						<td ><strong>'.number_format($tseptiembre, $decimales, ',', '.').'</strong></td>
						<td ><strong>'.number_format($toctubre, $decimales, ',', '.').'</strong></td>
						<td ><strong>'.number_format($tnoviembre, $decimales, ',', '.').'</strong></td>
						<td ><strong>'.number_format($tdiciembre, $decimales, ',', '.').'</strong></td>
						
						<td style=" border-left:1px solid #575757;"><strong >'.number_format($ttrim1, $decimales, ',', '.').'</strong></td>
						<td ><strong>'.number_format($ttrim2, $decimales, ',', '.').'</strong></td>
						<td ><strong>'.number_format($ttrim3, $decimales, ',', '.').'</strong></td>
						<td style=" border-right:1px solid #575757;"><strong>'.number_format($ttrim4, $decimales, ',', '.').'</strong></td>
						
						<td ><strong>'.number_format($tUNDS, 0, '', '.').'</strong></td>
						
						
						<td ><strong>'.number_format($tCLP, 0, '', '.').'</strong></td>
						<td ><strong>'.number_format($tUSD, 4, ',', '.').'</strong></td>
						<td ><strong>'.number_format($tCIF, 4, ',', '.').'</strong></td>
						
						
						</tr>';
						
						}//Fin consultar
		 ?>
		</tfoot>
	</table>
<div>	

<style type="text/css">
#tablelike a:link {
	color: #666;
	font-weight: bold;
	text-decoration:none;
}
#tablelike a:visited {
	color: #999999;
	font-weight:bold;
	text-decoration:none;
}
#tablelike a:active,
#tablelike a:hover {
	color: #bd5a35;
	text-decoration:underline;
}
#tablelike {
	font-family:Arial, Helvetica, sans-serif;
	color:#666;
	font-size:10px;
	text-shadow: 1px 1px 0px #fff;
	background:#649EBF;
	margin:10px;
	border:#ccc 1px solid;

	-moz-border-radius:3px;
	-webkit-border-radius:3px;
	border-radius:3px;

	-moz-box-shadow: 0 1px 2px #d1d1d1;
	-webkit-box-shadow: 0 1px 2px #d1d1d1;
	box-shadow: 0 1px 2px #d1d1d1;
}
#tablelike th {
	padding:11px 15px 12px 15px;
	border-top:1px solid #fafafa;
	border-bottom:1px solid #e0e0e0;

	background: #ededed;
	background: -webkit-gradient(linear, left top, left bottom, from(#ededed), to(#ebebeb));
	background: -moz-linear-gradient(top,  #ededed,  #ebebeb);
}
#tablelike th:first-child {
	text-align: left;
	padding-left:20px;
}
#tablelike tr:first-child th:first-child {
	-moz-border-radius-topleft:3px;
	-webkit-border-top-left-radius:3px;
	border-top-left-radius:3px;
}
#tablelike tr:first-child th:last-child {
	-moz-border-radius-topright:3px;
	-webkit-border-top-right-radius:3px;
	border-top-right-radius:3px;
}
#tablelike tr {
	text-align: center;
	padding-left:20px;
}
#tablelike td:first-child {
	text-align: left;
	padding-left:20px;
	border-left: 0;
}
#tablelike td {
	padding:8px;
	border-top: 1px solid #ffffff;
	border-bottom:1px solid #e0e0e0;
	border-left: 1px solid #e0e0e0;

	background: #fafafa;
	background: -webkit-gradient(linear, left top, left bottom, from(#fbfbfb), to(#fafafa));
	background: -moz-linear-gradient(top,  #fbfbfb,  #fafafa);
}
#tablelike tr.even td {
	background: #f6f6f6;
	background: -webkit-gradient(linear, left top, left bottom, from(#f8f8f8), to(#f6f6f6));
	background: -moz-linear-gradient(top,  #f8f8f8,  #f6f6f6);
}
#tablelike tr:last-child td {
	border-bottom:0;
}
#tablelike tr:last-child td:first-child {
	-moz-border-radius-bottomleft:3px;
	-webkit-border-bottom-left-radius:3px;
	border-bottom-left-radius:3px;
}
#tablelike tr:last-child td:last-child {
	-moz-border-radius-bottomright:3px;
	-webkit-border-bottom-right-radius:3px;
	border-bottom-right-radius:3px;
}
#tablelike tr:hover td {
	background: #f2f2f2;
	background: -webkit-gradient(linear, left top, left bottom, from(#f2f2f2), to(#f0f0f0));
	background: -moz-linear-gradient(top,  #f2f2f2,  #f0f0f0);	
}
</style>

	<?php odbc_close( $conn );?>