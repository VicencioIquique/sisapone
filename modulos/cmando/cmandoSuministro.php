<?php 
require_once("../../clases/conexionocdb.php");//incluimos archivo de conexión
?>
<head>
	<style>
		
		#ind1{
			float:left;
			margin-left: 300px;
		}
	</style>
	 <link rel="stylesheet" href="css/styles.css" type="text/css" media="screen, print"/>
	<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js' type='text/javascript'/></script>
	<script src="js/raphael.2.1.0.min.js"></script>
	<script src="js/justgage.1.0.1.min.js"></script>
	<script src="js/jquery.backstretch.min.js"></script>
	<script>
     
		$(document).ready(function() {
			$.backstretch("img/suministro.png");
		});
		 
	</script> 
	<script type="text/javascript">
	var resEstadoUno=<?php
		
		$sql = "SELECT COUNT(*) AS Pedidos
			  FROM [RP_VICENCIO].[dbo].[sisap_solicitudes]
			  WHERE estado = 1";
			  

				$rs = odbc_exec( $conn, $sql );
				if ( !$rs){
					exit( "Error en la consulta SQL" );
				}
				 
				$resultado = odbc_fetch_array($rs);
				echo $resultado['Pedidos'];
	?>;
	var resEstadoDos=<?php
		
		$sql = "SELECT COUNT(*) AS Pedidos
			  FROM [RP_VICENCIO].[dbo].[sisap_solicitudes]
			  WHERE estado = 2";
			  

				$rs = odbc_exec( $conn, $sql );
				if ( !$rs){
					exit( "Error en la consulta SQL" );
				}
				 
				$resultado = odbc_fetch_array($rs);
				echo $resultado['Pedidos'];
	?>;
	var resPendientes=<?php
		$sql = "SELECT 
				COUNT(TABLA.NroDem) AS Pendientes
				 FROM
				(
				SELECT COUNT(NroDem) AS NroDem
				  FROM [RP_VICENCIO].[dbo].[RP_DEM]
				  WHERE estado = 0
				  GROUP BY NroDem
				  ) AS TABLA";
			  

				$rs = odbc_exec( $conn, $sql );
				if ( !$rs){
					exit( "Error en la consulta SQL" );
				}
				 
				$resultado = odbc_fetch_array($rs);
				echo $resultado['Pendientes'];
	?>;
	function pedidosMercaderia(){
		
		$.post('estadoSolicitud.php', {estado:1}, function(res){
			var resPHP = $.parseJSON(res);
			resEstadoUno = resPHP['cant'];
		});
		return resEstadoUno;
	}
	function pedidosMercaderiaDos(){
		
		$.post('estadoSolicitud.php', {estado:2}, function(res){
			var resPHP = $.parseJSON(res);
			resEstadoUno = resPHP['cant'];
		});
		return resEstadoDos;
	}
	function pedidosPendientes(){
		
		$.post('solPentientes.php', {estado:2}, function(res){
			var resPHP = $.parseJSON(res);
			resPendientes = resPHP['cant'];
		});
		return resPendientes;
	}
	
	
		$(document).ready(function(){
			 var g1 = new JustGage({
			  id: "g1", 
			  value: pedidosMercaderia(), /*PHP RESPONSE*/ 
			  min: 0,
			  max: 50,
			  title: "SOLICITA MERCADERIA\n POR SISAP",
			  label: "Pedidos"
			  
			});
			 var g2 = new JustGage({
			  id: "g2", 
			  value: pedidosMercaderiaDos(), /*PHP RESPONSE*/ 
			  min: 0,
			  max: 50,
			  title: "RECEPCION DE PEDIDOS",
			  label: "Pedidos"
			  
			});
			 var g3 = new JustGage({
			  id: "g3", 
			  value: pedidosPendientes(), /*PHP RESPONSE*/ 
			  min: 0,
			  max: 50,
			  title: "RECEPCION DE PEDIDOS",
			  label: "Pedidos"
			  
			});
			setInterval(function() {
			  g1.refresh(pedidosMercaderia()); /*PHP RESPONSE*/
			  g2.refresh(pedidosMercaderiaDos()); /*PHP RESPONSE*/
			  g3.refresh(pedidosPendientes()); /*PHP RESPONSE*/
			}, 300000);
			
		});
	</script>
	<script type="text/javascript">
	//<![CDATA[
		$(window).load(function() { // makes sure the whole site is loaded
			$('#status').fadeOut(); // will first fade out the loading animation
			$('#preloader').delay(350).fadeOut('slow'); // will fade out the white DIV that covers the website.
			$('body').delay(350).css({'overflow':'visible'});
		})
	//]]>
</script> 

</head>
<html>
<div id="preloader">
	<div id="status">&nbsp;</div>
</div>

	<div id="g1" class="indicador" style=" float: left; width:115px; height:100px; margin:1.1% 0 0 4.5%;"></div>
	<div id="g3" class="indicador" style="float:left; width:115px; height:100px; margin:1.1% 0 0 70.4%;"></div>
	<div style="clear:both;"></div>
	<div id="g2" class="indicador" style="float:left; width:115px; height:100px; margin:0.8% 0 0 4.5%;"></div>

	
</html>