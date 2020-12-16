<?php

                      /* $sql3="SELECT  [Cantidad] AS Cant
							  			   ,[FechaDoc]
						
						  FROM [RP_VICENCIO].[dbo].[SI_CantidadesParaRotacion_ON]
						  WHERE Sku = '".$_GET['sku']."' AND Bodega = ".$_GET['bodega']."
														
							UNION ALL
						
						  SELECT [Cantidad] AS Cant
							  ,[FechaDoc] AS FECHA
						  FROM [RP_VICENCIO].[dbo].[RP_DEM]
						  WHERE Codmodulo = ".$_GET['bodega']." AND CodigoProducto = '".$_GET['sku']."'
						  ORDER BY FechaDoc";*/

$sql3 ="SELECT     TOP (100) PERCENT dbo.RP_ReceiptsCab_SAP.Bodega, dbo.RP_ReceiptsCab_SAP.Workstation AS CAJA, dbo.RP_ReceiptsCab_SAP.TipoDocto, 
                      dbo.RP_ReceiptsCab_SAP.NumeroDocto, dbo.RP_ReceiptsCab_SAP.FechaDocto AS Fecha, dbo.RP_ReceiptsDet_SAP.Cantidad, 
                      dbo.RP_ReceiptsDet_SAP.PrecioExtendido, dbo.RP_ReceiptsCab_SAP.Total, dbo.RP_ReceiptsCab_SAP.Vendedor AS VendedorBoleta, 
                      dbo.RP_ReceiptsDet_SAP.Vendedor AS VendedorDetalle, dbo.RP_Articulos.PRICE01 AS PrecioOriginal
FROM         dbo.RP_ReceiptsDet_SAP LEFT OUTER JOIN
                      dbo.RP_Articulos ON dbo.RP_ReceiptsDet_SAP.Sku = dbo.RP_Articulos.ALU RIGHT OUTER JOIN
                      dbo.RP_ReceiptsCab_SAP ON dbo.RP_ReceiptsDet_SAP.ID = dbo.RP_ReceiptsCab_SAP.ID
WHERE     (dbo.RP_ReceiptsCab_SAP.Bodega = ".$_GET['bodega'].") AND (dbo.RP_ReceiptsDet_SAP.Sku = '".$_GET['sku']."')
ORDER BY Fecha";
						  
							$rs2 = odbc_exec( $conn, $sql3 );
							if ( !$rs2)
							{
							exit( "Error en la consulta SQL" );
							}
							
					$promedio = 35000;
						  	
?>   


       
        <script type="text/javascript">
            var chart;

            var chartData = [
			
			
<?php 
		$auxCarga= 0;
 		while($resultado = odbc_fetch_array($rs2))
		{ 
			
			 $fechaAux = explode(" ", $resultado["Fecha"]);							
							$fechaAux2 = $fechaAux[0];
							$hora = $fechaAux[1];
							$date = strtotime($fechaAux2);
			
							  
									echo '{ 
										date: "'.(int)$resultado["NumeroDocto"].'",
										Promedio: "'.(int)$resultado["PrecioOriginal"].'",
										Precio: "'.(int)($resultado["PrecioExtendido"]/$resultado["Cantidad"]).'",
										
									},'; //fin data
									
		 }//fin while
	
?>
			
			];

			function handleClick(event)
			{
			   
				alert(event.item.category + ": " + event.item.values.value);
			}

            AmCharts.ready(function () {
                // SERIAL CHART
                chart = new AmCharts.AmSerialChart();
                chart.dataProvider = chartData;
                chart.categoryField = "date";
                chart.dataDateFormat = "YYYY-MM-DD";
				
				 // add click listener
					chart.addListener("clickGraphItem",handleClick);

                // AXES
                // category
                var categoryAxis = chart.categoryAxis;
              
                categoryAxis.inside = true;
                categoryAxis.gridAlpha = 0;
                categoryAxis.tickLength = 0;
                categoryAxis.axisAlpha = 0;
                // value
                var valueAxis = new AmCharts.ValueAxis();
                valueAxis.dashLength = 5;
                valueAxis.title = "Evolucion Precio"
                valueAxis.axisAlpha = 0;
                chart.addValueAxis(valueAxis);

                // GRAPH
                var graph = new AmCharts.AmGraph(); // SEguimiento de Stock
                graph.valueField = "Precio";
                graph.lineColor = "#0C5789";
			    graph.type = "line";                
                graph.balloonText = "[[category]]: [[value]]";
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
                chart.write("evolucionPrecio");
            });
        </script>
   