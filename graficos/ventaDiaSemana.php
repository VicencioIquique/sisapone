<?php
	
	$rs = odbc_exec( $conn, $sql );
	if ( !$rs )
	{
	exit( "Error en la consulta SQL" );
	}
			
while($resultado = odbc_fetch_array($rs))
		{ 
			if($resultado["DIA"]=='Monday')
			{
				$lunes[] = $resultado["total"];
				$lunesCIF[] = $resultado["CIFTOTAL"];
				$lunesCant[] = $resultado["Cantidad"];
				$lunesUSD[] = $resultado["USD"];
			}
			if($resultado["DIA"]=='Tuesday')
			{
				$martes[] = $resultado["total"];
				$martesCIF[] = $resultado["CIFTOTAL"];
				$martesCant[] = $resultado["Cantidad"];
				$martesUSD[] = $resultado["USD"];
			}
			if($resultado["DIA"]=='Wednesday')
			{
				$miercoles[] = $resultado["total"];
				$miercolesCIF[] = $resultado["CIFTOTAL"];
				$miercolesCant[] = $resultado["Cantidad"];
				$miercolesUSD[] = $resultado["USD"];
			}
			if($resultado["DIA"]=='Thursday')
			{
				$jueves[] = $resultado["total"];
				$juevesCIF[] = $resultado["CIFTOTAL"];
				$juevesCant[] = $resultado["Cantidad"];
				$juevesUSD[] = $resultado["USD"];
			}
			if($resultado["DIA"]=='Friday')
			{
				$viernes[] = $resultado["total"];
				$viernesCIF[] = $resultado["CIFTOTAL"];
				$viernesCant[] = $resultado["Cantidad"];
				$viernesUSD[] = $resultado["USD"];
			}
			if($resultado["DIA"]=='Saturday')
			{
				$sabado[] = $resultado["total"];
				$sabadoCIF[] = $resultado["CIFTOTAL"];
				$sabadoCant[] = $resultado["Cantidad"];
				$sabadoUSD[] = $resultado["USD"];
			}
			if($resultado["DIA"]=='Sunday')
			{
				$domingo[] = $resultado["total"];
				$domingoCIF[] = $resultado["CIFTOTAL"];
				$domingooCant[] = $resultado["Cantidad"];
				$domingooUSD[] = $resultado["USD"];
			}
			
		  //echo $lunes[0];
		}
			
?>   
     <script type="text/javascript">
            var chart;

            var chartData = [
			
<?php 
echo '{ country: "Lunes",
			visits: '.abs($lunes[1]-$lunes[0]).',
			cif: '.abs($lunesCIF[1]-$lunesCIF[0]).',
			cant: '.abs($lunesCant[1]-$lunesCant[0]).',
			USD: '.abs($lunesUSD[1]-$lunesUSD[0]).',
			color: "#0489B1"
		},
		{ country: "Martes",
			visits: '.abs($martes[1]-$martes[0]).',
			cif: '.abs($martesCIF[1]-$martesCIF[0]).',
			cant: '.abs($martesCant[1]-$martesCant[0]).',
			USD: '.abs($martesUSD[1]-$martesUSD[0]).',
			color: "#0489B1"
		},
		{ country: "Miercoles",
			visits: '.abs($miercoles[1]-$miercoles[0]).',
			cif: '.abs($miercolesCIF[1]-$miercolesCIF[0]).',
			cant: '.abs($miercolesCant[1]-$miercolesCant[0]).',
			USD: '.abs($miercolesUSD[1]-$miercolesUSD[0]).',
			color: "#0489B1"
		},
		{ country: "Jueves",
			visits: '.abs($jueves[1]-$jueves[0]).',
			cif: '.abs($juevesCIF[1]-$juevesCIF[0]).',
			cant: '.abs($juevesCant[1]-$juevesCant[0]).',
			USD: '.abs($juevesUSD[1]-$juevesUSD[0]).',
			color: "#0489B1"
		},
		{ country: "Viernes",
			visits: '.abs($viernes[1]-$viernes[0]).',
			cif: '.abs($viernesCIF[1]-$viernesCIF[0]).',
			cant: '.abs($viernesCant[1]-$viernesCant[0]).',
			USD: '.abs($viernesUSD[1]-$viernesUSD[0]).',
			color: "#0489B1"
		},
		{ country: "Sabado",
			visits: '.abs($sabado[1]-$sabado[0]).',
			cif: '.abs($sabadoCIF[1]-$sabadoCIF[0]).',
			cant: '.abs($sabadoCant[1]-$sabadoCant[0]).',
			USD: '.abs($sabadoUSD[1]-$sabadoUSD[0]).',
			color: "#0489B1"
		},
		{ country: "Domingo",
			visits: '.abs($domingo[1]-$domingo[0]).',
			cif: '.abs($domingoCIF[1]-$domingoCIF[0]).',
			cant: '.abs($domingoCant[1]-$domingoCant[0]).',
			USD: '.abs($domingoUSD[1]-$domingoUSD[0]).',
			color: "#0489B1"
		},
		
		'; //fin data
