<?php
	//Funcion que suma o resta n dias a una fecha
function DiasFecha($fecha,$dias,$operacion){
  Switch($operacion){
    case "sumar":
    $varFecha = date("Y-m-d", strtotime("$fecha + $dias day"));
    return $varFecha;
    break;
    case "restar":
    $varFecha = date("Y-m-d", strtotime("$fecha - $dias day"));
    return $varFecha;
    break;
    default:
    $varFecha = date("Y-m-d", strtotime("$fecha + $dias day"));
    break;
  }
}
            
						  
$sql3="
SELECT  [Cantidad] AS Cant
	   ,[FechaDoc] AS FECHA
       ,CASE
			WHEN TipoDocto = 3 THEN 'NC'
			WHEN TipoDocto = 1 THEN 'BF'
			WHEN TipoDocto = 4 THEN 'BV'
			WHEN TipoDocto = 2 THEN 'FV'
        END AS TipoDoc
	 FROM [RP_VICENCIO].[dbo].[SI_CantidadesParaRotacion_ON]
     WHERE Sku = '".$_GET['sku']."' AND Bodega = ".$_GET['bodega']."
														
 UNION ALL
						
   SELECT [Cantidad] AS Cant
  ,[FechaDoc] AS FECHA
    ,CASE
                    WHEN TipoDocto = 59 THEN 'DSM'
                    WHEN TipoDocto = 67 THEN 'DSM'
     END AS TipoDoc

  FROM [RP_VICENCIO].[dbo].[RP_DEM]
  WHERE Codmodulo = ".$_GET['bodega']." AND CodigoProducto = '".$_GET['sku']."' AND Estado = 1

 UNION ALL
						
   SELECT -[Cantidad] AS Cant
  ,[FechaDoc] AS FECHA
    ,CASE
                    WHEN TipoDocto = 67 THEN 'DEM'
     END AS TipoDoc

  FROM [RP_VICENCIO].[dbo].[RP_DSM]
WHERE Torigen = ".$_GET['bodega']." AND CodigoProducto = '".$_GET['sku']."' AND Estado = 1

ORDER BY FECHA";


							$rs2 = odbc_exec( $conn, $sql3 );
							if ( !$rs2)
							{
							exit( "Error en la consulta SQL" );
							}
							
						
						  
						  $sql4="SELECT  -AVG([Cantidad]) AS PROM
						
						  FROM [RP_VICENCIO].[dbo].[SI_CantidadesParaRotacion_ON]
						  WHERE Sku = '".$_GET['sku']."' AND Bodega = ".$_GET['bodega']."
							
							
							UNION ALL
						
						  SELECT AVG([Cantidad]) AS PROM
				
						  FROM [RP_VICENCIO].[dbo].[RP_DEM]
						  WHERE Codmodulo = ".$_GET['bodega']." AND CodigoProducto = '".$_GET['sku']."'
						 ";


							$rs4 = odbc_exec( $conn, $sql4 );
							if ( !$rs4)
							{
							exit( "Error en la consulta SQL" );
							}
							while($resultado4 = odbc_fetch_array($rs4))
							{ 
								$promedio  = $resultado4["PROM"];
							}
							
													
?>   

        <script type="text/javascript">
            var chart;

            var chartData = [
			
			
<?php 
		$auxCarga= 0;
 		while($resultado = odbc_fetch_array($rs2))
		{ 
			
			 $fechaAux = explode(" ", $resultado["FECHA"]);							
							$fechaAux2 = $fechaAux[0];
							$hora = $fechaAux[1];
							$date = strtotime($fechaAux2);

			
							  
									echo '{ 
										date: "'.DiasFecha(date('Y-m-d', $date),"1","sumar").'",
										Promedio: "'.(int)$promedio.'",
										TipoDoc: "'.$resultado["TipoDoc"].'",
										cant: "'.(int)$resultado["Cant"].'",
										Stock: ';
										if ($resultado["Cant"] >0)
										{
											echo (int)$auxCarga=$auxCarga+$resultado["Cant"];
											
																						
											
										}
										if ($resultado["Cant"] <0)
										{
											
											echo $auxCarga=$auxCarga+$resultado["Cant"];	
										}
										
										//($auxMax+$resultado["Cant"])
										echo'
									},'; //fin data
									
		 }//fin while

?>
			
			];


            AmCharts.ready(function () {
                // SERIAL CHART
                chart = new AmCharts.AmSerialChart();
                chart.dataProvider = chartData;
                chart.categoryField = "date";
                chart.dataDateFormat = "YYYY-MM-DD";


                // AXES
                // category
                var categoryAxis = chart.categoryAxis;
               categoryAxis.parseDates = true; // as our data is date-based, we set parseDates to true
                categoryAxis.minPeriod =  "DD"; // our data is daily, so we set minPeriod to DD
                categoryAxis.inside = true;
                categoryAxis.gridAlpha = 0;
                categoryAxis.tickLength = 0;
                categoryAxis.axisAlpha = 0;
                // value
                var valueAxis = new AmCharts.ValueAxis();
                valueAxis.dashLength = 5;
                valueAxis.title = "Evolucion"
                valueAxis.axisAlpha = 0;
                chart.addValueAxis(valueAxis);

                // GRAPH
                var graph = new AmCharts.AmGraph(); // SEguimiento de Stock
                graph.valueField = "Stock";
                graph.lineColor = "#0C5789";
			    graph.type = "line";                
                graph.balloonText = "STOCK :[[value]] \n [[TipoDoc]]:[[cant]]   ";
				graph.bulletSize = 14; // bullet image should be a rectangle (width = height)
				
				var graph2 = new AmCharts.AmGraph(); // Promedio de Seguimiento
                graph2.valueField = "Promedio";
                graph2.lineColor = "#E1AD32";
			    graph2.type = "line";   
				graph2.dashLength = 3;
                graph2.balloonText = "[[category]]: [[value]]";
				graph2.bulletSize = 14; // bullet image should be a rectangle (width = height)
				
				chart.addGraph(graph2);
                chart.addGraph(graph);
				
				
				var chartCursor = new AmCharts.ChartCursor();
                chart.addChartCursor(chartCursor);

                // WRITE
                chart.write("rotacion");
            });
        </script>
   