<?php 
require_once("clases/conexionocdb.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
$vendedor = $_GET['id'];
$vendedorSelect = $_GET['id'];

$vendedor = str_pad($vendedor, 3, '0', 'STR_PAD_LEFT');
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

							
?>
<script type="text/javascript">
  $(document).ready(function(){
				//comienza focus en modulo
				$('#moduloid').focus();
				// calendarios en text de fecha inicio fin
				$( "#inicio" ).datepicker({ 
			   firstDay: 1, // comenzar el lunes
			  } );
				//formatos de las fechas
			   // $('#inicio').datepicker('option', {dateFormat: 'dd-mm-yy'});
				$( "#fin" ).datepicker(  );
				//$('#fin').datepicker('option', {dateFormat: 'dd-mm-yy'});

            });

</script>


<div class="idTabs">
      <ul>
        <li><a href="#one"><img src="images/agregar.png" width="30px" height="30px" /></a></li>
		<?php // pregunta si ha ingresado una fecha para que se muestre el imagen link de generar Excel
		
		if($finicio2){
		
		?>
		     <!-- <li><a href="../SISAP/modulos/vendedor/ventasproexcel.php?id=<?php //echo $vendedor; ?>&modulo=<?php // echo $modulo; ?>&inicio=<?php //echo $finicio2; ?>&fin=<?php // echo $ffin2; ?>&marca=<?php //echo $marca; ?>&codbarra=<?php //echo $codbarra; ?>"><img src="images/excel.png" width="30px" height="30px" /></a></li>-->
		<?php }?>
	 </ul>
      <div class="items">
        <div id="one"> <form action="" method="GET" id="horizontalForm">
        
            <fieldset>
				<legend>Ingresar Fechas</legend>
						

							  <input name="opc" type="hidden" id="opc" size="40" class="required" value="ventasBM" />
							
                             <label for="fecha1">
					            Inicio
                            <input name="inicio" type="text" id="inicio" size="40" class="required" value="<?php echo $finicio;?>"  />
                            </label>
							 <label for="fecha2">
					            Fin
                            <input name="fin" type="text" id="fin" size="40" class="required"  value="<?php echo $ffin;?>" />
                            </label>
                            
                             </label>
							
                             <input name="agregar" type="submit" id="agregar" class="submit" value="Consultar" />

			</fieldset>
            </form>
         </div> <!-- fin div two-->
      </div> <!-- fin items -->
    </div> <!-- fin idTabs -->
        
        
        
                 <?php
				 		
				  
				  $sql="SELECT SUM([Cantidad]) AS Cantidad
						  ,SUM([Pextendido])AS Pextendido
						  ,SUM([USD])AS USD
						  ,SUM([CIF])AS CIF
						  ,[BManager]
						 
					  FROM [RP_VICENCIO].[dbo].[SI_VentasPorBrandManager_ON]
					 WHERE (FechaDocto >= '".$finicio2." 00:00:00.000') AND (FechaDocto <= '".$ffin2." 23:59:59.000') 
					 GROUP BY  [BManager]";


echo $sql;
										
							//echo $sql;	
							$rs = odbc_exec( $conn, $sql );
							if ( !$rs )
							{
							exit( "Error en la consulta SQL" );
							}
						
				?>
	<div style="float:right;margin-right:10px;margin-top:20px;">
		  <table  id="ssptable2" class="lista" style="width:500px;margin: 0 0 0 0;  " >
              <thead>
                    <tr>
						<th>Nombre</th>
						<th>Un.</th>
						<th>Total Venta</th> 
						<!--<th>Cant N. Credito</th> 
						<th>Total N. Credito</th> 
						<th>Total CIF</th> -->
                    </tr>
                </thead>
				
                <tbody>
				<?php
				while($resultado = odbc_fetch_array($rs) )
				{ 
							echo'<tr>
									<td >'.$resultado['BManager'].'</td> 
									<td >'.(int)$resultado['Cantidad'].'</td> 
									<td ><strong>'.number_format($resultado['Pextendido'], 0, '', '.').'</strong></td>
								 </tr>';
							$cantotal=$cantotal+$resultado['Cantidad'];
							$total = $total + $resultado['Pextendido'];
				}
				?>
				</tbody>
				
                <tfoot>
                	<tr>
                    	<td colspan="11">Cantidad: <strong> <?php echo $cantotal; ?></strong> Productos. --- TOTAL de: <strong>$<?php echo number_format($total, 0, '', '.'); ?></strong> </td>
                    </tr>
                </tfoot>
            </table>
		</div>	
		
		<div style=" width:560px; height:300px; float:left; margin-left:10px;-moz-border-radius:5px 5px 5px;-webkit-border-radius: 5px 5px 5px;
     	border-radius: 5px 5px 5px 5px;
	
	       border: 1px solid #dedede;">
		<script src="graficos/amcharts/amcharts.js" type="text/javascript"></script>
			     <script type="text/javascript">
            var chart;

            var chartData = [
			
			<?php 
			
			$rs2 = odbc_exec( $conn, $sql );
							if ( !$rs2 )
							{
							exit( "Error en la consulta SQL" );
							}
						
				while($resultado2 = odbc_fetch_array($rs2)){ 
							  
									echo '{ 
										country: "'.utf8_encode($resultado2["BManager"]).'",
										visits: '.$resultado2["Pextendido"].'
										
									},'; //fin data
									
					}//fin while
	
			?>
			
		];


            AmCharts.ready(function () {
                // PIE CHART
                chart = new AmCharts.AmPieChart();
				

                // title of the chart
              chart.addTitle("Ventas Brand Manager", 16);

                chart.dataProvider = chartData;
                chart.titleField = "country";
                chart.valueField = "visits";
                chart.sequencedAnimation = true;
                chart.startEffect = "elastic";
                chart.innerRadius = "30%";
                chart.startDuration = 2;
                chart.labelRadius = 15;
				

				chart.autoMargins = false;
				chart.marginTop = 0;
				chart.marginBottom = 0;
				chart.marginLeft = 0;
				chart.marginRight = 0;
				chart.colors = ["#B0DE09", "#04D215", "#0D8ECF", "#0D52D1", "#ff0000"];
			

                // the following two lines makes the chart 3D
                chart.depth3D = 10;
                chart.angle = 15;

                // WRITE                                 
                chart.write("chartdiv");
            });
        </script>
    </head>
    
    <body>
        <div id="chartdiv" style="width:600px; height:350px; padding-top:-20px;"></div>
    </body>
		</div>
            


	<?php odbc_close( $conn );?>