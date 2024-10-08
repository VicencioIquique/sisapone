<?php
// Incluye solo la conexión necesaria
include_once("clases/conexionocdb.php");

// Obtener los parámetros necesarios
$vendedor = $_GET['id'];
$codbarra = $_GET['codbarra'];
$finicio = $_GET['inicio'];
$ffin = $_GET['fin'];

// Si no hay fechas, se definen las predeterminadas
if(!$finicio) {
    $finicio = date("m/d/Y");
    $ffin= date("m/d/Y");
}

// Cambiar formato de fecha si es necesario
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
				<legend>Ingresar Codigo</legend>
							 
							 <input name="opc" type="hidden" id="opc" size="40" class="required" value="buscarCodigoBodega" />
							 
                             

							 <label for="sku">
					            Codigo de Barra
                            <input name="codbarra" type="text" class="codbarra2" id="codbarra2" size="40"  value="<?php echo $codbarra;?>" />
                            </label>
							 <input style="clear:initial;" name="agregar" type="submit" id="agregar" class="submit" value="Consultar" />

			</fieldset>
            </form>
			  <?php

// Ejecuta la consulta de la cabecera
$sql= "SELECT dbo.RP_Articulos.ALU, dbo.RP_Articulos.PRICE01, dbo.RP_Articulos.DESC1
       FROM dbo.RP_Articulos
       LEFT OUTER JOIN dbo.oITM_From_SBO 
       ON dbo.RP_Articulos.ALU = dbo.oITM_From_SBO.ItemCode COLLATE SQL_Latin1_General_CP1_CI_AS
       WHERE dbo.RP_Articulos.ALU = '".$codbarra."'";

$stock = explode("-",getBodegaStock($codbarra));

// Ejecuta la consulta usando la conexión $conn2 (o la que se definió en conexionodbc-2.php)
$rs = odbc_exec($conn, $sql);

if (!$rs) {
    exit("Error en la consulta SQL1");
}

while ($resultado = odbc_fetch_array($rs)) {
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
						
						
						
						<div id="muestraPrecio" class="caja2" style="margin-top:10px; font-size:24px; text-align:center; padding-top:10px;float:left;width:12%; height:10px; background-color: #054950;border: 1px solid #d5d5d5;">
								<span>13-1</span>	

						</div>
						<div id="muestraPrecio" class="caja2" style="margin-top:10px; font-size:24px; text-align:center; padding-top:10px;float:left;width:12%; height:10px; background-color: #054950;border: 1px solid #d5d5d5;">
								<span>13-2</span>	

						</div>
						<div id="muestraPrecio" class="caja2" style="margin-top:10px; font-size:24px; text-align:center; padding-top:10px;float:left;width:12%; height:10px; background-color: #054950;border: 1px solid #d5d5d5;">
								<span>14-6</span>	
						</div>
						<div id="muestraPrecio" class="caja2" style="margin-top:10px; font-size:24px; text-align:center; padding-top:10px;float:left;width:12%; height:10px;  background-color: #054950;border: 1px solid #d5d5d5;">
								<span>13-6</span>	
						</div>
						<div id="muestraPrecio" class="caja2" style="margin-top:10px; font-size:24px; text-align:center; padding-top:10px;float:left;width:12%;height:10px;  background-color: #054950;border: 1px solid #d5d5d5;">
								<span>17SZ</span>	
						</div>
						<div id="muestraPrecio" class="caja2" style="margin-top:10px; font-size:24px; text-align:center; padding-top:10px;float:left;width:11%;height:10px;  background-color: #054950;border: 1px solid #d5d5d5;">
								<span>1623 </span>	
						</div>
						
						<!-- modulos -->
										
						<div id="muestraPrecio" class="caja2" style="margin-top:1px; font-size:24px; text-align:center; padding-top:10px;float:left;width:12%; height:80px; background-color: #054950;border: 1px solid #d5d5d5;">
								<span style="font-size:55px;  text-shadow: #000 0px 0px 10px; text-shadow: #000 0px 0px 10px 10px; ">'.$stock[0].'</span>	

						</div>
						<div id="muestraPrecio" class="caja2" style="margin-top:1px; font-size:24px; text-align:center; padding-top:10px;float:left;width:12%; height:80px; background-color: #054950;border: 1px solid #d5d5d5;">
								<span style="font-size:55px; text-shadow: #000 0px 0px 10px; text-shadow: #000 0px 0px 10px 10px;">'.$stock[1].'</span>	
						</div>
						<div id="muestraPrecio" class="caja2" style="margin-top:1px; font-size:24px; text-align:center; padding-top:10px;float:left;width:12%; height:80px; background-color: #054950;border: 1px solid #d5d5d5;">
								<span style="font-size:55px; text-shadow: #000 0px 0px 10px; text-shadow: #000 0px 0px 10px 10px;">'.$stock[2].'</span>	
						</div>
						<div id="muestraPrecio" class="caja2" style="margin-top:1px; font-size:24px; text-align:center; padding-top:10px;float:left;width:12%; height:80px;  background-color: #054950;border: 1px solid #d5d5d5;">
								<span style="font-size:55px; text-shadow: #000 0px 0px 10px; text-shadow: #000 0px 0px 10px 10px;">'.$stock[3].'</span>	
						</div>
						<div id="muestraPrecio" class="caja2" style="margin-top:1px; font-size:24px; text-align:center; padding-top:10px;float:left;width:12%;height:80px;  background-color: #054950;border: 1px solid #d5d5d5;">
								<span style="font-size:55px; text-shadow: #000 0px 0px 10px; text-shadow: #000 0px 0px 10px 10px;">'.$stock[4].'</span>	
						</div>
						<div id="muestraPrecio" class="caja2" style="margin-top:1px; font-size:24px; text-align:center; padding-top:10px;float:left;width:11%;height:80px;  background-color: #054950;border: 1px solid #d5d5d5;">
								<span style="font-size:55px; text-shadow: #000 0px 0px 10px; text-shadow: #000 0px 0px 10px 10px;">'.$stock[5].'</span>	
						</div>
						
						
			</div>';
}

odbc_close($conn);
?>
