<?php
require_once("../../clases/conexionocdb.php");


$idFondoFijo = $_POST['idFondoFijo'];

$sql="UPDATE SISAP.dbo.SI_FondoFijo SET FK_idEstado = 5 WHERE idFondoFijo =". $idFondoFijo;
echo $sql;
$rs = odbc_exec( $conn, $sql );
if(!$rs){
	exit( "Error en la consulta SQL" );
}
odbc_close($conn);
?>
