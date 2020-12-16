<?php



 /* $sql2="SELECT TOP 1000 
      
       SUM([Cantidad]) AS SumaCant
      ,SUM([TotalCLP]) AS SumaMarca
      ,SUM([TotalCIF]) AS CIF
      ,SUM([TotalUSD]) AS USD
      ,[Marca] AS Name
     ".$conAreaNegocio."
  FROM [SBO_Imp_Eximben_SAC].[dbo].[VIC_VW_VtasD_RPRO]
  WHERE (DocDate >= '".$finicio2." 00:00:00.000') AND (DocDate <= '".$ffin2." 23:59:59.000')
		".$conGrupo."
		".$conModulo."
  GROUP BY [Marca] ".$conGrupoGroup."  ".$conModuloGroup."
  ORDER BY SumaCant DESC";*/


//echo $sql2;	
							$rs2 = odbc_exec( $conn, $sql );
							if ( !$rs2 )
							{
							exit( "Error en la consulta SQL" );
							}
							
		
?>   


       
        <script type="text/javascript">
            var chart2;

            var chartData2 = [
			
			<?php 
 		while($resultado2 = odbc_fetch_array($rs2)){ 
							  
									echo '{ 
										country: "'.utf8_encode($resultado2["Name"]).'",
										visits: '.$resultado2["SumCantidad"].',
										color: "#7eb61b"
									},'; //fin data
									
		 }//fin while
	
?>
			
			];


            AmCharts.ready(function () {
                // SERIAL CHART
                chart2 = new AmCharts.AmSerialChart();
                chart2.dataProvider = chartData2;
                chart2.categoryField = "country";
                chart2.startDuration = 1;

                // AXES
                // category
                var categoryAxis2 = chart2.categoryAxis;
                categoryAxis2.labelRotation = 45; // this line makes category values to be rotated
                categoryAxis2.gridAlpha = 0;
                categoryAxis2.fillAlpha = 1;
                categoryAxis2.fillColor = "#FAFAFA";
                categoryAxis2.gridPosition = "start";

                // value
                var valueAxis2 = new AmCharts.ValueAxis();
                valueAxis2.dashLength = 5;
                valueAxis2.title = "Cantidades Por Marca"
                valueAxis2.axisAlpha = 0;
                chart2.addValueAxis(valueAxis2);

                // GRAPH
                var graph2 = new AmCharts.AmGraph();
                graph2.valueField = "visits";
                graph2.colorField = "color";
                graph2.balloonText = "[[category]]: [[value]]";
                graph2.type = "column";
                graph2.lineAlpha = 0;
                graph2.fillAlphas = 1;
                chart2.addGraph(graph2);

                // WRITE
                chart2.write("unidadCantidad");
            });
        </script>
   