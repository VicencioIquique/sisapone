<script type="text/javascript" src="js/jquery.base64.js"></script>
<script type="text/javascript" src="js/jquery.btechco.excelexport.js"></script>
<?php 

require_once("clases/conexionocdb.php");
ini_set('max_execution_time', 600); //300 seconds = 5 minutes


$finicio = $_GET['inicio'];
$ffin = $_GET['fin'];
$codbarra = $_GET['codbarra'];


if(!$finicio)
{
	 $finicio = date("m/d/Y");
	 $ffin= date("m/d/Y");
}

/********************** para que solo busque por modulos segun pertenesca ******************************************/
if($_SESSION["usuario_modulo"] !=-1)
{
	$modulo = $_SESSION["usuario_modulo"];
	if($modulo == 8)
		$modulo='ZFI.2077';
	if($modulo == 1)
		$modulo='ZFI.1010';
	if($modulo == 2)
		$modulo='ZFI.1132';
	if($modulo ==3)
		$modulo='ZFI.181';
	if($modulo == 4)
		$modulo='ZFI.184';
	if($modulo == 5)
		$modulo='ZFI.2002';
	if($modulo == 6)
		$modulo='ZFI.6115';
	if($modulo == 7)
		$modulo='ZFI.6130';
	if($modulo == 42)
		$modulo='LOCAL.2';
	if($modulo == 48)
		$modulo='LOCAL.8';
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
				  $(".botonExcel").click(function(){
		$("#ssptable2").btechco_excelexport({
			containerid: "ssptable2"
		   , datatype: $datatype.Table
		});
	});
            });

</script>
<div class="idTabs">
<ul>
        <li><a href="#one"><img src="images/agregar.png" width="30px" height="30px" /></a></li>
		<?php // pregunta si ha ingresado una fecha para que se muestre el imagen link de generar Excel
					
		if($finicio2){
		
			echo'<form action="/sisapone/clases/ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion"> 
			<center><a href="#one"><img src="images/excel.png" width="30px" height="30px" class="botonExcel"  /></a> </center>
			<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" /> 
			</form> ';
		}?>
	 </ul>
<div class="items">
 <div id="one"><form action="" method="GET" id="horizontalForm">
        
            <fieldset>
				<legend>Ingresar Codigo</legend>
							 
							 <input name="opc" type="hidden" id="opc" size="40" class="required" value="kardex" />
							 

							 <label for="sku">
					            Codigo de Barra
                            <input name="codbarra" type="text" class="codbarra2" id="codbarra2" size="40"  value="<?php echo $codbarra;?>" />
                            </label>
							
							<?php
							 	if($_SESSION["usuario_modulo"] == -1)
								{
									
									echo '<label class="first" for="title1">
									Retail
									<select id="modulo" name="modulo"     class="styled" >
									<option ></option>';
									if($modulo)
									{
										echo'<option value="'.$modulo.'" selected>'.$modulo.'</option>';
									}
									
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
									<option value="LOCAL.2">Local 2</option>
									<option value="LOCAL.8">Local 8</option>
									</select>
				            </label>';
								}
					        ?>
					       
							 <input name="agregar" style="clear:initial;"  type="submit" id="agregar" class="submit" value="Consultar" />

			</fieldset>
            </form>
              </div> <!-- fin div two-->
      </div> <!-- fin items -->
    </div> <!-- fin idTabs -->
		
 <?php
		 
				$sql= "SELECT     dbo.RP_Articulos.ALU, dbo.RP_Articulos.PRICE01, dbo.oITM_From_SBO.ItemName AS DESC1
FROM         dbo.RP_Articulos LEFT OUTER JOIN
                      dbo.oITM_From_SBO ON dbo.RP_Articulos.ALU = dbo.oITM_From_SBO.ItemCode COLLATE SQL_Latin1_General_CP1_CI_AS
WHERE     (dbo.RP_Articulos.ALU ='".$codbarra."') ";
							
										
							//echo $sql;	
							$rs = odbc_exec( $conn, $sql );
							if ( !$rs )
							{
							exit( "Error en la consulta SQL" );
							}

							  while($resultado = odbc_fetch_array($rs))
							  { 

								echo'	<div id="muestraPrecio" class="caja" style="margin-top:10px;overflow:auto;">
											<div id="muestraPrecio" class="caja2" style="margin-top:5px;color:#FFF; font-size:22px; text-align:center; padding-top:20px;background-color: #0084FF;">
													'.$resultado["DESC1"].'	
											</div>
															
										</div>';
         }
  				 

				 
