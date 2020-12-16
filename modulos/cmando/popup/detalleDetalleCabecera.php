<head>
	<script src="js/raphael.2.1.0.min.js"></script>
    <script src="js/justgage.1.0.1.min.js"></script>
	
</head>
<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
th, td {
    padding: 5px;
}
th {
    text-align: left;
}


</style>
<body>
<title>Detalle VS Cabecera</title>

<?php>
require_once("../../../clases/conexionocdb.php");
$sql = "Select CAB.ID,cab.total cabecera,det.total detalle FROM [RP_VICENCIO].[dbo].[RP_ReceiptsCab_SAP] cab
LEFT JOIN (SELECT ID,SUM (PrecioExtendido) total FROM [RP_VICENCIO].[dbo].[RP_ReceiptsDet_SAP]
group by id) det on cab.id=det.ID
WHERE cab.total <>det.total  and FechaDocto >'2018' and cab.estado <2";
	$rs = odbc_exec( $conn, $sql );
if ( !$rs){
		exit( "Error en la consulta SQL" );
}
echo "
	<table border = 1 cellspacing = 1 cellpadding = 1>
		<tr>
			<th>ID</th>
			<th>Monto Cabecera</th>
			<th>Monto Detalle</th>
		</tr>";
while($resultado = odbc_fetch_array($rs)){
		echo "
		<tr>
			<td>".$resultado['ID']."</td>
			<td>".$resultado['cabecera']."</td>
			<td>".$resultado['detalle']."</td>
		</tr>";
	
	}
echo "</table>";

?>

</body>