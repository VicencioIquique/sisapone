   <script type="text/javascript">
	var chart = AmCharts.makeChart("dsmNoAtendidos", {
    "type": "gauge",
	"theme": "none",    
    "axes": [{
        "axisThickness":13,
         "axisAlpha":0.2,
         "tickAlpha":5,
         "valueInterval":20,
        "bands": [{
            "color": "#A6CFE6",
            "endValue": 15,
            "startValue": 0
        }, {
            "color": "#649ebf",
            "endValue": 45,
            "startValue": 15
        }, {
            "color": "#cc4748",
            "endValue": 100,
            "innerRadius": "95%",
            "startValue": 45
        }],
        "bottomText": "0 DSM",
        "bottomTextYOffset": -10,
        "endValue": 100
    }],
    "arrows": [{}]
});

setInterval(randomValue, 10000);

 // set random value
function randomValue() {
    
	$.get("modulos/cmando/obtenerNumDSM.php",function(data){
						var value=data;
						 chart.arrows[0].setValue(value);
					chart.axes[0].setBottomText(value + " Dsm Pendientes");
		
					});
	
	//var value = Math.round(Math.random() * 50);
	
   
}

        </script>
   