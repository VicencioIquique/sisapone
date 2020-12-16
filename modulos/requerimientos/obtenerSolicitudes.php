<?php
	require_once("../../clases/conexionocdb.php");
	$idReq = $_POST['idReq'];
	$sql = "SELECT [idRequerimiento]
			  ,[createDate]
			  ,[title]
			  ,[description]
			  ,[idSolicitante]
			  ,[idRecepcion]
			  ,[revDate]
			  ,[startDate]
			  ,[endDate]
			  ,[FK_idEstado]
			  ,[FK_idServicio]
			  ,[FK_idAreaEmision]
			  ,[FK_idAreaRecepcion]
			  ,[VBSolicitante]
			  ,[VBRecepcion]
			  ,[feedback]
			  ,[adjunto]
			  ,[calendarizacion]
			  ,[estadoAlerta]
		  FROM [SISAP].[dbo].[SI_Requerimiento]
		  WHERE FK_idEstado <> '5' AND FK_idEstado <> '4'";
	$rs = odbc_exec( $conn, $sql );
	if ( !$rs ){
		exit( "Error en la consulta SQL" );
	}
	while($resultado = odbc_fetch_array($rs)){
		$res[] = array ( 
			'idRequerimiento' => $resultado['idRequerimiento'],
			'createDate' => $resultado['createDate']
		);
	}
			
	echo json_encode($res);
	odbc_close( $conn );
?>