<?php
	//ini_set("SMTP", "mail.eximben.cl"); 
	require_once("../../clases/conexionocdb.php");
	session_start();
	$idSolicitante = $_SESSION['usuario_id'];	
	$datos = $_POST['datos'];
	$estado = 1;
	
	$sqlArea = "SELECT FK_idArea FROM RP_VICENCIO.dbo.sisap_usuarios WHERE usuario_id = '".$idSolicitante."'";
	$rsArea = odbc_exec( $conn, $sqlArea );
									if ( !$rsArea ){
										exit( "Error en la consulta SQL" );
									}
									$resultado = odbc_fetch_array($rsArea);
	
	$idAreaEmision = $resultado['FK_idArea'];
	odbc_close( $conn );
	
	$sql="INSERT INTO SISAP.dbo.SI_Requerimiento 
		([createDate]
		,[title]
		,[description]
		,[idSolicitante]
		,[FK_idEstado]
		,[FK_idAreaEmision]
		,[FK_idAreaRecepcion]
		)
		VALUES
		(
		GETDATE()
		,'".utf8_encode($datos['title'])."'
		,'".utf8_encode($datos['description'])."'
		,'".$idSolicitante."'
		,'".$estado."'
		,'".utf8_encode($idAreaEmision)."'
		,'".utf8_encode($datos['areaRecibeDesc'])."'
		)";
		/*
		GETDATE()
		,'".$datos[]title."'
		,'".$description."'
		,'".$idSolicitante."'
		,'".$estado."'
		,'".$idAreaEmision."'
		,'".$idAreaRecepcion."'
		)";
		*/
		$rs = odbc_exec( $conn, $sql );
							
							if ( !$rs )
							{
							exit( "Error en la consulta SQL" );
							}
	odbc_close( $conn );

							
		
		
		/* INICIO DE FORMATO DE CORREO */
		$sqlNumTicket = "SELECT TOP 1 idRequerimiento FROM SISAP.dbo.SI_Requerimiento
						ORDER BY idRequerimiento DESC";
		$rsIdReq = odbc_exec($conn, $sqlNumTicket);
		if(!$rsIdReq){
			exit("Error en la consulta SQL");
		}
		$resultadoIdReq = odbc_fetch_array($rsIdReq);
		odbc_close( $conn );
		
		$sqlMailDestinatario = "SELECT usuario_nombre, email FROM RP_VICENCIO.dbo.sisap_usuarios WHERE usuario_id = ".$idSolicitante."";
		$rsMailDest = odbc_exec($conn, $sqlMailDestinatario);
		if(!$rsMailDest){
			exit("Error en la consulta SQL");
		}
		$resultadoMailDest = odbc_fetch_array($rsMailDest);
		odbc_close( $conn );
		
		$sqlfechaInicio = "SELECT CONVERT(varchar(20),createDate,13) [createDate], title, description FROM SISAP.dbo.SI_Requerimiento WHERE idRequerimiento = ".$resultadoIdReq["idRequerimiento"]."";
		$rsFechaInicio = odbc_exec($conn, $sqlfechaInicio);
		if(!$rsFechaInicio){
			exit("Error en la consulta SQL");
		}
		$resultadoFechaInicio = odbc_fetch_array($rsFechaInicio);
		odbc_close( $conn );
		
		$destinatario = $resultadoMailDest["email"]; 
		$asunto = "Generacion ticket Nuevo Requerimiento numero: ".$resultadoIdReq["idRequerimiento"].""; 
		$cuerpo = ' 
		<html> 
		<head> 
		   <title></title> 
		</head> 
		<body> 
		<p>
			Estimado '.$resultadoMailDest['usuario_nombre'].'<br><br>
			Gracias por contactar al centro de soporte de Grupo Vicencio.<br>
			Se ha generado una nueva solicitud de soporte t&eacute;cnico para dar cumplimiento a su requerimiento seg&uacute;n los siguientes detalles:
		</p>
		<p> 
			Solicitante: '.$resultadoMailDest['usuario_nombre'].' <br>
			T&iacute;tulo: '.utf8_decode($resultadoFechaInicio["title"]).' <br>
			Descripci&oacute;n: '.utf8_decode($resultadoFechaInicio["description"]).' <br>
			Fecha de solicitud: '.$resultadoFechaInicio["createDate"].' <br>
		</p> 
		<p>
			El personal de soporte se contactar&aacute; con ud a la brevedad para coordinar los trabajos pertinentes.<br><br>
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