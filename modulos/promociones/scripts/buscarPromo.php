<?php
require_once("../../../clases/conexionocdb.php");

$sql = "SELECT ALU,convert(int,PRICE01) precio,isnull(descuento,'NO')descuento,DESC2 FROM [RP_VICENCIO].[dbo].[RP_Articulos] art
LEFT JOIN [RP_VICENCIO].[dbo].[RP_Descuento_Navidad2] nav ON art.ALU =nav.upc
where alu ='".$_POST['codigo']."'";

// Escapa el valor de $_POST['codigo'] para evitar inyecciones SQL
//$codigo = odbc_escape_string($_POST['codigo']);

$sql = "SELECT ALU, convert(int, PRICE01) precio, ISNULL(descuento, 'NO') descuento, DESC2 
        FROM [RP_VICENCIO].[dbo].[RP_Articulos] art
        LEFT JOIN [RP_VICENCIO].[dbo].[RP_Descuento_Navidad2] nav ON art.ALU = nav.upc
        WHERE alu = '$codigo'";
//echo $sql;

$rsSql = odbc_exec($conn, $sql);
if (!$rsSql) {
    exit("Error en la consulta SQL");
}

$resultado = odbc_fetch_array($rsSql);
$objeto = new stdClass();
$objeto->precio = utf8_encode($resultado['precio']);
$objeto->descripcion = utf8_encode($resultado['DESC2']);
$objeto->oferta = utf8_encode($resultado['descuento']);

echo json_encode($objeto);

odbc_close($conn);
?>