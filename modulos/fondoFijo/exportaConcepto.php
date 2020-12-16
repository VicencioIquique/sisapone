<?php
require_once("../../clases/conexionocdb.php");
$id = $_POST['id'];
	
		$sql = "D.AcctName AS Concepto
		,A.[FK_idFondoFijo] AS IdFondo
		,B.idEncargado AS IdEncargado
		,C.usuario_nombre AS Usuario
		,SUM(A.[cost]) AS Costo
		,E.OcrCode AS Norma
		FROM [SISAP].[dbo].[SI_DetalleFondoFijo] AS A
		INNER JOIN [SISAP].dbo.SI_FondoFijo AS B ON A.FK_idFondoFijo = B.idFondoFijo
		INNER JOIN [RP_VICENCIO].[dbo].[sisap_usuarios] AS C ON B.idEncargado = C.usuario_id
		INNER JOIN [SBO_Imp_Eximben_SAC].[dbo].[OACT] AS D ON A.AcctCode = D.AcctCode COLLATE SQL_Latin1_General_CP850_CI_AS
		INNER JOIN [SBO_Imp_Eximben_SAC].[dbo].[OOCR] AS E ON A.OcrCode = E.OcrCode COLLATE SQL_Latin1_General_CP850_CI_AS
		WHERE FK_idFondoFijo = '".$id['id']."'
		GROUP BY D.AcctName, A.[FK_idFondoFijo], B.idEncargado, C.usuario_nombre, E.OcrCode";
			  
		$rs = odbc_exec( $conn, $sql );
		if ( !$rs ){
			exit( "Error en la consulta SQL" );
		}
		
			while($resultado = odbc_fetch_array($rs)){ 
				$res[] = array ( 
								'concepto' => $resultado['Concepto'],
								'idFondoFijo' => $resultado['IdFondo'],
								'usuario' => $resultado['Usuario'],
								'costo' => $resultado['Costo'],
								'norma' => $resultado['Norma']
							);
			}
		
		echo json_encode($res);
		
?>