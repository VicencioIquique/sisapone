<?php 
require_once("clases/conexionocdb.php");
ini_set('max_execution_time', 600); //300 seconds = 5 minutes


$areaNegocio = $_GET['areaNegocio'];
$tipoProducto = $_GET['tipoProducto'];
$periodo = $_GET['periodo'];
$marca = $_GET['marca'];
$linea = $_GET['linea'];
$subLinea = $_GET['subLinea'];
$proveedor = $_GET['proveedor'];
$brandManager = $_GET['brandManager'];
$consultar = $_GET['agregar'];
if(!$periodo)
{
	$periodo =  date('Y-m', strtotime('-1 month'));
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


$marca = $_GET['marca']; // Pregunta si realmente busco por marca -> crea la consulta WHERE

// Consulta para llamar las marcas de los productos
$sql2= "SELECT 
      DISTINCT[Marca]     AS Marca
  FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_VW_ItemsVenta]
  ORDER BY Marca
";
							$rs2 = odbc_exec( $conn, $sql2 );
							if ( !$rs2 )
							{
							exit( "Error en la consulta SQL" );
							}
/************************************************************ PARA LOS VENDEDORES **************************************/


$sql4= "
SELECT 
      DISTINCT[Linea]     AS Linea
  FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_VW_ItemsVenta]
  ORDER BY Linea
";
							$rs4 = odbc_exec( $conn,$sql4 );
							if ( !$rs4 )
							{
							exit( "Error en la consulta SQL" );
							}
// Consulta para llamar las marcas de los productos
$sql5= "
SELECT 
      DISTINCT[SubLinea]     SubLinea
  FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_VW_ItemsVenta]
  ORDER BY SubLinea
";
							$rs5 = odbc_exec( $conn,$sql5 );
							if ( !$rs5 )
							{
							exit( "Error en la consulta SQL" );
							}
							
// Consulta para llamar las marcas de los productos
$sql6= "
SELECT 
      DISTINCT[Proveedor]     AS Proveedor
  FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_VW_ItemsVenta]
  ORDER BY Proveedor
";
							$rs6 = odbc_exec( $conn,$sql6);
							if ( !$rs6 )
							{
							exit( "Error en la consulta SQL" );
							}
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
				dateFormat: 'yy-mm',
				changeMonth: true,
				changeYear: true,
				
				showButtonPanel: true,

				onClose: function(dateText, inst) {
					var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
					var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
					$(this).val($.datepicker.formatDate('yy-mm', new Date(year, month, 1)));
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
							 
							 <input name="opc" type="hidden" id="opc" size="40" class="required" value="estAuto" />
							 
							 
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
									Marca
									<select id="marca" name="marca"    class="styled" >';
											
									echo'<option value=""></option>';	
									 if($marca)
									{
										echo'<option value="'.$marca.'" selected>'.$marca.'</option>';
									}
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
									if($linea)
									{
										echo'<option value="'.$linea.'" selected>'.$linea.'</option>';
									}	
											 echo'<option value=""></option>';	
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
				            </label>
							
							<label >
										Periodo:
										<input type="text" id="periodo" name="periodo" class="periodo" size="5" value="'.$periodo.'"  />
						  </label>
							';
							
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
					$WareaNegocio = " AND ITM.AreaNegocio LIKE '".$areaNegocio."'";
				 }
				 if($tipoProducto)
				 {
					$WtipoProducto = " AND ITM.TipoProducto  LIKE '".$tipoProducto."'";
				 }
				 if($marca)
				 {
					$Wmarca = " AND ITM.Marca LIKE '".$marca."'";
				 }
				 if($linea)
				 {
					$Wlinea = " AND ITM.Linea LIKE '".$linea."'";
				 }
				 if($subLinea)
				 {
					$WsubLinea = " AND ITM.SubLinea LIKE '".$subLinea."'";
				 }
				 if($proveedor)
				 {
					$Wproveedor = " AND ITM.Proveedor LIKE '".$proveedor."'";
				 }
				 if($brandManager)
				 {
					$WbrandManager = " AND ITM.BrandManager LIKE '".$brandManager."'";
				 }
				 
						 					
