<?php 
require_once("clases/conexionocdb.php");//incluimos archivo de conexión

ini_set('max_execution_time', 1000); //300 seconds = 5 minutes

$vendedor = $_GET['id'];
$vendedor = str_pad($vendedor, 3, '0', 'STR_PAD_LEFT');
$modulo = $_GET['modulo'];
$grupo = $_GET['grupo'];
$finicio = $_GET['inicio'];
$ffin = $_GET['fin'];
$top = $_GET['top'];
$tipoProducto = $_GET['tipoProducto'];

if(!$finicio)
{
	 $finicio = date("Y-m");
	 $ffin= date("Y-m");
}

/*function cambiarFecha($fecha) 
{
  return implode("-", array_reverse(explode("-", $fecha)));
}*/
/*$finicio2 = cambiarFecha($finicio);
$ffin2 = cambiarFecha($ffin);
*/
if ($modulo)// si selecciono modulo, se genera la consulta
{
	$conModulo = "  AND (WhsCode LIKE '".$modulo."') ";
	$conModuloGroup = " , WhsCode ";
}

if ($tipoProducto)// si selecciono modulo, se genera la consulta
{
	$conTipo = "   AND TipoProducto =  '".$tipoProducto."'";
	
}

if ($grupo)// si selecciono modulo, se genera la consulta
{
	$conAreaNegocio = ",[AreaNegocio]";
	$conGrupo = " AND AreaNegocio =  '".$grupo."' ";
	$conGrupoGroup = " ,AreaNegocio";
}

/************************************************************ PARA LOS VENDEDORES ********************************************************************************/

/*$sql= "SELECT      SUM(dbo.RP_ReceiptsDet_SAP.PrecioExtendido) AS SumaMarca, SBO_Imp_Eximben_SAC.dbo.OITM.U_VK_Marca, 
                      SUM(dbo.RP_ReceiptsDet_SAP.Cantidad) AS SumCantidad, View_OMAR_1.Name, SBO_Imp_Eximben_SAC.dbo.OITB.ItmsGrpNam
FROM         SBO_Imp_Eximben_SAC.dbo.OITB INNER JOIN
               $conAreaNegocio       SBO_Imp_Eximben_SAC.dbo.OITM ON SBO_Imp_Eximben_SAC.dbo.OITB.ItmsGrpCod = SBO_Imp_Eximben_SAC.dbo.OITM.ItmsGrpCod RIGHT OUTER JOIN
                      dbo.RP_ReceiptsDet_SAP INNER JOIN
                      dbo.RP_ReceiptsCab_SAP ON dbo.RP_ReceiptsDet_SAP.ID = dbo.RP_ReceiptsCab_SAP.ID ON 
                      SBO_Imp_Eximben_SAC.dbo.OITM.ItemCode = dbo.RP_ReceiptsDet_SAP.Sku COLLATE SQL_Latin1_General_CP850_CI_AS LEFT OUTER JOIN
                      dbo.View_OMAR AS View_OMAR_1 ON SBO_Imp_Eximben_SAC.dbo.OITM.U_VK_Marca = View_OMAR_1.Code

WHERE     (dbo.RP_ReceiptsCab_SAP.FechaDocto >= '".$finicio2." 00:00:00.000') AND (dbo.RP_ReceiptsCab_SAP.FechaDocto <= '".$ffin2." 23:59:59.000')  AND  (dbo.RP_ReceiptsDet_SAP.TipoDocto <> 3)
			".$conModulo."  ".$conGrupo." 
GROUP BY SBO_Imp_Eximben_SAC.dbo.OITM.U_VK_Marca, View_OMAR_1.Name, SBO_Imp_Eximben_SAC.dbo.OITM.ItmsGrpCod, 
                      SBO_Imp_Eximben_SAC.dbo.OITB.ItmsGrpCod, SBO_Imp_Eximben_SAC.dbo.OITB.ItmsGrpNam ".$conModuloGroup." 
ORDER BY SBO_Imp_Eximben_SAC.dbo.OITM.U_VK_Marca";*/

  
$sql="

SELECT 
       [Marca]
      ,SUM([Cantidad]) [SumCantidad]
      ,SUM([TotalCLP]) [SumaMarca]
      ,SUM([TotalCIF]) [CIF]
      ,SUM([TotalUSD]) [USD]
  
  FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_VW_VtasD_RPRO_Slim]
  WHERE  Periodo >= '".$finicio."' AND  Periodo <= '".$ffin."'
	".$conGrupo."
	".$conModulo."
	".$conTipo."
	GROUP BY [Marca] ".$conGrupoGroup." ".$conModuloGroup."
  ORDER BY SumaMarca DESC


