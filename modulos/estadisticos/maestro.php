<?php 
require_once("clases/conexionocdb.php");
ini_set('max_execution_time', 600); //300 seconds = 5 minutes


$areaNegocio = $_GET['areaNegocio'];
$tipoProducto = $_GET['tipoProducto'];
$marca = $_GET['marca'];
$linea = $_GET['linea'];
$subLinea = $_GET['subLinea'];
$proveedor = $_GET['proveedor'];
$brandManager = $_GET['brandManager'];
$consultar = $_GET['agregar'];



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


$marca = $_GET['marca']; // Pregunta si realmente busco por marca -> crea la consulta WHERE

// Consulta para llamar las marcas de los productos
$sql2= "SELECT 
      DISTINCT[Marca]     
  FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_VW_ItemsVenta] ORDER BY Marca ASC
";
							$rs2 = odbc_exec( $conn, $sql2 );
							if ( !$rs2 )
							{
							exit( "Error en la consulta SQL" );
							}
/************************************************************ PARA LOS VENDEDORES **************************************/


$sql4= "
SELECT 
      DISTINCT[Linea]     
  FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_VW_ItemsVenta] ORDER BY Linea ASC
";
							$rs4 = odbc_exec( $conn,$sql4 );
							if ( !$rs4 )
							{
							exit( "Error en la consulta SQL" );
							}
// Consulta para llamar las marcas de los productos
$sql5= "
SELECT 
      DISTINCT[SubLinea]     
  FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_VW_ItemsVenta] ORDER BY SubLinea ASC
";
							$rs5 = odbc_exec( $conn,$sql5 );
							if ( !$rs5 )
							{
							exit( "Error en la consulta SQL" );
							}
							
// Consulta para llamar las marcas de los productos
$sql6= "
SELECT 
      DISTINCT[Proveedor]     
  FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_VW_ItemsVenta] ORDER BY Proveedor ASC
";
							$rs6 = odbc_exec( $conn,$sql6);
							if ( !$rs6 )
							{
							exit( "Error en la consulta SQL" );
							}
// Consulta para llamar las marcas de los productos
$sql7= "
SELECT 
      DISTINCT[BrandManager]     
  FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_VW_ItemsVenta] ORDER BY BrandManager ASC
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
				$('#moduloid').focus();
				// calendarios en text de fecha inicio fin
				$( "#inicio" ).datepicker( );
				//formatos de las fechas
			   // $('#inicio').datepicker('option', {dateFormat: 'dd-mm-yy'});
				$( "#fin" ).datepicker(  );
				//$('#fin').datepicker('option', {dateFormat: 'dd-mm-yy'});
				 $( document ).tooltip();
            });
			

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
		
			echo'<form action="/sisap/clases/ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion"> 
			<center><img src="images/excel.png" width="30px" height="30px" class="botonExcel"  /> </center>
			<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" /> 
			</form> ';
		}?>
	 </ul>
      <div class="items">
        <div id="one"> <form action="" method="GET" id="horizontalForm">
        
            <fieldset>
				<legend>Filtros</legend>
							 
							 <input name="opc" type="hidden" id="opc" size="40" class="required" value="maestroArticulos" />
							 
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
							 	if($_SESSION["usuario_modulo"] == -1)
								{
									
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
								}
					        ?>
                            
							 <?php // para cargar un list con las marcas
									 echo' <label class="first" for="title1">
									Marca
									<select id="marca" name="marca"    class="styled" >';
									if($marca)
									{
										echo'<option value="'.$marca.'" selected>'.$marca.'</option>';
									}
											 echo'<option value=""></option>';	
											 while($result = odbc_fetch_array($rs2))
											 { 
												
												 echo'<option value="'.$result['Marca'].'">'.utf8_encode($result['Marca']).'</option>';
												
											 }
										
				
								  echo'</select>
				            </label>';
					        ?>
							
							 <?php // para cargar un list con las marcas
									 echo' <label class="first" for="title1">
									Linea
									<select id="linea" name="linea"    class="styled" >';
											
											 echo'<option value=""></option>';	
									if($linea)
									{
										echo'<option value="'.$linea.'" selected>'.$linea.'</option>';
									}
											 while($result = odbc_fetch_array($rs4))
											 { 
												
												 echo'<option value="'.$result['Linea'].'">'.utf8_encode($result['Linea']).'</option>';
												
											 }
										
				
								  echo'</select>
				            </label>';
					        ?>
							
							 <?php // para cargar un list con las marcas
									 echo' <label class="first" for="title1">
									Sub Linea
									<select id="subLinea" name="subLinea"    class="styled" >';
									if($subLinea)
									{
										echo'<option value="'.$subLinea.'" selected>'.$subLinea.'</option>';
									}		
											 echo'<option value=""></option>';	
											 while($result = odbc_fetch_array($rs5))
											 { 
												
												 echo'<option value="'.$result['SubLinea'].'">'.utf8_encode($result['SubLinea']).'</option>';
												
											 }
										
				
								  echo'</select>
				            </label>';
					        ?>

                              <?php // para cargar un list con las marcas
									 echo' <label class="first" for="title1">
									Proveedor
									<select id="proveedor" name="proveedor"    class="styled" >';
									if($proveedor)
									{
										echo'<option value="'.$proveedor.'" selected>'.$proveedor.'</option>';
									}			
											 echo'<option value=""></option>';	
											 while($result = odbc_fetch_array($rs6))
											 { 
												
												 echo'<option value="'.$result['Proveedor'].'">'.utf8_encode($result['Proveedor']).'</option>';
												
											 }
										
				
								  echo'</select>
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
				 if($marca)
				 {
					$Wmarca = " AND Marca LIKE '".$marca."'";
				 }
				 if($linea)
				 {
					$Wlinea = " AND Linea LIKE '".$linea."'";
				 }
				 if($subLinea)
				 {
					$WsubLinea = " AND SubLinea LIKE '".$subLinea."'";
				 }
				 if($proveedor)
				 {
					$Wproveedor = " AND Proveedor LIKE '".$proveedor."'";
				 }
				 if($brandManager)
				 {
					$WbrandManager = " AND BrandManager LIKE '".$brandManager."'";
				 }
				 
				

				 					