/*$sql= "
DECLARE @Periodo Char(7)
SET @Periodo = '".$periodo."'
SELECT 
       @Periodo                            AS  [Periodo]
      ,ITM.AreaNegocio                     AS  [Area_Negocio]
      ,ITM.TipoProducto                    AS  [Tipo_Producto]
      ,ITM.Marca                           AS  [Marca]
      ,ITM.Proveedor                       AS  [Proveedor]
      ,ITM.BrandManager                    AS  [Brand_Manager]
      ,ITM.Linea                           AS  [Linea]
      ,ITM.SubLinea                        AS  [Sub_Linea]
      ,ITM.ItemCode                        AS  [Codigo]
      ,ITM.ItemName                        AS  [Descripcion]
      ,ISNULL(VTP.M_Quantity,0)            AS  [May_Und]
      ,ISNULL(VTP.M_Total_CLP,0)           AS  [May_Vta_CLP]
      ,ISNULL(VTP.M_Total_USD,0)           AS  [May_Vta_USD]
      ,ISNULL(VTP.M_CtoVtaCIF,0)           AS  [May_Cto_CIF]
      ,ISNULL(VTP.R_Quantity,0)            AS  [Ret_Und]
      ,ISNULL(VTP.R_Total_CLP,0)           AS  [Ret_Vta_CLP]
      ,ISNULL(VTP.R_Total_USD,0)           AS  [Ret_Vta_USD]
      ,ISNULL(VTP.R_CtoVtaCIF,0)           AS  [Ret_Cto_CIF]
      ,ISNULL(VTP.Quantity,0)              AS  [Per_Und]
      ,ISNULL(VTP.Total_CLP,0)             AS  [Per_Vta_CLP]
      ,ISNULL(VTP.Total_USD,0)             AS  [Per_Vta_USD]
      ,ISNULL(VTP.CtoVtaCIF,0)             AS  [Per_Cto_CIF]
      ,ISNULL(VTA.Quantity,0)              AS  [Acum_Und]
      ,ISNULL(VTA.Total_CLP,0)             AS  [Acum_Vta_CLP]
      ,ISNULL(VTA.Total_USD,0)             AS  [Acum_Vta_USD]
      ,ISNULL(VTA.CtoVtaCIF,0)             AS  [Acum_Cto_CIF]
      ,SUM(CASE KDL.BdgaRetail
              WHEN 'Y' THEN 
                   ISNULL(KDL.Quantity,0)
              ELSE 0
           END)                            AS  [Stock_Modulo]
      ,SUM(CASE KDL.BdgaRetail
              WHEN 'N' THEN 
                   ISNULL(KDL.Quantity,0)
              ELSE 0
           END)                            AS  [Stock_Galpon]
      ,SUM(ISNULL(KDL.Quantity,0))         AS  [Stock_Total]
      ,SUM(ISNULL(KDL.Total_CIF,0))        AS  [Stock_CIF]
      ,CASE SUM(ISNULL(KDL.Quantity,0))
          WHEN 0 THEN 0
          ELSE ROUND(
               SUM(ISNULL(KDL.Total_CIF,0))/
               SUM(ISNULL(KDL.Quantity,0))
               ,4)
       END                                 AS  [CIF_Promedio]
      ,ISNULL(LUF.PerUltIngr,'')           AS  [Ult_Ingreso]
      ,ISNULL(LUC.Ultimo_CIF,0)            AS  [Ult-CIF]
  FROM      SBO_Imp_Eximben_SAC..VIC_VW_ItemsVenta     ITM
  LEFT JOIN SBO_Imp_Eximben_SAC..VIC_VW_Vtas_Acum_Per  VTA  ON ITM.ItemCode = VTA.ItemCode
                                      AND VTA.Periodo  = @Periodo
  LEFT JOIN SBO_Imp_Eximben_SAC..VIC_VW_Mov_SAP_RPro   KDL  ON ITM.ItemCode = KDL.ItemCode
                                      AND KDL.BdgaVenta = 'Y'
                                      AND KDL.Periodo <= @Periodo
  LEFT JOIN SBO_Imp_Eximben_SAC..VIC_VW_Ventas_Per     VTP  ON ITM.ItemCode = VTP.ItemCode
                                      AND VTP.Periodo  = @Periodo
  LEFT JOIN SBO_Imp_Eximben_SAC..VIC_VW_LoteFchUltIngr LUF  ON ITM.ItemCode         = LUF.ItemCode
  LEFT JOIN SBO_Imp_Eximben_SAC..VIC_VW_LoteUltimoCIF  LUC  ON ITM.ItemCode         = LUC.ItemCode
 WHERE 1 = 1
 
 ".$WareaNegocio."
 ".$WtipoProducto."
 ".$Wmarca."
 ".$Wlinea."
 ".$WsubLinea."
 ".$Wproveedor."
 ".$WbrandManager."
 
 
 GROUP BY
       ITM.AreaNegocio
      ,ITM.TipoProducto
      ,ITM.Marca
      ,ITM.Proveedor
      ,ITM.BrandManager
      ,ITM.Linea
      ,ITM.SubLinea
      ,ITM.ItemCode
      ,ITM.ItemName
      ,VTA.Quantity
      ,VTA.Total_CLP
      ,VTA.Total_USD
      ,VTA.CtoVtaCIF
      ,VTP.M_Quantity
      ,VTP.M_Total_CLP
      ,VTP.M_Total_USD
      ,VTP.M_CtoVtaCIF
      ,VTP.R_Quantity
      ,VTP.R_Total_CLP
      ,VTP.R_Total_USD
      ,VTP.R_CtoVtaCIF
      ,VTP.Quantity
      ,VTP.Total_CLP
      ,VTP.Total_USD
      ,VTP.CtoVtaCIF
      ,LUF.PerUltIngr
      ,LUC.Ultimo_CIF
 ORDER BY
       ITM.AreaNegocio
      ,ITM.TipoProducto
      ,ITM.ItemCode
";*/
		
