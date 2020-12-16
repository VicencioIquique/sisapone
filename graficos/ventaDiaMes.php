 <script type="text/javascript">
            var chart;

            var chartData = [
			
<?php 
					echo '{ country: "1",
							visits: '.abs($d1[1]+$d1[0]+$d1[2]+$d1[3]).',
							cif: '.abs($d1CIF[1]+$d1CIF[0]+$d1CIF[2]+$d1CIF[3]).',
							cant: '.abs($d1Cant[1]+$d1Cant[0]+$d1Cant[2]+$d1Cant[3]).',
							USD: '.abs($d1USD[1]+$d1USD[0]+$d1USD[2]+$d1USD[3]).',
							color: "#0489B1"
						},
							{ country: "2",
							visits: '.abs($d2[1]+$d2[0]+$d2[2]+$d2[3]).',
							cif: '.abs($d2CIF[1]+$d2CIF[0]+$d2CIF[2]+$d2CIF[3]).',
							cant: '.abs($d2Cant[1]+$d2Cant[0]+$d2Cant[2]+$d2Cant[3]).',
							USD: '.abs($d2USD[1]+$d2USD[0]+$d2USD[2]+$d2USD[3]).',
							color: "#0489B1"
						},
							{ country: "3",
							visits: '.abs($d3[1]+$d3[0]+$d3[2]+$d3[3]).',
							cif: '.abs($d3CIF[1]+$d3CIF[0]+$d3CIF[2]+$d3CIF[3]).',
							cant: '.abs($d3Cant[1]+$d3Cant[0]+$d3Cant[2]+$d3Cant[3]).',
							USD: '.abs($d3USD[1]+$d3USD[0]+$d3USD[2]+$d3USD[3]).',
							color: "#0489B1"
						},
							{ country: "4",
							visits: '.abs($d4[1]+$d4[0]+$d4[2]+$d4[3]).',
							cif: '.abs($d4CIF[1]+$d4CIF[0]+$d4CIF[2]+$d4CIF[3]).',
							cant: '.abs($d4Cant[1]+$d4Cant[0]+$d4Cant[2]+$d4Cant[3]).',
							USD: '.abs($d4USD[1]+$d4USD[0]+$d4USD[2]+$d4USD[3]).',
							color: "#0489B1"
						},
							{ country: "5",
							visits: '.abs($d5[1]+$d5[0]+$d5[2]+$d5[3]).',
							cif: '.abs($d5CIF[1]+$d5CIF[0]+$d5CIF[2]+$d5CIF[3]).',
							cant: '.abs($d5Cant[1]+$d5Cant[0]+$d5Cant[2]+$d5Cant[3]).',
							USD: '.abs($d5USD[1]+$d5USD[0]+$d5USD[2]+$d5USD[3]).',
							color: "#0489B1"
						},
							{ country: "6",
							visits: '.abs($d6[1]+$d6[0]+$d6[2]+$d6[3]).',
							cif: '.abs($d6CIF[1]+$d6CIF[0]+$d6CIF[2]+$d6CIF[3]).',
							cant: '.abs($d6Cant[1]+$d6Cant[0]+$d6Cant[2]+$d6Cant[3]).',
							USD: '.abs($d6USD[1]+$d6USD[0]+$d6USD[2]+$d6USD[3]).',
							color: "#0489B1"
						},
							{ country: "7",
							visits: '.abs($d7[1]+$d7[0]+$d7[2]+$d7[3]).',
							cif: '.abs($d7CIF[1]+$d7CIF[0]+$d7CIF[2]+$d7CIF[3]).',
							cant: '.abs($d7Cant[1]+$d7Cant[0]+$d7Cant[2]+$d7Cant[3]).',
							USD: '.abs($d7USD[1]+$d7USD[0]+$d7USD[2]+$d7USD[3]).',
							color: "#0489B1"
						},
							{ country: "8",
							visits: '.abs($d8[1]+$d8[0]+$d8[2]+$d8[3]).',
							cif: '.abs($d8CIF[1]+$d8CIF[0]+$d8CIF[2]+$d8CIF[3]).',
							cant: '.abs($d8Cant[1]+$d8Cant[0]+$d8Cant[2]+$d8Cant[3]).',
							USD: '.abs($d8USD[1]+$d8USD[0]+$d8USD[2]+$d8USD[3]).',
							color: "#0489B1"
						},
							{ country: "9",
							visits: '.abs($d9[1]+$d9[0]+$d9[2]+$d9[3]).',
							cif: '.abs($d9CIF[1]+$d9CIF[0]+$d9CIF[2]+$d9CIF[3]).',
							cant: '.abs($d9Cant[1]+$d9Cant[0]+$d9Cant[2]+$d9Cant[3]).',
							USD: '.abs($d9USD[1]+$d9USD[0]+$d9USD[2]+$d9USD[3]).',
							color: "#0489B1"
						},
							{ country: "10",
							visits: '.abs($d10[1]+$d10[0]+$d10[2]+$d10[3]).',
							cif: '.abs($d10CIF[1]+$d10CIF[0]+$d10CIF[2]+$d10CIF[3]).',
							cant: '.abs($d10Cant[1]+$d10Cant[0]+$d10Cant[2]+$d10Cant[3]).',
							USD: '.abs($d10USD[1]+$d10USD[0]+$d10USD[2]+$d10USD[3]).',
							color: "#0489B1"
						},
							{ country: "11",
							visits: '.abs($d11[1]+$d11[0]+$d11[2]+$d11[3]).',
							cif: '.abs($d11CIF[1]+$d11CIF[0]+$d11CIF[2]+$d11CIF[3]).',
							cant: '.abs($d11Cant[1]+$d11Cant[0]+$d11Cant[2]+$d11Cant[3]).',
							USD: '.abs($d11USD[1]+$d11USD[0]+$d11USD[2]+$d11USD[3]).',
							color: "#0489B1"
						},
							{ country: "12",
							visits: '.abs($d12[1]+$d12[0]+$d12[2]+$d12[3]).',
							cif: '.abs($d12CIF[1]+$d12CIF[0]+$d12CIF[2]+$d12CIF[3]).',
							cant: '.abs($d12Cant[1]+$d12Cant[0]+$d12Cant[2]+$d12Cant[3]).',
							USD: '.abs($d12USD[1]+$d12USD[0]+$d12USD[2]+$d12USD[3]).',
							color: "#0489B1"
						},
							{ country: "13",
							visits: '.abs($d13[1]+$d13[0]+$d13[2]+$d13[3]).',
							cif: '.abs($d13CIF[1]+$d13CIF[0]+$d13CIF[2]+$d13CIF[3]).',
							cant: '.abs($d13Cant[1]+$d13Cant[0]+$d13Cant[2]+$d13Cant[3]).',
							USD: '.abs($d13USD[1]+$d13USD[0]+$d13USD[2]+$d13USD[3]).',
							color: "#0489B1"
						},
							{ country: "14",
							visits: '.abs($d14[1]+$d14[0]+$d14[2]+$d14[3]).',
							cif: '.abs($d14CIF[1]+$d14CIF[0]+$d14CIF[2]+$d14CIF[3]).',
							cant: '.abs($d14Cant[1]+$d14Cant[0]+$d14Cant[2]+$d14Cant[3]).',
							USD: '.abs($d14USD[1]+$d14USD[0]+$d14USD[2]+$d14USD[3]).',
							color: "#0489B1"
						},
							{ country: "15",
							visits: '.abs($d15[1]+$d15[0]+$d15[2]+$d15[3]).',
							cif: '.abs($d15CIF[1]+$d15CIF[0]+$d15CIF[2]+$d15CIF[3]).',
							cant: '.abs($d15Cant[1]+$d15Cant[0]+$d15Cant[2]+$d15Cant[3]).',
							USD: '.abs($d15USD[1]+$d15USD[0]+$d15USD[2]+$d15USD[3]).',
							color: "#0489B1"
						},
							{ country: "16",
							visits: '.abs($d16[1]+$d16[0]+$d16[2]+$d16[3]).',
							cif: '.abs($d16CIF[1]+$d16CIF[0]+$d16CIF[2]+$d16CIF[3]).',
							cant: '.abs($d16Cant[1]+$d16Cant[0]+$d16Cant[2]+$d16Cant[3]).',
							USD: '.abs($d16USD[1]+$d16USD[0]+$d16USD[2]+$d16USD[3]).',
							color: "#0489B1"
						},
							{ country: "17",
							visits: '.abs($d17[1]+$d17[0]+$d17[2]+$d17[3]).',
							cif: '.abs($d17CIF[1]+$d17CIF[0]+$d17CIF[2]+$d17CIF[3]).',
							cant: '.abs($d17Cant[1]+$d17Cant[0]+$d17Cant[2]+$d17Cant[3]).',
							USD: '.abs($d17USD[1]+$d17USD[0]+$d17USD[2]+$d17USD[3]).',
							color: "#0489B1"
						},
							{ country: "18",
							visits: '.abs($d18[1]+$d18[0]+$d18[2]+$d18[3]).',
							cif: '.abs($d18CIF[1]+$d18CIF[0]+$d18CIF[2]+$d18CIF[3]).',
							cant: '.abs($d18Cant[1]+$d18Cant[0]+$d18Cant[2]+$d18Cant[3]).',
							USD: '.abs($d18USD[1]+$d18USD[0]+$d18USD[2]+$d18USD[3]).',
							color: "#0489B1"
						},
							{ country: "19",
							visits: '.abs($d19[1]+$d19[0]+$d19[2]+$d19[3]).',
							cif: '.abs($d19CIF[1]+$d19CIF[0]+$d19CIF[2]+$d19CIF[3]).',
							cant: '.abs($d19Cant[1]+$d19Cant[0]+$d19Cant[2]+$d19Cant[3]).',
							USD: '.abs($d19USD[1]+$d19USD[0]+$d19USD[2]+$d19USD[3]).',
							color: "#0489B1"
						},
							{ country: "20",
							visits: '.abs($d20[1]+$d20[0]+$d20[2]+$d20[3]).',
							cif: '.abs($d20CIF[1]+$d20CIF[0]+$d20CIF[2]+$d20CIF[3]).',
							cant: '.abs($d20Cant[1]+$d20Cant[0]+$d20Cant[2]+$d20Cant[3]).',
							USD: '.abs($d20USD[1]+$d20USD[0]+$d20USD[2]+$d20USD[3]).',
							color: "#0489B1"
						},
							{ country: "21",
							visits: '.abs($d21[1]+$d21[0]+$d21[2]+$d21[3]).',
							cif: '.abs($d21CIF[1]+$d21CIF[0]+$d21CIF[2]+$d21CIF[3]).',
							cant: '.abs($d21Cant[1]+$d21Cant[0]+$d21Cant[2]+$d21Cant[3]).',
							USD: '.abs($d21USD[1]+$d21USD[0]+$d21USD[2]+$d21USD[3]).',
							color: "#0489B1"
						},
							{ country: "22",
							visits: '.abs($d22[1]+$d22[0]+$d22[2]+$d22[3]).',
							cif: '.abs($d22CIF[1]+$d22CIF[0]+$d22CIF[2]+$d22CIF[3]).',
							cant: '.abs($d22Cant[1]+$d22Cant[0]+$d22Cant[2]+$d22Cant[3]).',
							USD: '.abs($d22USD[1]+$d22USD[0]+$d22USD[2]+$d22USD[3]).',
							color: "#0489B1"
						},
							{ country: "23",
							visits: '.abs($d23[1]+$d23[0]+$d23[2]+$d23[3]).',
							cif: '.abs($d23CIF[1]+$d23CIF[0]+$d23CIF[2]+$d23CIF[3]).',
							cant: '.abs($d23Cant[1]+$d23Cant[0]+$d23Cant[2]+$d23Cant[3]).',
							USD: '.abs($d23USD[1]+$d23USD[0]+$d23USD[2]+$d23USD[3]).',
							color: "#0489B1"
						},
							{ country: "24",
							visits: '.abs($d24[1]+$d24[0]+$d24[2]+$d24[3]).',
							cif: '.abs($d24CIF[1]+$d24CIF[0]+$d24CIF[2]+$d24CIF[3]).',
							cant: '.abs($d24Cant[1]+$d24Cant[0]+$d24Cant[2]+$d24Cant[3]).',
							USD: '.abs($d24USD[1]+$d24USD[0]+$d24USD[2]+$d24USD[3]).',
							color: "#0489B1"
						},
							{ country: "25",
							visits: '.abs($d25[1]+$d25[0]+$d25[2]+$d25[3]).',
							cif: '.abs($d25CIF[1]+$d25CIF[0]+$d25CIF[2]+$d25CIF[3]).',
							cant: '.abs($d25Cant[1]+$d25Cant[0]+$d25Cant[2]+$d25Cant[3]).',
							USD: '.abs($d25USD[1]+$d25USD[0]+$d25USD[2]+$d25USD[3]).',
							color: "#0489B1"
						},
							{ country: "26",
							visits: '.abs($d26[1]+$d26[0]+$d26[2]+$d26[3]).',
							cif: '.abs($d26CIF[1]+$d26CIF[0]+$d26CIF[2]+$d26CIF[3]).',
							cant: '.abs($d26Cant[1]+$d26Cant[0]+$d26Cant[2]+$d26Cant[3]).',
							USD: '.abs($d26USD[1]+$d26USD[0]+$d26USD[2]+$d26USD[3]).',
							color: "#0489B1"
						},
							{ country: "27",
							visits: '.abs($d27[1]+$d27[0]+$d27[2]+$d27[3]).',
							cif: '.abs($d27CIF[1]+$d27CIF[0]+$d27CIF[2]+$d27CIF[3]).',
							cant: '.abs($d27Cant[1]+$d27Cant[0]+$d27Cant[2]+$d27Cant[3]).',
							USD: '.abs($d27USD[1]+$d27USD[0]+$d27USD[2]+$d27USD[3]).',
							color: "#0489B1"
						},
							{ country: "28",
							visits: '.abs($d28[1]+$d28[0]+$d28[2]+$d28[3]).',
							cif: '.abs($d28CIF[1]+$d28CIF[0]+$d28CIF[2]+$d28CIF[3]).',
							cant: '.abs($d28Cant[1]+$d28Cant[0]+$d28Cant[2]+$d28Cant[3]).',
							USD: '.abs($d28USD[1]+$d28USD[0]+$d28USD[2]+$d28USD[3]).',
							color: "#0489B1"
						},
							{ country: "29",
							visits: '.abs($d29[1]+$d29[0]+$d29[2]+$d29[3]).',
							cif: '.abs($d29CIF[1]+$d29CIF[0]+$d29CIF[2]+$d29CIF[3]).',
							cant: '.abs($d29Cant[1]+$d29Cant[0]+$d29Cant[2]+$d29Cant[3]).',
							USD: '.abs($d29USD[1]+$d29USD[0]+$d29USD[2]+$d29USD[3]).',
							color: "#0489B1"
						},
							{ country: "30",
							visits: '.abs($d30[1]+$d30[0]+$d30[2]+$d30[3]).',
							cif: '.abs($d30CIF[1]+$d30CIF[0]+$d30CIF[2]+$d30CIF[3]).',
							cant: '.abs($d30Cant[1]+$d30Cant[0]+$d30Cant[2]+$d30Cant[3]).',
							USD: '.abs($d30USD[1]+$d30USD[0]+$d30USD[2]+$d30USD[3]).',
							color: "#0489B1"
						},
							{ country: "31",
							visits: '.abs($d31[1]+$d31[0]+$d31[2]+$d31[3]).',
							cif: '.abs($d31CIF[1]+$d31CIF[0]+$d31CIF[2]+$d31CIF[3]).',
							cant: '.abs($d31Cant[1]+$d31Cant[0]+$d31Cant[2]+$d31Cant[3]).',
							USD: '.abs($d31USD[1]+$d31USD[0]+$d31USD[2]+$d31USD[3]).',
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
                valueAxis4.axisColor = "#CB2B3B";
				valueAxis4.title = "Ventas USD"
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
				 graph4.valueAxis = valueAxis4; // we have to indicate which value axis should be used
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
                chart.write("ventaDiaMes");
            });
        </script>
   