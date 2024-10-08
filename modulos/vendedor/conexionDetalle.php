<?php
// Incluye solo la conexión necesaria para el detalle
//include_once("clases/conexionodbc-2.php");

$dsn = "VICENCIOSAP"; 
$usuario = "sa";
$clave = "V1c3nc10.!";

$conn2 = odbc_connect($dsn, $usuario, $clave);

$codbarra = $_GET['codbarra'];
//echo "Código de barra: " . $codbarra . "<br>";

// Verifica si la conexión se ha establecido correctamente
if (!$conn2) {
    echo "Error al establecer la conexión con ODBC: " . odbc_error();
    exit;
}

echo'</br>
 <div id="usual1" class="usual" > 
  <ul> 
    <li ><a id="tabdua" href="#tab1" class="selected">Detalle Saldos</a></li> 
   
  </ul> 
  <div id="tab3">
  
  
  </div> <!-- fin de grafico de marcas -->
  <div id="tab1"> 
  	<table  id="ssptable" class="lista">
      <thead>
            <tr>
				<th>N°</th>        
                <th>Codigo Barra</th>
				<th>Descrip.</th>
				<th>Cantidad</th>
				<th>Lote</th>
				<th>Bodega</th>
            </tr>
      </thead>
      <tbody>';

// Consulta para el detalle
$sql2 = "
SELECT TOP 1000 [ItemCode]
      ,[BatchNum]
      ,[WhsCode]
      ,[ItemName]
      ,[SuppSerial]
      ,[IntrSerial]
      ,[ExpDate]
      ,[PrdDate]
      ,[InDate]
      ,[Located]
      ,[Notes]
      ,[Quantity]
      ,[BaseType]
      ,[BaseEntry]
      ,[BaseNum]
      ,[BaseLinNum]
      ,[CardCode]
      ,[CardName]
      ,[CreateDate]
      ,[Status]
      ,[Direction]
      ,[IsCommited]
      ,[OnOrder]
      ,[Consig]
      ,[DataSource]
      ,[UserSign]
      ,[Transfered]
      ,[Instance]
      ,[SysNumber]
      ,[LogInstanc]
      ,[UserSign2]
      ,[UpdateDate]
      ,[U_ZF_CIF_U]
      ,[Location]
      ,[ExpensesAc]
      ,[grupo_bodega]
  FROM [SBO_Imp_Eximben_SAC].[dbo].[Stock_Bodegas_SAPJPL]
  WHERE ItemCode = '".$codbarra."' AND(WhsCode NOT IN ('ZFI.2077','ZFI.1010', 'ZFI.181', 'ZFI.184', 'ZFI.2002', 'ZFI.1132', 'ZFI.6130', 'ZFI.33', 'ZFI.66', 'NA', 'ZFI.6115')) ";

// Muestra la consulta SQL que se va a ejecutar (para depuración)
//echo "Consulta SQL: " . $sql2 . "<br>";

// Ejecuta la consulta usando la conexión $conn2
$rs2 = odbc_exec($conn2, $sql2);

// Verifica si la consulta fue exitosa
if (!$rs2) {
    echo "Error en la consulta SQL2.1: " . odbc_error($conn2);
    exit;
}

// Procesa los resultados
$i = 0;
while ($resultado2 = odbc_fetch_array($rs2)) {
    echo '<tr>
            <td>'.($i+1).'</td>
            <td>'.$resultado2["ItemCode"].'</td>
            <td>'.$resultado2["ItemName"].'</td>
            <td>'.number_format($resultado2["Quantity"], 0, '', '.').'</td>
            <td>'.$resultado2["BatchNum"].'</td>
            <td>'.$resultado2["WhsCode"].'</td>
          </tr>';
    $i++;
}

// Cierra la conexión ODBC
odbc_close($conn2);
?>