$sql="
DECLARE @Periodo Char(7)
SET @Periodo = '".$periodo."'
SELECT
       @Periodo                              [Periodo]
      ,ITM.AreaNegocio                       [Area_Negocio]
      ,ITM.TipoProducto                      [Tipo_Producto]
      ,ITM.Marca                             [Marca]
      ,ITM.Proveedor                         [Proveedor]
      ,ITM.BrandManager                      [Brand_Manager]
      ,ITM.Linea                             [Linea]
      ,ITM.SubLinea                          [Sub_Linea]
      ,ITM.ItemCode                          [Codigo]
      ,ITM.ItemName                          [Descripcion]
      ,ISNULL(VTP.M_Quantity,0)              [May_Und]
      ,ISNULL(VTP.M_Total_CLP,0)             [May_Vta_CLP]
      ,ISNULL(VTP.M_Total_USD,0)             [May_Vta_USD]
      ,ISNULL(VTP.M_CtoVtaCIF,0)             [May_Cto_CIF]
      ,ISNULL(VTP.R_Quantity,0)              [Ret_Und]
      ,ISNULL(VTP.R_Total_CLP,0)             [Ret_Vta_CLP]
      ,ISNULL(VTP.R_Total_USD,0)             [Ret_Vta_USD]
      ,ISNULL(VTP.R_CtoVtaCIF,0)             [Ret_Cto_CIF]
      ,ISNULL(VTP.Quantity,0)                [Per_Und]
      ,ISNULL(VTP.Total_CLP,0)               [Per_Vta_CLP]
      ,ISNULL(VTP.Total_USD,0)               [Per_Vta_USD]
      ,ISNULL(VTP.CtoVtaCIF,0)               [Per_Cto_CIF]
      ,ISNULL(VTA.Quantity,0)                [Acum_Und]
      ,ISNULL(VTA.Total_CLP,0)               [Acum_Vta_CLP]
      ,ISNULL(VTA.Total_USD,0)               [Acum_Vta_USD]
      ,ISNULL(VTA.CtoVtaCIF,0)               [Acum_Cto_CIF]
      ,SUM(CASE KDL.BdgaRetail
              WHEN 'Y' THEN 
                   ISNULL(KDL.Quantity,0)
              ELSE 0
           END)                              [Stock_Modulo]
      ,SUM(CASE KDL.BdgaRetail
              WHEN 'N' THEN 
                   ISNULL(KDL.Quantity,0)
              ELSE 0
           END)                              [Stock_Galpon]
      ,SUM(ISNULL(KDL.Quantity,0))           [Stock_Total]
      ,SUM(ISNULL(KDL.Total_CIF,0))          [Stock_CIF]
      ,CASE SUM(ISNULL(KDL.Quantity,0))
          WHEN 0 THEN 0
          ELSE ROUND(
               SUM(ISNULL(KDL.Total_CIF,0))/
               SUM(ISNULL(KDL.Quantity,0))
               ,4)
       END                                   [CIF_Promedio]
      ,ISNULL(LUF.PerUltIngr,'')             [Ult_Ingreso]
      ,ISNULL(LUC.Ultimo_CIF,0)              [Ult-CIF]
  FROM      SBO_Imp_Eximben_SAC..VIC_VW_ItemsVenta     ITM
  LEFT JOIN (SELECT
                   VAC.ItemCode                 [ItemCode]
                  ,ISNULL(SUM(VAC.Quantity) ,0) [Quantity]
                  ,ISNULL(SUM(VAC.Total_CLP),0) [Total_CLP]
                  ,ISNULL(SUM(VAC.Total_USD),0) [Total_USD]
                  ,ISNULL(SUM(VAC.CtoVtaCIF),0) [CtoVtaCIF]
              FROM  SBO_Imp_Eximben_SAC..VIC_VW_Ventas VAC
             WHERE 1 = 1
			   AND VAC.Periodo  <= @Periodo
             GROUP BY
                   VAC.ItemCode)  VTA  ON ITM.ItemCode = VTA.ItemCode
  LEFT JOIN SBO_Imp_Eximben_SAC..VIC_VW_Mov_SAP_RPro   KDL  ON ITM.ItemCode = KDL.ItemCode
                                      AND KDL.BdgaVenta = 'Y'
                                      AND KDL.Periodo <= @Periodo
  LEFT JOIN SBO_Imp_Eximben_SAC..VIC_VW_Ventas_Per     VTP  ON ITM.ItemCode = VTP.ItemCode
                                      AND VTP.Periodo  = @Periodo
  LEFT JOIN SBO_Imp_Eximben_SAC..VIC_VW_LoteFchUltIngr LUF  ON ITM.ItemCode         = LUF.ItemCode
  LEFT JOIN SBO_Imp_Eximben_SAC..VIC_VW_LoteUltimoCIF  LUC  ON ITM.ItemCode         = LUC.ItemCode
 WHERE 1 = 1
 
  ".$WareaNegocio."
 ".$WtipoProducto."
 ".$Wmarca."
 ".$Wlinea."
 ".$WsubLinea."
 ".$Wproveedor."
 ".$WbrandManager."
 
 
 GROUP BY
       ITM.AreaNegocio
      ,ITM.TipoProducto
      ,ITM.Marca
      ,ITM.Proveedor
      ,ITM.BrandManager
      ,ITM.Linea
      ,ITM.SubLinea
      ,ITM.ItemCode
      ,ITM.ItemName
      ,VTA.Quantity
      ,VTA.Total_CLP
      ,VTA.Total_USD
      ,VTA.CtoVtaCIF
      ,VTP.M_Quantity
      ,VTP.M_Total_CLP
      ,VTP.M_Total_USD
      ,VTP.M_CtoVtaCIF
      ,VTP.R_Quantity
      ,VTP.R_Total_CLP
      ,VTP.R_Total_USD
      ,VTP.R_CtoVtaCIF
      ,VTP.Quantity
      ,VTP.Total_CLP
      ,VTP.Total_USD
      ,VTP.CtoVtaCIF
      ,LUF.PerUltIngr
      ,LUC.Ultimo_CIF
 ORDER BY
       ITM.AreaNegocio
      ,ITM.TipoProducto
      ,ITM.ItemCode

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
						<th>Periodo</th>
						<th>Area Negocio</th>
						<th>Tipo Producto</th>
						<th>Marca</th>
						<th>Proveedor</th>
						<th>Brand Manager</th>
					    <th>Linea</th>
                        <th>Sub Linea</th>
						<th>Codigo</th>
						<th>Descripcion</th>
						<th>Mayorista Unidades</th> 
						<th>Mayorista CLP</th> 
						<th>Mayorista USD</th> 
						<th>Mayorista CIF</th> 
						<th>Retail Unidades</th> 
						<th>Retail CLP</th> 
						<th>Retail USD</th> 
						<th>Retail CIF</th> 
						<th>Total Unidades</th> 
						<th>Total CLP</th> 
						<th>Total USD</th> 
						<th>Total CIF</th> 
						<th>Acum Unidades</th> 
						<th>Acum CLP</th> 
						<th>Acum USD</th> 
						<th>Acum CIF</th> 
						<th>Stock Modulo</th> 
						<th>Stock Galpon</th> 
						<th>Stock Total</th> 
						<th>Stock CIF</th> 
						<th>CIF Promedio</th> 
						<th>Ult. Ingreso</th> 
						<th>Ult. CIF</th> 
					</tr>	
           
              </thead>
              <tbody>
		<?php
					$rs = odbc_exec( $conn, $sql );
					if ( !$rs )
					{
					exit( "Error en la consulta SQL" );
					}
							
					 odbc_next_result($rs);
			

					while($resultado = odbc_fetch_array($rs))
					{
					
			
						echo'
						<tr>
						<td >'.utf8_encode($resultado["Periodo"]).'</td>
						<td >'.utf8_encode($resultado["Area_Negocio"]).'</td>
						<td >'.utf8_encode($resultado["Tipo_Producto"]).'</td>
						<td >'.utf8_encode($resultado["Marca"]).'</td>
						<td >'.utf8_encode($resultado["Proveedor"]).'</td>
						<td >'.utf8_encode($resultado["Brand_Manager"]).'</td>
						<td >'.utf8_encode($resultado["Linea"]).'</td>
						<td >'.utf8_encode($resultado["Sub_Linea"]).'</td>
						<td >'.utf8_encode((string)$resultado["Codigo"]).'&nbsp;</td> 
						<td >'.utf8_encode($resultado["Descripcion"]).'</td> 
						<td ><strong>'.number_format($resultado["May_Und"], 0, '', '.').'</strong></td>
						<td ><strong>'.number_format($resultado["May_Vta_CLP"], 0, '', '.').'</strong></td>
						<td ><strong>'.number_format($resultado["May_Vta_USD"], 4, ',', '.').'</strong></td>
						<td ><strong>'.number_format($resultado["May_Cto_CIF"], 4, ',', '.').'</strong></td>
						
						<td ><strong>'.number_format($resultado["Ret_Und"], 0, '', '.').'</strong></td>
						<td ><strong>'.number_format($resultado["Ret_Vta_CLP"], 0, '', '.').'</strong></td>
						<td ><strong>'.number_format($resultado["Ret_Vta_USD"], 4, ',', '.').'</strong></td>
						<td ><strong>'.number_format($resultado["Ret_Cto_CIF"], 4, ',', '.').'</strong></td>
						
						<td ><strong>'.number_format($resultado["Per_Und"], 0, '', '.').'</strong></td>
						<td ><strong>'.number_format($resultado["Per_Vta_CLP"], 0, '', '.').'</strong></td>
						<td ><strong>'.number_format($resultado["Per_Vta_USD"], 4, ',', '.').'</strong></td>
						<td ><strong>'.number_format($resultado["Per_Cto_CIF"], 4, ',', '.').'</strong></td>
						
						<td ><strong>'.number_format($resultado["Acum_Und"], 0, '', '.').'</strong></td>
						<td ><strong>'.number_format($resultado["Acum_Vta_CLP"], 0, '', '.').'</strong></td>
						<td ><strong>'.number_format($resultado["Acum_Vta_USD"], 4, ',', '.').'</strong></td>
						<td ><strong>'.number_format($resultado["Acum_Cto_CIF"], 4, ',', '.').'</strong></td>
						
						
						<td ><strong>'.number_format($resultado["Stock_Modulo"], 0, '', '.').'</strong></td>
						<td ><strong>'.number_format($resultado["Stock_Galpon"], 0, '', '.').'</strong></td>
						<td ><strong>'.number_format($resultado["Stock_Total"], 0, '', '.').'</strong></td>
						<td ><strong>'.number_format($resultado["Stock_CIF"], 4, ',', '.').'</strong></td>
						
						<td ><strong>'.number_format($resultado["CIF_Promedio"], 4, ',', '.').'</strong></td>
						<td ><strong>'.$resultado["Ult_Ingreso"].'</strong></td>
						<td ><strong>'.number_format($resultado["Ult-CIF"], 4, ',', '.').'</strong></td>
						
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