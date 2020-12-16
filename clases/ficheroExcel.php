<?php 
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
header("Content-type: application/vnd.ms-excel; name='excel'; charset=utf-8"); 
header("Content-Disposition: filename=ExcelSISAP.xls"); 
header("Pragma: no-cache"); 
header("Expires: 0"); 
echo $_POST['datos_a_enviar']; 
?> 