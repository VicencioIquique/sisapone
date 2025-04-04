<?php 
// require_once("clases/conexionocdb.php");
require_once("clases/conexionodbc-2.php");
require_once("clases/funciones.php");

ini_set('max_execution_time', 300); //300 seconds = 5 minutes
$vendedor = $_GET['id'];

$vendedor = str_pad($vendedor, 3, '0', 'STR_PAD_LEFT');

$finicio = $_GET['inicio'];
$ffin = $_GET['fin'];
$marca = $_GET['marca'];
$Hoy= date("m/d");
$uNegocio = $_GET['grupo'];

if(!$finicio)
{
	 $finicio = date("m/d/Y");
	 $ffin= date("m/d/Y");
}

// Consulta para llamar las marcas de los productos
 $sql2= "SELECT   [Code]
      ,[Name]
      ,[U_Marca]
  FROM [RP_VICENCIO].[dbo].[View_OMAR] ORDER BY U_Marca ASC
";
							$rs3 = odbc_exec( $conn2, $sql2 );
							if ( !$rs3 )
							{
							exit( "Error en la consulta SQL" );
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

if ($marca)
					{
						$nameMarca = ',[U_VK_Marca]';
						$conMarca= " AND  [Code] = '".$marca."' ";
						$conMarcaGroup = " , U_VK_Marca ";
					}
/*if ($modulo)
					{*/
						//$conModulo = "   (Bodega LIKE '".$modulo."') ";
						$conModulo = "  [WhsCode] = '".$modulo."'";
					//}
if ($uNegocio)
					{
						$conuNegocio = " AND ItmsGrpCod = ".$uNegocio."  ";
						$conModuloNegocio = " , ItmsGrpCod ";
}



/*$sql="SELECT  
	   [WhsCode] AS Bodega
	  ,[ItemCode]
	  ,[ItemName]
      
      ,[BatchNum]
	  ,[Name]
     
      ,SUM([Quantity])AS Cantidad
      
  FROM [SBO_Imp_Eximben_SAC].[dbo].[Stock_x_Bodega_SAP]
  WHERE ".$conMarca."  ".$conModulo."  ".$conuNegocio."
  GROUP BY [WhsCode],ItemCode,ItemName,Name
  ";*/
  
  $sql="SELECT [ItemCode]
      ,[BatchNum]
      ,[WhsCode] AS Bodega
      ,[ItemName]
      ,[Quantity] AS Cantidad
      ,[grupo_bodega]
      ,[U_Marca] AS Name
      ,[Code]
      ,[ItmsGrpCod]
  FROM [SBO_Imp_Eximben_SAC].[dbo].[Stock_Bodegas_SAPJPL]
  WHERE [WhsCode] = '".$modulo."' ".$conMarca."    ".$conuNegocio." ";

//echo $sql;
							
	echo'  <script src="graficos/amcharts/amcharts.js" type="text/javascript"></script>   ';	
	
	

					//include("graficos/topVendedores.php");					
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
        <li><a href="#one"><img src="images/buscar.png" width="30px" height="30px" /></a></li>
		<?php // pregunta si ha ingresado una fecha para que se muestre el imagen link de generar Excel
					
		if($finicio2){
		
			echo'<form action="/sisapone/clases/ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion"> 
			<center><img src="images/excel.png" width="30px" height="30px" class="botonExcel"  /> </center>
			<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" /> 
			</form> ';
		}?>
	 </ul>
      <div class="items">
        <div id="one"> <form action="" method="GET" id="horizontalForm">
            <fieldset>
				<legend>Ingresar Filtros</legend>
							 
							 <input name="opc" type="hidden" id="opc" size="40" class="required" value="stockMarcaBodegaLote" />
							 
							 
							
							 
							<?php
							// para cargar un list con las marcas
									 echo' <label class="first" for="title1">
									Marca
									<select id="marca" name="marca"  class="styled" class="required" >';
											if($marca)
												{
													echo'<option value="'.$marca.'" selected>'.utf8_encode($marca).'</option>';
												}
											 echo'<option value=""></option>';	
											 while($result = odbc_fetch_array($rs3))
											 { 
												
												 echo'<option value="'.$result['Code'].'">'.utf8_encode($result['Name']).'</option>';
												
											 }
										
				
								  echo'</select>
				            </label>';
							
							 	if($_SESSION["usuario_modulo"] == -1)
								{
									
									echo '<label class="first" for="title1">
									Bodega
									<select id="moduloid" name="modulo"     class="styled" class="required" >
									<option ></option>';
									if($modulo)
									{
										echo'<option value="'.$modulo.'" selected>'.$modulo.'</option>';
									}
									
									echo'
									
									<option value="ZFI.13-1">13-1</option>
									<option value="ZFI.13-2">13-2</option>
									<option value="ZFI.13-6">13-6</option>
									<option value="ZFI.16-4">16-4</option>
									<option value="ZFI.17SZ">17SZ</option>
									<option value="ZFI.1623">1623</option>
									
									</select>
				            </label>';
								}
					        ?>
					       
							
                           
                             <?php 
							
							echo '<label class="first" for="title1">
									Grupo
									<select id="moduloid" name="grupo"    class="styled" >
									<option ></option>';
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
					        ?>
							
							
                             <input style="clear:initial;" name="agregar" type="submit" id="agregar" class="submit" value="Consultar" />

			</fieldset>
            </form>
         </div> <!-- fin div two-->
      </div> <!-- fin items -->
    </div> <!-- fin idTabs -->
      
      
<div id="usual1" class="usual" > 
  <ul> 
  <?php 
  
  if ($modulo)
	{

	/*echo'<li ><a id="tabdua" href="#tab3" class="selected">Detalle</a></li> 
    <li ><a id="tabdua" href="#" > Hoy '.$Hoy.' a las '.date("G:i").' el Modulo ha emitido hasta la boleta '.getLastBoleta($modulo,"RP_VICENCIO") .' y ha recibido hasta la E.M. '.getLastDSM($modulo,"RP_VICENCIO").'</a></li> ';*/
    }
  
  ?>    
  </ul> 
 

<?php 
if ($modulo)
	{

  
  echo'<div id="tab3"> 
  <table  id="ssptable2" class="lista">
              <thead>
                    <tr>
                    	<th>Nº</th>
                        <th>Bodega</th>
                        <th>Marca</th>
                        <th>Código</th>
						<th>Descripción</th>
                       <!-- <th>Cif Promedio</th>
                        <th>Cif Total</th>-->
						 <th>Lote</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>';
		}
				 
					
					$total =0;
					$cantotal =0;
								
							
						if ($modulo)
						{	
							echo $sql;	
							$rs = odbc_exec( $conn2, $sql );
							echo $rs;
							if ( !$rs )
							{
							exit( "Error en la consulta SQL Franco" );
							}
							
							$i=1;
							while($resultado = odbc_fetch_array($rs)){ 
							  
							   echo '<tr>
							 		<td style="background-color:#6C6B6B;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" >'.$i.'</td>
									<td >'.utf8_encode($resultado["Bodega"]).'</td>
									<td ><strong>'.$resultado["Name"].'</strong></td>
									<td ><strong>'.$resultado["ItemCode"].'</strong></td>
									<td ><strong>'.$resultado["ItemName"].'</strong></td>
									<td ><strong>'.$resultado["BatchNum"].'</strong></td>
									<td ><strong>'.number_format($resultado["Cantidad"], 0, ',', '.').'</strong></td>									
									</tr>' ;
									/*<td ><strong>'.number_format($resultado["Cif"], 4, ',', '.').'</strong></td>
									<td ><strong>'.number_format($resultado["CifTotal"], 4, ',', '.').'</strong></td>
									<td><strong>'.number_format($totalCif, 2, ',', '.').'</strong></td>
                        <td><strong>'.number_format($totalCifTotal, 2, ',', '.').'</strong></td>*/

									
									//$totalCif = $totalCif + $resultado["Cif"];
									//$totalCifTotal = $totalCifTotal + $resultado["CifTotal"];
									$totalCant = $totalCant + $resultado["Cantidad"];
							$i++;		
							}
							
						}
				
 if ($modulo)
	{
                echo'</tbody>
                <tfoot>
                	<tr  style=" border-top:2px double #B5B5B5;">
                        <td></td>
                    	<td></td>
                        <td></td>
                        <td><strong></strong></td>
                        <td><strong></strong></td>
                        <td><strong></strong></td>
                        <td><strong>'. number_format($totalCant, 0, ',', '.').'</strong></td>
                    </tr>
                </tfoot>
            </table>
            </div>  <!-- fin de tabla de vendedores -->';
}  ?>
  
<script type="text/javascript"> 
  $("#usual1 ul").idTabs(); 
</script>
           
			
            


<?php odbc_close( $conn2 );?>