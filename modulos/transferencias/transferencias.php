<?php 
require_once("clases/conexionocdb.php");//incluimos archivo de conexión
require_once("clases/funciones.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes

$nDsm = $_GET['nDsm'];
$vendedor = str_pad($vendedor, 3, '0', 'STR_PAD_LEFT');
$modulo = $_GET['modulo'];
$finicio = $_GET['inicio'];
$ffin = $_GET['fin'];

if ($nDsm)
{
	$buscarDSM = "AND SBO_Imp_Eximben_SAC.dbo.OWTR.DocNum =".$nDsm;
}


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




  
  $sql="SELECT DISTINCT  SBO_Imp_Eximben_SAC.dbo.OWTR.DocNum,  SBO_Imp_Eximben_SAC.dbo.OWTR.Filler,  SBO_Imp_Eximben_SAC.dbo.WTR1.WhsCode,  SBO_Imp_Eximben_SAC.dbo.OWTR.U_Bes_TipoDoc AS RPRO,  SBO_Imp_Eximben_SAC.dbo.OWTR.DocDate, 
                       SBO_Imp_Eximben_SAC.dbo.VISAP_TRANSFERENCIAS.folio
FROM          SBO_Imp_Eximben_SAC.dbo.OWTR INNER JOIN
                       SBO_Imp_Eximben_SAC.dbo.WTR1 ON  SBO_Imp_Eximben_SAC.dbo.OWTR.DocEntry =  SBO_Imp_Eximben_SAC.dbo.WTR1.DocEntry INNER JOIN
                       SBO_Imp_Eximben_SAC.dbo.VISAP_TRANSFERENCIAS ON  SBO_Imp_Eximben_SAC.dbo.OWTR.DocEntry =  SBO_Imp_Eximben_SAC.dbo.VISAP_TRANSFERENCIAS.DocEntry
WHERE     ( SBO_Imp_Eximben_SAC.dbo.OWTR.Filler = 'ZFI.13-6') ".$buscarDSM."
ORDER BY  SBO_Imp_Eximben_SAC.dbo.OWTR.DocNum DESC";

echo  $sql;//		$_SESSION["usuario_modulo"];			
						
?>
<link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css" /> 
<link rel="stylesheet" href="css/jquery-ui.css" />
<script src="js/jquery-ui.js"></script>
<link type="text/css" rel="stylesheet" href="css/ui.notify.css" />
<script src="js/jquery.notify.js" type="text/javascript"></script>
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
				fn_detalle_dsm();
				
			});//fin funciotn principal
			
	$(function() {
   
			
 
    
 
    function checkRegexp( o, regexp, n ) {
      if ( !( regexp.test( o.val() ) ) ) {
        o.addClass( "ui-state-error" );
        updateTips( n );
        return false;
      } else {
        return true;
      }
    }
 
    $( "#dsmDetalle" ).dialog({
      autoOpen: false,
       height: 700,
      width: 900,
      modal: true,
	  resizable: false,
      position: [120,5],
	  show: {effect: 'fade', duration: 50},
	  hide: {effect: 'fade', duration: 50},
      buttons: {
		
        "Aceptar": function() {            
			
            $( this ).dialog( "close" );
			//location.href = 'index.php?opc=pasodos&idsol='+ $("#idsol").val();
        },
		
       "cerrar": function() {
          $( this ).dialog( "close" );
		
          }
         },
		  close: function() {
			$( this ).dialog( "close" );
			
		  }
 });
 
	 
  }); // fin script para popup		
			

</script>


         <form action="" method="GET" id="horizontalForm">
            <fieldset >
				<legend>Ingrese Nro. Documento</legend>
					<input name="opc" type="hidden" id="opc" size="40" class="required" value="transferencias" />
					
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
	
	$NroDEM = $resultado["DocNum"];
	$fecha = $resultado["Fecha"];
	$origen = $resultado["TOrigen"];
   $estado = $resultado["Estado"];
	$codModulo = $resultado["CodModulo"];
	$totalItem = $resultado["TotalItem"];
  
  }

						 
						    ?>
				</fieldset>
            </form>
<?php 
			
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
  	<table  id="ssptable2" class="lista">
      <thead>
            <tr>
				<th>N°</th>    
				<th>N° Doc</th> 
                <th>Fecha</th>
				<th>Origen -> Destino</th>
				<th>Nro Visación</th>
				<th>En RPro</th>
				<th></th>
            </tr>
      </thead>
      <tbody>';}


   //  echo $sql2;	
	$rs = odbc_exec( $conn, $sql );
	
	if ( !$rs )
	{
		exit( "Error en la consulta SQL" );
	}
	$i=1;
  while($resultado2 = odbc_fetch_array($rs)){ 
		   echo '<tr  >
				<td style="background-color:#393939;color:#FFF;width:20px;text-align:center;font-weight:bold;font-size:16px;">'.$i.'</td>
				<td style="background-color:#CDCDCD;color:#000;width:100px;text-align:center;font-weight:bold;font-weight:bold;font-size:17px;">'.$resultado2["DocNum"].'</td>
				<td style="width:150px;text-align:center;font-weight:bold;font-weight:bold;font-size:15px;"  >'.substr($resultado2["DocDate"],0,10).' <!--<img src="images/flecha2.png"  />--> </td>
				<td style="width:150px;text-align:center;font-weight:bold;font-weight:bold;font-size:15px;" >'.substr($resultado2["Filler"],4).' <img width="16px" height=16px" src="images/flecha3.png" />'. substr($resultado2["WhsCode"],4).'</td>
				<td style="width:100px;text-align:center;font-weight:bold;font-weight:bold;font-size:15px;"  >'.$resultado2["folio"].'</td>
				<td  style="width:100px;text-align:center;font-weight:bold;font-weight:bold;font-size:15px;"  >'.$resultado2["RPRO"].'</td>
				<td  style="width:50px"  ><a href="index.php?opc=transdet&docnum='.$resultado2["DocNum"].'"><img width="16px" height=16px" src="images/buscar.png" /></a></td>
				</tr>' ;
$i++;}?>
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
 
 <div id="dsmDetalle" title="Detalle DSM">
  
  <p class="validateTips">hola</p>

 </div>
 
<script type="text/javascript"> 
  $("#usual1 ul").idTabs(); 
</script>
 <?php odbc_close( $conn );?>