";

//echo $sql;			
	echo'  <script src="graficos/amcharts/amcharts.js" type="text/javascript"></script> ';//incluyo la librería para generar graficos	
	include("graficos/marcas.php");// grafico que mustra las ventas por marcas en peso 
	include("graficos/unidadPorMarca.php");// grafico que muestra las cantidades en unidad por marca					
?>
<script type="text/javascript">
  $(document).ready(function(){
				//comienza focus en modulo
				$('#moduloid').focus();
				// calendarios en text de fecha inicio fin
				$( "#inicio" ).datepicker({
					dateFormat: 'yy-mm',
					changeMonth: true,
					changeYear: true,
					
					showButtonPanel: true,

					onClose: function(dateText, inst) {
						var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
						var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
						$(this).val($.datepicker.formatDate('yy-mm', new Date(year, month, 1)));
					}
				}  );
				
				$("#inicio").focus(function () {
					$(".ui-datepicker-calendar").hide();
					$("#ui-datepicker-div").position({
						my: "center top",
						at: "center bottom",
						of: $(this)
					});
				});
				//formatos de las fechas
			   // $('#inicio').datepicker('option', {dateFormat: 'dd-mm-yy'});
				$( "#fin" ).datepicker( {
					dateFormat: 'yy-mm',
					changeMonth: true,
					changeYear: true,
					
					showButtonPanel: true,

					onClose: function(dateText, inst) {
						var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
						var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
						$(this).val($.datepicker.formatDate('yy-mm', new Date(year, month, 1)));
					}
				}  );
				$("#fin").focus(function () {
					$(".ui-datepicker-calendar").hide();
					$("#ui-datepicker-div").position({
						my: "center top",
						at: "center bottom",
						of: $(this)
					});
				});
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
          <li><a href="#one"><img src="images/agregar.png" width="30px" height="30px" /></a></li>
		<?php 
		if($finicio2){
		
		echo'<form action="/sisapone/clases/ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion"> 
			<center><img src="images/excel.png" width="30px" height="30px" class="botonExcel"  /> </center>
			<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" /> 
			</form> ';
		}
		?>
	 </ul>
      <div class="items">
        <div id="one"> 
         <form action="" method="GET" id="horizontalForm">
            <fieldset>
				<legend>Ingresar Fechas</legend>
					<input name="opc" type="hidden" id="opc" size="40" class="required" value="ventmarca" />
					    <?php
							 	if($_SESSION["usuario_modulo"] == -1)
								{
									
									echo '<label class="first" for="title1">
									Retail
									<select id="moduloid" name="modulo"    class="styled" >
									<option ></option>';
									
									echo'
									<option value="ECM.2002">Ventas WEB</option>
									<option value="ZFI.2077">Modulo 2077</option>
									<option value="ZFI.1010">Modulo 1010</option>
									<option value="ZFI.1132">Modulo 1132</option>
									<option value="ZFI.181">Modulo 181</option>
									<option value="ZFI.184">Modulo 184</option>
									<option value="ZFI.2002">Modulo 2002</option>
									<option value="ZFI.6115">Modulo 6115</option>
									<option value="ZFI.6130">Modulo 6130</option>
									<option value="Local.2">Local 2</option>
									<option value="Local.8">Local 8</option>
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
					<label for="top">
                    	
                    </label>
                        <input name="agregar" type="submit" id="agregar" class="submit" value="Consultar" />
						    <?php
							 	
									
									echo '<label class="first" for="title1">
									Grupo
									<select id="moduloid" name="grupo"    class="styled" >
									<option ></option>';
									
									echo'<option value="Artículos">Artículos</option>
									<option value="Perfumes">Perfumes</option>
									<option value="Cosmeticos">Cosmeticos</option>
									<option value="Ropa">Ropa</option>
									<option value="Accesorios">Accesorios</option>
									<option value="Confitería">Confitería</option>
									<option value="Óptica">Óptica</option>
									<option value="Servicios">Servicios</option>
									</select>
				            </label>';
								

							 	
									
									echo '<label class="first" for="title1">
									Top
									<select id="top" name="top" lass="styled" >
									<option ></option>';
									if($top)
									{
										echo'<option value="'.$top.'" selected>'.$top.'</option>';
									}
									echo'<option value="TOP 5">Top 5</option>
									<option value="TOP 10">Top 10</option>
									<option value="TOP 15">Top 15</option>
									<option value="TOP 20">Top 20</option>
									</select>
				            </label>';
								
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
						
				</fieldset>
            </form>
         </div> <!-- fin div two-->
      </div> <!-- fin items -->
    </div> <!-- fin idTabs -->
      
      
<div id="usual1" class="usual" > 
  <ul> 
    <li ><a id="tabdua" href="#tab1" class="selected">Gráfico Ventas</a></li> 
    <li ><a id="tabdua" href="#tab3">Detalle</a></li> 
  </ul> 
  <div id="tab1"><?php 
		//echo' <div id="ventanual" style="width:100%; height:200px;"></div>';
		echo'<div id="unidadCantidad" style="width:100%; height: 400px;"></div>';
		echo'<div id="ingresos" style="width:100%; height: 400px;"></div>';
	?>
  </div> <!-- fin de grafico de marcas -->
  <div id="tab3"> 
  	<table  id="ssptable2" class="lista">
      <thead>
            <tr>
				<th>N°</th>
                <th>Marca</th>
				<th>Grupo</th>
                <th>Cantidad</th>
                <th>Total</th>
				<th>USD</th>
				<th>CIF</th>
				<th>Pi %</th>
            </tr>
      </thead>
      <tbody>
   <?php
	$total =0;
	$cantotal =0;
     //echo $sql;	
	$rs = odbc_exec( $conn, $sql );
	if ( !$rs )
	{
		exit( "Error en la consulta SQL" );
	}
	$rs2 = odbc_exec( $conn, $sql );
	if ( !$rs2 )
	{
		exit( "Error en la consulta SQL" );
	}
	$totalSUM = 0;
	
	while($resultado2 = odbc_fetch_array($rs2))
	{ 
			 $totalSUM = $totalSUM + $resultado2["USD"];
	}
	//echo $totalSUM;
		$i=1;
		  while($resultado = odbc_fetch_array($rs)){ 
		   echo '<tr>
				<td style="background-color:#6C6B6B;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" >'.$i.'</td>
				<td >'.utf8_encode($resultado["Marca"]).'</td>
				<td >'.utf8_encode($resultado["ItmsGrpNam"]).'</td>
				<td ><strong>'.number_format($resultado["SumCantidad"], 0, '', '.').'</strong></td>
				<td ><strong>'.number_format($resultado["SumaMarca"], 0, '', '.').'</strong></td> 
				<td ><strong>'.number_format($resultado["USD"], 2, ',', '.').'</strong></td> 
				<td ><strong>'.number_format($resultado["CIF"], 2, ',', '.').'</strong></td> 
				<td ><strong>'.number_format(($resultado["USD"]/$totalSUM)*100, 2, ',', '.').'%</strong></td>' ;
				$totalCant = $totalCant + $resultado["SumCantidad"];
				$total = $total + $resultado["SumaMarca"];
				$totalCIF = $totalCIF + $resultado["CIF"];
				$totalUSD = $totalUSD + $resultado["USD"];
				$totalPI = $totalPI + ($resultado["USD"]/$totalSUM)*100;
				//$cantotal = $cantotal + $resultado["Cantidad"];
				
			echo '</tr>';
			$i++;
			}?>
	  </tbody>
	  <tfoot>
			<tr style=" border-top:2px double #B5B5B5;">
				<td></td>
				<td ></td>
				<td ></td>
				<td ><strong><?php echo number_format($totalCant, 0, '', '.'); ?></strong></td>
				<td ><strong><?php echo number_format($total, 0, '', '.'); ?></strong></td>
				<td ><strong><?php echo number_format($totalUSD, 2, ',', '.'); ?></strong></td>
				<td ><strong><?php echo number_format($totalCIF, 2, ',', '.'); ?></strong></td>
				<td ><strong><?php echo number_format($totalPI, 2, ',', '.'); ?>%</strong></td>
			</tr>
	  </tfoot>
	</table>
 </div>  <!-- fin de tabla de vendedores -->
<script type="text/javascript"> 
  $("#usual1 ul").idTabs(); 
</script>
 <?php odbc_close( $conn );?>