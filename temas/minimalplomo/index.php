<?php
require_once("clases/menu.php");
require_once("clases/modulos.php");
require_once("clases/funciones.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>.: SISAP :.</title>
<link rel="stylesheet" type="text/css" href="temas/minimalplomo/minimalplomo.css"><!-- estilos geneales-->
<link rel="stylesheet" type="text/css" href="css/preload.css"><!--Preload-->
<link rel="stylesheet" type="text/css" href="css/introLoader.css"><!--Preload 2.0-->
<link rel="stylesheet" type="text/css" href="css/jquery-ui.css"><!-- estilos geneales-->
<!--<link rel="stylesheet" type="text/css" href="css/tooltip-form.css"> estilos geneales-->
<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js' type='text/javascript'/></script>
<script type="text/javascript" language="javascript" src="js/jquery-ui.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.ui.datepicker-es.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.datetimepicker.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery-ui-timepicker-addon.js"></script>
<script language="javascript" type="text/javascript" src="js/jquery.validate.1.5.2.js"></script>
<script language="javascript" type="text/javascript" src="js/script.js"></script>
<script language="javascript" type="text/javascript" src="js/jquery.idTabs.js"></script>

<!-- PRELOADER -->
<script src="js/jquery.easing.1.3.js"></script>
<script src="js/spin.min.js"></script>
<script src="js/jquery.introLoader.js"></script>

<!-- Prueba cmandoNuevo -->
	<script src="modulos/cmando/js/raphael.2.1.0.min.js"></script>
    <script src="modulos/cmando/js/justgage.1.0.1.min.js"></script>
	<script src="modulos/cmando/chart/Chart.js"></script>
	<script type="text/javascript" src="modulos/cmando/amchart/amcharts/amcharts.js"></script>
	<script type="text/javascript" src="modulos/cmando/amchart/amcharts/serial.js"></script>
	<script type="text/javascript" src="modulos/cmando/amchart/themes/light.js"></script>

<script language="javascript" type="text/javascript" src="js/jquery.Rut.js" ></script>
<script language="javascript" type="text/javascript" src="js/jquery.Rut.min.js" ></script>
<script type="text/javascript" language="javascript" src="js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" language="javascript" src="js/modal-window.min.js"></script>
<script type="text/javascript">
 $.datepicker.regional['es'] = {
 closeText: 'Cerrar',
 prevText: '<Ant',
 nextText: 'Sig>',
 currentText: 'Hoy',
 monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
 monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
 dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
 dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
 dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
 weekHeader: 'Sm',
 firstDay: 1,
 isRTL: false,
 showMonthAfterYear: false,
 yearSuffix: ''
 };
 $.datepicker.setDefaults($.datepicker.regional['es']);
 </script>
 <script>
	// function alertas(){
	// 	$.post('modulos/requerimientos/obtenerSolicitudes.php',function(resPHP){
	// 		var fechaActual = new Date();
	// 		var diaActual = fechaActual.getDate(); 
	// 		res = $.parseJSON(resPHP);
	// 		for(i=0;i<res.length;i++){
	// 			/*
	// 				Estados:
	// 				1: Sin alerta
	// 				2: Con alerta y correo mandado
	// 			*/
	// 			$.post('modulos/requerimientos/obtenerEstadoAlerta.php',{idReq:res[i]['idRequerimiento']},function(resPHP){
	// 				var resAlert = $.parseJSON(resPHP);
	// 				if((resAlert[0]['estadoAlerta'] == '1') && (diaActual%3 == 0)){
	// 					/*CAMBIAR A ESTADO 2 Y MANDAR EMAIL*/
	// 					$.post('modulos/requerimientos/actualizarEstadoAlarmaUno.php',{idReq:resAlert[0]['idRequerimiento']});
	// 				}else if((resAlert[0]['estadoAlerta'] == '2') && (diaActual%3 == 0)){
	// 					/*DEJAR EN ESTADO 2 Y NO MANDAR EMAIL*/
	// 					//$.post('modulos/requerimientos/actualizarEstadoAlarmaDos.php',{idReq:resAlert[0]['idRequerimiento']});
	// 				}else if(diaActual%3 != 0){
	// 					/*CAMBIAR A ESTADO 1 PARA REINICIAR EL ESTADO Y MANDAR EMAIL EN LOS DÍAS HÁBILES*/
	// 					$.post('modulos/requerimientos/actualizarEstadoAlarmaSinAlerta.php',{idReq:resAlert[0]['idRequerimiento']});
	// 				}
	// 			});
	// 		}
	// 	});
	// };
	$(document).ready(function(){
		// alertas();
		$("#largo").focus();
	});
 </script>
</head>
                          <!--  <script type="text/javascript">
                            function downloadJSAtOnload() { 
                                var element=document.createElement("script");element.src="http://www.elbuzondesugerencias.com/desarrollo/wdg/38505d5ca4688f41befc5bc986f436fc.js";document.body.appendChild(element); 
                            } 
                            if(window.addEventListener){ 
                                window.addEventListener("load",downloadJSAtOnload,false);
                            }else if(window.attachEvent){ 
                                window.attachEvent("onload",downloadJSAtOnload);
                            }else { 
                                window.onload=downloadJSAtOnload; }
                            </script>-->
                        
                        
<body>
<div id="contenedor">
	<div id="header">
	
	<a href='<?php  IF ($_SESSION["linkPersonal"]) echo $_SESSION["linkPersonal"]; ELSE  echo '#';?>' style='color:#3D9DE2; float:right !important;display:absolute;margin-top:7px; margin-right:5px; ' ><?php  echo $_SESSION["usuario_nombre"];?> </a>
	<img  style="display:inline;float:right !important;display:absolute;width:16px; height:16px; margin-top:8px;" src="images/user1.png" >
	<div id="navegacion">
		<?php  
			 $menu = new menu();
			 $menu->mostrar(); ?>
			
	</div><!-- fin navegacion  -->
	
	<div id="cuerpo">
			<?php  
			 $modulo = new modulos();
			 $modulo->mostrar(); ?>
	</div><!-- fin   cuerpo-->
    </div>
</div><!-- fin contenedor-->

</body>


</html>


