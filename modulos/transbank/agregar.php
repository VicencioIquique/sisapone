<?php 
require_once("../../clases/conexionocdb.php");


$bodega = $_POST['bodega'];
$tipoPago = $_POST['tipoPago'];
$monto = $_POST['monto'];
$descripcion = $_POST['descripcion'];
$usuario = $_POST['usuario'];


$sql="INSERT INTO [RP_VICENCIO].[dbo].[sisap_abonosTransbank]

       ( bodega, tipoPago, monto, descripcion, fechaCreacion, fechaDoc,usuario)
VALUES ( '".$bodega."','".$tipoPago."',".$monto.",'',GETDATE(), GETDATE(),'".$usuario."')";

echo $sql;

$rs = odbc_exec( $conn, $sql );
							
							if ( !$rs )
							{
							exit( "Error en la consulta SQL" );
							}


odbc_execute($rs);

odbc_close( $conn );

?>