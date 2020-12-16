<?php
	require_once("../../clases/conexionocdb.php");
	session_start();
	$fileName = $_FILES['afile']['name']; //Cargar las propiedades del archivo a adjuntar
	$fileType = $_FILES['afile']['type'];
	$fileSize = $_FILES['afile']['size']; 
	$archivo = $_FILES['afile']['tmp_name'];
	$prefijo = substr(md5(uniqid(rand())),0,6);
	
	$destino = "adjuntos/".$prefijo.$fileName; //Definir ubicación de destino del archivo
	
	/*Rescatar el id del requerimiento para actualizar con el nombre del archivo en el registro de la base de datos*/
	$sqlNumTicket = "SELECT TOP 1 idRequerimiento FROM SISAP.dbo.SI_Requerimiento
						ORDER BY idRequerimiento DESC";
		$rsIdReq = odbc_exec($conn, $sqlNumTicket);
		if(!$rsIdReq){
			exit("Error en la consulta SQL");
		}
		$resultadoIdReq = odbc_fetch_array($rsIdReq);
		odbc_close( $conn );
	
	echo $resultadoIdReq['idRequerimiento'];
	
	/*Subir archivo al destino especificado*/
	if (copy($archivo,$destino)){
		/*Actualizar campo "adjunto" de SI_Requerimientos con el nombre del archivo adjunto*/
		$sql="
		UPDATE [SISAP].[dbo].[SI_Requerimiento] 
		SET adjunto = '".$prefijo.$fileName."' 
		WHERE idRequerimiento = ".$resultadoIdReq['idRequerimiento'];

	$rs = odbc_exec( $conn, $sql );
								
				if ( !$rs )
				{
					exit( "Error en la consulta SQL" );
				}



	odbc_close( $conn );
	}else{
		echo "PROBLEMA PARA SUBIR";
	}
?>