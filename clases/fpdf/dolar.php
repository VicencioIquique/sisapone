<?php
require_once("conexionocdb.php");
$apiUrl = 'http://mindicador.cl/api';
//http://mindicador.cl/api/{tipo_indicador}/{dd-mm-yyyy}
//Es necesario tener habilitada la directiva allow_url_fopen para usar file_get_contents
if ( ini_get('allow_url_fopen') ) {
    $json = file_get_contents($apiUrl);
} else {
    //De otra forma utilizamos cURL
    $curl = curl_init($apiUrl);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $json = curl_exec($curl);
    curl_close($curl);
}
 $dailyIndicators = json_decode($json);
 
 $sql="
		 SELECT 
			  STR(YEAR(DO.RateDate),4,0)+'-'+
			  REPLACE(STR(MONTH(DO.RateDate),2,0),' ',0)+'-'+
			  REPLACE(STR(DAY(DO.RateDate),2,0),' ',0)       AS [Periodo]
			  ,DO.*
			  ,US.USER_CODE
			  ,US.U_NAME 
		FROM [SBO_Imp_Eximben_SAC]..ORTT DO
		LEFT JOIN [SBO_Imp_Eximben_SAC]..OUSR US ON US.USERID = DO.UserSign
		WHERE STR(YEAR(DO.RateDate),4,0)+'-'+
			  REPLACE(STR(MONTH(DO.RateDate),2,0),' ',0)+'-'+
			  REPLACE(STR(DAY(DO.RateDate),2,0),' ',0)  = '".date("Y-m-d")."'
		ORDER BY RateDate
 ";

$sqlInsert="
        INSERT INTO [SISAP].[dbo].[SI_CapturaDolarWeb]
        ([RateDate]
           ,[Currency]
           ,[Rate]
           ,[DataSource]
           ,[UserSign]
		   ,[estado])
        VALUES
           (CONVERT (date, GETDATE())
           ,'USD'
		   ,".$dailyIndicators->dolar->valor."
           ,'O'
           ,1
		   ,1)       
         "; 

$sqlInsertEuro="
        INSERT INTO [SISAP].[dbo].[SI_CapturaDolarWeb]
        ([RateDate]
           ,[Currency]
           ,[Rate]
           ,[DataSource]
           ,[UserSign]
		   ,[estado])
        VALUES
           (CONVERT (date, GETDATE())
           ,'EUR'
		   ,".$dailyIndicators->euro->valor."
           ,'O'
           ,1
		   ,1)       
         "; 		 
		 
 
 //'".date("Y-m-d")."'
      $rs= odbc_exec( $conn, $sql );
		if ( !$rs)
		{
			exit( "Error en la consulta SQL" );
		}
	   while($resultado = odbc_fetch_array($rs))
	   { 
		 if($resultado['Currency']=='USD')
		 {
			$dolarBD = $resultado['Rate'];
			$dolarUsr = $resultado['U_NAME'];
		 }	
							 
	   }
   

			 
if($dolarBD==$dailyIndicators->dolar->valor)
{
	echo " El dolar del dia ya fue ingresado por ".$dolarUsr." y su valor es : ".$dolarBD;  
}
else 
{
   if(!$dolarBD)
   {
	echo " Quieres Ingresar el dolar de forma automatica? Sugerido: ".$dailyIndicators->dolar->valor;
	
		 odbc_exec( $conn, $sqlInsert );
		 odbc_exec( $conn, $sqlInsertEuro );
		 
   }	
   else
   {
	echo " Puede que el dolar no coincida, revisalo en SAP! ".$dolarBD."- ".$dailyIndicators->dolar->valor." ";
   }
}

//echo  $dailyIndicators->dolar->fecha.' observado es ' . $dailyIndicators->dolar->valor;
//echo '<p>'.date("Y-m-d", strtotime($dailyIndicators->dolar->fecha)); 
//echo "<p>Dolar BD: ".$dolarBD;  
//echo 'El valor actual del Euro es ' . $dailyIndicators->euro->valor;

?>