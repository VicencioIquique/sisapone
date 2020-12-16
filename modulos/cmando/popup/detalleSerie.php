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
<title>Series</title>

<?php>
require_once("../../../clases/conexionocdb.php");
$sql = "SELECT cab.ID,cab.serie,Serie.Serie as sug
		FROM [RP_VICENCIO].[dbo].[RP_ReceiptsCab_SAP] cab
		left join [RP_VICENCIO].[dbo].[Bodega] bod on cab.bodega=bod.retail
		left join [RP_VICENCIO].[dbo].[Serie] serie on bod.bodega = serie.Bodega 
		and cab.Workstation=serie.caja 
		and cab.TipoDocto=serie.Documento
		where estado ='0'
		and YEAR(FechaDocto) ='2018'
		and cab.serie<>serie.serie";
	$rs = odbc_exec( $conn, $sql );
if ( !$rs){
		exit( "Error en la consulta SQL" );
}
echo "
	<table>
		<tr>
			<th>ID</th>
			<th>Serie</th>
			<th>Serie Sugerida</th>
		</tr>";
while($resultado = odbc_fetch_array($rs)){
		echo "
		<tr>
			<td>".$resultado['ID']."</td>
			<td>".$resultado['serie']."</td>
			<td>".$resultado['sug']."</td>
		</tr>";
	
	}
echo "</table>";

?>
</body>