<?php
	
	$rs = odbc_exec( $conn, $sql );
	if ( !$rs )
	{
	exit( "Error en la consulta SQL" );
	}
			
while($resultado = odbc_fetch_array($rs))
		{ 
			if($resultado["MES"]=='2014.01')
			{
				$enero[] = $resultado["total"];
				$eneroCIF[] = $resultado["CIFTOTAL"];
				$eneroCant[] = $resultado["Cantidad"];
				$eneroUSD[] = $resultado["USD"];
			}
			if($resultado["MES"]=='2014.02')
			{
				$febrero[] = $resultado["total"];
				$febreroCIF[] = $resultado["CIFTOTAL"];
				$febreroCant[] = $resultado["Cantidad"];
				$febreroUSD[] = $resultado["USD"];
			}
			if($resultado["MES"]=='2014.03')
			{
				$marzo[] = $resultado["total"];
				$marzoCIF[] = $resultado["CIFTOTAL"];
				$marzoCant[] = $resultado["Cantidad"];
				$marzoUSD[] = $resultado["USD"];
			}
			if($resultado["MES"]=='2014.04')
			{
				$abril[] = $resultado["total"];
				$abrilCIF[] = $resultado["CIFTOTAL"];
				$abrilCant[] = $resultado["Cantidad"];
				$abrilUSD[] = $resultado["USD"];
			}
			if($resultado["MES"]=='2014.05')
			{
				$mayo[] = $resultado["total"];
				$mayoCIF[] = $resultado["CIFTOTAL"];
				$mayoCant[] = $resultado["Cantidad"];
				$mayoUSD[] = $resultado["USD"];
			}
			if($resultado["MES"]=='2014.06')
			{
				$junio[] = $resultado["total"];
				$junioCIF[] = $resultado["CIFTOTAL"];
				$junioCant[] = $resultado["Cantidad"];
				$junioUSD[] = $resultado["USD"];
			}
			if($resultado["MES"]=='2014.07')
			{
				$julio[] = $resultado["total"];
				$julioCIF[] = $resultado["CIFTOTAL"];
				$julioCant[] = $resultado["Cantidad"];
				$julioUSD[] = $resultado["USD"];
			}
			if($resultado["MES"]=='2014.08')
			{
				$agosto[] = $resultado["total"];
				$agostoCIF[] = $resultado["CIFTOTAL"];
				$agostoCant[] = $resultado["Cantidad"];
				$agostoUSD[] = $resultado["USD"];
			}
			if($resultado["MES"]=='2014.09')
			{
				$sept[] = $resultado["total"];
				$septCIF[] = $resultado["CIFTOTAL"];
				$septCant[] = $resultado["Cantidad"];
				$septUSD[] = $resultado["USD"];
			}
			if($resultado["MES"]=='2014.10')
			{
				$oct[] = $resultado["total"];
				$octCIF[] = $resultado["CIFTOTAL"];
				$octCant[] = $resultado["Cantidad"];
				$octUSD[] = $resultado["USD"];
			}
			if($resultado["MES"]=='2014.11')
			{
				$nov[] = $resultado["total"];
				$novCIF[] = $resultado["CIFTOTAL"];
				$novCant[] = $resultado["Cantidad"];
				$novUSD[] = $resultado["USD"];
			}
			if($resultado["MES"]=='2014.12')
			{
				$dic[] = $resultado["total"];
				$dicCIF[] = $resultado["CIFTOTAL"];
				$dicCant[] = $resultado["Cantidad"];
				$dicUSD[] = $resultado["USD"];
			}
		  //echo $enero[0];
		}
			