?>
			
			];
			
			//alert(chart);

            AmCharts.ready(function () {
                // SERIAL CHART
                chart = new AmCharts.AmSerialChart();
                chart.dataProvider = chartData;
                chart.categoryField = "country";
                chart.startDuration = 1;
				
				chart.numberFormatter = {
					  precision:-1,decimalSeparator:",",thousandsSeparator:"."
					};
				

                // AXES
               
                // value
                var valueAxis1 = new AmCharts.ValueAxis();
                valueAxis1.dashLength = 5;
				valueAxis1.axisColor = "#1464F4";
                valueAxis1.axisThickness = 1;
				valueAxis1.fontSize = 9;
                valueAxis1.title = "Ventas Por DIA CLP"
               
                chart.addValueAxis(valueAxis1);
				
				 // second value axis (on the right) 
                var valueAxis2 = new AmCharts.ValueAxis();
                valueAxis2.position = "right"; // this line makes the axis to appear on the right
                valueAxis2.axisColor = "#FF6600";
				valueAxis2.title = "Ventas Por DIA USD CIF"
                valueAxis2.gridAlpha = 0;
                valueAxis2.axisThickness = 1;
				valueAxis2.fontSize = 9;
				valueAxis1.dashLength = 5;
                chart.addValueAxis(valueAxis2);
				
				// second value axis (on the right) 
                var valueAxis3 = new AmCharts.ValueAxis();
				valueAxis3.offset = 90;
                valueAxis3.position = "right"; // this line makes the axis to appear on the right
                valueAxis3.axisColor = "#90CB2B";
				valueAxis3.title = "Unidades"
                valueAxis3.gridAlpha = 0;
                valueAxis3.axisThickness = 1;
				valueAxis3.fontSize = 9;
                chart.addValueAxis(valueAxis3);
				
				// second value axis (on the right) 
                var valueAxis4 = new AmCharts.ValueAxis();
				valueAxis4.offset = 90;
                valueAxis4.position = "right"; // this line makes the axis to appear on the right
                valueAxis4.axisColor = "#90CB2B";
				valueAxis4.title = "Unidades"
                valueAxis4.gridAlpha = 0;
                valueAxis4.axisThickness = 1;
				valueAxis4.fontSize = 9;
                chart.addValueAxis(valueAxis4);

                // GRAPH
                var graph = new AmCharts.AmGraph();
				 graph.valueAxis = valueAxis1; // we have to indicate which value axis should be used
                graph.valueField = "visits";
				graph.title = "Ventas en CLP ";
                graph.colorField = "color";
				graph.showBullet = false;
                graph.balloonText = "CLP $[[value]]";
                graph.type = "column";
                graph.lineAlpha = 0;
                graph.fillAlphas = 1;
                chart.addGraph(graph);
				
				 var graph2 = new AmCharts.AmGraph();
				 graph2.valueAxis = valueAxis2; // we have to indicate which value axis should be used
                graph2.type = "line";
                graph2.title = "Ventas en CIF USD";
                graph2.valueField = "cif";
                graph2.lineThickness = 1;
				graph2.balloonText = "CIF $[[value]]";
				 graph2.lineColor = "#FF6600";
				 graph2.bulletBorderColor = "#FF6600";
                graph2.bullet = "round";
                chart.addGraph(graph2);
				
				var graph3 = new AmCharts.AmGraph();
				 graph3.valueAxis = valueAxis3; // we have to indicate which value axis should be used
                graph3.type = "line";
                graph3.title = "Ventas en Unidades";
                graph3.valueField = "cant";
                graph3.lineThickness = 1;
				graph3.balloonText = "[[value]] UN.";
				 graph3.lineColor = "#90CB2B";
				 graph3.bulletBorderColor = "#90CB2B";
                graph3.bullet = "square";
                chart.addGraph(graph3);
				
				var graph4 = new AmCharts.AmGraph();
				 graph4.valueAxis = valueAxis3; // we have to indicate which value axis should be used
                graph4.type = "line";
                graph4.title = "Ventas en USD";
                graph4.valueField = "USD";
                graph4.lineThickness = 1;
				graph4.balloonText = "[[value]] USD";
				 graph4.lineColor = "#CB2B3B";
				 graph4.bulletBorderColor = "#CB2B3B";
                graph4.bullet = "triangleUp";
                chart.addGraph(graph4);
				
				// category
                var categoryAxis = chart.categoryAxis;
                categoryAxis.labelRotation = 45; // this line makes category values to be rotated
                categoryAxis.gridAlpha = 0;
                categoryAxis.fillAlpha = 1;
                categoryAxis.fillColor = "#FAFAFA";
                categoryAxis.gridPosition = "start";

				
				 var legend = new AmCharts.AmLegend();
                legend.marginLeft = 90;
                chart.addLegend(legend);
				
				
                // WRITE
                chart.write("ventaDiaSemana");
            });
        </script>
   