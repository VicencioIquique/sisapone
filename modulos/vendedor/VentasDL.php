<?php 
require_once("clases/conexionocdb.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
$vendedor = $_GET['id'];
$vendedorSelect = $_GET['id'];

$vendedor = str_pad($vendedor, 3, '0', 'STR_PAD_LEFT');
$finicio = $_GET['inicio'];
$consultar = $_GET['agregar'];


if(!$finicio)
{
	 $finicio = date("m/01/Y");
	 $ffin= date("m/d/Y");
}
function cambiarFecha($fecha) {
					  return implode("-", array_reverse(explode("-", $fecha)));
					}
	$finicio2 = cambiarFecha($finicio);
	$ffin2 = cambiarFecha($ffin);
	if ($tipoProducto)
			{
				$WtipoProducto = "  AND (TipoProducto LIKE '".$tipoProducto."') ";

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
            });

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
		<?php // pregunta si ha ingresado una fecha para que se muestre el imagen link de generar Excel
		
		if($finicio2){
		
		echo'<form action="/sisapone/clases/ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion"> 
			<center><img src="images/excel.png" width="30px" height="30px" class="botonExcel"  /> </center>
			<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" /> 
			</form> ';
		
		
		?>
		     <!-- <li><a href="../SISAP/modulos/vendedor/ventasproexcel.php?id=<?php //echo $vendedor; ?>&modulo=<?php // echo $modulo; ?>&inicio=<?php //echo $finicio2; ?>&fin=<?php // echo $ffin2; ?>&marca=<?php //echo $marca; ?>&codbarra=<?php //echo $codbarra; ?>"><img src="images/excel.png" width="30px" height="30px" /></a></li>-->
		<?php }?>
	</ul>
    <div class="items">
        <div id="one"> 
        	<form action="" method="GET" id="horizontalForm">
	            <fieldset>
					<legend>Ingresar Fecha </legend>
							  <input name="opc" type="hidden" id="opc" size="40" class="required" value="VentasDL" />
	                            <label for="fecha1">
						            Fecha
	                            <input name="inicio" type="text" id="inicio" size="40" class="required" value="<?php echo $finicio;?>"  />
	                            </label>
							    <input style="clear:initial;" name="agregar" type="submit" id="agregar" class="submit" value="Consultar" />

				</fieldset>
            </form>
        </div> <!-- fin div two-->
    </div> <!-- fin items -->
</div> <!-- fin idTabs -->

<table  id="ssptable2" class="lista">
	<thead>
		<tr>
			<th ></th>
			<th cols="5" >Fecha</th>
			<th  ><?php echo $finicio;?></th>
			<th  ></th>
			<th  ></th
		</tr>
	</head>
	<thead>
		<tr>
			<th style="width:150px;">Locales</th>
			<th>Desde</th>
			<th>Hasta</th> 
			<th>Retencion DL</th> 
			<th>Total Diario</th> 
		</tr>
	</thead>
                

<tbody>
<?php
	$total =0;
	$cantotal =0;
	$totalCIFEXT =0;
	$totalCIF=0;
	$totalUSD=0;
if($consultar)
{
	$sql="
		SELECT T1.*,T2.Total
		FROM (
			SELECT  TABLA.WhsCode   [Local]
				   ,MIN(CASE 
						  WHEN TABLA.ObjType=13 THEN CONVERT(int,TABLA.DocNum)
						END)        [DocMin]
				   ,MAX(CASE 
						  WHEN TABLA.ObjType=13 THEN CONVERT(int,TABLA.DocNum)
						END)        [DocMax]
				   ,SUM(TABLA.RetencionDL)                [RetencionDL]
			FROM (
				SELECT  DISTINCT [TransId]
					  ,[DocNum]
					  ,[ObjType]
					  ,[DocDate]
					  ,[WhsCode]
					  ,[RetencionDL]
    			FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_VW_VtasD_RPRO]
				WHERE 1=1
				AND Year = '2023'
				AND CONVERT(date,[DocDate]) = '".$finicio."'
			) AS TABLA
			GROUP BY TABLA.WhsCode 
		) AS T1 LEFT JOIN 
			(
			SELECT WhsCode
      			,SUM(TotalCLP) [Total]
  			FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_VW_VtasD_RPRO]
			WHERE 1=1
			  AND Year = '2024'
			  AND CONVERT(date,[DocDate]) = '".$finicio."'
			GROUP BY WhsCode) T2 ON T1.Local = T2.WhsCode
		";
}
//echo $sql;
//echo $sql2;
	$rs = odbc_exec( $conn, $sql );
	if ( !$rs)
		{
	   		exit( "Error en la consulta SQL" );
		}
	if($consultar)
		{
        	while(($resultado = odbc_fetch_array($rs)) )
				{ 
					echo '<tr>
							<td  >'.utf8_encode(str_replace("ZFI.","LOCAL ",$resultado["Local"])).'</td> 									
							<td >'.number_format($resultado["DocMin"], 0, '', '.').'</td> 
							<td >'.number_format($resultado["DocMax"], 0, '', '.').'</td>
							<td ><strong>'.number_format($resultado["RetencionDL"], 0, '', '.').'</strong></td>
							<td ><strong>'.number_format($resultado["Total"], 0, '', '.').'</strong></td>';
					echo'</tr>' ;

					$TotalReten = $TotalReten + $resultado["RetencionDL"];
					$TotalDia = $TotalDia + $resultado["Total"];

				}
		}
?>
</tbody>
<tbody>		
	<tr style=" border-top:2px double #B5B5B5;">
		<td><strong>TOTALES</strong></td>
		<td></td>
		<td></td>
		<td><strong><?php echo number_format($TotalReten, 2, ',', '.'); ?></strong></td>
		<td><strong><?php echo number_format($TotalDia, 2, ',', '.'); ?></strong></td>
	</tr>
</tbody>
                
<?php odbc_close( $conn );?>


