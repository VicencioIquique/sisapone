<?php
require_once("../../../clases/conexionocdb.php");

// Asegúrate de que la conexión está correctamente establecida
// $conn = odbc_connect("DSN_NAME", "USER", "PASSWORD");
// if (!$conn) {
//     exit("Error en la conexión a la base de datos");
// }

// Escapa el valor de $_POST['codigo'] para evitar inyecciones SQL
$codigo = addslashes($_POST['codigo']);

$sql = "SELECT art.ALU, art.PRICE01 AS precio, ISNULL(nav.descuento, 'NO') AS descuento, art.DESC2 
        FROM [RP_VICENCIO].[dbo].[RP_Articulos] art
        LEFT JOIN [RP_VICENCIO].[dbo].[RP_Descuento_Navidad2] nav ON art.ALU = nav.upc
        WHERE alu = '$codigo'";

$rsSql = odbc_exec($conn, $sql);
if (!$rsSql) {
    exit("Error en la consulta SQL");
}

$resultado = odbc_fetch_array($rsSql);

// Depurar los resultados
// echo "<pre>";
// print_r($resultado); // Aquí corriges el uso de print_r
// echo "</pre>";

$objeto = new stdClass();
$objeto->precio = $resultado['precio'];
$objeto->descripcion = utf8_encode($resultado['DESC2']);
$objeto->oferta = utf8_encode($resultado['descuento']);

echo json_encode($objeto);

odbc_close($conn);
