<?php
require_once("../../clases/conexionocdb.php");

$datos = $_POST['datos'];
$idFondoFijo = $datos['idFondoFijo'];

$sql="UPDATE SISAP.dbo.SI_FondoFijo SET FK_idEstado = 4 WHERE idFondoFijo =". $idFondoFijo;
echo $sql;
$rs = odbc_exec( $conn, $sql );
if(!$rs){
	exit( "Error en la consulta SQL" );
}
odbc_close($conn);
?>
