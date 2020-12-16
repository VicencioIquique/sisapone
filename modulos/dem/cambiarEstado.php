<?php
require_once("../../clases/conexionocdb.php");

$ndem = $_POST['ndem']; // valor por el cual reemplazar
 



  
 $sql="
	UPDATE   [RP_VICENCIO].[dbo].[RP_DSM] 
	SET     Estado = 1
	WHERE   [NroDSM] = ".$ndem."";
echo $sql;
$rs = odbc_exec( $conn, $sql );
							
			if ( !$rs )
			{
				exit( "Error en la consulta SQL" );
			}

 
//odbc_execute($rs);

//echo $value;

odbc_close( $conn );

?>