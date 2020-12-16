<?php 
ini_set('SMTP', 'smtp.eximben.cl'); 
ini_set('smtp_port', '27'); 
ini_set('auth','true'); 

ini_set('sendmail_from', 'sisap@eximben.cl');
ini_set('auth_username', 'sisap@eximben.cl');
ini_set('auth_password', 'sc3qohhfw2');

//require_once("../../clases/conexionocdb.php"); // conexion con obcd driver
//require_once("../../clases/funciones.php"); // funciones propias


$idsol = (int)$_REQUEST['idsol'];

$correos = $_REQUEST['correos'];

$lista = substr($correos, 0, -1);


$sql="SELECT  [solicitud_id]
      ,[estado]
      , CONVERT(varchar, [fecha_crea], 103)as Fecha
      ,[fecha_estado]
      ,[cantidad_total]
      ,[modulo]
      ,[vendedor_id]
      ,[recepcion_id]
  FROM [RP_VICENCIO].[dbo].[sisap_solicitudes]
             
 WHERE [solicitud_id]  = ".$idsol;
 
 	//$rs = odbc_exec( $conn, $sql );
							/*if ( !$rs )
							{
							exit( "Error en la consulta SQL" );
							}

							  while($resultado = odbc_fetch_array($rs)){ 
							  
							  	$fechacrea = $resultado["Fecha"];
								$modulo	 = $resultado["modulo"];
								$vendedor = $resultado["vendedor_id"];
								$recepcion = $resultado["recepcion_id"];
							  
							  }*/

$destinatario = 'juliocortes@eximben.cl'; 
$asunto = "Nueva Solicitud"; 
$cuerpo = ' 
<html> 
<head> 
   <title></title> 
</head> 
<body> 
<h1>HOLA!</h1> 
<p> 
<b>Buen dia!, le ha llegado una nueva solicitud</b>. Para revisar haga click en el siguiente enlace: <a href="bx.eximben.cl:8080/SISAP/index.php?opc=nuevaSolicitudbrand" >CLICK AQUI</a>
</p> 
<p> 
<b>Solicitud numero:</b> 
</p> 
<p> 
<b>Solicitada por:</b> 
</p> 
<p> 
<b>Modulo:</b> 
</p> 
<p> 
<b>Fecha:</b> 
</p> 
</body> 
</html> 
'; 

//para el envío en formato HTML 
$headers = "MIME-Version: 1.0\r\n"; 
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 

//dirección del remitente 
$headers .= "From: \r\n"; 

//dirección de respuesta, si queremos que sea distinta que la del remitente 
$headers .= "Reply-To:  \r\n"; 


//direcciones que recibián copia 
$headers .= "Cc: soporte@eximben.cl\r\n"; 

//direcciones que recibirán copia oculta 
//$headers .= "Bcc: pepe@pepe.com,juan@juan.com\r\n"; 

mail($destinatario,$asunto,$cuerpo,$headers) 
?>