$sql= "

SELECT [ItemCode]
      ,[ItemName]
      ,[AreaNegocio]
      ,[Marca]
      ,[Linea]
      ,[SubLinea]
      ,[Proveedor]
      ,[BrandManager]
      ,[Mercancia]
      ,[Tester]
      ,[Publicidad]
      ,[TipoProducto]
      ,[LPV_Mon]
      ,[LPV_Precio]
      ,[LPC_Mon]
      ,[LPC_Precio]
      ,[DFS_Mon]
      ,[DFS_Precio]
      ,[PorLote]
  FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_VW_ItemsVenta]
  WHERE 1=1
  ".$WareaNegocio."
 ".$WtipoProducto."
 ".$Wmarca."
 ".$Wlinea."
 ".$WsubLinea."
 ".$Wproveedor."
 ".$WbrandManager."
";
									
		if($consultar)
		{
				//echo $sql;
		?>
		<div style="width: 100%;
overflow-x:auto;
overflow-y:hidden;">				
            <table   width="2000px;" id="tablelike"  class="lista">
              <thead>
                   <tr>
					    <th>Codigo</th>
						<th>Descripcion</th>
						<th>Area de Negocio</th> 
						<th>Marca</th> 
						<th>Linea</th> 
						<th>Sub Linea</th> 
						<th>Proveedor</th> 
						<th>Brand Manager</th> 
						<th>Mercancia</th> 
						<th>Tester</th> 
						<th>Publicidad</th> 
						<th>Tipo Producto</th> 
						<th>Moneda</th> 
						<th>Precio Lista</th> 
						 
					</tr>	
           
              </thead>
              <tbody>
		<?php
					$rs = odbc_exec( $conn, $sql );
					if ( !$rs )
					{
					exit( "Error en la consulta SQL" );
					}
							
					
			

					while($resultado = odbc_fetch_array($rs))
					{
	  
						echo'
						<tr>
						<td >'.(string)$resultado["ItemCode"].'&nbsp;</td> 
						<td >'.utf8_encode($resultado["ItemName"]).'</td> 
						<td >'.utf8_encode($resultado["AreaNegocio"]).'</td>
						<td >'.utf8_encode($resultado["Marca"]).'</td>
						<td >'.utf8_encode($resultado["Linea"]).'</td>
						<td >'.utf8_encode($resultado["SubLinea"]).'</td>
						<td >'.utf8_encode($resultado["Proveedor"]).'</td>
						<td >'.utf8_encode($resultado["BrandManager"]).'</td>
						<td >'.utf8_encode($resultado["Mercancia"]).'</td>
						<td >'.utf8_encode($resultado["Tester"]).'</td>
						<td >'.utf8_encode($resultado["Publicidad"]).'</td>
						<td >'.utf8_encode($resultado["TipoProducto"]).'</td>
						
						<td ><strong>'.$resultado["LPV_Mon"].'</strong></td>
						
						<td ><strong>'.number_format($resultado["LPV_Precio"], 0, '', '.').'</strong></td>
						
						
						</tr>';
					
					}
		}//Fin consultar	
		?>
		</tbody>
		<tfoot>
			<tr>
			</tr>
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