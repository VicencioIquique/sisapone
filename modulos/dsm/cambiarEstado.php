<?php
require_once("../../clases/conexionocdb.php");

$ndsm = $_POST['ndsm']; // valor por el cual reemplazar
 



  
 $sql="
	UPDATE   [RP_VICENCIO].[dbo].[RP_DEM] 
	SET     Estado = 1
	WHERE   [NroDEM] = ".$ndsm."";

$rs = odbc_exec( $conn, $sql );
							
			if ( !$rs )
			{
				exit( "Error en la consulta SQL" );
			}

 
//odbc_execute($rs);

//echo $value;

odbc_close( $conn );

?>