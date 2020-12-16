<style>
	#ssptable2{
		background-color:red;
	}
</style>
<?php
require_once("clases/conexionocdb.php");
ini_set('max_execution_time', 600); //300 seconds = 5 minutes
$vendedor = $_GET['id'];
$vendedorSelect = $_GET['id'];

$vendedor = str_pad($vendedor, 3, '0', 'STR_PAD_LEFT');
$finicio = $_GET['inicio'];
$fcorteStock = $_GET['corteStock'];
$fmarca = $_GET['linea'];
$fproveedor = $_GET['proveedor'];
$ffin = $_GET['fin'];
$codbarra = $_GET['codbarra'];
$consultar = $_GET['agregar'];
$marca = '';

$cont = $_GET['cont'];
$tipoProducto = $_GET['tipoProducto'];
$areaNegocio = $_GET['areaNegocio'];
$tipoReporte = $_GET['tipoReporte'];

if(!$finicio)
{
	 $finicio = date("m/01/Y");
	 $ffin= date("m/d/Y");
}

if(!$finicio){
	 $finicio = date("Y-m");

}
function cambiarFecha($fecha) {
					  return implode("-", array_reverse(explode("-", $fecha)));
					}
					$finicio2 = cambiarFecha($finicio);
					$ffin2 = cambiarFecha($ffin);
?>
<script type="text/javascript">
  $(document).ready(function(){
				//comienza focus en modulo
				$('#moduloid').focus();
				// calendarios en text de fecha inicio fin
				$( "#inicio" ).datepicker({
					dateFormat: 'yy-mm',
					//changeMonth: true,
					changeYear: true,

					showButtonPanel: true,

					onClose: function(dateText, inst) {
						//var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
						var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
						$(this).val($.datepicker.formatDate('yy', new Date(year, 1)));
					}
				} );
				$("#inicio").focus(function () {
					$(".ui-datepicker-calendar").hide();
					$(".ui-datepicker-month").hide();
					$("#ui-datepicker-div").position({
						my: "center top",
						at: "center bottom",
						of: $(this)
					});
				});
				//formatos de las fechas

				$( "#corteStock" ).datepicker({
					dateFormat: 'yy-mm',
					changeMonth: true,
					changeYear: true,

					showButtonPanel: true,

					onClose: function(dateText, inst) {
						var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
						var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
						$(this).val($.datepicker.formatDate('yy-mm', new Date(year,month, 1)));
					}
				} );
				$("#corteStock").focus(function () {
					$(".ui-datepicker-calendar").hide();
					$("#ui-datepicker-div").position({
						my: "center top",
						at: "center bottom",
						of: $(this)
					});
				});
				//formatos de las fechas
				
				$( "#fin" ).datepicker(  );
				//$('#fin').datepicker('option', {dateFormat: 'dd-mm-yy'});


            });
</script>
<script language="javascript">
$(document).ready(function() {
   	
				$("#proveedor").change(function(){
					$("#cargaLinea").css('display','');
					$("#linea").css('display','none');
					var prov = $("#proveedor").val();
					var jsonProveedor = {
						proveedor : prov
					};
					$.post('modulos/vendedor/script/obtenerLinea.php',{jsonProveedor:jsonProveedor},function(resPHP){
						var res = $.parseJSON(resPHP);
							$("#linea").empty();
							$("#linea").append('<option value=""></option>');
						for(i=0;i<res.length;i++){
							$("#linea").append('<option value="'+res[i]['marca']+'">'+res[i]['marca']+'</option>');
						}
						$("#cargaLinea").css('display','none');
						$("#linea").css('display','');
					});
				});
	//$("#dialogDescarga .ui-dialog-titlebar "){ display:none; }
});
</script>
<div class="idTabs">
      <ul>
        <li><a href="#one"><img src="images/agregar.png" width="30px" height="30px" /></a></li>
	 </ul>
      <div class="items">
        <div id="one"> <form action="" method="GET" id="horizontalForm">
	
			<!-- FORMULARIO PARA GENERACIÓN DE REPORTE -->
            <fieldset>
				<legend>Ingresar proveedor</legend>
					<input name="opc" type="hidden" id="opc" size="40" class="required" value="listaPrecio" />
						<label class="first" for="title1">
							Proveedor
							<select id="proveedor" name="proveedor" class="styled" >
								<option value=""></option>
								<?php
									$sql="SELECT DISTINCT Proveedor FROM SBO_Imp_Eximben_SAC.dbo.VIC_VW_ItemsVenta ORDER  BY Proveedor ASC";
									$rs = odbc_exec( $conn, $sql );
									if ( !$rs){
										exit( "Error en la consulta SQL" );
									}
									while($resultado = odbc_fetch_array($rs)){
										echo'
											<option value="'.$resultado['Proveedor'].'">'.$resultado['Proveedor'].'</option>
										';
									}
								?>
							</select>
				        </label>
						
						<label class="first" for="title1">
							Línea 
							<select id="linea" name="linea"  class="styled" width="30">
								<!--<option value=""></option>-->
							</select><br>
							<img id="cargaLinea" src="modulos/vendedor/images/loading3.gif" width="20" style="display:none;"/>
				        </label>
								 <input name="cont" type="hidden" id="cont" size="40" class="required" value="1" />
                             <input style="clear:initial;" name="agregar" type="submit" id="agregar" class="submit" value="Consultar" />

			</fieldset>
            </form>
         </div> <!-- fin div two-->
      </div> <!-- fin items -->
    </div> <!-- fin idTabs -->
  	<?php 
	switch($fproveedor){
	  case "CLARINS":
		  include("modulos/listaPrecios/clarins.php");
		  break;
	  case "TED LAPIDUS":
		  include("modulos/listaPrecios/tedLapidus.php");
		  break;
	  case "COTY PRESTIGE":
		  include("modulos/listaPrecios/coty.php");
		  break;
	  case "ST. HONORE":
		  include("modulos/listaPrecios/stHonore.php");
		  break;
	  case "EUROITALIA":
		  include("modulos/listaPrecios/euroitalia.php");
		  break;
	
	
	}
	?>
