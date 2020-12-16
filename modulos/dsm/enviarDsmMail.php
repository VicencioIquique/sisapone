<?php 
session_start();
ini_set("SMTP", "mail.eximben.cl"); 
require_once("../../clases/conexionocdb.php"); // conexion con obcd driver
require_once("../../clases/funciones.php"); // funciones propias


$ndsm = (int)$_REQUEST['ndsm'];

$correos = $_REQUEST['correos'];

$lista = substr($correos, 0, -1);


$sql="SELECT [NroDEM]  ,[TOrigen],[CodModulo] ,CONVERT(varchar, [FechaDoc], 103) AS Fecha,count([NroDEM]) AS TotalItem,Estado  FROM [RP_VICENCIO].[dbo].[RP_DEM] 
WHERE [NroDEM] = '".$ndsm."' AND [CodModulo] = ". $_SESSION["usuario_modulo"]."
GROUP BY NroDEM,[FechaDoc],[CodModulo],[TOrigen],Estado 
ORDER BY FechaDoc DESC";

//echo $sql;
 
 	$rs = odbc_exec( $conn, $sql );
							if ( !$rs )
							{
							exit( "Error en la consulta SQL" );
							}

							  while($resultado = odbc_fetch_array($rs)){ 
							  
							  	$NroDEM = $resultado["NroDEM"];
								$fecha = $resultado["Fecha"];
								$origen = $resultado["TOrigen"];
							   $estado = $resultado["Estado"];
								$codModulo = $resultado["CodModulo"];
								$totalItem = $resultado["TotalItem"];
							  
							  }
$fechaValida = date("d/m/Y");
$destinatario = $lista; 
//$destinatario = "julicortes@eximben.cl"; 
$asunto = "Declaracion ".$ndsm." ha llegado a modulo"; 
$cuerpo = ' 
<html> 
<head> 
   <title></title> 
</head> 
<body> 
<h1>ENHORABUENA!</h1> 
<p> 
<b>La Mercaderia ha llegado al modulo '.getmodulo($codModulo).' exitosamente</b>. 
</p> 
<p> 
<b>Nro. Declaracion de Salida a Modulo :</b> '.$ndsm.'
</p> 
<p> 
Nro de items:</b> '.$totalItem.'
</p> 

<p> 
Fecha Documento:</b> '.$fecha.' 
</p> 

<p> 
Fecha Validacion:</b> '.$fechaValida.' 
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
$headers .= "From: juliocortes@eximben.cl\r\n"; 

//dirección de respuesta, si queremos que sea distinta que la del remitente 
$headers .= "Reply-To:  juliocortes@eximben.cl\r\n"; 


//direcciones que recibián copia 
$headers .= "Cc:  \r\n"; 

//direcciones que recibirán copia oculta 
//$headers .= "Bcc: pepe@pepe.com,juan@juan.com\r\n"; 

mail($destinatario,$asunto,$cuerpo,$headers) 
?>