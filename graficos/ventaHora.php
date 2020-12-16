 <script type="text/javascript">
            var chart;

            var chartData = [
			
<?php 
$dias =array('','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');
//echo $sql;	
							$rs2 = odbc_exec( $conn, $sql );
							if ( !$rs2 )
							{
							exit( "Error en la consulta SQL" );
							}

 while($resultado2 = odbc_fetch_array($rs2)){ 
 
 						    $fechaAux = explode(" ", $resultado2["HORA"]);							
							$fechaAux2 = $fechaAux[0];
							$hora = $fechaAux[1];
							$diaName = $dias[date('N', strtotime($fechaAux2 ))];
							$fechaAux2 = date('j', strtotime($fechaAux2 ));
 						
					echo '{ country: "'.$diaName.' '.$fechaAux2.' - '.$hora.':00",
							cant: '.$resultado2["CANT"].',
							total: '.$resultado2["TOTAL"].',
							color: "#E78239"
						}, '; //fin data
 }//fin while
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
                var valueAxis3 = new AmCharts.ValueAxis();
				 valueAxis3.dashLength = 5;
				valueAxis3.axisColor = "#1464F4";
                valueAxis3.axisThickness = 1;
				valueAxis3.offset = 90;
                valueAxis3.position = "right"; // this line makes the axis to appear on the right
                valueAxis3.axisColor = "#90CB2B";
				valueAxis3.title = "Unidades"
                valueAxis3.gridAlpha = 0;
                valueAxis3.axisThickness = 1;
				valueAxis3.fontSize = 9;
                chart.addValueAxis(valueAxis3);
				
				

                // GRAPH
                var graph = new AmCharts.AmGraph();
				 graph.valueAxis = valueAxis3; // we have to indicate which value axis should be used
                graph.valueField = "total";
				graph.title = "Ventas en CLP ";
                graph.colorField = "color";
				graph.showBullet = false;
                graph.balloonText = "CLP $[[value]]";
                graph.type = "column";
				graph.hidden = true;
                graph.lineAlpha = 0;
                graph.fillAlphas = 1;
                chart.addGraph(graph);
				
				
				
				var graph3 = new AmCharts.AmGraph();
				 graph3.valueAxis = valueAxis1; // we have to indicate which value axis should be used
                graph3.type = "line";
                graph3.title = "Ventas en Unidades";
                graph3.valueField = "cant";
                graph3.lineThickness = 1;
                graph3.balloonText = "[[value]]";
				graph3.lineColor = "#328FC1";
				graph3.bullet = "round";
				graph3.bulletSize = 5; // bullet image should be a rectangle (width = height)
                chart.addGraph(graph3);
				
				
				
				// category
                var categoryAxis = chart.categoryAxis;
                categoryAxis.labelRotation = 60; // this line makes category values to be rotated
				categoryAxis.fontSize = 9;
                categoryAxis.gridAlpha = 0;
                categoryAxis.fillAlpha = 1;
                categoryAxis.fillColor = "#FAFAFA";
                categoryAxis.gridPosition = "start";
				
				 // CURSOR
                chartCursor = new AmCharts.ChartCursor();
                chartCursor.cursorPosition = "mouse";
                chartCursor.pan = true; // set it to fals if you want the cursor to work in "select" mode
                chart.addChartCursor(chartCursor);

				
				 var legend = new AmCharts.AmLegend();
                legend.marginLeft = 90;
                chart.addLegend(legend);

                // WRITE
                chart.write("ventaHora");
            });
        </script>
   