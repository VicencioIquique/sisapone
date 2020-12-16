<?php
require_once("../../clases/conexionocdb.php");

$idFondoFijo = $_POST['idFondoFijo'];
$numDoc = $_POST['numDoc'];
$titulo = $_POST['titulo'];
$comentario = $_POST['comentario'];
$costo = $_POST['costo'];
$concepto = $_POST['concepto'];
$normaReparto = $_POST['normaReparto'];
$negocio = $_POST['negocio'];
$empresa = $_POST['empresa'];

if($idFondoFijo != "" AND $numDoc != "" AND $titulo != "" AND $costo != ""){
	$sql="SELECT MAX(idDetalleFondoFijo) AS Correlativo FROM SISAP.dbo.SI_DetalleFondoFijo WHERE FK_idFondoFijo = ".$idFondoFijo."";
	$rs = odbc_exec( $conn, $sql );
	if(!$rs){
		exit( "Error en la consulta SQL" );
	}else{
		$resultado = odbc_fetch_array($rs);
		$idNuevoDetalle = $resultado['Correlativo'] + 1;
	}
	$sql="INSERT INTO SISAP.dbo.SI_DetalleFondoFijo
		([idDetalleFondoFijo]
	  ,[FK_idFondoFijo]
		,[rinDate]
		,[business]
		,[numDoc]
		,[title]
		,[description]
		,[cost]
		,[AcctCode]
		,[OcrCode]
		,[baseDatos]
		)
		VALUES
		(". $idNuevoDetalle ."
	  ,". $idFondoFijo ."
		,GETDATE()
		,'". $negocio ."'
		,'". $numDoc ."'
		,'". $titulo ."'
		,'". $comentario ."'
		,". $costo ."
		,'". $concepto ."'
		,'". $normaReparto ."'
		,'". $empresa ."'
		)";
	$rs = odbc_exec( $conn, $sql );
	echo $sql;
	if(!$rs){
		exit( "Error en la consulta SQL" );
	}else{
		echo "SE INSERTO LA WEA";
	}
	//odbc_execute($rs);
}else{
	echo "ENTRO AL ELSE";
}
?>