if($codbarra)
{
				

//desde aquí muestra tabla para detalle		 
echo'</br>
 <div id="usual1" class="usual" > 
  <ul> 
    <li ><a id="tabdua" href="#tab1" class="selected">Detalle Saldos</a></li> 
   
  </ul> 
  <div id="tab3">
  
  
  </div>
  <div id="tab1"> 
  	<table  id="ssptable2" class="lista">
      <thead>
            <tr>
				<th>N°</th>        
                <th>Fecha</th>
				<th>Nro. Doc</th>
				<th>Z</th>
				<th>Bodega</th>
				<th>Movimiento</th>
				<th>Tipo de Documento</th>
				<th>Cantidad</th>
				<th>Stock</th>
            </tr>
      </thead>
      <tbody>';
	
	$sql2="
SELECT [Empresa]
      ,[BdgaVenta]
      ,[BdgaRetail]
      ,[Periodo]
      ,[Year]
      ,[Month]
      ,[Quarter]
      ,[Week]
	  ,[DocNum]
      ,[Quantity]
      ,[DocDate]
	  ,CONVERT(varchar, DocDate, 103) AS FECHA
      ,[ItemCode]
      ,[WhsCode]
      ,[WhsRefer]
      ,CASE TipoDoc
		 WHEN 'BV' THEN 'Boleta de Venta'
		 WHEN 'NCV' THEN 'Nota de Crédito'
		 WHEN 'DSM' THEN 'DSM'
		 WHEN 'DEM' THEN 'DEM'
	   END          	 [TipoDoc]
	    ,CASE TipoDoc
		 WHEN 'BV' THEN 'Venta'
		 WHEN 'NCV' THEN 'Devolución'
		 WHEN 'DSM' THEN 'Abastecimiento'
		 WHEN 'DEM' THEN 'Entrada a Galón'
	   END          	 [TipoMov]
      ,[Lote]
      ,[CIF_Price]
      ,[ValorMovCIF]
      ,[Confirmado]
  FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_VW_MovRetail]
  WHERE Confirmado = 'Y' AND WhsCode = '".$modulo."' AND ItemCode = '".$codbarra."'
   ORDER BY DocDate ASC
  ";

    echo $sql2;	
	$rs2 = odbc_exec( $conn, $sql2 );
	
	if ( !$rs2 )
	{
		exit( "Error en la consulta SQL" );
	}
	$i=0;
  while($resultado2 = odbc_fetch_array($rs2)){ 
  
	$acumCant = $acumCant + $resultado2["Quantity"];
		   echo '<tr  >
				<td style="background-color:#393939;color:#FFF;width:20px;text-align:center;font-weight:bold;font-size:16px;">'.($i+1).'</td>
				<td style="background-color:#CDCDCD;color:#000;width:100px;text-align:center;font-weight:bold;">'.$resultado2["FECHA"].'  </td>
					<td >'.$resultado2["DocNum"].' &nbsp;</td>
					<td >'.$resultado2["Lote"].'&nbsp;</td>
				<td >'.$resultado2["WhsCode"].'</td>
				<td >'.$resultado2["TipoMov"].'</td>';
				if(($resultado2["Empresa"] == "EXB_AEROP") && ($resultado2["TipoDoc"] == "DSM")  )
				echo'<td >SRF</td>';
				else 
				echo'<td >'.$resultado2["TipoDoc"].'</td>';
				
				if($resultado2["Quantity"] >=0)
				    echo'<td ><strong style="font-size:14px;color:#0076FE;">'.number_format($resultado2["Quantity"], 0, '', '.').'</strong></td>';
				else
					echo'<td ><strong style="font-size:14px;color:#FE1111;">'.number_format($resultado2["Quantity"], 0, '', '.').'</strong></td>';
				echo'
				<td ><strong style="font-size:14px;color:">'.number_format($acumCant, 0, '', '.').'</strong></td>
				</tr>' ;
			$i++;}
			
	
	/** SOLO PARA ADMINS **/
	
	
	 if ($modulo)
	{
                echo'</tbody>
                <tfoot>
                	<tr  style=" border-top:2px double #B5B5B5;">
                        <td></td>
                    	<td></td>';
						if($_SESSION["usuario_modulo"] == -1)
						{
							echo'<td>LOTES DISPONIBLE:</td>
							<td><strong>'.lotesDiponible($codbarra,$modulo).'</strong></td>';
						}
						else{
						echo'<td></td>
							<td></td>';
						}
                        echo'<td><strong></strong></td>
						<td><strong></strong></td>
                        <td><strong>STOCK:</strong></td>
                        <td><strong style="font-size:15px;">'. number_format($acumCant, 0, ',', '.').'</strong></td>
                    </tr>
                </tfoot>
            </table>
            </div>  <!-- fin de tabla de vendedores -->';
}  ?>		
			
			


<?php
} // Fin IF
	odbc_close( $conn );?>