<?php 
require_once("../../clases/conexionocdb.php");

$datos = $_POST['datos'];

echo $sql="
	UPDATE  SISAP.dbo.SI_Requerimiento
	SET     FK_idEstado = 4
			,VBRecepcion = 1
			,endDate = GETDATE()
	WHERE   idRequerimiento = ".$datos['idReq'];
	

$rs = odbc_exec( $conn, $sql );
							
			if ( !$rs )
			{
				exit( "Error en la consulta SQL" );
			}
odbc_close( $conn );

		$sqlNumTicket = $datos['idReq'];
		
		$sqlSolicitante = "SELECT idSolicitante FROM SISAP.dbo.SI_Requerimiento WHERE idRequerimiento = ".$sqlNumTicket."";
		$rsSolicitante = odbc_exec($conn, $sqlSolicitante);
		if(!$rsSolicitante){
			exit("Error en la consulta SQL");
		}
		$resultadoSolicitante = odbc_fetch_array($rsSolicitante);
		odbc_close( $conn );
		
		$sqlMailDestinatario = "SELECT usuario_nombre, email FROM RP_VICENCIO.dbo.sisap_usuarios WHERE usuario_id = ".$resultadoSolicitante['idSolicitante']."";
		$rsMailDest = odbc_exec($conn, $sqlMailDestinatario);
		if(!$rsMailDest){
			exit("Error en la consulta SQL");
		}
		$resultadoMailDest = odbc_fetch_array($rsMailDest);
		odbc_close( $conn );
		
		$sqlfechaInicio = "SELECT CONVERT(varchar(20),createDate,13) [createDate], title, description FROM SISAP.dbo.SI_Requerimiento WHERE idRequerimiento = ".$sqlNumTicket."";
		$rsFechaInicio = odbc_exec($conn, $sqlfechaInicio);
		if(!$rsFechaInicio){
			exit("Error en la consulta SQL");
		}
		$resultadoFechaInicio = odbc_fetch_array($rsFechaInicio);
		odbc_close( $conn );
		
		$destinatario = $resultadoMailDest["email"]; 
		$asunto = "Finalizacion de Requerimiento numero: ".$sqlNumTicket.""; 
		$cuerpo = ' 
		<html> 
		<head> 
		   <title></title> 
		</head> 
		<body> 
		<p>
			Estimado '.$resultadoMailDest["usuario_nombre"].'<br><br>
			El &aacute;rea de soporte ha finalizado los trabajos t&eacute;cnicos en relaci&oacute;n al requerimiento solicitado.
		</p>
		<p> 
			Solicitante: '.$resultadoMailDest["usuario_nombre"].' <br>
			T&iacute;tulo: '.utf8_decode($resultadoFechaInicio["title"]).' <br>
			Descripci&oacute;n: '.utf8_decode($resultadoFechaInicio["description"]).' <br>
			Fecha de solicitud: '.$resultadoFechaInicio["createDate"].' <br>
		</p> 
		<p>
			Favor ingresar al siguiente enlace para confirmar los trabajos realizados.<br>
			<a href="http://192.168.3.41:8080/sisap/index.php?opc=req">Confirmaci&oacute;n</a><br>
			Saludos coordiales, <br><br>
			&Aacute;rea de Soporte<br>
			Gerencia de Operaciones e Inform&aacute;tica
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
		/* FIN DE FORMATO DE CORREO*/
		



?>