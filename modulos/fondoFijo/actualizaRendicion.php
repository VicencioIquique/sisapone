<?php
require_once("../../clases/conexionocdb.php");

$datos = $_POST['datos'];
$idFondoFijo = $datos['idFondoFijo'];
$idFondoDetalle = $datos['idFondoDetalle'];
$numDoc = $datos['numDoc'];
$titulo = $datos['titulo'];
$comentario = $datos['comentario'];
$costo = $datos['costo'];
$concepto = $datos['concepto'];
$normaReparto = $datos['normaReparto'];
$negocio = $datos['negocio'];
$empresa = $datos['empresa'];

$sql="UPDATE SISAP.dbo.SI_DetalleFondoFijo SET business ='". $negocio  ."', numDoc ='". $numDoc."', title ='". $titulo ."', description ='". $comentario ."', cost=". $costo .", AcctCode ='". $concepto ."' , OcrCode ='". $normaReparto ."' , baseDatos ='". $empresa ."' WHERE idDetalleFondoFijo =". $idFondoDetalle ." AND FK_idFondoFijo =". $idFondoFijo;
echo $sql;
$rs = odbc_exec( $conn, $sql );
if(!$rs){
	exit( "Error en la consulta SQL" );
}
odbc_close($conn);
?>
