<?php 
require_once("clases/conexionocdb.php");//incluimos archivo de conexión

ini_set('max_execution_time', 300); //300 seconds = 5 minutes

$vendedor = $_GET['id'];
$vendedor = str_pad($vendedor, 3, '0', 'STR_PAD_LEFT');
$modulo = $_GET['modulo'];
$grupo = $_GET['grupo'];
$finicio = $_GET['inicio'];
$ffin = $_GET['fin'];
$top = $_GET['top'];

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
	$conModulo = "  AND (dbo.RP_ReceiptsDet_SAP.Bodega LIKE '".$modulo."') ";
	$conModuloGroup = " , dbo.RP_ReceiptsDet_SAP.Bodega ";
}

if ($grupo)// si selecciono modulo, se genera la consulta
{
	$conGrupo = "  AND (ItmsGrpCod =  ".$grupo.") ";
	$conGrupoGroup = " ,ItmsGrpCod ";
}

/************************************************************ PARA LAS MARCAS ********************************************************************************/


$sql2="SELECT ".$top."
	  SUM([SumCantidad]) AS SumCantidad
	   ,SUM([CIF]) AS CIF
      ,SUM([SumaMarca]) AS SumaMarca
	  ,SUM(USD) AS USD
      ,Name
  FROM [RP_VICENCIO].[dbo].[SI_VentasPorMarcaUnion_ON]
  WHERE (FechaDocto >= '".$finicio2." 00:00:00.000') AND (FechaDocto <= '".$ffin2." 23:59:59.000') ".$conGrupo."
  GROUP BY U_VK_Marca, Name ".$conGrupoGroup."
  ORDER BY SumaMarca DESC";
  
 $sql="   
 SELECT
		[Marca] AS Name
      --,[TipoVenta]
     -- ,[AreaNegocio]
      --,[TipoProducto]
      ,SUM([Quantity]) AS SumCantidad
      ,SUM([Total_CLP]) AS SumaMarca
      ,SUM([Total_USD]) AS USD
      ,SUM([CtoVtaCIF]) AS CIF
  FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_VW_Ventas]
  WHERE 1= 1 
	AND Periodo >= '2014-10'
	AND Periodo <= '2014-10'
	--AND Empresa = 'SVX_ZOFRI'
  GROUP BY [Marca]
  ORDER BY USD DESC";

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
          <li><a href="#one"><img src="images/agregar.png" width="30px" height="30px" /></a></li>
		<?php 
		if($finicio2){
		
		echo'<form action="/sisap/clases/ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion"> 
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
					<input name="opc" type="hidden" id="opc" size="40" class="required" value="rankMarca" />
					    <?php
						
								if($_SESSION["usuario_modulo"] == -1)
								{
								
									echo '<label class="first" for="title1">
									Empresa
									<select id="empresa" name="empresa"   class="styled" >
									<option ></option>								
									<option value="EXB_ZOFRI">Eximben</option>
									<option value="SVX_ZOFRI">Servimex</option>
									<option value="EXB_AEROP">Aeropuerto</option>
									</select>
									</label>';
									
									echo '<label class="first" for="title1">
									Tipo Venta
									<select id="tipoVenta" name="tipoVenta"   class="styled" >
									<option ></option>								
									<option value="EXB_ZOFRI">Retail</option>
									<option value="SVX_ZOFRI">Mayrista</option>
								
									</select>
									</label>';
								}
								
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
									if($modulo)
									{
										echo'<option value="'.$modulo.'" selected>'.getmodulo($modulo).'</option>';
									}
									echo'<option value="100">Artículos</option>
									<option value="101">Perfumes</option>
									<option value="102">Cosmeticos</option>
									<option value="103">Ropa</option>
									<option value="104">Accesorios</option>
									<option value="105">Confitería</option>
									<option value="106">Óptica</option>
									<option value="107">Servicios</option>
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
				<td >'.utf8_encode($resultado["Name"]).'</td>
				<td >'.utf8_encode($resultado["ItmsGrpNam"]).'</td>
				<td ><strong>'.number_format($resultado["SumCantidad"], 0, '', '.').'</strong></td>
				<td ><strong>'.number_format($resultado["SumaMarca"], 0, '', '.').'</strong></td> 
				<td ><strong>'.number_format($resultado["USD"], 2, ',', '.').'</strong></td> 
				<td ><strong>'.number_format(($resultado["USD"]/$totalSUM)*100, 2, ',', '.').'%</strong></td>' ;
				$totalCant = $totalCant + $resultado["SumCantidad"];
				$total = $total + $resultado["SumaMarca"];
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
				<td ><strong><?php echo number_format($totalPI, 2, ',', '.'); ?>%</strong></td>
			</tr>
	  </tfoot>
	</table>
 </div>  <!-- fin de tabla de vendedores -->
<script type="text/javascript"> 
  $("#usual1 ul").idTabs(); 
</script>
 <?php odbc_close( $conn );?>