   <script type="text/javascript">
	var chart2 = AmCharts.makeChart("cantidadPorVenta", {
    "type": "gauge",
	"theme": "none",    
    "axes": [{
        "axisThickness":13,
         "axisAlpha":0.2,
         "tickAlpha":5,
         "valueInterval":20000,
        "bands": [{
            "color": "#A6CFE6",
            "endValue": 15000,
            "startValue": 0
        }, {
            "color": "#649ebf",
            "endValue": 45000,
            "startValue": 15000
        }, {
            "color": "#cc4748",
            "endValue": 100000,
            "innerRadius": "95%",
            "startValue": 45000
        }],
        "bottomText": "0 Venta",
        "bottomTextYOffset": -10,
        "endValue": 100000
    }],
    "arrows": [{}]
});

setInterval(randomValue2, 10000);

 // set random value
function randomValue2() {
    
	$.get("modulos/cmando/obtenerCantPorVenta.php",function(data2){
						var value2=data2;
						 chart2.arrows[0].setValue(value2);
					chart2.axes[0].setBottomText(value2+ " Venta");
		
					});
	
	//var value = Math.round(Math.random() * 50);
	
   
}

        </script>
   