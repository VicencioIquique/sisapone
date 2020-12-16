<?php
require_once("../../clases/conexionocdb.php");

$datos = $_POST['datos'];
$idFondoFijo = $datos['idFondoFijo'];
$idFondoDetalle = $datos['idFondoDetalle'];
$maxID = 0;

$sql="SELECT MAX(idDetalleFondoFijo) AS Correlativo FROM SISAP.dbo.SI_DetalleFondoFijo WHERE FK_idFondoFijo = ".$idFondoFijo."";
$rs = odbc_exec( $conn, $sql );

if(!$rs){
	exit( "Error en la consulta SQL" );
}else{
	$resultado = odbc_fetch_array($rs);
	$maxID = $resultado['Correlativo'];
}
echo '<br>'.$maxID;

$sql="DELETE FROM SISAP.dbo.SI_DetalleFondoFijo WHERE idDetalleFondoFijo =". $idFondoDetalle ." AND FK_idFondoFijo =". $idFondoFijo;
echo '<br>'.$sql;
$rs = odbc_exec( $conn, $sql );

if(!$rs){
	exit( "Error en la consulta SQL" );
}
if($idFondoDetalle < $maxID){
	echo "<br> ENTRO!!!";
	for($i = $idFondoDetalle; $i < $maxID; $i++) {
		$nuevoIdDetalleFondoFijo = $i + 1;
		$sql="UPDATE SISAP.dbo.SI_DetalleFondoFijo SET idDetalleFondoFijo =". $i ." WHERE idDetalleFondoFijo =". $nuevoIdDetalleFondoFijo ." AND FK_idFondoFijo =". $idFondoFijo;
		echo '<br>'.$sql;
		$rs = odbc_exec( $conn, $sql );
		if(!$rs){
			exit( "Error en la consulta SQL" );
		}
	}
}

odbc_close($conn);
?>
