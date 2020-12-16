<?php 
require_once("../../clases/conexionocdb.php");

$datos = $_POST['datos'];
$fecha = $datos['fecha'];

$fechaVec = explode(" ", $fecha);
$fechaPreHora = $fechaVec[1].":00";

$fechaPreVec = explode("/",$fechaVec[0]);

if($fechaPreVec[0] == '01'){
	$mes = 'Ene';
}else if($fechaPreVec[0] == '02'){
	$mes = 'Feb';
}else if($fechaPreVec[0] == '03'){
	$mes = 'Mar';
}else if($fechaPreVec[0] == '04'){
	$mes = 'Abr';
}else if($fechaPreVec[0] == '05'){
	$mes = 'May';
}else if($fechaPreVec[0] == '06'){
	$mes = 'Jun';
}else if($fechaPreVec[0] == '07'){
	$mes = 'Jul';
}else if($fechaPreVec[0] == '08'){
	$mes = 'Ago';
}else if($fechaPreVec[0] == '09'){
	$mes = 'Sep';
}else if($fechaPreVec[0] == '10'){
	$mes = 'Oct';
}else if($fechaPreVec[0] == '11'){
	$mes = 'Nov';
}else if($fechaPreVec[0] == '12'){
	$mes = 'Dic';
}

$fechaPre = $fechaPreVec[1]." ".$mes." ".$fechaPreVec[2]." ".$fechaPreHora;

/*$fechaFinal = $fechaPreVec[2]."-".$fechaPreVec[0]."-".$fechaPreVec[1]." ".$fechaPreHora;
echo $fechaFinal;
*/



$sql="
	UPDATE  SISAP.dbo.SI_Requerimiento
	SET     idRecepcion = ".$datos['idRecepcion']." 
			,revDate = GETDATE() 
			,FK_idEstado = 2
			,FK_idServicio = ".$datos['idServicio']."
			,calendarizacion = '".$fechaPre."'
	WHERE   idRequerimiento = ".$datos['idReq'];

$rs = odbc_exec( $conn, $sql );
							
			if ( !$rs )
			{
				exit( "Error en la consulta SQL" );
			}



odbc_close( $conn );

?>