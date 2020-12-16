<?php 
require_once("../../clases/conexionocdb.php"); // conexion con obcd driver
require_once("../../clases/funciones.php"); // funciones propias


$ndem = (int)$_REQUEST['ndem'];

$correos = $_REQUEST['correos'];

$lista = substr($correos, 0, -1);


$sql="SELECT [NroDSM],[TOrigen],[CodModulo],CONVERT(varchar, [FechaDoc], 103) AS Fecha, count([NroDSM]) AS TotalItem ,Estado  FROM [RP_VICENCIO].[dbo].[RP_DSM] 
WHERE [NroDSM] = '".$ndem."'
GROUP BY NroDSM,[FechaDoc],[CodModulo],[TOrigen],Estado 
ORDER BY FechaDoc DESC";

//echo $sql;
 
 	$rs = odbc_exec( $conn, $sql );
							if ( !$rs )
							{
							exit( "Error en la consulta SQL" );
							}

							  while($resultado = odbc_fetch_array($rs)){ 
							  
							  	$NroDSM = $resultado["NroDSM"];
								$Fecha = $resultado["Fecha"];
								$origen = $resultado["TOrigen"];
							    $estado = $resultado["Estado"];
								$codModulo = $resultado["CodModulo"];
								$TotalItem = $resultado["TotalItem"];
							  
							  }
$fechaValida = date("d/m/Y");
$destinatario = $lista; 
//$destinatario = "julicortes@eximben.cl"; 
$asunto = "Declaracion ".$NroDSM." ha llegado desde modulo"; 
$cuerpo = ' 
<html> 
<head> 
   <title></title> 
</head> 
<body> 
<h1>ENHORABUENA!</h1> 
<p> 
<b>La Mercaderia ha llegado desde modulo '.getmodulo($origen).' exitosamente</b>. 
</p> 
<p> 
<b>Nro. Declaracion de Entrada Modulo :</b> '. $NroDSM .'
</p> 
<p> 
<b>Nro de Items:</b> '. $TotalItem .'
</p> 

<p> 
<b>Fecha Documento:</b> '. $Fecha .' 
</p> 

<p> 
<b>Fecha Validacion:</b> '. $fechaValida .' 
</p> 

<p> 
</p> 
<p>
</p>
<p style="font-size:9px;">
 " Procedimiento en prueba", El uso de tildes se ha omitido en este mensaje.
</p>
</body> 
</html> 
'; 

//para el envío en formato HTML 
		$headers = "MIME-Version: 1.0\r\n"; 
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 

		//dirección del remitente 
		$headers .= "From: sisap@eximben.cl\r\n"; 

		//dirección de respuesta, si queremos que sea distinta que la del remitente 
		$headers .= "Reply-To:  \r\n"; 


		//direcciones que recibián copia 
		$headers .= "Cc: soporte@eximben.cl\r\n"; 
		
		//direcciones que recibirán copia oculta 
		//$headers .= "Bcc: pepe@pepe.com,juan@juan.com\r\n"; 

mail($destinatario,$asunto,$cuerpo,$headers)
?>