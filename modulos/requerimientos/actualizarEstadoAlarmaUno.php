<?php 
require_once("../../clases/conexionocdb.php");
$idReq = $_POST['idReq'];
$sql="
	UPDATE  SISAP.dbo.SI_Requerimiento
	SET     estadoAlerta = 2
	WHERE   idRequerimiento = ".$idReq;

$rs = odbc_exec( $conn, $sql );
							
			if ( !$rs )
			{
				exit( "Error en la consulta SQL" );
			}
odbc_close( $conn );
/* INICIO DE FORMATO DE CORREO */
		$sqlEstado = "SELECT T2.name FROM SISAP.dbo.SI_Requerimiento AS T1
		LEFT JOIN SISAP.dbo.SI_Estado AS T2 ON T1.FK_idEstado = T2.idEstado
		WHERE T1.idRequerimiento = '".$idReq."'";
		$rsEstado = odbc_exec($conn, $sqlEstado);
		if(!$rsEstado){
			exit("Error en la consulta SQL");
		}
		$resultadoEstado = odbc_fetch_array($rsEstado);
		odbc_close( $conn );
		
		
		$sqlMailDestinatario = "SELECT T2.usuario_nombre, T2.email FROM SISAP.dbo.SI_Requerimiento AS T1
								LEFT JOIN RP_VICENCIO.dbo.sisap_usuarios AS T2 ON T1.idRecepcion = T2.usuario_id
								WHERE idRequerimiento = '".$idReq."'";
		$rsMailDest = odbc_exec($conn, $sqlMailDestinatario);
		if(!$rsMailDest){
			exit("Error en la consulta SQL");
		}
		$resultadoMailDest = odbc_fetch_array($rsMailDest);
		odbc_close( $conn );
		
		$sqlfechaInicio = "SELECT CONVERT(varchar(20),createDate,13) [createDate], title, description FROM SISAP.dbo.SI_Requerimiento WHERE idRequerimiento = ".$idReq."";
		$rsFechaInicio = odbc_exec($conn, $sqlfechaInicio);
		if(!$rsFechaInicio){
			exit("Error en la consulta SQL");
		}
		$resultadoFechaInicio = odbc_fetch_array($rsFechaInicio);
		odbc_close( $conn );
		
		
		$sqlSolicitante = "SELECT T2.usuario_nombre FROM SISAP.dbo.SI_Requerimiento AS T1
		LEFT JOIN RP_VICENCIO.dbo.sisap_usuarios AS T2 ON T1.idSolicitante = T2.usuario_id 
		WHERE idRequerimiento = ".$idReq."";
		$rsSolicitante = odbc_exec($conn, $sqlSolicitante);
		if(!$rsSolicitante){
			exit("Error en la consulta SQL");
		}
		$resultadoSolicitante = odbc_fetch_array($rsSolicitante);
		odbc_close( $conn );
		
		if($resultadoMailDest["email"]== ""){
			$destinatario = "juanpablolobos@eximben.cl";
		}else{
			$destinatario = $resultadoMailDest["email"]; 
		}
		if($resultadoMailDest['usuario_nombre'] == ""){
			$encargado = "No hay designado hasta el momento";
		}else{
			$encargado = $resultadoMailDest['usuario_nombre'];
		}
		$asunto = "Alarma requerimiento detenido: ".$resultadoIdReq["idRequerimiento"].""; 
		$cuerpo = ' 
		<html> 
		<head> 
		   <title></title> 
		</head> 
		<body> 
		<p>
			Equipo de Inform&aacute;tica<br><br>
			Este mensaje se ha autogenerado debido al no proceso de uno de los requerimientos solicitados por la empresa en alguna de las etapas.<br>
			Los datos del requerimiento son los siguientes:
		</p>
		<p> 
			Encargado del requerimiento: '.$encargado.' <br>
			ID del requerimiento: '.$idReq.'<br>
			T&iacute;tulo: '.utf8_decode($resultadoFechaInicio["title"]).' <br>
			Solicitante : '.utf8_decode($resultadoSolicitante["usuario_nombre"]).'<br>
			Descripci&oacute;n: '.utf8_decode($resultadoFechaInicio["description"]).' <br>
			Fecha de solicitud: '.$resultadoFechaInicio["createDate"].' <br>
			Estado del requerimiento: '.$resultadoEstado['name'].'<br>
		</p> 
		<p>
			Se ruega continuar con el avance del requerimiento para su finalización.<br>
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
		echo ($destinatario." ".$asunto." ".$cuerpo." ".$headers);
		mail($destinatario,$asunto,$cuerpo,$headers) 
		//echo ($destinatario.$asunto.$cuerpo.$headers);
		
		/* FIN DE FORMATO DE CORREO*/
?>