?>   
     <script type="text/javascript">
            var chart;

            var chartData = [
			
<?php 
echo '{ country: "Enero",
			visits: '.abs($enero[1]+$enero[0]+$enero[2]+$enero[3]).',
			cif: '.abs($eneroCIF[1]+$eneroCIF[0]+$eneroCIF[2]+$eneroCIF[3]).',
			cant: '.abs($eneroCant[1]+$eneroCant[0]+$eneroCant[2]+$eneroCant[3]).',
			USD: '.abs($eneroUSD[1]+$eneroUSD[0]+$eneroUSD[2]+$eneroUSD[3]).',
			color: "#0489B1"
		},
		{ country: "Febrero",
			visits: '.abs($febrero[1]+$febrero[0]+$febrero[2]+$febrero[3]).',
			cif: '.abs($febreroCIF[1]+$febreroCIF[0]+$febreroCIF[2]+$febreroCIF[3]).',
			cant: '.abs($febreroCant[1]+$febreroCant[0]+$febreroCant[2]+$febreroCant[3]).',
			USD: '.abs($febreroUSD[1]+$febreroUSD[0]+$febreroUSD[2]+$febreroUSD[3]).',
			color: "#0489B1"
		},
		{ country: "Marzo",
			visits: '.abs($marzo[1]+$marzo[0]+$marzo[2]+$marzo[3]).',
			cif: '.abs($marzoCIF[1]+$marzoCIF[0]+$marzoCIF[2]+$marzoCIF[3]).',
			cant: '.abs($marzoCant[1]+$marzoCant[0]+$marzoCant[2]+$marzoCant[3]).',
			USD: '.abs($marzoUSD[1]+$marzoUSD[0]+$marzoUSD[2]+$marzoUSD[3]).',
			color: "#0489B1"
		},
		{ country: "Abril",
			visits: '.abs($abril[1]+$abril[0]+$abril[2]+$abril[3]).',
			cif: '.abs($abrilCIF[1]+$abrilCIF[0]+$abrilCIF[2]+$abrilCIF[3]).',
			cant: '.abs($abrilCant[1]+$abrilCant[0]+$abrilCant[2]+$abrilCant[3]).',
			USD: '.abs($abrilUSD[1]+$abrilUSD[0]+$abrilUSD[2]+$abrilUSD[3]).',
			color: "#0489B1"
		},
		{ country: "Mayo",
			visits: '.abs($mayo[1]+$mayo[0]+$mayo[2]+$mayo[3]).',
			cif: '.abs($mayoCIF[1]+$mayoCIF[0]+$mayoCIF[2]+$mayoCIF[3]).',
			cant: '.abs($mayoCant[1]+$mayoCant[0]+$mayoCant[2]+$mayoCant[3]).',
			USD: '.abs($mayoUSD[1]+$mayoUSD[0]+$mayoUSD[2]+$mayoUSD[3]).',
			color: "#0489B1"
		},
		{ country: "Junio",
			visits: '.abs($junio[1]+$junio[0]+$junio[2]+$junio[3]).',
			cif: '.abs($junioCIF[1]+$junioCIF[0]+$junioCIF[2]+$junioCIF[3]).',
			cant: '.abs($junioCant[1]+$junioCant[0]+$junioCant[2]+$junioCant[3]).',
			USD: '.abs($junioUSD[1]+$junioUSD[0]+$junioUSD[2]+$junioUSD[3]).',
			color: "#0489B1"
		},
		{ country: "Julio",
			visits: '.abs($julio[1]+$julio[0]+$julio[2]+$julio[3]).',
			cif: '.abs($julioCIF[1]+$julioCIF[0]+$julioCIF[2]+$julioCIF[3]).',
			cant: '.abs($julioCant[1]+$julioCant[0]+$julioCant[2]+$julioCant[3]).',
			USD: '.abs($julioUSD[1]+$julioUSD[0]+$julioUSD[2]+$julioUSD[3]).',
			color: "#0489B1"
		},
		{ country: "Agosto",
			visits: '.abs($agosto[1]+$agosto[0]+$agosto[2]+$agosto[3]).',
			cif: '.abs($agostoCIF[1]+$agostoCIF[0]+$agostoCIF[2]+$agostoCIF[3]).',
			cant: '.abs($agostoCant[1]+$agostoCant[0]+$agostoCant[2]+$agostoCant[3]).',
			USD: '.abs($agostoUSD[1]+$agostoUSD[0]+$agostoUSD[2]+$agostoUSD[3]).',
			color: "#0489B1"
		},
		{ country: "Septiembre",
			visits: '.abs($sept[1]+$sept[0]+$sept[2]+$sept[3]).',
			cif: '.abs($septCIF[1]+$septCIF[0]+$septCIF[2]+$septCIF[3]).',
			cant: '.abs($septCant[1]+$septCant[0]+$septCant[2]+$septCant[3]).',
			USD: '.abs($septUSD[1]+$septUSD[0]+$septUSD[2]+$septUSD[3]).',
			color: "#0489B1"
		},
		{ country: "Octubre",
			visits: '.abs($oct[1]+$oct[0]+$oct[2]+$oct[3]).',
			cif: '.abs($octCIF[1]+$octCIF[0]+$octCIF[2]+$octCIF[3]).',
			cant: '.abs($octCant[1]+$octCant[0]+$octCant[2]+$octCant[3]).',
			USD: '.abs($octUSD[1]+$octUSD[0]+$octUSD[2]+$octUSD[3]).',
			color: "#0489B1"
		},
		{ country: "Noviembre",
			visits: '.abs($nov[1]+$nov[0]+$nov[2]+$nov[3]).',
			cif: '.abs($novCIF[1]+$novCIF[0]+$novCIF[2]+$novCIF[3]).',
			cant: '.abs($novCant[1]+$novCant[0]+$novCant[2]+$novCant[3]).',
			USD: '.abs($novUSD[1]+$novUSD[0]+$novUSD[2]+$novUSD[3]).',
			color: "#0489B1"
		},
		{ country: "Diciembre",
			visits: '.abs($dic[1]+$dic[0]+$dic[2]+$dic[3]).',
			cif: '.abs($dicCIF[1]+$dicCIF[0]+$dicCIF[2]+$dicCIF[3]).',
			cant: '.abs($dicCant[1]+$dicCant[0]+$dicCant[2]+$dicCant[3]).',
			USD: '.abs($dicUSD[1]+$dicUSD[0]+$dicUSD[2]+$dicUSD[3]).',
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
                valueAxis1.title = "Ventas Por Mes CLP"
               
                chart.addValueAxis(valueAxis1);
				
				 // second value axis (on the right) 
                var valueAxis2 = new AmCharts.ValueAxis();
                valueAxis2.position = "right"; // this line makes the axis to appear on the right
                valueAxis2.axisColor = "#FF6600";
				valueAxis2.title = "Ventas Por Mes USD CIF"
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
                chart.write("ventaMensual");
            });
        </script>
   