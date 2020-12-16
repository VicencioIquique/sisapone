<?php
require_once("../../clases/conexionocdb.php");
$id = $_POST['id'];
	
		$sql = "SELECT A.[idDetalleFondoFijo] AS IdDetalle 
		,A.[FK_idFondoFijo] AS IdFondo 
		,B.idEncargado AS IdEncargado 
		,C.usuario_nombre AS Usuario 
		,A.[rinDate] AS Fecha 
		,A.[business] AS Negocio
		,A.[numDoc] AS Documento
		,A.[title] AS Titulo
		,A.[description] AS Comentario
		,A.[cost] AS Costo
		,A.OcrCode AS Norma
		,D.AcctName AS Concepto
		,E.OcrName AS NormaNombre
		FROM [SISAP].[dbo].[SI_DetalleFondoFijo] AS A
		INNER JOIN [SISAP].dbo.SI_FondoFijo AS B ON A.FK_idFondoFijo = B.idFondoFijo
		INNER JOIN [RP_VICENCIO].[dbo].[sisap_usuarios] AS C ON B.idEncargado = C.usuario_id
		INNER JOIN [SBO_Imp_Eximben_SAC].[dbo].[OACT] AS D ON A.AcctCode = D.AcctCode COLLATE SQL_Latin1_General_CP850_CI_AS
		INNER JOIN [SBO_Imp_Eximben_SAC].[dbo].[OOCR] AS E ON A.OcrCode = E.OcrCode COLLATE SQL_Latin1_General_CP850_CI_AS
		WHERE FK_idFondoFijo = '".$id['id']."'";
			  
		$rs = odbc_exec( $conn, $sql );
		if ( !$rs ){
			exit( "Error en la consulta SQL" );
		}
		
			while($resultado = odbc_fetch_array($rs)){ 
				$res[] = array ( 
								'idDetalleFondoFijo' => $resultado['IdDetalle'],
								'idFondoFijo' => $resultado['IdFondo'],
								'usuario' => $resultado['Usuario'],
								'fecha' => $resultado['Fecha'],
								'negocio' => $resultado['Negocio'],
								'documento' => $resultado['Documento'],
								'titulo' => $resultado['Titulo'],
								'descripcion' => $resultado['Comentario'],
								'costo' => $resultado['Costo'],
								'concepto' => $resultado['Concepto'],
								'norma' => $resultado['Norma'],
								'normanombre' => $resultado['NormaNombre'],
							);
			}
		
		echo json_encode($res);
		
?>