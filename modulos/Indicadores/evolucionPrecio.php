<?php 
require_once("../../clases/conexionocdb.php");//incluimos archivo de conexión

ini_set('max_execution_time', 300); //300 seconds = 5 minutes

$vendedor = $_GET['id'];
$vendedor = str_pad($vendedor, 3, '0', 'STR_PAD_LEFT');
$modulo = $_GET['modulo'];
$marca = $_GET['marca'];
$fecha = $_GET['fecha'];
if (!$fecha)
{
	 $fecha = date("m-Y");
}
$mes = substr($fecha,0, 2);
$anio = substr($fecha,3, 4);


// Consulta para llamar las marcas de los productos
$sql2= "SELECT   [Cantidad]
      ,[FechaDoc]
  FROM [RP_VICENCIO].[dbo].[RP_DEM]
  WHERE Codmodulo = 1 AND CodigoProducto = '8411061401200'
  ORDER BY FechaDoc";
  
		$rs2 = odbc_exec( $conn, $sql2 );
		if ( !$rs2 )
		{
		exit( "Error en la consulta SQL" );
		}

echo $sql1;
		 

while($resultado = odbc_fetch_array($rs2))
		{ 
			
			
		  //echo $lunes[0];
		}

//echo $sql;			
	echo'  <script src="../../graficos/amcharts/amcharts.js" type="text/javascript"></script> 
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"  type="text/javascript"/></script>
	<script language="javascript" type="text/javascript" src="../../js/jquery.idTabs.js"></script>
<link rel="stylesheet" type="text/css" href="../../temas/minimalplomo/minimalplomo.css"><!-- estilos geneales-->';//incluyo la librería para generar graficos	
	include("../../graficos/evolucionPrecio.php");// grafico 
?>

<script type="text/javascript">
  $(document).ready(function(){
				//comienza focus en modulo
				  $("#usual1 ul").idTabs(); 
				$('#moduloid').focus();
				// calendarios en text de fecha inicio fin
				
			
			
			
			$(".fecha").focus(function () {
				$(".ui-datepicker-calendar").hide();
				$("#ui-datepicker-div").position({
					my: "center top",
					at: "center bottom",
					of: $(this)
				});
			});
				
				
			});//fin funciotn principal
</script>
                        
<body>
<div id="contenedor">
<div id="cuerpo">      
      
<div id="usual1" class="usual" > 
  <ul> 
	
    <li ><a id="tabdua" href="#tab2" class="selected" >Seguimient de Precio</a></li> 
 </ul> 
 </div>
  <div id="tab1">
		
  </div> <!-- fin de grafico de marcas -->
  <div id="tab2">

      
		<div id="evolucionPrecio" style="width:100%; height: 400px;"></div>
  </div> <!-- fin de grafico de marcas -->
  
  
  </div><!-- fin   cuerpo-->
 </div>

                        
</body>

    
 <?php odbc_close( $conn );?>